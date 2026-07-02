<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('main_categories', 'bottom_banner_section_enabled')) {
                $table->boolean('bottom_banner_section_enabled')->default(true)->after('bottom_banner_text');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_show_text')) {
                $table->boolean('bottom_banner_show_text')->default(true)->after('bottom_banner_section_enabled');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_subtext')) {
                $table->string('bottom_banner_subtext')->nullable()->after('bottom_banner_show_text');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_button_text')) {
                $table->string('bottom_banner_button_text')->nullable()->after('bottom_banner_subtext');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_button_url')) {
                $table->string('bottom_banner_button_url')->nullable()->after('bottom_banner_button_text');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_bg_image')) {
                $table->string('bottom_banner_bg_image')->nullable()->after('bottom_banner_button_url');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_blocks_enabled')) {
                $table->boolean('bottom_banner_blocks_enabled')->default(true)->after('bottom_banner_images');
            }
            if (! Schema::hasColumn('main_categories', 'bottom_banner_block_urls')) {
                $table->json('bottom_banner_block_urls')->nullable()->after('bottom_banner_blocks_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('main_categories', function (Blueprint $table) {
            foreach ([
                'bottom_banner_section_enabled',
                'bottom_banner_show_text',
                'bottom_banner_subtext',
                'bottom_banner_button_text',
                'bottom_banner_button_url',
                'bottom_banner_bg_image',
                'bottom_banner_blocks_enabled',
                'bottom_banner_block_urls',
            ] as $column) {
                if (Schema::hasColumn('main_categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
