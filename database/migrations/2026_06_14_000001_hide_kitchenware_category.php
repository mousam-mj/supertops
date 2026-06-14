<?php

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $main = MainCategory::query()->where('slug', 'kitchenware')->first();
        if ($main) {
            $main->update(['is_active' => false]);
            Category::query()
                ->where('main_category_id', $main->id)
                ->update(['is_active' => false]);
        }

        Category::query()
            ->where('slug', 'kitchenware')
            ->update(['is_active' => false]);
    }

    public function down(): void
    {
        $main = MainCategory::query()->where('slug', 'kitchenware')->first();
        if ($main) {
            $main->update(['is_active' => true]);
            Category::query()
                ->where('main_category_id', $main->id)
                ->update(['is_active' => true]);
        }

        Category::query()
            ->where('slug', 'kitchenware')
            ->update(['is_active' => true]);
    }
};
