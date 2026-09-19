<?php

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the main Barware category
        $mainBarware = MainCategory::where('slug', 'barware')->first();
        if (! $mainBarware) {
            return;
        }

        // Get the Barware root category
        $barwareRoot = Category::where('slug', 'barware')
            ->where('main_category_id', $mainBarware->id)
            ->whereNull('parent_id')
            ->first();

        if (! $barwareRoot) {
            return;
        }

        // Create "Cocktail Sets" subcategory
        $cocktailSets = Category::firstOrCreate(
            ['slug' => 'cocktail-sets'],
            [
                'name' => 'Cocktail Sets',
                'description' => 'Premium cocktail sets for home entertaining',
                'parent_id' => $barwareRoot->id,
                'main_category_id' => $mainBarware->id,
                'sort_order' => 2,
                'is_active' => true,
                'show_on_parent_page' => true,
                'hero_button_text' => 'Shop Now',
                'hero_show_text' => true,
            ]
        );

        // Move existing barware products to appropriate subcategories
        // Note: These are actual Product models, not Category models
        $barwareEssentials = Category::where('slug', 'barware-essentials')->first();
        $cocktailSets = Category::where('slug', 'cocktail-sets')->first();

        if ($barwareEssentials && $cocktailSets) {
            // Move all remaining barware products to appropriate subcategories
            // Move cocktail shaker sets and bartender kits to Barware Essentials
            \App\Models\Product::where('category_id', $barwareRoot->id)
                ->where(function($query) {
                    $query->where('name', 'like', '%Cocktail Shaker Set%')
                          ->orWhere('name', 'like', '%Bartender Kit%')
                          ->orWhere('name', 'like', '%Ice Bucket Set%');
                })
                ->update(['category_id' => $barwareEssentials->id]);

            // Move suitcase bar sets to Cocktail Sets (from any category including Barware Essentials)
            \App\Models\Product::where('name', 'like', '%Suitcase Bar Set%')
                ->update(['category_id' => $cocktailSets->id]);

            // Move smoker kits to Cocktail Sets (from any category including Barware Essentials)
            \App\Models\Product::where('name', 'like', '%Smoker Kit%')
                ->update(['category_id' => $cocktailSets->id]);
        }

        // Ensure Barware Essentials is properly set up
        $barwareEssentials = Category::where('slug', 'barware-essentials')->first();
        if ($barwareEssentials) {
            $barwareEssentials->update([
                'parent_id' => $barwareRoot->id,
                'main_category_id' => $mainBarware->id,
                'sort_order' => 1,
                'show_on_parent_page' => true,
                'hero_button_text' => 'Shop Now',
                'hero_show_text' => true,
            ]);
        }

        // Update sort orders
        Category::where('slug', 'barware-essentials')->update(['sort_order' => 1]);
        Category::where('slug', 'cocktail-sets')->update(['sort_order' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get the main Barware category
        $mainBarware = MainCategory::where('slug', 'barware')->first();
        if (! $mainBarware) {
            return;
        }

        // Get the Barware root category
        $barwareRoot = Category::where('slug', 'barware')
            ->where('main_category_id', $mainBarware->id)
            ->whereNull('parent_id')
            ->first();

        if (! $barwareRoot) {
            return;
        }

        // Get subcategories
        $barwareEssentials = Category::where('slug', 'barware-essentials')->first();
        $cocktailSets = Category::where('slug', 'cocktail-sets')->first();

        // Move all products back to the Barware root category
        if ($barwareEssentials) {
            \App\Models\Product::where('category_id', $barwareEssentials->id)
                ->update(['category_id' => $barwareRoot->id]);
        }

        if ($cocktailSets) {
            \App\Models\Product::where('category_id', $cocktailSets->id)
                ->update(['category_id' => $barwareRoot->id]);
        }

        // Delete the Cocktail Sets subcategory
        Category::where('slug', 'cocktail-sets')->delete();
    }
};
