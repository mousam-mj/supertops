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

if (! function_exists('setting_form_value')) {
    /**
     * Value for admin settings inputs (old input, stored value, or theme default).
     */
    function setting_form_value(string $key, array $settings, string $default): string
    {
        $old = old($key);
        if ($old !== null) {
            return $old;
        }

        $stored = trim((string) ($settings[$key] ?? ''));

        return $stored !== '' ? $stored : $default;
    }
}

if (! function_exists('setting_image_url')) {
    /**
     * Setting-stored image path or fallback public asset.
     */
    function setting_image_url(?string $storedPath, string $defaultAssetPath): string
    {
        $storedPath = trim((string) $storedPath);
        if ($storedPath !== '') {
            if (str_starts_with($storedPath, 'http://') || str_starts_with($storedPath, 'https://')) {
                return $storedPath;
            }

            return storage_asset($storedPath);
        }

        return asset($defaultAssetPath);
    }
}

if (! function_exists('setting_flag')) {
    /**
     * Boolean setting (1/0, true/false, yes/no).
     */
    function setting_flag(string $key, bool $default = true): bool
    {
        $value = \App\Models\Setting::get($key);

        if ($value === null || $value === '') {
            return $default;
        }

        return in_array(strtolower((string) $value), ['1', 'true', 'yes', 'on'], true);
    }
}

if (! function_exists('setting_link_url')) {
    /**
     * Admin-entered link (path or full URL) with fallback.
     */
    function setting_link_url(?string $value, string $defaultUrl): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return $defaultUrl;
        }
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return url(str_starts_with($value, '/') ? $value : '/'.$value);
    }
}
