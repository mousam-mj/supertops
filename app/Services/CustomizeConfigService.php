<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Setting;

class CustomizeConfigService
{
    public const SETTING_GLOBAL = 'customize_global';

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
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
    ];

    protected static array $defaultTumblerColors = [
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
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
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
        ['name' => 'Green', 'hex' => '#3aaa5a'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
    ];

    protected static array $defaultStrawColors = [
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
    ];

    /**
     * Global customizer JSON from settings (title, colors, sizes, prices).
     *
     * @return array<string, mixed>
     */
    public static function getGlobalCustomizeConfig(): array
    {
        $raw = Setting::get(self::SETTING_GLOBAL);
        if (!is_string($raw) || $raw === '') {
            return [];
        }
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Catalog product used for cart/checkout lines for /customize builds (slug from seeder).
     */
    public static function getCartProductId(): ?int
    {
        $id = Product::query()
            ->where('slug', '1200ml-running-tumbler')
            ->where('is_active', true)
            ->value('id');

        return $id ? (int) $id : null;
    }

    /**
     * Size rows as on the public customizer (aligned with composeFrontendConfig defaults).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function effectiveCustomizerSizes(): array
    {
        $customizeConfig = self::getGlobalCustomizeConfig();

        return $customizeConfig['sizes'] ?? [
            ['name' => '24 oz', 'desc' => 'Insulated tumbler for life on the go.', 'price' => 3500],
            ['name' => '32 oz', 'desc' => 'Medium insulated tumbler.', 'price' => 4000],
            ['name' => '40 oz', 'desc' => 'Large insulated tumbler with handle and straw.', 'price' => 4500],
        ];
    }

    public static function unitPriceForCustomizerSizeIndex(int $sizeIndex): ?float
    {
        $sizes = self::effectiveCustomizerSizes();
        if ($sizeIndex < 0 || $sizeIndex >= count($sizes)) {
            return null;
        }
        $row = $sizes[$sizeIndex];
        if (!is_array($row) || !array_key_exists('price', $row)) {
            return null;
        }

        return max(0, round((float) $row['price'], 2));
    }

    /**
     * Merged palettes/sizes for admin form padding (no product color fallback).
     *
     * @param  array<string, mixed>  $stored
     * @return array<string, mixed>
     */
    public static function mergedForAdminForm(array $stored): array
    {
        $stub = new Product(['customize_config' => $stored, 'colors' => null]);

        return self::composeFrontendConfig($stored, $stub, false);
    }

    /**
     * Public /customize page — settings only, not tied to a catalog product.
     *
     * @return array<string, mixed>
     */
    public static function getStandaloneConfig(): array
    {
        $customizeConfig = self::getGlobalCustomizeConfig();
        $stub = new Product([
            'slug' => 'customize',
            'name' => 'Customize',
            'price' => 0,
            'sale_price' => null,
            'colors' => null,
            'customize_config' => null,
        ]);

        return self::composeFrontendConfig($customizeConfig, $stub, false);
    }

    public static function getConfig(Product $product): array
    {
        $global = self::getGlobalCustomizeConfig();
        $useGlobal = $global !== [];
        $customizeConfig = $useGlobal ? $global : ($product->customize_config ?? []);

        return self::composeFrontendConfig($customizeConfig, $product, !$useGlobal);
    }

    /**
     * @param  array<string, mixed>  $customizeConfig
     * @return array<string, mixed>
     */
    private static function composeFrontendConfig(array $customizeConfig, Product $product, bool $allowProductColorFallback): array
    {
        $bottleColors = $customizeConfig['bottle_colors'] ?? $customizeConfig['tumbler_colors'] ?? null;
        if (!$bottleColors && $allowProductColorFallback && !empty($product->colors)) {
            $bottleColors = self::colorsArrayToConfig($product->colors);
        }
        $bottleColors = $bottleColors ?: self::$defaultTumblerColors;

        $capColors = $customizeConfig['cap_colors'] ?? $customizeConfig['lid_colors'] ?? self::$defaultLidColors;
        $strapColors = $customizeConfig['strap_colors'] ?? $customizeConfig['straw_colors'] ?? self::$defaultStrawColors;
        $bootColors = $customizeConfig['boot_colors'] ?? self::$defaultBootColors;
        $handleColors = $customizeConfig['handle_colors'] ?? $customizeConfig['boot_colors'] ?? self::$defaultBootColors;

        $sizes = $customizeConfig['sizes'] ?? [
            ['name' => '24 oz', 'desc' => 'Insulated tumbler for life on the go.', 'price' => 3500],
            ['name' => '32 oz', 'desc' => 'Medium insulated tumbler.', 'price' => 4000],
            ['name' => '40 oz', 'desc' => 'Large insulated tumbler with handle and straw.', 'price' => 4500],
        ];

        $lastSize = end($sizes);
        $basePrice = (float) ($lastSize['price'] ?? $product->sale_price ?? $product->price ?? 45);

        $defaultPartStlUrls = [
            'body' => route('customize.part.stl', ['part' => 'body']),
            'cap' => route('customize.part.stl', ['part' => 'cap']),
            'straw' => route('customize.part.stl', ['part' => 'straw']),
            'handle' => route('customize.part.stl', ['part' => 'handle']),
            'boot' => route('customize.part.stl', ['part' => 'boot']),
        ];
        $partStlUrls = array_replace(
            $defaultPartStlUrls,
            is_array($customizeConfig['part_stl_urls'] ?? null) ? $customizeConfig['part_stl_urls'] : []
        );

        $displayName = isset($customizeConfig['display_name']) && $customizeConfig['display_name'] !== ''
            ? (string) $customizeConfig['display_name']
            : 'Customize';

        return [
            'product_id' => $product->id,
            'cart_product_id' => self::getCartProductId(),
            'product_name' => $displayName,
            'product_slug' => $product->slug,
            'stl_model_url' => asset('assets/models/perch-tumbler-1200ml.stl'),
            'part_stl_urls' => $partStlUrls,
            'bottle_colors' => $bottleColors,
            'cap_colors' => $capColors,
            'strap_colors' => $strapColors,
            'boot_colors' => $bootColors,
            'handle_colors' => $handleColors,
            'sizes' => $sizes,
            'base_price' => $basePrice,
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
