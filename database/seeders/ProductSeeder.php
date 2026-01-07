<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        // Product data with realistic names and descriptions
        $products = [
            // Double Wall Bottles
            ['name' => 'Zenith Double Wall Bottle 500ml', 'price' => 29.99, 'sale_price' => 24.99, 'stock' => 50, 'category' => 'Double wall Bottles'],
            ['name' => 'Oasis Double Wall Bottle 750ml', 'price' => 34.99, 'sale_price' => null, 'stock' => 30, 'category' => 'Double wall Bottles'],
            ['name' => 'Oasis Pro Double Wall Bottle 1L', 'price' => 39.99, 'sale_price' => 34.99, 'stock' => 25, 'category' => 'Double wall Bottles'],
            ['name' => 'Zion Double Wall Bottle 500ml', 'price' => 27.99, 'sale_price' => null, 'stock' => 40, 'category' => 'Double wall Bottles'],
            ['name' => 'California Double Wall Bottle 750ml', 'price' => 32.99, 'sale_price' => 28.99, 'stock' => 35, 'category' => 'Double wall Bottles'],
            ['name' => 'Apex Double Wall Bottle 1L', 'price' => 42.99, 'sale_price' => null, 'stock' => 20, 'category' => 'Double wall Bottles'],
            ['name' => 'Retro Double Wall Bottle 500ml', 'price' => 31.99, 'sale_price' => 27.99, 'stock' => 15, 'category' => 'Double wall Bottles'],
            ['name' => 'Froste Double Wall Bottle 750ml', 'price' => 36.99, 'sale_price' => null, 'stock' => 28, 'category' => 'Double wall Bottles'],
            ['name' => 'Hydro Double Wall Bottle 1L', 'price' => 44.99, 'sale_price' => 39.99, 'stock' => 22, 'category' => 'Double wall Bottles'],
            
            // Single Wall Bottles
            ['name' => 'Magic Single Wall Bottle 500ml', 'price' => 19.99, 'sale_price' => null, 'stock' => 60, 'category' => 'Single Wall Bottles'],
            ['name' => 'Classic Single Wall Bottle 750ml', 'price' => 24.99, 'sale_price' => 21.99, 'stock' => 45, 'category' => 'Single Wall Bottles'],
            ['name' => 'Elegant Single Wall Bottle 1L', 'price' => 29.99, 'sale_price' => null, 'stock' => 38, 'category' => 'Single Wall Bottles'],
            
            // Barware Essentials
            ['name' => 'Elite Kit Barware Set', 'price' => 89.99, 'sale_price' => 79.99, 'stock' => 12, 'category' => 'Barware Essentials'],
            ['name' => 'Perch O Holic Cocktail Shaker', 'price' => 45.99, 'sale_price' => null, 'stock' => 25, 'category' => 'Barware Essentials'],
            ['name' => 'Premium Bar Tools Set', 'price' => 65.99, 'sale_price' => 55.99, 'stock' => 18, 'category' => 'Barware Essentials'],
            ['name' => 'Professional Mixing Set', 'price' => 52.99, 'sale_price' => null, 'stock' => 20, 'category' => 'Barware Essentials'],
            
            // Home & Kitchen
            ['name' => 'Speckle Storage Container Set', 'price' => 39.99, 'sale_price' => 34.99, 'stock' => 30, 'category' => 'Home & Kitchen'],
            ['name' => 'Modern Kitchen Utensil Set', 'price' => 49.99, 'sale_price' => null, 'stock' => 25, 'category' => 'Home & Kitchen'],
            ['name' => 'Premium Cookware Set', 'price' => 129.99, 'sale_price' => 109.99, 'stock' => 8, 'category' => 'Home & Kitchen'],
        ];

        foreach ($products as $productData) {
            // Find category by name
            $category = $categories->firstWhere('name', $productData['category']);
            
            if (!$category) {
                // Try to find a subcategory
                $category = $categories->first(function ($cat) use ($productData) {
                    return $cat->parent && $cat->parent->name === $productData['category'];
                });
                
                if (!$category) {
                    // Use first available category as fallback
                    $category = $categories->first();
                }
            }

            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $this->generateDescription($productData['name']),
                'short_description' => $this->generateShortDescription($productData['name']),
                'category_id' => $category ? $category->id : null,
                'price' => $productData['price'],
                'sale_price' => $productData['sale_price'],
                'sku' => 'PROD-' . strtoupper(Str::random(8)),
                'stock_quantity' => $productData['stock'],
                'in_stock' => $productData['stock'] > 0,
                'is_active' => true,
                'is_featured' => rand(0, 1) === 1, // Random featured products
                'sort_order' => rand(0, 100),
            ]);
        }

        $this->command->info('Products seeded successfully!');
    }

    private function generateDescription($name): string
    {
        return "Premium quality {$name}. Made with high-grade materials for durability and style. Perfect for everyday use. Features excellent craftsmanship and modern design.";
    }

    private function generateShortDescription($name): string
    {
        return "High-quality {$name} with modern design and premium materials.";
    }
}
