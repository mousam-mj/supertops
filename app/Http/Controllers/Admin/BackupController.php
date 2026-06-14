<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BackupService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class BackupController extends Controller
{
    public function index(BackupService $backupService)
    {
        return view('admin.backup.index', [
            'imageSources' => $backupService->imageSourcePaths(),
            'recentBackups' => $backupService->listRecentBackups(),
        ]);
    }

    public function downloadDatabase(BackupService $backupService): BinaryFileResponse|RedirectResponse
    {
        try {
            $path = $backupService->createDatabaseBackup();

            return response()->download($path, basename($path));
        } catch (Throwable $e) {
            return back()->with('error', 'Database backup failed: '.$e->getMessage());
        }
    }

    public function downloadImages(BackupService $backupService): BinaryFileResponse|RedirectResponse
    {
        try {
            $path = $backupService->createImagesBackup();

            return response()->download($path, basename($path));
        } catch (Throwable $e) {
            return back()->with('error', 'Images backup failed: '.$e->getMessage());
        }
    }

    public function downloadStored(string $file, BackupService $backupService): BinaryFileResponse|RedirectResponse
    {
        try {
            $path = $backupService->resolveStoredBackup($file);

            return response()->download($path, basename($path));
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
