<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('main_categories', 'hero_section_enabled')) {
                $table->boolean('hero_section_enabled')->default(true)->after('hero_show_text');
            }
            if (! Schema::hasColumn('main_categories', 'whats_new_section_enabled')) {
                $table->boolean('whats_new_section_enabled')->default(true)->after('hero_section_enabled');
            }
            if (! Schema::hasColumn('main_categories', 'subcategory_cards_section_enabled')) {
                $table->boolean('subcategory_cards_section_enabled')->default(true)->after('whats_new_section_enabled');
            }
            if (! Schema::hasColumn('main_categories', 'testimonial_section_enabled')) {
                $table->boolean('testimonial_section_enabled')->default(true)->after('subcategory_cards_section_enabled');
            }
            if (! Schema::hasColumn('main_categories', 'promo_section_enabled')) {
                $table->boolean('promo_section_enabled')->default(true)->after('testimonial_section_enabled');
            }
            if (! Schema::hasColumn('main_categories', 'benefits_section_enabled')) {
                $table->boolean('benefits_section_enabled')->default(true)->after('promo_section_enabled');
            }
            if (! Schema::hasColumn('main_categories', 'instagram_section_enabled')) {
                $table->boolean('instagram_section_enabled')->default(true)->after('benefits_section_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('main_categories', function (Blueprint $table) {
            $columns = [
                'hero_section_enabled',
                'whats_new_section_enabled',
                'subcategory_cards_section_enabled',
                'testimonial_section_enabled',
                'promo_section_enabled',
                'benefits_section_enabled',
                'instagram_section_enabled',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('main_categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
