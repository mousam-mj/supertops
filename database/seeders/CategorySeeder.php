<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Drinkware (Main Category)
        $drinkware = Category::create([
            'name' => 'Drinkware',
            'slug' => 'drinkware',
            'description' => 'Drinkware products',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 1.1 Double wall Bottles (Sub-category)
        $doubleWallBottles = Category::create([
            'name' => 'Double wall Bottles',
            'slug' => 'double-wall-bottles',
            'description' => 'Double wall insulated bottles',
            'parent_id' => $drinkware->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Double wall Bottles - Products
        $doubleWallProducts = [
            'Zenith',
            'Oasis',
            'Oasis Pro',
            'Zion',
            'California',
            'Apex',
            'Retro',
            'Froste',
            'Hydro',
        ];

        foreach ($doubleWallProducts as $index => $productName) {
            Category::create([
                'name' => $productName,
                'slug' => Str::slug($productName),
                'description' => $productName . ' - Double wall bottle',
                'parent_id' => $doubleWallBottles->id,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // 1.2 Single Wall Bottles (Sub-category)
        $singleWallBottles = Category::create([
            'name' => 'Single Wall Bottles',
            'slug' => 'single-wall-bottles',
            'description' => 'Single wall bottles',
            'parent_id' => $drinkware->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Single Wall Bottles - Products
        Category::create([
            'name' => 'Magic',
            'slug' => 'magic',
            'description' => 'Magic - Single wall bottle',
            'parent_id' => $singleWallBottles->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. Barware Essentials (Main Category)
        $barware = Category::create([
            'name' => 'Barware Essentials',
            'slug' => 'barware-essentials',
            'description' => 'Essential barware products',
            'parent_id' => null,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Barware Essentials - Products
        $barwareProducts = [
            'Perch O Holic',
            'Elite Kit',
            'Suitcase Bar Set',
            '3D Printed Cocktail Set',
        ];

        foreach ($barwareProducts as $index => $productName) {
            Category::create([
                'name' => $productName,
                'slug' => Str::slug($productName),
                'description' => $productName . ' - Barware essential',
                'parent_id' => $barware->id,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // 3. Home & Kitchen (Main Category)
        $homeKitchen = Category::create([
            'name' => 'Home & Kitchen',
            'slug' => 'home-kitchen',
            'description' => 'Home and kitchen products',
            'parent_id' => null,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Home & Kitchen - Products
        $homeKitchenProducts = [
            'Speckle',
            'Plaxa',
            'Graters & Bowls',
            'Cheese Shakers',
            'Measuring Cup & Spoon',
        ];

        foreach ($homeKitchenProducts as $index => $productName) {
            Category::create([
                'name' => $productName,
                'slug' => Str::slug($productName),
                'description' => $productName . ' - Home & kitchen product',
                'parent_id' => $homeKitchen->id,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
