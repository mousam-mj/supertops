<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerMedia
{
    public static function replaceUploaded(Request $request, string $field, ?string $oldPath, string $directory): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($field)->store($directory, 'public');
    }

    public static function removeIfRequested(Request $request, string $removeField, ?string $path): ?string
    {
        if ($request->filled($removeField) && $request->input($removeField) == '1') {
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return null;
        }

        return $path;
    }

    /**
     * @param  array<int, string|null>  $existing
     * @return array<int, string|null>
     */
    public static function syncJsonImageSlots(
        Request $request,
        string $filesKey,
        string $removeKey,
        array $existing,
        int $maxSlots,
        string $directory
    ): array {
        while (count($existing) < $maxSlots) {
            $existing[] = null;
        }
        $existing = array_slice($existing, 0, $maxSlots);

        if ($request->hasFile($filesKey)) {
            foreach ($request->file($filesKey) as $index => $file) {
                if ($file && $file->isValid() && $index >= 0 && $index < $maxSlots) {
                    if (! empty($existing[$index])) {
                        Storage::disk('public')->delete($existing[$index]);
                    }
                    $existing[(int) $index] = $file->store($directory, 'public');
                }
            }
        }

        foreach ($request->input($removeKey, []) as $index => $remove) {
            if ($remove == '1' && ! empty($existing[$index])) {
                Storage::disk('public')->delete($existing[$index]);
                $existing[(int) $index] = null;
            }
        }

        return $existing;
    }

    /** @return array<int, string|null>|null */
    public static function filteredJsonSlots(array $slots): ?array
    {
        return count(array_filter($slots)) > 0 ? $slots : null;
    }
}
