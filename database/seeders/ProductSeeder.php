<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 30 mobile accessory products with original (Unsplash) image URLs.
     */
    public function run(): void
    {
        $main = MainCategory::where('slug', 'mobile-accessories')->first();
        if (!$main) {
            $this->command->warn('Mobile Accessories main category not found. Run CategorySeeder first.');
            return;
        }

        $categories = Category::where('main_category_id', $main->id)->get();
        if ($categories->isEmpty()) {
            $this->command->warn('No mobile accessory categories found. Run CategorySeeder first.');
            return;
        }

        $products = [
            ['name' => 'Silicone iPhone Case - Clear Protective', 'price' => 599, 'sale_price' => 449, 'category_name' => 'Phone Cases', 'image' => 'https://images.unsplash.com/photo-1601593346742-d1c539289bfe?w=600', 'description' => 'Premium clear silicone case with shock absorption. Fits iPhone 14/15 series.'],
            ['name' => 'Leather Wallet Phone Case', 'price' => 1299, 'sale_price' => null, 'category_name' => 'Phone Cases', 'image' => 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600', 'description' => 'Genuine leather wallet case with card slots and magnetic closure.'],
            ['name' => 'Rugged Armor Shockproof Case', 'price' => 899, 'sale_price' => 699, 'category_name' => 'Phone Cases', 'image' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=600', 'description' => 'Military-grade drop protection. Dual-layer design.'],
            ['name' => 'USB-C Fast Charger 25W', 'price' => 799, 'sale_price' => 599, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600', 'description' => 'PD 3.0 compatible. Fast charge compatible with Samsung/iPhone.'],
            ['name' => 'Wireless Charging Pad 15W', 'price' => 1499, 'sale_price' => 1199, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1625723044792-44de16ccb4e9?w=600', 'description' => 'Qi-certified. LED indicator. Non-slip surface.'],
            ['name' => 'Car Charger Dual Port 36W', 'price' => 649, 'sale_price' => null, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=600', 'description' => 'Dual USB-A + USB-C. Quick Charge 3.0 support.'],
            ['name' => 'Braided USB-C to Lightning Cable 1m', 'price' => 499, 'sale_price' => 399, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1583394293214-28f3f2b2a2a2?w=600', 'description' => 'Nylon braided. MFi certified. Durable design.'],
            ['name' => 'Wireless Bluetooth Earbuds TWS', 'price' => 2499, 'sale_price' => 1999, 'category_name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1598331668826-20cecc596b86?w=600', 'description' => 'Active noise cancellation. 30hr total battery. IPX5 water resistant.'],
            ['name' => 'Over-Ear Wireless Headphones', 'price' => 3999, 'sale_price' => 3299, 'category_name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600', 'description' => '40mm drivers. 35hr playback. Foldable with carry case.'],
            ['name' => 'Gaming Headset with Mic', 'price' => 2799, 'sale_price' => null, 'category_name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=600', 'description' => '7.1 surround. Detachable mic. RGB lighting.'],
            ['name' => 'Sports Running Wireless Earbuds', 'price' => 1799, 'sale_price' => 1499, 'category_name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1577174881658-45f9d3f2c932?w=600', 'description' => 'Ear hooks. IPX7. 8hr battery. Secure fit.'],
            ['name' => 'Tempered Glass Screen Protector 9H', 'price' => 299, 'sale_price' => 199, 'category_name' => 'Protection', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600', 'description' => '9H hardness. Oleophobic coating. Bubble-free installation.'],
            ['name' => 'Camera Lens Protector Kit', 'price' => 449, 'sale_price' => null, 'category_name' => 'Protection', 'image' => 'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=600', 'description' => 'Sapphire glass. Anti-glare. Easy alignment.'],
            ['name' => 'Privacy Screen Protector', 'price' => 599, 'sale_price' => 499, 'category_name' => 'Protection', 'image' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=600', 'description' => '45° viewing angle. Blue light filter. HD clear.'],
            ['name' => '10000mAh Power Bank 22.5W', 'price' => 1499, 'sale_price' => 1199, 'category_name' => 'Power Banks', 'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=600', 'description' => 'Dual USB output. Fast charge. Compact design.'],
            ['name' => '20000mAh Power Bank 65W PD', 'price' => 2999, 'sale_price' => null, 'category_name' => 'Power Banks', 'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=600', 'description' => 'Laptop charging. 3 ports. LED display.'],
            ['name' => 'Wireless Power Bank 10000mAh', 'price' => 2299, 'sale_price' => 1999, 'category_name' => 'Power Banks', 'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=600', 'description' => 'Qi wireless + USB. Stand design. Fast charge.'],
            ['name' => 'Aluminum Phone Stand Desktop', 'price' => 499, 'sale_price' => 399, 'category_name' => 'Stands & Mounts', 'image' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=600', 'description' => 'Adjustable angle. Non-slip base. Portable.'],
            ['name' => 'Car Vent Magnetic Phone Mount', 'price' => 649, 'sale_price' => null, 'category_name' => 'Stands & Mounts', 'image' => 'https://images.unsplash.com/photo-1601593346742-d1c539289bfe?w=600', 'description' => 'Strong magnet. 360° rotation. One-hand operation.'],
            ['name' => 'Gaming Phone Cooler Mount', 'price' => 1799, 'sale_price' => 1499, 'category_name' => 'Stands & Mounts', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600', 'description' => 'Active cooling. Adjustable. Compatible with controllers.'],
            ['name' => 'Portable Bluetooth Speaker', 'price' => 1999, 'sale_price' => 1699, 'category_name' => 'Audio Accessories', 'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600', 'description' => 'IPX7 waterproof. 12hr play. Bass boost.'],
            ['name' => 'USB-C to 3.5mm Audio Adapter', 'price' => 349, 'sale_price' => 249, 'category_name' => 'Audio Accessories', 'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600', 'description' => 'DAC included. No loss in quality. Compact.'],
            ['name' => 'Magnetic Cable Organizer', 'price' => 199, 'sale_price' => null, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600', 'description' => 'Cable management. Reusable. Multiple colors.'],
            ['name' => 'Premium Silicone Watch Band', 'price' => 899, 'sale_price' => 699, 'category_name' => 'Phone Cases', 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600', 'description' => 'Comfortable. Sweat resistant. Quick release pins.'],
            ['name' => 'Multi-Port USB Hub 4-in-1', 'price' => 999, 'sale_price' => 799, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=600', 'description' => 'USB 3.0. HDMI. SD card reader. Compact.'],
            ['name' => 'Noise Cancelling Ear Tips Set', 'price' => 299, 'sale_price' => 199, 'category_name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1577174881658-45f9d3f2c932?w=600', 'description' => '3 sizes. Memory foam. Better seal and bass.'],
            ['name' => 'Phone Grip Ring Holder', 'price' => 249, 'sale_price' => null, 'category_name' => 'Phone Cases', 'image' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=600', 'description' => 'Sticky base. Stand function. Multiple colors.'],
            ['name' => 'Laptop Sleeve with Phone Pocket', 'price' => 1299, 'sale_price' => 999, 'category_name' => 'Protection', 'image' => 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600', 'description' => 'Neoprene. Padded. Fits 13-15 inch laptops.'],
            ['name' => 'Smartwatch Charging Cable', 'price' => 449, 'sale_price' => 349, 'category_name' => 'Chargers', 'image' => 'https://images.unsplash.com/photo-1583394293214-28f3f2b2a2a2?w=600', 'description' => 'Magnetic. Fast charge. Universal compatibility.'],
            ['name' => 'Earbuds Case with Keychain', 'price' => 399, 'sale_price' => null, 'category_name' => 'Headphones', 'image' => 'https://images.unsplash.com/photo-1598331668826-20cecc596b86?w=600', 'description' => 'Silicone. Dust proof. Carabiner clip.'],
            ['name' => 'Tablet Stand with Cooling Fan', 'price' => 1599, 'sale_price' => 1299, 'category_name' => 'Stands & Mounts', 'image' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=600', 'description' => 'Adjustable. USB fan. Fits 7-12 inch tablets.'],
        ];

        foreach ($products as $index => $data) {
            $category = $categories->firstWhere('name', $data['category_name']) ?? $categories->first();
            $slug = Str::slug($data['name']);
            $existing = Product::where('slug', $slug)->first();

            $payload = [
                'name' => $data['name'],
                'description' => $data['description'] ?? $this->description($data['name']),
                'short_description' => $this->shortDescription($data['name']),
                'category_id' => $category?->id,
                'price' => $data['price'],
                'sale_price' => $data['sale_price'] ?? null,
                'stock_quantity' => rand(15, 80),
                'in_stock' => true,
                'is_active' => true,
                'is_featured' => $index < 10,
                'is_new_arrival' => $index % 3 === 0,
                'image' => $data['image'],
                'images' => [$data['image']],
                'sort_order' => $index + 1,
            ];

            if ($existing) {
                $existing->update($payload);
            } else {
                Product::create(array_merge($payload, [
                    'slug' => $slug,
                    'sku' => 'MAC-' . strtoupper(Str::random(6)),
                ]));
            }
        }

        $this->command->info('30 mobile accessories products seeded.');
    }

    private function description(string $name): string
    {
        return "Premium {$name}. High quality materials, durable design. Perfect for daily use.";
    }

    private function shortDescription(string $name): string
    {
        return "Premium {$name} with great build quality and design.";
    }
}
