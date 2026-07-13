<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('main_categories')) {
            Schema::table('main_categories', function (Blueprint $table) {
                if (! Schema::hasColumn('main_categories', 'hero_button_url')) {
                    $table->string('hero_button_url')->nullable()->after('hero_button_text');
                }
                if (! Schema::hasColumn('main_categories', 'promo_button_text')) {
                    $table->string('promo_button_text')->nullable()->after('promo_show_text');
                }
                if (! Schema::hasColumn('main_categories', 'banner_urls')) {
                    $table->json('banner_urls')->nullable()->after('banner_texts');
                }
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (! Schema::hasColumn('categories', 'hero_button_url')) {
                    $table->string('hero_button_url')->nullable()->after('hero_button_text');
                }
                if (! Schema::hasColumn('categories', 'banner_urls')) {
                    $table->json('banner_urls')->nullable()->after('banner_texts');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('main_categories')) {
            Schema::table('main_categories', function (Blueprint $table) {
                foreach (['hero_button_url', 'promo_button_text', 'banner_urls'] as $column) {
                    if (Schema::hasColumn('main_categories', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                foreach (['hero_button_url', 'banner_urls'] as $column) {
                    if (Schema::hasColumn('categories', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
