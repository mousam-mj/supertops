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

if (! function_exists('banner_picture_urls')) {
    /**
     * Desktop + mobile URLs for responsive banner images.
     *
     * @return array{desktop: string, mobile: string}
     */
    function banner_picture_urls(?string $desktop, ?string $mobile = null, ?string $defaultAssetPath = null): array
    {
        $desktopStored = trim((string) $desktop);
        $desktopUrl = $desktopStored !== ''
            ? storage_asset($desktop)
            : ($defaultAssetPath ? asset($defaultAssetPath) : '');

        $mobileStored = trim((string) $mobile);
        $mobileUrl = $mobileStored !== '' ? storage_asset($mobile) : $desktopUrl;

        return [
            'desktop' => $desktopUrl,
            'mobile' => $mobileUrl,
        ];
    }
}

if (! function_exists('setting_banner_picture_urls')) {
    /**
     * Setting-stored banner paths with optional mobile override key.
     *
     * @return array{desktop: string, mobile: string}
     */
    function setting_banner_picture_urls(string $desktopKey, ?string $mobileKey, string $defaultAssetPath): array
    {
        $desktop = trim((string) \App\Models\Setting::get($desktopKey, ''));
        $mobile = $mobileKey ? trim((string) \App\Models\Setting::get($mobileKey, '')) : '';

        return banner_picture_urls(
            $desktop !== '' ? $desktop : null,
            $mobile !== '' ? $mobile : null,
            $defaultAssetPath
        );
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

if (! function_exists('normalize_banner_text_color')) {
    /**
     * Normalize banner text color to black, white, or null (use site default).
     */
    function normalize_banner_text_color(?string $value): ?string
    {
        $color = strtolower(trim((string) $value));
        if ($color === '' || $color === 'default') {
            return null;
        }

        return in_array($color, ['black', 'white'], true) ? $color : null;
    }
}

if (! function_exists('banner_text_color_mode')) {
    /**
     * Resolved banner text color: black or white.
     */
    function banner_text_color_mode(?string $override = null): string
    {
        $normalized = normalize_banner_text_color($override);
        if ($normalized !== null) {
            return $normalized;
        }

        $default = strtolower(trim((string) \App\Models\Setting::get('banner_text_color_default', 'black')));

        return $default === 'white' ? 'white' : 'black';
    }
}

if (! function_exists('banner_text_color_class')) {
    /**
     * CSS class for banner text tone (banner-text-tone-black|white).
     */
    function banner_text_color_class(?string $override = null): string
    {
        return 'banner-text-tone-'.banner_text_color_mode($override);
    }
}

if (! function_exists('normalize_banner_text_align')) {
    /**
     * Normalize banner text alignment to left, center, or right.
     */
    function normalize_banner_text_align(?string $value): string
    {
        $align = strtolower(trim((string) $value));

        return in_array($align, ['left', 'center', 'right'], true) ? $align : 'center';
    }
}

if (! function_exists('banner_text_align_class')) {
    /**
     * Tailwind text alignment class for banner copy.
     */
    function banner_text_align_class(?string $align = null): string
    {
        return match (normalize_banner_text_align($align)) {
            'left' => 'text-left',
            'right' => 'text-right',
            default => 'text-center',
        };
    }
}

if (! function_exists('banner_text_align_flex_class')) {
    /**
     * Flex alignment classes for banner content containers.
     */
    function banner_text_align_flex_class(?string $align = null): string
    {
        return match (normalize_banner_text_align($align)) {
            'left' => 'items-start justify-start',
            'right' => 'items-end justify-end',
            default => 'items-center justify-center',
        };
    }
}

if (! function_exists('product_search_has_results')) {
    /**
     * Whether any active product matches a search term.
     */
    function product_search_has_results(string $term): bool
    {
        $term = trim($term);
        if ($term === '') {
            return false;
        }

        return \App\Models\Product::query()
            ->where('is_active', true)
            ->searchTerm($term)
            ->exists();
    }
}

if (! function_exists('popular_search_suggestions')) {
    /**
     * Popular search chips for the search modal — categories and terms that match real inventory.
     *
     * @return array<int, array{label: string, url: string}>
     */
    function popular_search_suggestions(int $limit = 6): array
    {
        $suggestions = [];
        $seen = [];

        $add = function (string $label, string $url) use (&$suggestions, &$seen, $limit): void {
            $key = strtolower(trim($label));
            if ($key === '' || isset($seen[$key]) || count($suggestions) >= $limit) {
                return;
            }

            $seen[$key] = true;
            $suggestions[] = ['label' => $label, 'url' => $url];
        };

        foreach (\App\Models\MainCategory::visible()->orderBy('sort_order')->get() as $mainCategory) {
            $add($mainCategory->name, route('category', $mainCategory->slug));
        }

        foreach (\App\Models\Category::query()
            ->where('is_active', true)
            ->whereNotNull('parent_id')
            ->orderBy('sort_order')
            ->get() as $category) {
            $add($category->name, route('category', $category->slug));
        }

        foreach (\App\Models\MainCategory::visible()->orderBy('sort_order')->get() as $mainCategory) {
            foreach ($mainCategory->banner_texts ?? [] as $bannerText) {
                $label = trim((string) $bannerText);
                if ($label !== '' && product_search_has_results($label)) {
                    $add($label, route('search', ['q' => $label]));
                }
            }
        }

        foreach (['Bottle', 'Insulated', 'Tumbler', 'Whiskey', 'Cocktail', 'Flask', 'Bar'] as $priorityTerm) {
            if (product_search_has_results($priorityTerm)) {
                $add($priorityTerm, route('search', ['q' => $priorityTerm]));
            }
        }

        $wordCounts = [];
        $productTerms = \App\Models\Product::query()
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->limit(60)
            ->pluck('name');

        $stopWords = [
            'with', 'and', 'the', 'for', 'set', 'piece', 'pieces', 'print', 'leatherette',
            'suitcase', 'army', 'crocodile', 'natural', 'flavors', 'flavour', 'flavours',
            'rose', 'gold', 'golden', 'silver', 'black', 'white',
        ];

        foreach ($productTerms as $productName) {
            foreach (preg_split('/[^a-zA-Z0-9]+/', (string) $productName) ?: [] as $word) {
                $word = strtolower($word);
                if (strlen($word) < 4 || in_array($word, $stopWords, true)) {
                    continue;
                }

                $wordCounts[$word] = ($wordCounts[$word] ?? 0) + 1;
            }
        }

        arsort($wordCounts);

        foreach (array_keys($wordCounts) as $word) {
            if (product_search_has_results($word)) {
                $add(ucfirst($word), route('search', ['q' => $word]));
            }
        }

        return array_slice($suggestions, 0, $limit);
    }
}
