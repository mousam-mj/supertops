<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('parent_product_id')
                ->nullable()
                ->after('category_id')
                ->constrained('products')
                ->nullOnDelete();
            $table->string('variant_color_label')->nullable()->after('parent_product_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['parent_product_id']);
            $table->dropColumn(['parent_product_id', 'variant_color_label']);
        });
    }
};
