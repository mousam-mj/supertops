<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'show_on_parent_page')) {
                $table->boolean('show_on_parent_page')->default(true)->after('is_active');
            }
        });

        Schema::table('main_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('main_categories', 'bottom_banner_images')) {
                $table->json('bottom_banner_images')->nullable()->after('bottom_banner_text');
            }
            if (! Schema::hasColumn('main_categories', 'promo_banner_count')) {
                $table->unsignedTinyInteger('promo_banner_count')->default(3)->after('banner_texts');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'show_on_parent_page')) {
                $table->dropColumn('show_on_parent_page');
            }
        });

        Schema::table('main_categories', function (Blueprint $table) {
            if (Schema::hasColumn('main_categories', 'bottom_banner_images')) {
                $table->dropColumn('bottom_banner_images');
            }
            if (Schema::hasColumn('main_categories', 'promo_banner_count')) {
                $table->dropColumn('promo_banner_count');
            }
        });
    }
};
