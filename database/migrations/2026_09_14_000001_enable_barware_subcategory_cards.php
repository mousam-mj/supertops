<?php

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $barwareMain = MainCategory::where('slug', 'barware')->first();
        if (! $barwareMain) {
            return;
        }

        MainCategory::where('id', $barwareMain->id)->update([
            'subcategory_cards_section_enabled' => true,
        ]);

        $barwareRoot = Category::where('slug', 'barware')
            ->where('main_category_id', $barwareMain->id)
            ->whereNull('parent_id')
            ->first();

        if ($barwareRoot) {
            Category::where('parent_id', $barwareRoot->id)->update([
                'show_on_parent_page' => true,
            ]);
        }

        $drinkwareRoot = Category::where('slug', 'drinkware')->first();
        if ($drinkwareRoot) {
            Category::where('parent_id', $drinkwareRoot->id)->update([
                'show_on_parent_page' => true,
            ]);
        }
    }

    public function down(): void
    {
        MainCategory::where('slug', 'barware')->update([
            'subcategory_cards_section_enabled' => false,
        ]);
    }
};
