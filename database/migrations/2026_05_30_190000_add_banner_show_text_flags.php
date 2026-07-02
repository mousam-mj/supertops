<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            if (! Schema::hasColumn('hero_banners', 'show_text')) {
                $table->boolean('show_text')->default(false)->after('button_text');
            }
        });

        Schema::table('main_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('main_categories', 'hero_show_text')) {
                $table->boolean('hero_show_text')->default(true)->after('hero_button_text');
            }
            if (! Schema::hasColumn('main_categories', 'promo_show_text')) {
                $table->boolean('promo_show_text')->default(true)->after('promo_banner_count');
            }
            if (! Schema::hasColumn('main_categories', 'subcategory_cards_show_text')) {
                $table->boolean('subcategory_cards_show_text')->default(true)->after('promo_show_text');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'hero_show_text')) {
                $table->boolean('hero_show_text')->default(true)->after('hero_button_text');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            if (Schema::hasColumn('hero_banners', 'show_text')) {
                $table->dropColumn('show_text');
            }
        });

        Schema::table('main_categories', function (Blueprint $table) {
            foreach (['hero_show_text', 'promo_show_text', 'subcategory_cards_show_text'] as $column) {
                if (Schema::hasColumn('main_categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'hero_show_text')) {
                $table->dropColumn('hero_show_text');
            }
        });
    }
};
