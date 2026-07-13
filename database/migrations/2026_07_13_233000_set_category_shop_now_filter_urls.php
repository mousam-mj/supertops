<?php

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        foreach (MainCategory::query()->get() as $main) {
            $shop = '/shop?category='.$main->slug;
            $changed = false;

            if (trim((string) ($main->hero_button_url ?? '')) === '') {
                $main->hero_button_url = $shop;
                $changed = true;
            }

            if (trim((string) ($main->bottom_banner_button_url ?? '')) === '') {
                $main->bottom_banner_button_url = $shop;
                $changed = true;
            }

            $bannerUrls = is_array($main->banner_urls) ? $main->banner_urls : [];
            $newBannerUrls = [];
            foreach ($bannerUrls as $i => $url) {
                $url = trim((string) $url);
                if ($url === '' || $url === '/shop' || str_contains($url, '/category/')) {
                    $newBannerUrls[$i] = $shop;
                } else {
                    $newBannerUrls[$i] = $url;
                }
            }
            if ($newBannerUrls !== $bannerUrls) {
                $main->banner_urls = array_values($newBannerUrls);
                $changed = true;
            }

            $blockUrls = is_array($main->bottom_banner_block_urls) ? $main->bottom_banner_block_urls : [];
            $newBlockUrls = [];
            foreach ($blockUrls as $i => $url) {
                $url = trim((string) $url);
                if ($url === '' || $url === '/shop' || str_contains($url, '/category/')) {
                    $newBlockUrls[$i] = $shop;
                } else {
                    $newBlockUrls[$i] = $url;
                }
            }
            if ($newBlockUrls !== $blockUrls) {
                $main->bottom_banner_block_urls = array_values($newBlockUrls);
                $changed = true;
            }

            if ($changed) {
                $main->save();
            }
        }

        foreach (Category::query()->where('is_active', true)->get() as $category) {
            if (trim((string) ($category->hero_button_url ?? '')) === '') {
                $category->hero_button_url = '/shop?category='.$category->slug;
                $category->save();
            }
        }
    }

    public function down(): void
    {
        // Non-destructive data migration; no reverse.
    }
};
