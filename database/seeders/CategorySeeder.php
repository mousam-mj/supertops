<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Mobile Accessories only – main category + subcategories.
     */
    public function run(): void
    {
        $main = MainCategory::updateOrCreate(
            ['slug' => 'mobile-accessories'],
            [
                'name' => 'Mobile Accessories',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $subcategories = [
            ['name' => 'Phone Cases', 'description' => 'Phone cases and covers'],
            ['name' => 'Chargers', 'description' => 'Chargers, cables and adapters'],
            ['name' => 'Headphones', 'description' => 'Earbuds, headsets and audio'],
            ['name' => 'Protection', 'description' => 'Screen protectors and guards'],
            ['name' => 'Power Banks', 'description' => 'Portable power banks'],
            ['name' => 'Stands & Mounts', 'description' => 'Stands, mounts and holders'],
            ['name' => 'Audio Accessories', 'description' => 'Speakers, adapters and audio gear'],
        ];

        foreach ($subcategories as $i => $sub) {
            Category::updateOrCreate(
                ['slug' => Str::slug($sub['name'])],
                [
                    'name' => $sub['name'],
                    'description' => $sub['description'],
                    'parent_id' => null,
                    'main_category_id' => $main->id,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
