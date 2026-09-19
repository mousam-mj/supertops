<?php

use App\Models\Setting;

if (! function_exists('site_brand_name')) {
    function site_brand_name(): string
    {
        return trim((string) Setting::get('site_name', 'Perch')) ?: 'Perch';
    }
}

if (! function_exists('site_tagline')) {
    function site_tagline(): string
    {
        return trim((string) Setting::get('site_tagline', 'Your Things Elevated')) ?: 'Your Things Elevated';
    }
}

if (! function_exists('site_page_title')) {
    function site_page_title(?string $pageTitle = null): string
    {
        $brand = site_brand_name();
        $defaultTitle = trim((string) Setting::get('default_meta_title', 'Your Things Elevated')) ?: 'Your Things Elevated';

        if ($pageTitle !== null && trim($pageTitle) !== '') {
            return trim($pageTitle).' | '.$brand.' - '.$defaultTitle;
        }

        return $brand.' | '.$defaultTitle;
    }
}
