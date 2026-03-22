<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CustomizeProductSeeder extends Seeder
{
    /**
     * Seed customizable products (Hydro Flask style tumbler).
     */
    public function run(): void
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $category = $categories->firstWhere('name', 'Double wall Bottles')
            ?? $categories->first();

        $imagePath = 'assets/images/product/Bottle-8.webp';
        $sourcePath = public_path($imagePath);
        if (!File::exists($sourcePath)) {
            $imagePath = 'assets/images/product/perch-bottal.webp';
        }

        $slug = '1200ml-running-tumbler';
        $existingProduct = Product::where('slug', $slug)->first();

        $customizeConfig = [
            'sizes' => [
                ['name' => '24 oz', 'desc' => 'Insulated tumbler for life on the go.', 'price' => 3500],
                ['name' => '32 oz', 'desc' => 'Medium insulated tumbler.', 'price' => 4000],
                ['name' => '40 oz', 'desc' => 'Large insulated tumbler with handle and straw.', 'price' => 4500],
            ],
            'bottle_colors' => [
                ['name' => 'Stone', 'hex' => '#6b6b6b'],
                ['name' => 'Black', 'hex' => '#1a1a1a'],
                ['name' => 'White', 'hex' => '#f0f0ee'],
                ['name' => 'Pacific', 'hex' => '#3b78c4'],
                ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
                ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
                ['name' => 'Carnation', 'hex' => '#e8a29a'],
                ['name' => 'Tan', 'hex' => '#c2a97d'],
            ],
            'cap_colors' => [
                ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
                ['name' => 'Pacific', 'hex' => '#3b78c4'],
                ['name' => 'Green', 'hex' => '#3aaa5a'],
                ['name' => 'Camellia', 'hex' => '#e87aaa'],
                ['name' => 'Black', 'hex' => '#1a1a1a'],
                ['name' => 'White', 'hex' => '#f0f0ee'],
            ],
            'strap_colors' => [
                ['name' => 'Camellia', 'hex' => '#e87aaa'],
                ['name' => 'Black', 'hex' => '#1a1a1a'],
                ['name' => 'Pacific', 'hex' => '#3b78c4'],
                ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
            ],
            'boot_colors' => [
                ['name' => 'Black', 'hex' => '#1a1a1a'],
                ['name' => 'White', 'hex' => '#f0f0ee'],
                ['name' => 'Stone', 'hex' => '#6b6b6b'],
                ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
            ],
            'engraving_price' => 600,
            'has_engraving' => true,
        ];

        $data = [
            'name' => '1200ml Running Tumbler',
            'description' => 'Premium quality 1200ml Running Tumbler. Customize size, colors (tumbler, lid, straw, boot) and add engraving. Made with high-grade materials for durability and style.',
            'short_description' => 'Customizable insulated tumbler with size, color options and engraving.',
            'category_id' => $category->id,
            'price' => 2500,
            'sale_price' => 2499,
            'stock_quantity' => 50,
            'in_stock' => true,
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'image' => $imagePath,
            'images' => [$imagePath],
            'sort_order' => 0,
            'customize_config' => $customizeConfig,
        ];

        if ($existingProduct) {
            $existingProduct->update($data);
            $this->command->info('Customize product updated: 1200ml Running Tumbler');
        } else {
            Product::create(array_merge($data, [
                'slug' => $slug,
                'sku' => 'PROD-TUMBLER-' . strtoupper(Str::random(6)),
            ]));
            $this->command->info('Customize product created: 1200ml Running Tumbler');
        }
    }
}
