<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hero_banners') && ! Schema::hasColumn('hero_banners', 'text_color')) {
            Schema::table('hero_banners', function (Blueprint $table) {
                $table->string('text_color', 10)->default('black')->after('show_text');
            });
        }

        if (Schema::hasTable('main_categories')) {
            Schema::table('main_categories', function (Blueprint $table) {
                if (! Schema::hasColumn('main_categories', 'hero_text_color')) {
                    $table->string('hero_text_color', 10)->nullable()->after('hero_show_text');
                }
                if (! Schema::hasColumn('main_categories', 'promo_text_color')) {
                    $table->string('promo_text_color', 10)->nullable()->after('promo_show_text');
                }
            });
        }

        if (Schema::hasTable('categories') && ! Schema::hasColumn('categories', 'hero_text_color')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('hero_text_color', 10)->nullable()->after('hero_show_text');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('hero_banners') && Schema::hasColumn('hero_banners', 'text_color')) {
            Schema::table('hero_banners', function (Blueprint $table) {
                $table->dropColumn('text_color');
            });
        }

        if (Schema::hasTable('main_categories')) {
            Schema::table('main_categories', function (Blueprint $table) {
                if (Schema::hasColumn('main_categories', 'hero_text_color')) {
                    $table->dropColumn('hero_text_color');
                }
                if (Schema::hasColumn('main_categories', 'promo_text_color')) {
                    $table->dropColumn('promo_text_color');
                }
            });
        }

        if (Schema::hasTable('categories') && Schema::hasColumn('categories', 'hero_text_color')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('hero_text_color');
            });
        }
    }
};
