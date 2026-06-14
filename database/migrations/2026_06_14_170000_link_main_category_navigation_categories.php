<?php

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        MainCategory::query()->where('is_active', true)->orderBy('sort_order')->each(function (MainCategory $main) {
            $root = Category::updateOrCreate(
                ['slug' => $main->slug],
                [
                    'name' => $main->name,
                    'main_category_id' => $main->id,
                    'parent_id' => null,
                    'is_active' => true,
                    'sort_order' => $main->sort_order ?? 0,
                ]
            );

            Category::query()
                ->whereNull('main_category_id')
                ->where(function ($q) use ($main) {
                    $q->where('slug', 'like', $main->slug.'-%')
                        ->orWhere('slug', 'like', $main->slug.'%');
                })
                ->update([
                    'main_category_id' => $main->id,
                    'parent_id' => $root->id,
                ]);
        });
    }

    public function down(): void
    {
        // Non-destructive: leave linked categories in place.
    }
};
