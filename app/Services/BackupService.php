<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use RuntimeException;
use ZipArchive;

class BackupService
{
    public function backupDirectory(): string
    {
        $dir = storage_path('app/backups');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }

    /**
     * @return array<int, string>
     */
    public function imageSourcePaths(): array
    {
        $paths = [
            storage_path('app/public'),
            public_path('assets/images'),
        ];

        return array_values(array_filter($paths, static fn (string $path) => is_dir($path)));
    }

    public function createDatabaseBackup(): string
    {
        $connection = config('database.default');
        $driver = (string) config("database.connections.{$connection}.driver");
        $timestamp = now()->format('Y-m-d-His');

        if ($driver === 'sqlite') {
            $databasePath = (string) config("database.connections.{$connection}.database");
            if (! is_file($databasePath)) {
                throw new RuntimeException('SQLite database file was not found.');
            }

            $filename = "db-backup-{$timestamp}.sqlite";
            $target = $this->backupDirectory().DIRECTORY_SEPARATOR.$filename;
            if (! copy($databasePath, $target)) {
                throw new RuntimeException('Could not copy the SQLite database.');
            }

            return $target;
        }

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $filename = "db-backup-{$timestamp}.sql";
            $target = $this->backupDirectory().DIRECTORY_SEPARATOR.$filename;

            if ($this->createMysqlDump($connection, $target)) {
                return $target;
            }

            $this->createPhpDatabaseDump($connection, $target);

            return $target;
        }

        throw new RuntimeException("Database driver [{$driver}] is not supported for backup.");
    }

    public function createImagesBackup(): string
    {
        if (! class_exists(ZipArchive::class)) {
            throw new RuntimeException('ZipArchive is not available on this server.');
        }

        $sources = $this->imageSourcePaths();
        if ($sources === []) {
            throw new RuntimeException('No image folders were found to back up.');
        }

        $filename = 'images-backup-'.now()->format('Y-m-d-His').'.zip';
        $target = $this->backupDirectory().DIRECTORY_SEPARATOR.$filename;

        $zip = new ZipArchive;
        if ($zip->open($target, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Could not create the images backup archive.');
        }

        foreach ($sources as $sourcePath) {
            $prefix = basename($sourcePath);
            if ($sourcePath === storage_path('app/public')) {
                $prefix = 'storage-public';
            }

            $this->addDirectoryToZip($zip, $sourcePath, $prefix);
        }

        $zip->close();

        if (! is_file($target) || filesize($target) === 0) {
            @unlink($target);
            throw new RuntimeException('Images backup archive is empty.');
        }

        return $target;
    }

    /**
     * @return array<int, array{name: string, path: string, size: int, modified: int}>
     */
    public function listRecentBackups(int $limit = 15): array
    {
        $dir = $this->backupDirectory();
        if (! is_dir($dir)) {
            return [];
        }

        return collect(File::files($dir))
            ->sortByDesc(static fn ($file) => $file->getMTime())
            ->take($limit)
            ->map(static fn ($file) => [
                'name' => $file->getFilename(),
                'path' => $file->getPathname(),
                'size' => $file->getSize(),
                'modified' => $file->getMTime(),
            ])
            ->values()
            ->all();
    }

    public function resolveStoredBackup(string $filename): string
    {
        $filename = basename($filename);
        if (! preg_match('/^(db-backup-.+\.(sql|sqlite)|images-backup-.+\.zip)$/', $filename)) {
            throw new RuntimeException('Invalid backup file.');
        }

        $path = $this->backupDirectory().DIRECTORY_SEPARATOR.$filename;

        if (! is_file($path)) {
            throw new RuntimeException('Backup file was not found.');
        }

        return $path;
    }

    private function createMysqlDump(string $connection, string $target): bool
    {
        $config = config("database.connections.{$connection}");
        if (! is_array($config)) {
            return false;
        }

        $result = Process::timeout(300)->run([
            'mysqldump',
            '--host='.(string) ($config['host'] ?? '127.0.0.1'),
            '--port='.(string) ($config['port'] ?? '3306'),
            '--user='.(string) ($config['username'] ?? 'root'),
            '--default-character-set='.(string) ($config['charset'] ?? 'utf8mb4'),
            '--single-transaction',
            '--quick',
            '--lock-tables=false',
            (string) ($config['database'] ?? ''),
        ], null, [
            'MYSQL_PWD' => (string) ($config['password'] ?? ''),
        ]);

        if (! $result->successful()) {
            return false;
        }

        file_put_contents($target, $result->output());

        return is_file($target) && filesize($target) > 0;
    }

    private function createPhpDatabaseDump(string $connection, string $target): void
    {
        $sql = '-- Database backup generated at '.now()->toDateTimeString().PHP_EOL.PHP_EOL;
        $sql .= 'SET FOREIGN_KEY_CHECKS=0;'.PHP_EOL.PHP_EOL;

        $tables = collect(DB::connection($connection)->select('SHOW TABLES'))
            ->map(static function ($row) {
                return array_values((array) $row)[0];
            });

        foreach ($tables as $table) {
            $createRow = DB::connection($connection)->select("SHOW CREATE TABLE `{$table}`")[0] ?? null;
            if (! $createRow) {
                continue;
            }

            $createSql = array_values((array) $createRow)[1] ?? null;
            if (! is_string($createSql)) {
                continue;
            }

            $sql .= "DROP TABLE IF EXISTS `{$table}`;".PHP_EOL;
            $sql .= $createSql.';'.PHP_EOL.PHP_EOL;

            DB::connection($connection)->table($table)->orderByRaw('1')->chunk(200, function ($rows) use (&$sql, $table) {
                foreach ($rows as $row) {
                    $values = collect((array) $row)->map(static function ($value) {
                        if ($value === null) {
                            return 'NULL';
                        }

                        if (is_bool($value)) {
                            return $value ? '1' : '0';
                        }

                        if (is_int($value) || is_float($value)) {
                            return (string) $value;
                        }

                        return "'".str_replace(["\\", "'"], ["\\\\", "\\'"], (string) $value)."'";
                    })->implode(', ');

                    $sql .= "INSERT INTO `{$table}` VALUES ({$values});".PHP_EOL;
                }
            });

            $sql .= PHP_EOL;
        }

        $sql .= 'SET FOREIGN_KEY_CHECKS=1;'.PHP_EOL;
        file_put_contents($target, $sql);

        if (! is_file($target) || filesize($target) === 0) {
            throw new RuntimeException('Database backup file could not be created.');
        }
    }

    private function addDirectoryToZip(ZipArchive $zip, string $directory, string $zipPrefix): void
    {
        $directory = rtrim($directory, DIRECTORY_SEPARATOR);
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            /** @var \SplFileInfo $item */
            $relativePath = $zipPrefix.DIRECTORY_SEPARATOR.substr($item->getPathname(), strlen($directory) + 1);

            if ($item->isDir()) {
                $zip->addEmptyDir(str_replace('\\', '/', $relativePath));
                continue;
            }

            $zip->addFile($item->getPathname(), str_replace('\\', '/', $relativePath));
        }
    }
}
