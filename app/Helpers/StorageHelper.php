<?php

if (! function_exists('storage_asset')) {
    /**
     * Storage public URL (respects STORAGE_PUBLIC_PATH=media when set).
     */
    function storage_asset(?string $path): string
    {
        if (! $path) {
            return '';
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url(ltrim($path, '/'));
    }
}
