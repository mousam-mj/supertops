<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->string('banner_image_mobile')->nullable()->after('banner_image');
        });

        Schema::table('main_categories', function (Blueprint $table) {
            $table->string('image_mobile')->nullable()->after('image');
            $table->string('hero_image_mobile')->nullable()->after('hero_image');
            $table->json('banner_images_mobile')->nullable()->after('banner_images');
            $table->string('bottom_banner_image_mobile')->nullable()->after('bottom_banner_image');
            $table->string('bottom_banner_bg_image_mobile')->nullable()->after('bottom_banner_bg_image');
            $table->json('bottom_banner_images_mobile')->nullable()->after('bottom_banner_images');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('image_mobile')->nullable()->after('image');
            $table->string('hero_image_mobile')->nullable()->after('hero_image');
            $table->json('banner_images_mobile')->nullable()->after('banner_images');
        });
    }

    public function down(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->dropColumn('banner_image_mobile');
        });

        Schema::table('main_categories', function (Blueprint $table) {
            $table->dropColumn([
                'image_mobile',
                'hero_image_mobile',
                'banner_images_mobile',
                'bottom_banner_image_mobile',
                'bottom_banner_bg_image_mobile',
                'bottom_banner_images_mobile',
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'image_mobile',
                'hero_image_mobile',
                'banner_images_mobile',
            ]);
        });
    }
};
