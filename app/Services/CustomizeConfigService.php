<?php

namespace App\Services;

use App\Models\Product;

class CustomizeConfigService
{
    /** Color name to hex mapping for known Perch/Hydro Flask colors */
    protected static array $colorHexMap = [
        'Mermaid Green' => '#4aab6a',
        'Dragonfruit' => '#c4426a',
        'Pacific' => '#3b78c4',
        'Lava' => '#c94b2f',
        'Slate' => '#5e7080',
        'Tan' => '#c2a97d',
        'Carnation' => '#e8a29a',
        'Birch' => '#b8b0a0',
        'Black' => '#1a1a1a',
        'White' => '#f0f0ee',
        'Lupine' => '#5b4ea8',
        'Agave' => '#5aaa7a',
        'Cascade' => '#6b8fbd',
        'Sage' => '#8aaa8a',
        'Citron' => '#d4c03a',
        'Green' => '#3aaa5a',
        'Pink' => '#e87aaa',
    ];

    protected static array $defaultBottleColors = [
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Lava', 'hex' => '#c94b2f'],
        ['name' => 'Slate', 'hex' => '#5e7080'],
        ['name' => 'Tan', 'hex' => '#c2a97d'],
        ['name' => 'Carnation', 'hex' => '#e8a29a'],
        ['name' => 'Birch', 'hex' => '#b8b0a0'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Lupine', 'hex' => '#5b4ea8'],
        ['name' => 'Agave', 'hex' => '#5aaa7a'],
    ];

    protected static array $defaultCapColors = [
        ['name' => 'Cascade', 'hex' => '#6b8fbd'],
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Sage', 'hex' => '#8aaa8a'],
        ['name' => 'Carnation', 'hex' => '#e8a29a'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Birch', 'hex' => '#c0b9a8'],
    ];

    protected static array $defaultStrapColors = [
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Citron', 'hex' => '#d4c03a'],
        ['name' => 'Green', 'hex' => '#3aaa5a'],
        ['name' => 'Pink', 'hex' => '#e87aaa'],
        ['name' => 'Cascade', 'hex' => '#8ab4d4'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
    ];

    protected static array $defaultBootColors = [
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
    ];

    protected static array $defaultTumblerColors = [
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Carnation', 'hex' => '#e8a29a'],
        ['name' => 'Tan', 'hex' => '#c2a97d'],
    ];

    protected static array $defaultLidColors = [
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Green', 'hex' => '#3aaa5a'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
    ];

    protected static array $defaultStrawColors = [
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
    ];

    public static function getConfig(Product $product): array
    {
        $customizeConfig = $product->customize_config ?? [];

        $bottleColors = $customizeConfig['bottle_colors'] ?? $customizeConfig['tumbler_colors'] ?? null;
        if (!$bottleColors && !empty($product->colors)) {
            $bottleColors = self::colorsArrayToConfig($product->colors);
        }
        $bottleColors = $bottleColors ?: self::$defaultTumblerColors;

        $capColors = $customizeConfig['cap_colors'] ?? $customizeConfig['lid_colors'] ?? self::$defaultLidColors;
        $strapColors = $customizeConfig['strap_colors'] ?? $customizeConfig['straw_colors'] ?? self::$defaultStrawColors;
        $bootColors = $customizeConfig['boot_colors'] ?? self::$defaultBootColors;

        $sizes = $customizeConfig['sizes'] ?? [
            ['name' => '24 oz', 'desc' => 'Insulated tumbler for life on the go.', 'price' => 3500],
            ['name' => '32 oz', 'desc' => 'Medium insulated tumbler.', 'price' => 4000],
            ['name' => '40 oz', 'desc' => 'Large insulated tumbler with handle and straw.', 'price' => 4500],
        ];

        $lastSize = end($sizes);
        $basePrice = (float) ($lastSize['price'] ?? $product->sale_price ?? $product->price ?? 45);
        $engravingPrice = (float) ($customizeConfig['engraving_price'] ?? 600);

        return [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_slug' => $product->slug,
            'bottle_colors' => $bottleColors,
            'cap_colors' => $capColors,
            'strap_colors' => $strapColors,
            'boot_colors' => $bootColors,
            'sizes' => $sizes,
            'base_price' => $basePrice,
            'engraving_price' => $engravingPrice,
            'has_engraving' => $customizeConfig['has_engraving'] ?? true,
            'currency' => '₹',
        ];
    }

    protected static function colorsArrayToConfig(array $colors): array
    {
        $result = [];
        foreach ($colors as $c) {
            $name = is_array($c) ? ($c['name'] ?? $c['label'] ?? '') : (string) $c;
            $hex = is_array($c) && isset($c['hex']) ? $c['hex'] : (self::$colorHexMap[$name] ?? self::nameToHex($name));
            if ($name) {
                $result[] = ['name' => $name, 'hex' => $hex];
            }
        }
        return $result ?: self::$defaultBottleColors;
    }

    protected static function nameToHex(string $name): string
    {
        return self::$colorHexMap[$name] ?? '#' . substr(md5($name), 0, 6);
    }
}
