@extends('layouts.app')

@section('title', site_page_title($product->name))

@section('content')
@php
    use App\Models\MasterColor;

    $product->loadMissing('inventories');
    $availableColors = $product->inventories->pluck('color')->unique()->filter()->values()->toArray();
    $allSizes = $product->inventories->pluck('size')->unique()->filter()->values()->toArray();
    if (empty($availableColors) && is_array($product->colors ?? null)) { $availableColors = $product->colors ?? []; }
    if (empty($allSizes) && is_array($product->sizes ?? null)) { $allSizes = $product->sizes ?? []; }
    $sizesByColor = [];
    foreach ($product->inventories as $inv) {
        $c = $inv->color ?? '';
        $s = $inv->size ?? '';
        if ($s === '' && $c === '') continue;
        if (!isset($sizesByColor[$c])) $sizesByColor[$c] = [];
        if ($s !== '' && !in_array($s, $sizesByColor[$c], true)) $sizesByColor[$c][] = $s;
    }
    foreach ($sizesByColor as $c => $list) {
        if (empty($list) && $c !== '') $sizesByColor[$c] = array_values(array_unique($allSizes));
        else $sizesByColor[$c] = array_values($list);
    }
    $firstColor = $availableColors[0] ?? null;
    $sizesForFirstColor = isset($sizesByColor[$firstColor]) && !empty($sizesByColor[$firstColor]) ? $sizesByColor[$firstColor] : $allSizes;
    $firstSize = $sizesForFirstColor[0] ?? $allSizes[0] ?? null;
    $availableSizes = $allSizes;
    $colorImageUrls = [];
    foreach ($product->inventories as $inv) {
        if ($inv->color && $inv->image) {
            $colorImageUrls[$inv->color] = storage_asset($inv->image);
        }
    }
    if (empty($colorImageUrls) && isset($product->color_images) && is_array($product->color_images)) {
        foreach ($product->color_images as $cName => $path) {
            if ($path) $colorImageUrls[$cName] = str_starts_with($path, 'http') ? $path : storage_asset($path);
        }
    }
    $colorSwatchUrls = [];
    $swatchImages = is_array($product->color_swatch_images ?? null) ? $product->color_swatch_images : [];
    foreach ($availableColors as $colorName) {
        $swatchPath = $swatchImages[$colorName] ?? $product->getSwatchImageForColor($colorName);
        if ($swatchPath) {
            $colorSwatchUrls[$colorName] = str_starts_with($swatchPath, 'http') ? $swatchPath : storage_asset($swatchPath);
        } elseif (! empty($colorImageUrls[$colorName])) {
            // Fall back to inventory/color product image so swatches aren't blank grey
            $colorSwatchUrls[$colorName] = $colorImageUrls[$colorName];
        }
    }
    $masterColorCodes = MasterColor::pluck('color_code', 'name')
        ->mapWithKeys(fn ($code, $name) => [strtolower(trim((string) $name)) => $code])
        ->toArray();
    $hasColorSwatchImages = count($colorSwatchUrls) > 0;
    $variantPrices = [];
    $productPrice = (float) ($product->price ?? 0);
    $productSalePrice = $product->sale_price !== null ? (float) $product->sale_price : null;
    foreach ($product->inventories as $inv) {
        $c = $inv->color ?? '';
        $s = $inv->size ?? '';
        $p = $inv->price !== null && $inv->price > 0 ? (float) $inv->price : $productPrice;
        $sp = $inv->sale_price !== null && $inv->sale_price > 0 ? (float) $inv->sale_price : $productSalePrice;
        $variantPrices[] = ['color' => $c, 'size' => $s, 'price' => $p, 'sale_price' => $sp];
    }
    $initialPrice = $productPrice;
    $initialSalePrice = $productSalePrice;
    foreach ($variantPrices as $v) {
        if (($v['color'] === $firstColor || ($v['color'] === '' && !$firstColor)) && ($v['size'] === $firstSize || ($v['size'] === '' && !$firstSize))) {
            $initialPrice = $v['price'];
            $initialSalePrice = $v['sale_price'];
            break;
        }
    }
    $initialDisplayPrice = ($initialSalePrice !== null && $initialSalePrice > 0 && $initialSalePrice < $initialPrice) ? $initialSalePrice : $initialPrice;
    $colorVariantNames = is_array($product->color_variant_names ?? null) ? $product->color_variant_names : [];
    $productBaseName = $product->name;
    foreach ($availableColors as $c) {
        $suffix = ', ' . $c;
        if (str_ends_with($productBaseName, $suffix)) {
            $productBaseName = substr($productBaseName, 0, -strlen($suffix));
            break;
        }
    }
    $colorTitles = [];
    foreach ($availableColors as $c) {
        $custom = trim((string) ($colorVariantNames[$c] ?? ''));
        $colorTitles[$c] = $custom !== '' ? $custom : trim($productBaseName) . ', ' . $c;
    }
    $initialProductTitle = ($firstColor && isset($colorTitles[$firstColor])) ? $colorTitles[$firstColor] : $product->name;
    $linkedVariantProducts = [];
    $variantGroupMembers = $product->variantGroupMembers();
    if ($variantGroupMembers->count() > 1) {
        foreach ($variantGroupMembers as $variantProduct) {
            $variantProduct->loadMissing('inventories');
            $colorLabel = $variantProduct->getDisplayColorLabel();
            $variantCustomNames = is_array($variantProduct->color_variant_names ?? null) ? $variantProduct->color_variant_names : [];
            $variantCustomTitle = trim((string) ($variantCustomNames[$colorLabel] ?? ''));
            $swatchPath = $variantProduct->getSwatchUrlForDisplayColor();
            $matchedInv = $variantProduct->findInventoryForColorSize($colorLabel, null);
            $variantImagePath = $matchedInv?->image ?: $variantProduct->image;
            $toAssetUrl = static function (?string $path): ?string {
                if (! $path) {
                    return null;
                }

                return str_starts_with($path, 'http') ? $path : storage_asset($path);
            };
            $variantStock = max(0, (int) ($variantProduct->stock_quantity ?? 0));
            $variantInStock = ($variantProduct->in_stock ?? true) && $variantStock > 0;
            $linkedVariantProducts[] = [
                'product_id' => $variantProduct->id,
                'color' => $colorLabel,
                'url' => route('product.show', $variantProduct->slug),
                'is_current' => $variantProduct->id === $product->id,
                'title' => $variantCustomTitle !== '' ? $variantCustomTitle : $variantProduct->name,
                'swatch_url' => $toAssetUrl($swatchPath),
                'image_url' => $toAssetUrl($variantImagePath),
                'in_stock' => $variantInStock,
                'stock_quantity' => $variantStock,
            ];
        }
        // Disambiguate duplicate color labels (e.g. two "Beige" prints)
        $labelCounts = array_count_values(array_map(
            fn ($v) => strtolower(trim((string) $v['color'])),
            $linkedVariantProducts
        ));
        foreach ($linkedVariantProducts as &$linkedVariant) {
            $key = strtolower(trim((string) $linkedVariant['color']));
            if (($labelCounts[$key] ?? 0) <= 1) {
                continue;
            }
            $title = (string) $linkedVariant['title'];
            if (str_contains($title, ',')) {
                $linkedVariant['color'] = trim(substr($title, strrpos($title, ',') + 1));
            } elseif (preg_match('/\bBottle\s+(.+)$/i', $title, $m)) {
                $linkedVariant['color'] = trim($m[1]);
            } else {
                $words = preg_split('/\s+/', trim($title)) ?: [];
                $linkedVariant['color'] = implode(' ', array_slice($words, -2)) ?: $title;
            }
        }
        unset($linkedVariant);

        // Keep group swatches clean — inventory color/size options render separately below.
        $availableColors = [];
        $currentLinked = collect($linkedVariantProducts)->firstWhere('is_current', true);
        if ($currentLinked) {
            $initialProductTitle = $currentLinked['title'];
        }
    }

    // Fallback hex when MasterColor table has no match
    $fallbackColorHex = [
        'black' => '#111111',
        'white' => '#f5f5f5',
        'grey' => '#9ca3af',
        'gray' => '#9ca3af',
        'black & grey' => '#4b5563',
        'black and grey' => '#4b5563',
        'red' => '#dc2626',
        'blue' => '#2563eb',
        'green' => '#16a34a',
        'pink' => '#ec4899',
        'purple' => '#7c3aed',
        'cyan' => '#06b6d4',
        'amber brown' => '#b45309',
        'baby pink' => '#f9a8d4',
        'beige' => '#d6c3a8',
    ];
    $resolveColorHex = function (?string $name) use ($masterColorCodes, $fallbackColorHex): string {
        $key = strtolower(trim((string) $name));
        if ($key === '') {
            return '#e5e7eb';
        }
        $fromMaster = trim((string) ($masterColorCodes[$key] ?? ''));
        if ($fromMaster !== '' && preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $fromMaster)) {
            return $fromMaster;
        }

        return $fallbackColorHex[$key] ?? '#e5e7eb';
    };

    // Prefer local /storage file when present (new admin uploads), else CDN/STORAGE_URL.
    $publicMediaUrl = static function (?string $path): ?string {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        $relative = ltrim($path, '/');
        if (is_file(storage_path('app/public/'.$relative))) {
            return asset('storage/'.$relative);
        }

        return storage_asset($relative);
    };

    // This product's own inventory rows (color + size) — always shown when present.
    $inventoryOptions = [];
    foreach ($product->inventories as $inv) {
        $invColor = trim((string) ($inv->color ?? ''));
        $invSize = trim((string) ($inv->size ?? ''));
        if ($invColor === '' && $invSize === '') {
            continue;
        }
        $invQty = max(0, (int) ($inv->quantity ?? 0));
        $invPrice = $inv->price !== null && (float) $inv->price > 0 ? (float) $inv->price : $productPrice;
        $invSale = $inv->sale_price !== null && (float) $inv->sale_price > 0 ? (float) $inv->sale_price : $productSalePrice;
        $displayColor = $invColor !== '' ? ucwords(strtolower($invColor)) : '';
        $inventoryOptions[] = [
            'color' => $invColor,
            'display_color' => $displayColor,
            'size' => $invSize,
            'quantity' => $invQty,
            'in_stock' => $invQty > 0,
            'price' => $invPrice,
            'sale_price' => $invSale,
            'image' => $publicMediaUrl($inv->image),
            'hex' => $resolveColorHex($invColor),
            'label' => trim($displayColor.($displayColor !== '' && $invSize !== '' ? ' · ' : '').$invSize),
        ];
    }
    $inventoryOptionColors = collect($inventoryOptions)->pluck('color')->filter()->unique()->values()->all();
    $inventoryOptionSizes = collect($inventoryOptions)->pluck('size')->filter()->unique()->values()->all();
    // One chip per inventory row (Color+Size together) — avoids Black/1000 vs White/7200 mixups
    $showInventoryOptionPicker = count($inventoryOptions) > 0;

    $initialSelectedColor = collect($linkedVariantProducts)->firstWhere('is_current', true)['color']
        ?? ($product->getDisplayColorLabel() ?: ($firstColor ?? ''));
    // Prefer first in-stock inventory row for default size/color on this product
    $defaultInventoryOption = collect($inventoryOptions)->firstWhere('in_stock', true)
        ?? ($inventoryOptions[0] ?? null);
    $initialInventoryColor = '';
    $initialInventoryLabel = '';
    if ($defaultInventoryOption) {
        if (! empty($defaultInventoryOption['size'])) {
            $firstSize = $defaultInventoryOption['size'];
        }
        $initialInventoryColor = (string) ($defaultInventoryOption['color'] ?? '');
        $initialInventoryLabel = (string) ($defaultInventoryOption['label'] ?? '');
    }
    $showColorPicker = count($linkedVariantProducts) > 0 || count($availableColors) > 0;
    $hasLinkedVariantImages = collect($linkedVariantProducts)->contains(
        fn ($v) => ! empty($v['swatch_url']) || ! empty($v['image_url'])
    );
    if ($hasLinkedVariantImages) {
        $hasColorSwatchImages = true;
    }
    $realStock = $defaultInventoryOption
        ? (int) $defaultInventoryOption['quantity']
        : max(0, (int) ($product->stock_quantity ?? 0));
    $isInStock = $defaultInventoryOption
        ? (bool) $defaultInventoryOption['in_stock']
        : (($product->in_stock ?? true) && $realStock > 0);
    if ($defaultInventoryOption) {
        $initialPrice = (float) $defaultInventoryOption['price'];
        $initialSalePrice = $defaultInventoryOption['sale_price'];
        $initialDisplayPrice = ($initialSalePrice !== null && $initialSalePrice > 0 && $initialSalePrice < $initialPrice)
            ? $initialSalePrice
            : $initialPrice;
    }
@endphp
<style>
.desc-truncated { display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; }
.about-truncated { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.product-detail .desc-tab .desc-block .desc-item:not(.open) { pointer-events: none; overflow: hidden; }
.see-more-btn { display: none; }
.see-more-btn.is-visible { display: inline-block; }
.product-description-html p { margin-bottom: 0.5rem; }
.product-description-html h5, .product-description-html h6 { font-weight: 600; margin-top: 1rem; margin-bottom: 0.25rem; }
.product-description-html ul { list-style: disc; padding-left: 1.25rem; margin: 0.5rem 0; }
.product-description-html a { text-decoration: underline; }
.choose-color .list-color-image .color-item { overflow: hidden; padding: 0; background: transparent !important; }
.choose-color .list-color-image .color-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 9999px; }
.choose-color .list-color .color-item {
    width: 2.75rem;
    height: 2.75rem;
    flex-shrink: 0;
}
/* Out-of-stock pages must still allow switching to other group products */
.product-detail.out-of-stock .product-infor.style-out-of-stock .choose-color .color-item[data-product-url] {
    filter: none !important;
    pointer-events: auto !important;
    cursor: pointer !important;
    border: 2px solid transparent;
}
.product-detail.out-of-stock .product-infor.style-out-of-stock .choose-color .color-item[data-product-url]::before,
.product-detail.out-of-stock .product-infor.style-out-of-stock .choose-color .color-item[data-product-url]::after {
    content: none !important;
}
.product-detail.out-of-stock .product-infor.style-out-of-stock .choose-color .color-item.is-variant-oos {
    opacity: 0.55;
}
.choose-color .color-item.is-variant-oos:not(.active) {
    opacity: 0.55;
}
.product-stock-badge.text-stock-in {
    color: #15803d !important;
}
.product-stock-badge.text-stock-out {
    color: #b91c1c !important;
}
.choose-inventory-option .inventory-option-item {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    min-width: 10rem;
    text-align: left;
    padding: 0.65rem 0.9rem;
    background: #fff;
    border: 1.5px solid #e5e7eb;
}
.choose-inventory-option .inventory-option-item .opt-swatch {
    width: 1.75rem;
    height: 1.75rem;
    border-radius: 9999px;
    flex-shrink: 0;
    border: 1px solid rgba(0,0,0,.12);
    background-size: cover;
    background-position: center;
}
.choose-inventory-option .inventory-option-item .opt-swatch.is-light {
    box-shadow: inset 0 0 0 1px rgba(0,0,0,.15);
}
.choose-inventory-option .inventory-option-item .opt-meta {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
    min-width: 0;
}
.choose-inventory-option .inventory-option-item .opt-name {
    font-weight: 600;
    line-height: 1.2;
}
.choose-inventory-option .inventory-option-item .opt-stock {
    font-size: 11px;
    opacity: 0.7;
}
.choose-inventory-option .inventory-option-item.active {
    background: #111;
    color: #fff;
    border-color: #111;
}
.choose-inventory-option .inventory-option-item.active .opt-swatch {
    border-color: rgba(255,255,255,.35);
}
.choose-inventory-option .inventory-option-item.is-variant-oos:not(.active) {
    opacity: 0.5;
}
/* Product gallery: thumbs + square main image that stays inside left column */
.product-detail.style-grouped .product-gallery-wrap {
    max-width: 100%;
    min-width: 0;
    overflow: hidden;
}
.product-detail.style-grouped .product-gallery-inner {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    gap: 12px;
    width: 100%;
    max-width: 100%;
    min-width: 0;
}
.product-detail.style-grouped .product-gallery-thumbs {
    order: 0;
    position: relative !important;
    width: 72px !important;
    max-width: 72px;
    flex-shrink: 0;
    margin: 0 !important;
    height: auto !important;
    max-height: min(100%, calc((100vw - 3rem) / 2 - 45px));
    overflow: hidden;
}
.product-detail.style-grouped .product-gallery-main,
.product-detail.style-grouped .list-img .mySwiper2 {
    order: 1;
    flex: 1 1 auto;
    width: auto !important;
    max-width: calc(100% - 84px) !important;
    margin-left: 0 !important;
    aspect-ratio: 1 / 1;
    border-radius: 1rem;
    overflow: hidden;
    background: #f5f5f5;
}
.product-detail.style-grouped .product-gallery-thumbs .swiper-wrapper {
    position: relative !important;
    top: auto !important;
    left: auto !important;
    flex-direction: column !important;
    width: 72px !important;
    height: auto !important;
    gap: 0;
}
.product-detail.style-grouped .product-gallery-thumbs .swiper-slide {
    width: 72px !important;
    height: 72px !important;
    aspect-ratio: 1 / 1;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    opacity: 0.55;
    border: 1px solid #A0A0A0;
}
.product-detail.style-grouped .product-gallery-thumbs .swiper-slide-thumb-active {
    opacity: 1;
    border-color: #000;
}
.product-detail.style-grouped .product-gallery-thumbs .swiper-slide img {
    height: 100%;
    object-fit: cover;
    display: block;
}
.product-detail.style-grouped .product-gallery-main .swiper-wrapper {
    height: 100%;
}
.product-detail.style-grouped .product-gallery-main .swiper-slide {
    height: 100%;
}
.product-detail.style-grouped .product-gallery-main .swiper-slide img,
.product-detail.style-grouped .list-img .mySwiper2 .swiper-slide img {
    width: 100% !important;
    height: 100% !important;
    aspect-ratio: 1 / 1 !important;
    object-fit: cover !important;
    display: block;
}
.product-detail.style-grouped .product-infor {
    min-width: 0;
    max-width: 100%;
}
.product-detail.style-grouped .product-name {
    overflow-wrap: anywhere;
    word-break: break-word;
}
@media (max-width: 1023.98px) {
    .product-detail.style-grouped .product-gallery-thumbs {
        width: 56px !important;
        max-width: 56px;
    }
    .product-detail.style-grouped .product-gallery-thumbs .swiper-wrapper {
        width: 56px !important;
    }
    .product-detail.style-grouped .product-gallery-thumbs .swiper-slide {
        width: 56px !important;
        height: 56px !important;
    }
    .product-detail.style-grouped .product-gallery-main,
    .product-detail.style-grouped .list-img .mySwiper2 {
        max-width: calc(100% - 68px) !important;
    }
}
@media (max-width: 639.98px) {
    .product-detail.style-grouped .product-gallery-inner {
        flex-direction: column;
        gap: 12px;
    }
    .product-detail.style-grouped .product-gallery-main,
    .product-detail.style-grouped .list-img .mySwiper2 {
        order: 1;
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
    }
    .product-detail.style-grouped .product-gallery-thumbs {
        order: 2;
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden;
    }
    .product-detail.style-grouped .product-gallery-thumbs .swiper-wrapper {
        flex-direction: row !important;
        width: auto !important;
        gap: 10px;
    }
    .product-detail.style-grouped .product-gallery-thumbs .swiper-slide {
        width: 64px !important;
        height: 64px !important;
    }
}
.pincode-checker .delivery-result-box { padding: 14px 16px; border-radius: 10px; border: 1px solid var(--line, #d4d4d4); }
.pincode-checker .delivery-result-box--success { background: #f0fdf4; border-color: #86efac; }
.pincode-checker .delivery-result-box--error { background: #fef2f2; border-color: #fca5a5; }
.pincode-checker .delivery-result-header { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-size: 0.875rem; font-weight: 600; }
.pincode-checker .delivery-result-box--success .delivery-result-header { color: #166534; }
.pincode-checker .delivery-result-box--error .delivery-result-header { color: #991b1b; font-weight: 500; }
.pincode-checker .delivery-result-rows { display: flex; flex-direction: column; gap: 8px; }
.pincode-checker .delivery-result-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; font-size: 0.875rem; line-height: 1.4; }
.pincode-checker .delivery-result-row span:first-child { color: #525252; }
.pincode-checker .delivery-result-row span:last-child { font-weight: 600; text-align: right; }
</style>
<div class="product-page-content">
            <div class="breadcrumb-product">
                <div class="main bg-linear md:pt-[88px] pt-[70px] pb-[14px]">
                    <div class="container flex items-center justify-between flex-wrap gap-3">
                        <div class="left flex items-center gap-1 flex-wrap min-w-0">
                            <a href="{{ route('home') }}" class="caption1 text-secondary2 hover:underline">Homepage</a>
                            <i class="ph ph-caret-right text-xs text-secondary2"></i>
                            @if($product->category)
                                @php
                                    $cat = $product->category;
                                    $catUrl = $cat->slug ? route('category', $cat->slug) : route('shop');
                                @endphp
                                <a href="{{ $catUrl }}" class="caption1 text-secondary2 hover:underline">{{ $cat->name }}</a>
                                <i class="ph ph-caret-right text-xs text-secondary2"></i>
                            @endif
                            <div class="caption1 capitalize">{{ $product->name }}</div>
                        </div>
                        <div class="right flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto product-nav-links">
                            @if($prevProduct)
                                <a href="{{ route('product.show', $prevProduct->slug) }}" class="prev-btn flex items-center cursor-pointer text-secondary hover:text-black pr-3 border-r border-line">
                                    <i class="ph ph-caret-circle-left text-2xl text-black"></i>
                                    <span class="caption1 pl-1">Previous Product</span>
                                </a>
                @endif
                            @if($nextProduct)
                                <a href="{{ route('product.show', $nextProduct->slug) }}" class="next-btn flex items-center cursor-pointer text-secondary hover:text-black">
                                    <span class="caption1 pr-1">Next Product</span>
                                    <i class="ph ph-caret-circle-right text-2xl text-black"></i>
                                </a>
                @endif
                        </div>
                    </div>
                </div>
            </div>

        <div class="product-detail discount style-grouped{{ $isInStock ? '' : ' out-of-stock' }}">
            <div class="featured-product underwear filter-product-img bg-linear pt-7 md:pb-20 pb-10">
                <div class="container flex justify-between gap-y-6 flex-wrap">
                    <div class="list-img product-gallery-wrap md:w-1/2 md:pr-[45px] w-full flex-shrink-0">
                        @php
                    $getImageUrl = function($path) {
                        if (!$path) return asset('assets/images/product/perch-bottal.webp');
                        if (str_starts_with($path, 'http')) return $path;
                        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
                            return asset($path);
                        }
                        return storage_asset($path);
                    };
                    $mainImage = $getImageUrl($product->image ?? null);
                    if ($firstColor && isset($colorImageUrls[$firstColor])) {
                        $mainImage = $colorImageUrls[$firstColor];
                    }
                    $allImages = [$mainImage];
                    if (isset($product->images) && is_array($product->images)) {
                        foreach ($product->images as $img) {
                            $allImages[] = $getImageUrl($img);
                        }
                    }
                    $allImages = array_unique($allImages);
                @endphp
                        <div class="product-gallery-inner md:sticky" data-default-main-image="{{ $mainImage }}">
                            <div class="swiper mySwiper2 product-gallery-main rounded-2xl overflow-hidden">
                                <div class="swiper-wrapper">
                                    @foreach($allImages as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover" data-default-src="{{ $img }}" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper mySwiper product-gallery-thumbs">
                                <div class="swiper-wrapper">
                                    @foreach($allImages as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img }}" alt="{{ $product->name }}" class="h-full object-cover cursor-pointer" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper popup-img">
                                <span class="close-popup-btn absolute top-4 right-4 z-[2]">
                                    <i class="ph ph-x text-3xl text-white"></i>
                                </span>
                                <div class="swiper-wrapper">
                                    @foreach($allImages as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                    <div class="product-infor{{ $isInStock ? '' : ' style-out-of-stock' }} md:w-1/2 w-full lg:pl-[15px] md:pl-2"
                         data-default-size="{{ $firstSize ?? $availableSizes[0] ?? '' }}"
                         data-default-inventory-color="{{ $initialInventoryColor ?? '' }}"
                         data-in-stock="{{ $isInStock ? '1' : '0' }}"
                         data-inventory-options="{{ e(json_encode($inventoryOptions)) }}"
                         data-sizes-by-color="{{ e(json_encode($sizesByColor)) }}"
                         data-all-sizes="{{ e(json_encode($inventoryOptionSizes ?: $availableSizes)) }}">
                        <div class="sticky">
                            <div class="flex justify-between">
                                <div>
                                    <div class="product-category caption2 text-secondary font-semibold uppercase">{{ $product->category->name ?? 'Product' }}</div>
                                    <div class="product-name heading4 mt-1" @if(!empty($colorTitles)) data-color-titles="{{ e(json_encode($colorTitles)) }}" @endif>{{ $initialProductTitle }}</div>
                                    @php
                                        $stockBadgeText = $isInStock
                                            ? ('In Stock'.($realStock > 0 ? ': '.$realStock.' left' : ''))
                                            : 'Out of Stock';
                                    @endphp
                                    <div class="product-stock-badge caption2 font-semibold inline-flex items-center gap-1.5 mt-2 {{ $isInStock ? 'text-stock-in' : 'text-stock-out' }}"
                                         data-stock-qty="{{ $realStock }}">
                                        <i class="ph {{ $isInStock ? 'ph-check-circle' : 'ph-x-circle' }} text-base"></i>
                                        <span class="stock-badge-text">{{ $stockBadgeText }}</span>
                                    </div>
                                </div>
                                <div class="add-wishlist-btn w-10 h-10 flex-shrink-0 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white" data-product-id="{{ $product->id }}">
                                    <i class="ph ph-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 mt-3">
                                @php $avg = $reviewStats['avg'] ?? 0; $rc = $reviewStats['count'] ?? 0; @endphp
                                <div class="rate flex">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <i class="ph {{ $s <= round($avg) ? 'ph-fill' : 'ph' }} ph-star text-sm {{ $s <= round($avg) ? 'text-yellow' : 'text-line' }}"></i>
                                    @endfor
                                </div>
                                <span class="caption1 text-secondary">({{ number_format($rc) }} {{ $rc === 1 ? 'review' : 'reviews' }})</span>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line product-price-block" data-variant-prices="{{ json_encode($variantPrices) }}" data-product-price="{{ $productPrice }}" data-product-sale-price="{{ $productSalePrice !== null ? $productSalePrice : '' }}">
                                <div class="product-price heading5">₹{{ number_format($initialDisplayPrice, 2) }}</div>
                                @if($initialSalePrice !== null && $initialSalePrice > 0 && $initialPrice > $initialSalePrice)
                                    <div class="w-px h-4 bg-line"></div>
                                    <div class="product-origin-price font-normal text-secondary2">
                                        <del>₹{{ number_format($initialPrice, 2) }}</del>
                                    </div>
                                    @php $discount = round((($initialPrice - $initialSalePrice) / $initialPrice) * 100); @endphp
                                    @if($discount > 0)
                                        <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full">-{{ $discount }}%</div>
                                    @endif
                                @else
                                    <div class="w-px h-4 bg-line d-none"></div>
                                    <div class="product-origin-price font-normal text-secondary2 d-none"><del></del></div>
                                    <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full d-none"></div>
                                @endif
                                <div class="product-description text-secondary mt-3 w-full">{{ $product->short_description ?? ($product->description ? \Illuminate\Support\Str::limit($product->description, 150) : 'No description available.') }}</div>
                </div>
                            <div class="list-action mt-6">
                                <div class="discount-code">
                                    @if($coupons && $coupons->count() > 0)
                                        <div class="text-title">Useable discount codes:</div>
                                        <div class="flex items-center gap-3 mt-3">
                                            @foreach($coupons->take(2) as $coupon)
                                                <div class="item relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="130" height="32" viewBox="0 0 130 32" fill="none">
                                                        <path
                                                            d="M6.67572e-06 31.0335V31.0335C6.67572e-06 31.5651 0.430976 31.9961 0.962603 31.9961H13.5219C14.2048 31.9961 14.8816 31.4936 15.1194 30.795C15.1604 30.6745 15.0581 30.5573 14.9709 30.4646V30.4646C14.9168 30.407 14.887 30.3321 14.8874 30.2545V29.2172C14.8874 29.1347 14.9215 29.0555 14.9822 28.9972C15.043 28.9388 15.1253 28.906 15.2112 28.906C15.2971 28.906 15.3795 28.9388 15.4402 28.9972C15.5009 29.0555 15.535 29.1347 15.535 29.2172V30.2545C15.5354 30.3322 15.5055 30.4073 15.4511 30.4649V30.4649C15.3637 30.5576 15.261 30.6748 15.3021 30.7955C15.5399 31.4938 16.2158 31.9961 16.9005 31.9961L126 31.9961C128.209 31.9961 130 30.2052 130 27.9961V3.99609C130 1.78695 128.209 -0.00390625 126 -0.00390625L16.8962 -0.00390625C16.117 -0.00390625 15.5003 0.496968 15.2882 1.1946C15.2507 1.31784 15.3567 1.43416 15.4456 1.52737V1.52737C15.5006 1.58504 15.531 1.6605 15.5307 1.73873V2.25736C15.5307 2.3399 15.4966 2.41905 15.4359 2.47741C15.3751 2.53576 15.2928 2.56855 15.2069 2.56855C15.121 2.56855 15.0386 2.53576 14.9779 2.47741C14.9172 2.41905 14.8831 2.3399 14.8831 2.25736V1.73873C14.8826 1.6618 14.9118 1.58742 14.965 1.52995V1.52995C15.0504 1.43773 15.149 1.31968 15.1045 1.20212C14.8388 0.500396 14.0963 -0.00494385 13.5176 -0.00494385H0.481824C0.215723 -0.00494385 6.67572e-06 0.210773 6.67572e-06 0.476873V0.476873C6.67572e-06 0.742974 0.220644 0.951525 0.474363 1.03175C0.697986 1.10246 0.903572 1.22287 1.07316 1.38583C1.35777 1.65934 1.51767 2.03031 1.51767 2.41711C1.51767 2.8039 1.35777 3.17485 1.07316 3.44836C0.903447 3.61144 0.697684 3.73191 0.473869 3.8026C0.220396 3.88265 6.67572e-06 4.09098 6.67572e-06 4.3568V4.3568C6.67572e-06 4.62261 0.220397 4.83095 0.473867 4.91101C0.697682 4.98171 0.903447 5.10218 1.07316 5.26526C1.35777 5.53877 1.51767 5.90972 1.51767 6.29651C1.51767 6.68331 1.35777 7.05426 1.07316 7.32776C0.903447 7.49085 0.697683 7.61132 0.473868 7.68201C0.220397 7.76207 6.67572e-06 7.9704 6.67572e-06 8.23622V8.23622C6.67572e-06 8.50203 0.220397 8.71037 0.473868 8.79042C0.697683 8.86112 0.903447 8.98159 1.07316 9.14467C1.35777 9.41818 1.51767 9.78914 1.51767 10.1759C1.51767 10.5627 1.35777 10.9337 1.07316 11.2072C0.903447 11.3703 0.697683 11.4907 0.473868 11.5614C0.220397 11.6415 6.67572e-06 11.8498 6.67572e-06 12.1156V12.1156C6.67572e-06 12.3815 0.220397 12.5898 0.473868 12.6698C0.697683 12.7405 0.903447 12.861 1.07316 13.0241C1.35777 13.2976 1.51767 13.6685 1.51767 14.0553C1.51767 14.4421 1.35777 14.8131 1.07316 15.0866C0.902084 15.251 0.694377 15.3721 0.468473 15.4425C0.217696 15.5208 6.67572e-06 15.7267 6.67572e-06 15.9894V15.9894C6.67572e-06 16.2569 0.225281 16.4649 0.482009 16.54C0.519464 16.5509 0.556524 16.5633 0.5931 16.577C0.781892 16.6479 0.953983 16.7545 1.09922 16.8904C1.24445 17.0263 1.35989 17.1887 1.43871 17.3682C1.51753 17.5477 1.55815 17.7405 1.55815 17.9353C1.55815 18.1301 1.51753 18.3229 1.43871 18.5024C1.35989 18.6818 1.24445 18.8443 1.09922 18.9802C0.953983 19.1161 0.781892 19.2226 0.5931 19.2936C0.556521 19.3073 0.51946 19.3197 0.482002 19.3306C0.225278 19.4056 6.67572e-06 19.6137 6.67572e-06 19.8812V19.8812C6.67572e-06 20.1438 0.21768 20.3498 0.468455 20.428C0.506373 20.4398 0.54385 20.4531 0.580795 20.4678C0.764926 20.5411 0.932229 20.6485 1.07316 20.784C1.21409 20.9194 1.32588 21.0802 1.40215 21.2571C1.47842 21.4341 1.51767 21.6237 1.51767 21.8152C1.51767 22.0067 1.47842 22.1964 1.40215 22.3733C1.32588 22.5503 1.21409 22.711 1.07316 22.8465C0.932229 22.9819 0.764926 23.0893 0.580795 23.1626C0.545606 23.1766 0.509935 23.1893 0.47386 23.2007C0.220386 23.2808 6.67572e-06 23.4891 6.67572e-06 23.7549V23.7549C6.67572e-06 24.0207 0.220397 24.2291 0.473866 24.3091C0.697682 24.3798 0.903447 24.5003 1.07316 24.6634C1.35777 24.9369 1.51767 25.3078 1.51767 25.6946C1.51767 26.0814 1.35777 26.4524 1.07316 26.7259C0.903447 26.889 0.697683 27.0094 0.473867 27.0801C0.220397 27.1602 6.67572e-06 27.3685 6.67572e-06 27.6343V27.6343C6.67572e-06 27.9002 0.220396 28.1085 0.473867 28.1885C0.697683 28.2592 0.903447 28.3797 1.07316 28.5428C1.35777 28.8163 1.51767 29.1873 1.51767 29.5741C1.51767 29.9608 1.35777 30.3318 1.07316 30.6053C0.788785 30.8786 0.403181 31.0322 0.00104617 31.0325C0.000472754 31.0325 6.67572e-06 31.0329 6.67572e-06 31.0335V31.0335ZM14.8874 4.3288C14.8874 4.24627 14.9215 4.16712 14.9822 4.10876C15.043 4.0504 15.1253 4.01762 15.2112 4.01762C15.2971 4.01762 15.3795 4.0504 15.4402 4.10876C15.5009 4.16712 15.535 4.24627 15.535 4.3288V5.36608C15.535 5.44861 15.5009 5.52776 15.4402 5.58612C15.3795 5.64448 15.2971 5.67726 15.2112 5.67726C15.1253 5.67726 15.043 5.64448 14.9822 5.58612C14.9215 5.52776 14.8874 5.44861 14.8874 5.36608V4.3288ZM14.8874 7.44063C14.8874 7.3581 14.9215 7.27895 14.9822 7.22059C15.043 7.16223 15.1253 7.12945 15.2112 7.12945C15.2971 7.12945 15.3795 7.16223 15.4402 7.22059C15.5009 7.27895 15.535 7.3581 15.535 7.44063V8.47791C15.535 8.56044 15.5009 8.63958 15.4402 8.69794C15.3795 8.7563 15.2971 8.78909 15.2112 8.78909C15.1253 8.78909 15.043 8.7563 14.9822 8.69794C14.9215 8.63958 14.8874 8.56044 14.8874 8.47791V7.44063ZM14.8874 10.5525C14.8874 10.4699 14.9215 10.3908 14.9822 10.3324C15.043 10.2741 15.1253 10.2413 15.2112 10.2413C15.2971 10.2413 15.3795 10.2741 15.4402 10.3324C15.5009 10.3908 15.535 10.4699 15.535 10.5525V11.5897C15.535 11.6723 15.5009 11.7514 15.4402 11.8098C15.3795 11.8681 15.2971 11.9009 15.2112 11.9009C15.1253 11.9009 15.043 11.8681 14.9822 11.8098C14.9215 11.7514 14.8874 11.6723 14.8874 11.5897V10.5525ZM14.8874 13.6643C14.8874 13.5818 14.9215 13.5026 14.9822 13.4443C15.043 13.3859 15.1253 13.3531 15.2112 13.3531C15.2971 13.3531 15.3795 13.3859 15.4402 13.4443C15.5009 13.5026 15.535 13.5818 15.535 13.6643V14.7016C15.535 14.7841 15.5009 14.8632 15.4402 14.9216C15.3795 14.98 15.2971 15.0128 15.2112 15.0128C15.1253 15.0128 15.043 14.98 14.9822 14.9216C14.9215 14.8632 14.8874 14.7841 14.8874 14.7016V13.6643ZM14.8874 16.7761C14.8874 16.6936 14.9215 16.6144 14.9822 16.5561C15.043 16.4977 15.1253 16.4649 15.2112 16.4649C15.2971 16.4649 15.3795 16.4977 15.4402 16.5561C15.5009 16.6144 15.535 16.6936 15.535 16.7761V17.8134C15.535 17.8959 15.5009 17.9751 15.4402 18.0334C15.3795 18.0918 15.2971 18.1246 15.2112 18.1246C15.1253 18.1246 15.043 18.0918 14.9822 18.0334C14.9215 17.9751 14.8874 17.8959 14.8874 17.8134V16.7761ZM14.8874 19.888C14.8874 19.8054 14.9215 19.7263 14.9822 19.6679C15.043 19.6096 15.1253 19.5768 15.2112 19.5768C15.2971 19.5768 15.3795 19.6096 15.4402 19.6679C15.5009 19.7263 15.535 19.8054 15.535 19.888V20.9252C15.535 21.0078 15.5009 21.0869 15.4402 21.1453C15.3795 21.2036 15.2971 21.2364 15.2112 21.2364C15.1253 21.2364 15.043 21.2036 14.9822 21.1453C14.9215 21.0869 14.8874 21.0078 14.8874 20.9252V19.888ZM14.8874 22.9998C14.8874 22.9173 14.9215 22.8381 14.9822 22.7797C15.043 22.7214 15.1253 22.6886 15.2112 22.6886C15.2971 22.6886 15.3795 22.7214 15.4402 22.7797C15.5009 22.8381 15.535 22.9173 15.535 22.9998V24.0371C15.535 24.1196 15.5009 24.1987 15.4402 24.2571C15.3795 24.3155 15.2971 24.3483 15.2112 24.3483C15.1253 24.3483 15.043 24.3155 14.9822 24.2571C14.9215 24.1987 14.8874 24.1196 14.8874 24.0371V22.9998ZM14.8874 26.1116C14.8874 26.0291 14.9215 25.9499 14.9822 25.8916C15.043 25.8332 15.1253 25.8004 15.2112 25.8004C15.2971 25.8004 15.3795 25.8332 15.4402 25.8916C15.5009 25.9499 15.535 26.0291 15.535 26.1116V27.1489C15.535 27.2314 15.5009 27.3106 15.4402 27.3689C15.3795 27.4273 15.2971 27.4601 15.2112 27.4601C15.1253 27.4601 15.043 27.4273 14.9822 27.3689C14.9215 27.3106 14.8874 27.2314 14.8874 27.1489V26.1116Z"
                                                            fill="#DB4444"
                                                        />
                                                    </svg>
                                                    <div class="content absolute top-1/2 -translate-y-1/2 md:right-1 right-2 flex items-center gap-2">
                                                        <div class="caption1 text-white">
                                                            @if(isset($coupon->discount_type) && $coupon->discount_type === 'percentage')
                                                                {{ $coupon->discount_value ?? 0 }}% Off
                                                            @else
                                                                ₹{{ number_format($coupon->discount_value ?? 0, 2) }} Off
                                                            @endif
                                                        </div>
                                                        <div class="button bg-white font-semibold text-xs py-1 px-2 rounded-full duration-300 hover:bg-black hover:text-white cursor-pointer apply-coupon-btn" data-coupon-code="{{ $coupon->code }}">Apply</div>
                                                    </div>
                                                </div>
                                            @endforeach
                    </div>
                @endif
                                </div>
                                @if($showColorPicker)
                                    <div class="choose-color mt-5" data-color-images="{{ json_encode($colorImageUrls) }}">
                                        <div class="text-title">Colors: <span class="text-title color selected-color">{{ $initialSelectedColor }}</span></div>
                                        <div class="list-color {{ $hasColorSwatchImages ? 'list-color-image' : '' }} flex items-center gap-2 flex-wrap mt-3">
                                            @foreach($linkedVariantProducts as $variant)
                                                @php
                                                    $color = $variant['color'];
                                                    $swatchUrl = $variant['swatch_url'] ?? $variant['image_url'] ?? null;
                                                    $hexCode = trim((string) ($masterColorCodes[strtolower(trim((string) $color))] ?? ''));
                                                    $isValidHex = $hexCode !== '' && preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $hexCode);
                                                    $swatchStyle = (!$swatchUrl && $isValidHex) ? 'background-color: '.$hexCode.';' : ((!$swatchUrl) ? 'background-color: #e5e7eb;' : '');
                                                    $variantInStock = ! empty($variant['in_stock']);
                                                    $swatchTitle = $color.($variantInStock ? '' : ' (Out of Stock)');
                                                @endphp
                                                <div class="color-item w-10 h-10 rounded-full border-2 border-transparent hover:border-black cursor-pointer duration-300 {{ $variant['is_current'] ? 'active border-black' : '' }}{{ $variantInStock ? '' : ' is-variant-oos' }}"
                                                     @if($swatchStyle !== '') style="{{ $swatchStyle }}" @endif
                                                     data-color="{{ $color }}"
                                                     data-in-stock="{{ $variantInStock ? '1' : '0' }}"
                                                     @if(!$variant['is_current']) data-product-url="{{ $variant['url'] }}" @endif
                                                     title="{{ $swatchTitle }}">
                                                    @if($swatchUrl)
                                                        <img src="{{ $swatchUrl }}" alt="{{ $color }}" class="w-full h-full object-cover rounded-full">
                                                    @endif
                                                </div>
                                            @endforeach
                                            @foreach($availableColors as $color)
                                                @php
                                                    $swatchUrl = $colorSwatchUrls[$color] ?? $colorImageUrls[$color] ?? null;
                                                    $hexCode = trim((string) ($masterColorCodes[strtolower(trim((string) $color))] ?? ''));
                                                    $isValidHex = $hexCode !== '' && preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $hexCode);
                                                    $swatchStyle = (!$swatchUrl && $isValidHex) ? 'background-color: '.$hexCode.';' : ((!$swatchUrl) ? 'background-color: #e5e7eb;' : '');
                                                @endphp
                                                <div class="color-item w-10 h-10 rounded-full border-2 border-transparent hover:border-black cursor-pointer duration-300 {{ $loop->first ? 'active border-black' : '' }}"
                                                     @if($swatchStyle !== '') style="{{ $swatchStyle }}" @endif
                                                     data-color="{{ $color }}"
                                                     title="{{ $color }}">
                                                    @if($swatchUrl)
                                                        <img src="{{ $swatchUrl }}" alt="{{ $color }}" class="w-full h-full object-cover rounded-full">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                    </div>
                @endif
                                {{-- One option per inventory row: Color + Size stay paired --}}
                                @if($showInventoryOptionPicker)
                                    <div class="choose-inventory-option mt-5">
                                        <div class="text-title">Options: <span class="text-title selected-inventory-option">{{ $initialInventoryLabel }}</span></div>
                                        <div class="list-inventory-option flex items-center gap-2 flex-wrap mt-3">
                                            @foreach($inventoryOptions as $opt)
                                                @php
                                                    $isActiveOpt = $defaultInventoryOption
                                                        && strcasecmp((string) ($opt['color'] ?? ''), (string) ($defaultInventoryOption['color'] ?? '')) === 0
                                                        && strcasecmp((string) ($opt['size'] ?? ''), (string) ($defaultInventoryOption['size'] ?? '')) === 0;
                                                    $optHex = $opt['hex'] ?? '#e5e7eb';
                                                    $isLightSwatch = in_array(strtolower($optHex), ['#fff', '#ffffff', '#f5f5f5', '#fafafa', '#e5e7eb'], true);
                                                    $swatchBg = ! empty($opt['image'])
                                                        ? 'background-image:url('.e($opt['image']).');'
                                                        : 'background-color:'.$optHex.';';
                                                @endphp
                                                <button type="button"
                                                    class="inventory-option-item size-item rounded-lg caption1 cursor-pointer duration-300 hover:border-black {{ $isActiveOpt ? 'active' : '' }}{{ ! empty($opt['in_stock']) ? '' : ' is-variant-oos size-unavailable' }}"
                                                    data-color="{{ $opt['color'] }}"
                                                    data-size="{{ $opt['size'] }}"
                                                    data-stock="{{ $opt['quantity'] }}"
                                                    data-in-stock="{{ ! empty($opt['in_stock']) ? '1' : '0' }}"
                                                    data-price="{{ $opt['price'] }}"
                                                    data-sale-price="{{ $opt['sale_price'] ?? '' }}"
                                                    data-label="{{ $opt['label'] }}"
                                                    @if(! empty($opt['image'])) data-image="{{ $opt['image'] }}" @endif
                                                    title="{{ $opt['label'] }}{{ ! empty($opt['in_stock']) ? '' : ' (Out of Stock)' }}">
                                                    <span class="opt-swatch {{ $isLightSwatch ? 'is-light' : '' }}" style="{{ $swatchBg }}"></span>
                                                    <span class="opt-meta">
                                                        <span class="opt-name">{{ $opt['display_color'] ?: 'Option' }}@if(!empty($opt['size'])) · {{ $opt['size'] }}@endif</span>
                                                        <span class="opt-stock">{{ ! empty($opt['in_stock']) ? ($opt['quantity'].' left') : 'Out of stock' }}</span>
                                                    </span>
                                                </button>
                                            @endforeach
                                        </div>
                                        {{-- Hidden active mirrors so existing cart/price JS keeps working --}}
                                        <div class="choose-inventory-color sr-only" aria-hidden="true">
                                            <div class="inventory-color-item color-item active" data-color="{{ $initialInventoryColor }}"></div>
                                        </div>
                                        <div class="choose-size sr-only" aria-hidden="true"
                                             data-sizes-by-color="{{ e(json_encode($sizesByColor)) }}"
                                             data-all-sizes="{{ e(json_encode($inventoryOptionSizes)) }}">
                                            <div class="list-size">
                                                <div class="size-item active" data-size="{{ $firstSize }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="text-title mt-5">Quantity:</div>
                                <div class="choose-quantity flex items-center max-xl:flex-wrap gap-3 mt-3">
                                    @if($isInStock)
                                    <div class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0">
                                        <i class="ph-bold ph-minus cursor-pointer body1"></i>
                                        <input type="number" min="1" max="9999" step="1" value="1" inputmode="numeric" aria-label="Quantity" class="quantity body1 font-semibold w-12 min-w-[3rem] text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" />
                                        <i class="ph-bold ph-plus cursor-pointer body1"></i>
                                    </div>
                                    <button type="button" class="add-cart-btn button-main whitespace-nowrap flex-1 min-w-[120px] text-center bg-white text-black border border-black cursor-pointer" data-product-id="{{ $product->id }}">Add To Cart</button>
                                    <button type="button" class="buy-it-now-btn button-main whitespace-nowrap flex-1 min-w-[120px] text-center border-0 cursor-pointer bg-black text-white font-semibold uppercase" data-product-id="{{ $product->id }}" data-checkout-url="{{ route('checkout.index') }}">Buy It Now</button>
                                    @else
                                    <div class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0 opacity-60 pointer-events-none">
                                        <i class="ph-bold ph-minus body1"></i>
                                        <input type="number" min="0" max="0" step="1" value="0" readonly tabindex="-1" aria-label="Quantity" class="quantity body1 font-semibold w-12 min-w-[3rem] text-center bg-transparent border-0 p-0 opacity-60 cursor-not-allowed" />
                                        <i class="ph-bold ph-plus body1"></i>
                                    </div>
                                    <button type="button" class="add-cart-btn is-out-of-stock button-main whitespace-nowrap flex-1 min-w-[120px] text-center bg-white text-black border border-black opacity-50 cursor-not-allowed select-none" data-product-id="{{ $product->id }}" data-out-of-stock="1" aria-disabled="true" disabled>Out of Stock</button>
                                    @endif
                                    <button type="button" class="share-product-btn w-12 h-12 flex-shrink-0 flex items-center justify-center border border-line rounded-lg cursor-pointer hover:bg-black hover:text-white duration-300" data-share-url="{{ route('product.show', $product->slug) }}" data-share-title="{{ $product->name }}" title="Share">
                                        <i class="ph ph-share-network text-xl"></i>
                                    </button>
                                </div>
                                <!-- Pincode Checker -->
                                <div class="pincode-checker mt-5 p-4 border border-line rounded-lg">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="ph ph-map-pin text-xl"></i>
                                        <div class="text-title">Check Delivery</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               id="pincode-input" 
                                               placeholder="Enter pincode" 
                                               class="flex-1 px-3 py-2 border border-line rounded-lg text-sm"
                                               maxlength="6"
                                               pattern="[0-9]{6}">
                                        <button type="button" 
                                                id="check-pincode-btn" 
                                                class="px-4 py-2 bg-black text-white rounded-lg text-sm hover:bg-gray-800 transition-colors">
                                            Check
                                        </button>
                                    </div>
                                    <div id="delivery-info" class="mt-3 hidden">
                                        <!-- Delivery information will be populated here -->
                                    </div>
                                </div>

                                @if(setting_flag('show_customize_product_button', true))
                                <div class="button-block mt-5 flex gap-3 flex-wrap">
                                    <a href="{{ route('customize') }}" class="button-main flex-1 text-center border-0 cursor-pointer bg-black text-white font-semibold py-3 px-4 uppercase no-underline min-w-[140px]">Customize</a>
                                </div>
                                @endif
                            </div>
                            @include('partials.product-benefit-items')
                        </div>
                    </div>
                </div>
            </div>
            <div class="desc-tab md:pt-20 pt-10">
                <div class="container">
                    <div class="flex items-center justify-center w-full">
                        <div class="menu-tab flex items-center md:gap-[60px] gap-8">
                            <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer select-none active" data-item="Description" role="button" tabindex="0">Description</div>
                            <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer select-none" data-item="Specifications" role="button" tabindex="0">Specifications</div>
                            <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer select-none" data-item="Review" role="button" tabindex="0">Review</div>
                        </div>
                    </div>
                    <div class="desc-block mt-8">
                        <div class="desc-item description open" data-item="Description">
                            <div class="grid md:grid-cols-2 gap-8 gap-y-5">
                                <div class="left">
                                    <div class="heading6">Detailed Description</div>
                                    @php
                                        $isHtml = $product->description && (str_contains($product->description, '<') && str_contains($product->description, '>'));
                                    @endphp
                                    <div class="desc-detail-wrapper see-more-wrap" data-truncate-class="desc-truncated">
                                        <div class="text-secondary mt-2 desc-detail-content {{ !$isHtml ? 'desc-truncated' : '' }} @if($isHtml) product-description-html @endif" data-see-more-content>
                                            @if($product->description)
                                                @if($isHtml)
                                                    {!! $product->description !!}
                                                @else
                                                    {!! nl2br(e($product->description)) !!}
                                                @endif
                                            @else
                                                <span class="text-secondary2">{{ $product->short_description ?: 'No detailed description has been added for this product.' }}</span>
                                            @endif
                                        </div>
                                        @if(!$isHtml)
                                            <button type="button" class="see-more-btn text-button text-black hover:underline mt-2 cursor-pointer font-semibold">See more</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="heading6">About This Product</div>
                                    <div class="list-feature">
                                        @if($product->short_description)
                                            <div class="item flex gap-1 text-secondary mt-1 about-short-wrap see-more-wrap" data-truncate-class="about-truncated">
                                                <i class="ph ph-dot text-2xl flex-shrink-0"></i>
                                                <div>
                                                    <p class="about-short-content about-truncated" data-see-more-content>{{ $product->short_description }}</p>
                                                    <button type="button" class="see-more-btn text-button text-black hover:underline mt-1 cursor-pointer font-semibold text-sm">See more</button>
                                                </div>
                                            </div>
                                        @endif
                                        @if($product->category)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Category: {{ $product->category->name }}</p>
                                            </div>
                                        @endif
                                        @if($product->in_stock)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>In Stock: {{ $product->stock_quantity ?? 'Available' }} units</p>
                                            </div>
                                        @else
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Currently Out of Stock</p>
                                            </div>
                                        @endif
                                        @if(isset($availableSizes) && count($availableSizes) > 0)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Size: {{ implode(', ', $availableSizes) }}</p>
                                            </div>
                                        @endif
                                        @if(isset($availableColors) && count($availableColors) > 0)
                                            <div class="item flex gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl"></i>
                                                <p>Colors: {{ implode(', ', $availableColors) }}</p>
                                            </div>
                                        @endif
                                        @if($product->specifications && is_array($product->specifications) && count($product->specifications) > 0)
                                            @foreach($product->specifications as $key => $value)
                                            <div class="item flex items-start gap-1 text-secondary mt-1">
                                                <i class="ph ph-dot text-2xl flex-shrink-0 leading-none"></i>
                                                <p class="min-w-0"><strong>{{ $key }}:</strong> {{ $value }}</p>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="grid lg:grid-cols-4 grid-cols-2 gap-[30px] md:mt-10 mt-6">
                                @php
                                    $f1Title = \App\Models\Setting::get('product_feature_1_title', 'Shipping Faster');
                                    $f1Text = \App\Models\Setting::get('product_feature_1_text', 'Free shipping on orders over ₹499. Fast delivery across India.');
                                    $f2Title = \App\Models\Setting::get('product_feature_2_title', 'Premium Material');
                                    $f2Text = \App\Models\Setting::get('product_feature_2_text', 'Crafted from high-quality materials for durability and style.');
                                    $f3Title = \App\Models\Setting::get('product_feature_3_title', 'High Quality');
                                    $f3Text = \App\Models\Setting::get('product_feature_3_text', 'Built to last. Every product is designed for everyday excellence.');
                                    $f4Title = \App\Models\Setting::get('product_feature_4_title', 'Highly Compatible');
                                    $f4Text = \App\Models\Setting::get('product_feature_4_text', 'Works beautifully at home, work, travel, and for gifting.');
                                @endphp
                                <div class="item">
                                    <div class="icon-delivery-truck text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f1Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f1Text }}</div>
                                </div>
                                <div class="item">
                                    <div class="icon-cotton text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f2Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f2Text }}</div>
                                </div>
                                <div class="item">
                                    <div class="icon-guarantee text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f3Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f3Text }}</div>
                                </div>
                                <div class="item">
                                    <div class="icon-leaves-compatible text-4xl"></div>
                                    <div class="heading6 mt-4">{{ $f4Title }}</div>
                                    <div class="text-secondary mt-2">{{ $f4Text }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="desc-item specifications" data-item="Specifications">
                            <div class="product-specs-table lg:w-1/2 sm:w-3/4 w-full mx-auto">
                                @if(isset($availableSizes) && count($availableSizes) > 0)
                                <div class="product-spec-row item flex items-start gap-4 sm:gap-8 py-3 px-4 sm:px-10">
                                    <div class="product-spec-label text-title shrink-0 sm:w-1/3 w-2/5">Size</div>
                                    <div class="product-spec-value text-secondary flex-1 min-w-0">{{ implode(', ', $availableSizes) }}</div>
                                </div>
                                @endif
                                @if(isset($availableColors) && count($availableColors) > 0)
                                <div class="product-spec-row item bg-surface flex items-start gap-4 sm:gap-8 py-3 px-4 sm:px-10">
                                    <div class="product-spec-label text-title shrink-0 sm:w-1/3 w-2/5">Colors</div>
                                    <div class="product-spec-value text-secondary flex-1 min-w-0">{{ implode(', ', $availableColors) }}</div>
                                </div>
                                @endif
                                @if($product->specifications && is_array($product->specifications) && count($product->specifications) > 0)
                                    @php $specIndex = 0; @endphp
                                    @foreach($product->specifications as $key => $value)
                                    <div class="product-spec-row item {{ $specIndex % 2 == 0 ? '' : 'bg-surface' }} flex items-start gap-4 sm:gap-8 py-3 px-4 sm:px-10">
                                        <div class="product-spec-label text-title shrink-0 sm:w-1/3 w-2/5">{{ $key }}</div>
                                        <div class="product-spec-value text-secondary flex-1 min-w-0">{{ is_array($value) ? implode(', ', $value) : $value }}</div>
                                    </div>
                                    @php $specIndex++; @endphp
                                    @endforeach
                                @endif
                                @if((isset($availableSizes) && count($availableSizes) > 0) || (isset($availableColors) && count($availableColors) > 0) || ($product->specifications && is_array($product->specifications) && count($product->specifications) > 0))
                                @else
                                <div class="product-spec-row item flex items-start gap-4 sm:gap-8 py-3 px-4 sm:px-10">
                                    <div class="text-secondary">No specifications available for this product.</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="desc-item review" data-item="Review">
                            @include('partials.product-reviews', ['product' => $product, 'reviews' => $reviews, 'reviewStats' => $reviewStats])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($product->video)
            <div class="container py-10">
                <div class="heading3 text-center mb-6">Product Video</div>
                <div class="w-full max-w-[720px] mx-auto rounded-2xl overflow-hidden bg-black shadow-lg" style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <video 
                        controls 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;"
                        preload="metadata"
                    >
                        <source src="{{ storage_asset($product->video) }}#t=0.1" type="video/mp4">
                        <source src="{{ storage_asset($product->video) }}" type="video/mp4">
                        <source src="{{ storage_asset($product->video) }}" type="video/quicktime">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        @endif

        <div class="tab-features-block filter-product-block related-products-section md:pt-16 md:pb-10 pt-8 pb-6">
            <div class="container">
                <div class="heading3 text-center">Related Products</div>
                <div class="list-product six-product hide-product-sold relative section-swiper-navigation style-outline style-small-border md:mt-8 mt-5 related-products-slider">
                    <button type="button" class="related-products-prev swiper-button-prev2" aria-label="Previous related products">
                        <i class="ph-bold ph-caret-left text-xl"></i>
                    </button>
                    <div class="swiper related-products-swiper relative">
                        <div class="swiper-wrapper">
                            @forelse($relatedProducts as $relatedProduct)
                                <div class="swiper-slide h-auto">
                                    @include('partials.product-card', ['product' => $relatedProduct])
                                </div>
                            @empty
                                <div class="swiper-slide col-span-full text-center py-10">
                                    <p class="text-secondary">No related products available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <button type="button" class="related-products-next swiper-button-next2" aria-label="Next related products">
                        <i class="ph-bold ph-caret-right text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.pushEcommerceEvent !== 'function') return;
    window.pushEcommerceEvent('view_item', @json(ecommerce_view_item_payload($product, $initialDisplayPrice, $initialProductTitle)));
});
</script>
<script src="{{ asset('assets/js/product-detail.js') }}?v={{ filemtime(public_path('assets/js/product-detail.js')) }}"></script>
<script>
(function () {
    function setupRelatedProductsSlider() {
        var root = document.querySelector('.related-products-slider');
        var el = root && root.querySelector('.related-products-swiper');
        if (!el || typeof Swiper === 'undefined') return;

        var prevEl = root.querySelector('.related-products-prev');
        var nextEl = root.querySelector('.related-products-next');

        if (el.swiper) {
            el.swiper.destroy(true, true);
        }

        new Swiper(el, {
            navigation: {
                prevEl: prevEl,
                nextEl: nextEl,
            },
            loop: false,
            watchOverflow: true,
            autoHeight: true,
            slidesPerView: 2,
            spaceBetween: 16,
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupRelatedProductsSlider);
    } else {
        setupRelatedProductsSlider();
    }
    // Re-init after theme main.js in case it races
    window.addEventListener('load', setupRelatedProductsSlider);

    function setupProductGallery() {
        var productDetail = document.querySelector('.product-detail.style-grouped');
        if (!productDetail || typeof Swiper === 'undefined') return;

        var thumbEl = productDetail.querySelector('.product-gallery-thumbs') || productDetail.querySelector('.mySwiper');
        var mainEl = productDetail.querySelector('.product-gallery-main') || productDetail.querySelector('.mySwiper2');
        if (!thumbEl || !mainEl) return;

        if (thumbEl.swiper) thumbEl.swiper.destroy(true, true);
        if (mainEl.swiper) mainEl.swiper.destroy(true, true);

        var isMobile = window.matchMedia('(max-width: 639.98px)').matches;

        var thumbSwiper = new Swiper(thumbEl, {
            direction: isMobile ? 'horizontal' : 'vertical',
            spaceBetween: 10,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
            watchOverflow: true,
        });

        var mainSwiper = new Swiper(mainEl, {
            spaceBetween: 0,
            thumbs: { swiper: thumbSwiper },
            on: {
                slideChange: function () {
                    var activeIndex = this.activeIndex;
                    thumbEl.querySelectorAll('.swiper-slide').forEach(function (slide, index) {
                        slide.classList.toggle('swiper-slide-thumb-active', index === activeIndex);
                    });
                },
            },
        });

        // Keep square gallery height for vertical thumbs column
        if (!isMobile && mainEl) {
            var syncThumbHeight = function () {
                thumbEl.style.maxHeight = mainEl.offsetHeight + 'px';
            };
            syncThumbHeight();
            window.addEventListener('resize', syncThumbHeight);
        }

        window.swiperUnderwear = thumbSwiper;
        window.swiper2 = mainSwiper;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupProductGallery);
    } else {
        setupProductGallery();
    }

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setupProductGallery, 250);
    });
})();
</script>
<script>
    // Description / Specifications / Review tabs — work without full reload (reliable on server)
    function initDescTabs() {
        var descTab = document.querySelector('.desc-tab');
        if (!descTab) return;
        var tabButtons = descTab.querySelectorAll('.menu-tab .tab-item');
        var panels = descTab.querySelectorAll('.desc-block .desc-item');
        if (!tabButtons.length || !panels.length) return;

        function showPanel(dataItem) {
            if (!dataItem) return;
            panels.forEach(function(panel) {
                if (panel.getAttribute('data-item') === dataItem) {
                    panel.classList.add('open');
                } else {
                    panel.classList.remove('open');
                }
            });
            tabButtons.forEach(function(btn) {
                btn.classList.remove('active');
                if (btn.getAttribute('data-item') === dataItem) btn.classList.add('active');
            });
            if (dataItem === 'Description' && typeof window.refreshProductSeeMore === 'function') {
                window.refreshProductSeeMore();
            }
        }

        // Event delegation: one listener on container so tabs work even if script runs early
        descTab.addEventListener('click', function(e) {
            var btn = e.target.closest('.menu-tab .tab-item');
            if (btn) {
                e.preventDefault();
                var dataItem = btn.getAttribute('data-item');
                if (dataItem) showPanel(dataItem);
            }
        });
        descTab.addEventListener('keydown', function(e) {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            var btn = e.target.closest('.menu-tab .tab-item');
            if (btn) {
                e.preventDefault();
                var dataItem = btn.getAttribute('data-item');
                if (dataItem) showPanel(dataItem);
            }
        });

        if (window.location.hash === '#form-review') showPanel('Review');
        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#form-review') showPanel('Review');
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDescTabs);
    } else {
        initDescTabs();
    }

    function initSeeMoreBlocks() {
        function contentOverflows(content, truncateClass) {
            if (!content || !truncateClass) return false;
            content.classList.remove(truncateClass);
            var fullHeight = content.scrollHeight;
            content.classList.add(truncateClass);
            var clampedHeight = content.scrollHeight;
            return fullHeight > clampedHeight + 2;
        }

        function syncSeeMoreWrap(wrap) {
            var content = wrap.querySelector('[data-see-more-content]');
            var btn = wrap.querySelector('.see-more-btn');
            var truncateClass = wrap.getAttribute('data-truncate-class') || 'about-truncated';
            if (!content || !btn) return;

            if (content.classList.contains('is-expanded')) {
                btn.classList.add('is-visible');
                btn.textContent = 'See less';
                return;
            }

            if (contentOverflows(content, truncateClass)) {
                content.classList.add(truncateClass);
                btn.classList.add('is-visible');
                btn.textContent = 'See more';
            } else {
                content.classList.remove(truncateClass);
                content.classList.remove('is-expanded');
                btn.classList.remove('is-visible');
                btn.textContent = 'See more';
            }
        }

        document.querySelectorAll('.see-more-wrap').forEach(syncSeeMoreWrap);

        requestAnimationFrame(function() {
            document.querySelectorAll('.see-more-wrap').forEach(syncSeeMoreWrap);
        });
        window.addEventListener('load', function() {
            document.querySelectorAll('.see-more-wrap').forEach(syncSeeMoreWrap);
        });

        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.see-more-btn');
            if (!btn) return;
            var wrap = btn.closest('.see-more-wrap');
            if (!wrap) return;
            e.preventDefault();
            e.stopPropagation();

            var content = wrap.querySelector('[data-see-more-content]');
            var truncateClass = wrap.getAttribute('data-truncate-class') || 'about-truncated';
            if (!content) return;

            var expanded = content.classList.contains('is-expanded');
            if (expanded) {
                content.classList.remove('is-expanded');
                content.classList.add(truncateClass);
                btn.textContent = 'See more';
            } else {
                content.classList.add('is-expanded');
                content.classList.remove(truncateClass);
                btn.textContent = 'See less';
            }
        });

        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                document.querySelectorAll('.see-more-wrap').forEach(syncSeeMoreWrap);
            }, 150);
        });

        window.refreshProductSeeMore = function() {
            document.querySelectorAll('.see-more-wrap').forEach(syncSeeMoreWrap);
        };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSeeMoreBlocks);
    } else {
        initSeeMoreBlocks();
    }

    // Product detail page functionality
    (function() {
        'use strict';
        
        function getSelectedInventoryColor() {
            const optEl = document.querySelector('.inventory-option-item.active');
            if (optEl) return optEl.getAttribute('data-color') || '';
            const invColorEl = document.querySelector('.inventory-color-item.active')
                || document.querySelector('.choose-inventory-color .color-item.active');
            if (invColorEl) return invColorEl.getAttribute('data-color') || '';
            const productInfor = document.querySelector('.product-infor');
            return productInfor ? (productInfor.getAttribute('data-default-inventory-color') || '') : '';
        }

        function getSelectedInventorySize() {
            const optEl = document.querySelector('.inventory-option-item.active');
            if (optEl) return optEl.getAttribute('data-size') || '';
            const sizeEl = document.querySelector('.choose-size .size-item.active, .size-item.active:not(.size-unavailable)');
            if (sizeEl) return sizeEl.getAttribute('data-size') || '';
            const productInfor = document.querySelector('.product-infor');
            return productInfor ? (productInfor.getAttribute('data-default-size') || '') : '';
        }

        function syncHiddenInventoryMirrors(color, size) {
            const colorMirror = document.querySelector('.choose-inventory-color .inventory-color-item');
            if (colorMirror) {
                colorMirror.setAttribute('data-color', color || '');
                colorMirror.classList.add('active');
            }
            const sizeMirror = document.querySelector('.choose-size .size-item');
            if (sizeMirror) {
                sizeMirror.setAttribute('data-size', size || '');
                sizeMirror.classList.add('active');
            }
            const productInfor = document.querySelector('.product-infor');
            if (productInfor) {
                productInfor.setAttribute('data-default-inventory-color', color || '');
                productInfor.setAttribute('data-default-size', size || '');
            }
        }

        function getInventoryOptions() {
            const productInfor = document.querySelector('.product-infor');
            if (!productInfor) return [];
            try {
                return JSON.parse(productInfor.getAttribute('data-inventory-options') || '[]') || [];
            } catch (e) {
                return [];
            }
        }

        function findInventoryOption(color, size) {
            const options = getInventoryOptions();
            const colorNorm = String(color || '').trim().toLowerCase();
            const sizeNorm = String(size || '').trim().toLowerCase();
            let match = options.find(function(o) {
                return String(o.color || '').trim().toLowerCase() === colorNorm
                    && String(o.size || '').trim().toLowerCase() === sizeNorm;
            });
            if (match) return match;
            if (sizeNorm) {
                match = options.find(function(o) {
                    return String(o.size || '').trim().toLowerCase() === sizeNorm;
                });
                if (match) return match;
            }
            if (colorNorm) {
                match = options.find(function(o) {
                    return String(o.color || '').trim().toLowerCase() === colorNorm;
                });
            }
            return match || null;
        }

        function updateStockBadge(qty, inStock) {
            const badge = document.querySelector('.product-stock-badge');
            if (!badge) return;
            const textEl = badge.querySelector('.stock-badge-text');
            badge.setAttribute('data-stock-qty', String(qty || 0));
            badge.classList.toggle('text-stock-in', !!inStock);
            badge.classList.toggle('text-stock-out', !inStock);
            badge.classList.remove('text-green', 'text-red');
            const icon = badge.querySelector('i');
            if (icon) {
                icon.className = inStock ? 'ph ph-check-circle text-base' : 'ph ph-x-circle text-base';
            }
            if (textEl) {
                textEl.textContent = inStock
                    ? ('In Stock' + (qty > 0 ? (': ' + qty + ' left') : ''))
                    : 'Out of Stock';
            }
            const productInfor = document.querySelector('.product-infor');
            if (productInfor) {
                productInfor.setAttribute('data-in-stock', inStock ? '1' : '0');
            }
        }

        function updateProductVariantPrice() {
            const block = document.querySelector('.product-price-block');
            if (!block) return;
            const variantPricesJson = block.getAttribute('data-variant-prices');
            const productPrice = parseFloat(block.getAttribute('data-product-price') || '0') || 0;
            const productSalePriceRaw = block.getAttribute('data-product-sale-price');
            const productSalePrice = productSalePriceRaw !== '' && productSalePriceRaw !== null ? (parseFloat(productSalePriceRaw) || null) : null;
            let variantPrices = [];
            try {
                if (variantPricesJson) variantPrices = JSON.parse(variantPricesJson);
            } catch (e) { return; }
            const productInfor = document.querySelector('.product-infor');
            const color = getSelectedInventoryColor();
            const size = getSelectedInventorySize() || (productInfor?.getAttribute('data-default-size') || '');
            const inv = findInventoryOption(color, size);
            let price = productPrice;
            let salePrice = productSalePrice;
            if (inv) {
                price = parseFloat(inv.price) || price;
                salePrice = (inv.sale_price !== null && inv.sale_price !== undefined && inv.sale_price !== '')
                    ? (parseFloat(inv.sale_price) || null)
                    : null;
                updateStockBadge(parseInt(inv.quantity, 10) || 0, !!inv.in_stock);
            } else {
                for (let i = 0; i < variantPrices.length; i++) {
                    const v = variantPrices[i];
                    const vColor = v.color || '';
                    const vSize = v.size || '';
                    if (vColor === color && vSize === size) {
                        price = parseFloat(v.price) || price;
                        salePrice = (v.sale_price !== null && v.sale_price !== undefined && v.sale_price !== '') ? (parseFloat(v.sale_price) || null) : null;
                        break;
                    }
                }
            }
            const displayPrice = (salePrice !== null && salePrice > 0 && salePrice < price) ? salePrice : price;
            const priceEl = block.querySelector('.product-price');
            const originEl = block.querySelector('.product-origin-price');
            const saleBadge = block.querySelector('.product-sale');
            const separator = block.querySelector('.w-px.h-4');
            if (priceEl) priceEl.textContent = '₹' + displayPrice.toFixed(2);
            const hasSale = salePrice !== null && salePrice > 0 && price > salePrice;
            if (originEl) {
                const del = originEl.querySelector('del');
                if (del) del.textContent = '₹' + price.toFixed(2);
                originEl.classList.toggle('d-none', !hasSale);
            }
            if (separator) separator.classList.toggle('d-none', !hasSale);
            if (saleBadge) {
                if (hasSale) {
                    const pct = Math.round(((price - salePrice) / price) * 100);
                    saleBadge.textContent = '-' + pct + '%';
                    saleBadge.classList.remove('d-none');
                } else {
                    saleBadge.classList.add('d-none');
                }
            }
        }
        window.updateProductVariantPrice = updateProductVariantPrice;
        
        function syncSizesForInventoryColor(selectedColor) {
            var chooseSizeBlock = document.querySelector('.choose-size');
            if (!chooseSizeBlock) return;
            var sizesByColorJson = chooseSizeBlock.getAttribute('data-sizes-by-color');
            var allSizesJson = chooseSizeBlock.getAttribute('data-all-sizes');
            try {
                var sizesByColor = sizesByColorJson ? JSON.parse(sizesByColorJson) : {};
                var allSizes = allSizesJson ? JSON.parse(allSizesJson) : [];
                var sizesForColor = (selectedColor && sizesByColor[selectedColor])
                    ? sizesByColor[selectedColor]
                    : (sizesByColor[''] || allSizes);
                var listSize = chooseSizeBlock.querySelector('.list-size');
                if (!listSize) return;
                var sizeItems = listSize.querySelectorAll('.size-item');
                var firstAvailable = null;
                sizeItems.forEach(function(si) {
                    var s = si.getAttribute('data-size');
                    var available = sizesForColor.indexOf(s) !== -1;
                    if (available) {
                        si.classList.remove('size-unavailable', 'opacity-50', 'opacity-60');
                        si.setAttribute('title', s || '');
                        if (!firstAvailable) firstAvailable = si;
                    } else {
                        si.classList.add('size-unavailable', 'opacity-50');
                        si.setAttribute('title', 'This size is not available for this variant');
                        si.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                    }
                });
                var activeSize = listSize.querySelector('.size-item.active:not(.size-unavailable)');
                if (!activeSize && firstAvailable) {
                    sizeItems.forEach(function(si) { si.classList.remove('active', 'border-black'); });
                    firstAvailable.classList.add('active', 'border-black');
                    var sizeText = document.querySelector('.selected-size');
                    if (sizeText) sizeText.textContent = firstAvailable.getAttribute('data-size') || '';
                }
            } catch (err) { /* ignore */ }
        }

        function getDefaultMainImage() {
            const wrap = document.querySelector('.product-gallery-inner');
            if (wrap && wrap.getAttribute('data-default-main-image')) {
                return wrap.getAttribute('data-default-main-image');
            }
            const first = document.querySelector('.product-detail .mySwiper2 .swiper-slide img');
            return first ? (first.getAttribute('data-default-src') || first.getAttribute('src') || '') : '';
        }

        function setGalleryMainImage(url) {
            const fallback = getDefaultMainImage();
            const target = (url && String(url).trim() !== '') ? String(url).trim() : fallback;
            if (!target) return;

            const mainImg = document.querySelector('.product-detail .mySwiper2 .swiper-slide-active img')
                || document.querySelector('.product-detail .mySwiper2 .swiper-slide img');
            const thumbImg = document.querySelector('.product-detail .mySwiper .swiper-slide-active img')
                || document.querySelector('.product-detail .mySwiper .swiper-slide img');
            const popupImg = document.querySelector('.product-detail .popup-img .swiper-slide img');

            function applySrc(img) {
                if (!img) return;
                img.onerror = function() {
                    img.onerror = null;
                    if (fallback && img.src !== fallback) {
                        img.src = fallback;
                    }
                };
                if (img.src !== target) {
                    img.src = target;
                }
            }

            applySrc(mainImg);
            applySrc(thumbImg);
            applySrc(popupImg);

            // Keep swiper on first slide when swapping option image
            try {
                var gallerySwiper = window.swiper2 || window.productGalleryMainSwiper;
                if (gallerySwiper && typeof gallerySwiper.slideTo === 'function') {
                    gallerySwiper.slideTo(0);
                }
            } catch (err) { /* ignore */ }
        }

        // Inventory option = Color + Size pair (e.g. white / 7200ml)
        document.addEventListener('click', function(e) {
            const optItem = e.target.closest('.inventory-option-item');
            if (!optItem || !optItem.closest('.choose-inventory-option')) return;
            e.preventDefault();
            e.stopPropagation();

            if (optItem.classList.contains('size-unavailable') || optItem.getAttribute('data-in-stock') === '0') {
                return;
            }

            const siblings = optItem.parentElement.querySelectorAll('.inventory-option-item');
            siblings.forEach(sib => sib.classList.remove('active'));
            optItem.classList.add('active');

            const color = optItem.getAttribute('data-color') || '';
            const size = optItem.getAttribute('data-size') || '';
            const label = optItem.getAttribute('data-label') || (color + (color && size ? ' / ' : '') + size);
            const labelEl = document.querySelector('.selected-inventory-option');
            if (labelEl) labelEl.textContent = label;

            syncHiddenInventoryMirrors(color, size);

            // Use option image when present; otherwise restore original product gallery image
            const optImage = optItem.getAttribute('data-image');
            setGalleryMainImage(optImage || '');

            const stockQty = parseInt(optItem.getAttribute('data-stock') || '0', 10) || 0;
            const inStock = optItem.getAttribute('data-in-stock') === '1';
            updateStockBadge(stockQty, inStock);

            if (typeof window.updateProductVariantPrice === 'function') {
                window.updateProductVariantPrice();
            }
        });

        // Group product color selection + switch main image when color has a dedicated image
        document.addEventListener('click', function(e) {
            const colorItem = e.target.closest('.color-item');
            if (!colorItem || !colorItem.closest('.choose-color')) return;
            if (colorItem.classList.contains('inventory-color-item')) return;
            
            e.preventDefault();
            e.stopPropagation();

            const linkedProductUrl = colorItem.getAttribute('data-product-url');
            if (linkedProductUrl) {
                window.location.href = linkedProductUrl;
                return;
            }
            
            const siblings = colorItem.parentElement.querySelectorAll('.color-item');
            siblings.forEach(sib => sib.classList.remove('active', 'border-black'));
            colorItem.classList.add('active', 'border-black');
            
            const selectedColor = colorItem.getAttribute('data-color');
            const colorText = document.querySelector('.selected-color');
            if (colorText) colorText.textContent = selectedColor;

            const nameEl = document.querySelector('.product-name');
            if (nameEl && selectedColor) {
                const titlesJson = nameEl.getAttribute('data-color-titles');
                if (titlesJson) {
                    try {
                        const titles = JSON.parse(titlesJson);
                        if (titles[selectedColor]) {
                            nameEl.textContent = titles[selectedColor];
                        }
                    } catch (err) { /* ignore */ }
                }
            }
            
            if (typeof window.updateProductVariantPrice === 'function') {
                window.updateProductVariantPrice();
            }
            var chooseSizeBlock = document.querySelector('.choose-size');
            if (chooseSizeBlock) {
                var sizesByColorJson = chooseSizeBlock.getAttribute('data-sizes-by-color');
                var allSizesJson = chooseSizeBlock.getAttribute('data-all-sizes');
                try {
                    var sizesByColor = sizesByColorJson ? JSON.parse(sizesByColorJson) : {};
                    var allSizes = allSizesJson ? JSON.parse(allSizesJson) : [];
                    var sizesForColor = sizesByColor[selectedColor] || sizesByColor[''] || allSizes;
                    var listSize = chooseSizeBlock.querySelector('.list-size');
                    if (listSize) {
                        var sizeItems = listSize.querySelectorAll('.size-item');
                        var firstAvailable = null;
                        sizeItems.forEach(function(si) {
                            var s = si.getAttribute('data-size');
                            var available = sizesForColor.indexOf(s) !== -1;
                            if (available) {
                                si.classList.remove('size-unavailable', 'opacity-60');
                                si.setAttribute('title', '');
                                if (!firstAvailable) firstAvailable = si;
                            } else {
                                si.classList.add('size-unavailable', 'opacity-60');
                                si.setAttribute('title', 'This size is not available for this color');
                                si.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                                si.classList.add('border-line');
                            }
                        });
                        var activeSize = listSize.querySelector('.size-item.active:not(.size-unavailable)');
                        if (!activeSize && firstAvailable) {
                            sizeItems.forEach(function(sib) {
                                sib.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                                sib.classList.add('border-line');
                            });
                            firstAvailable.classList.add('active', 'border-black', 'bg-black', 'text-white');
                            firstAvailable.classList.remove('border-line');
                            var sizeTextEl = document.querySelector('.selected-size');
                            if (sizeTextEl) sizeTextEl.textContent = firstAvailable.getAttribute('data-size');
                            if (typeof window.updateProductVariantPrice === 'function') window.updateProductVariantPrice();
                        }
                    }
                } catch (err) { /* ignore */ }
            }
            
            // Switch product image to color-based image if available
            const chooseColor = colorItem.closest('.choose-color');
            const colorImagesJson = chooseColor?.getAttribute('data-color-images');
            if (colorImagesJson) {
                try {
                    const colorImages = JSON.parse(colorImagesJson);
                    const colorImageUrl = selectedColor ? (colorImages[selectedColor] || colorImages[selectedColor.trim()]) : '';
                    const mainSwiper = document.querySelector('.product-detail .mySwiper2');
                    const thumbSwiper = document.querySelector('.product-detail .mySwiper');
                    if (colorImageUrl && mainSwiper) {
                        const wrapper = mainSwiper.querySelector('.swiper-wrapper');
                        const firstSlide = wrapper?.querySelector('.swiper-slide');
                        const firstImg = firstSlide?.querySelector('img');
                        if (firstImg) {
                            firstImg.src = colorImageUrl;
                            firstImg.alt = selectedColor + ' - ' + (firstImg.alt || '');
                        }
                        if (thumbSwiper) {
                            const thumbWrapper = thumbSwiper.querySelector('.swiper-wrapper');
                            const thumbFirst = thumbWrapper?.querySelector('.swiper-slide img');
                            if (thumbFirst) thumbFirst.src = colorImageUrl;
                        }
                        const popupImg = document.querySelector('.product-detail .popup-img .swiper-wrapper .swiper-slide img');
                        if (popupImg) popupImg.src = colorImageUrl;
                    }
                } catch (err) { /* ignore */ }
            }
        });
        
        // Size selection
        document.addEventListener('click', function(e) {
            const sizeItem = e.target.closest('.size-item');
            if (!sizeItem || !sizeItem.closest('.choose-size')) return;
            
            var chooseSizeBlock = sizeItem.closest('.choose-size');
            var sizesByColorJson = chooseSizeBlock.getAttribute('data-sizes-by-color');
            var allSizesJson = chooseSizeBlock.getAttribute('data-all-sizes');
            var clickedSize = sizeItem.getAttribute('data-size');
            var selectedColor = getSelectedInventoryColor();
            var isAvailable = true;
            try {
                if (sizesByColorJson && allSizesJson) {
                    var sizesByColor = JSON.parse(sizesByColorJson);
                    var allSizes = JSON.parse(allSizesJson);
                    var sizesForColor = (selectedColor && sizesByColor[selectedColor])
                        ? sizesByColor[selectedColor]
                        : (sizesByColor[''] || allSizes);
                    isAvailable = sizesForColor.indexOf(clickedSize) !== -1;
                }
            } catch (err) { }
            
            if (!isAvailable || sizeItem.classList.contains('size-unavailable')) {
                e.preventDefault();
                e.stopPropagation();
                var existingToast = document.querySelector('.product-size-toast');
                if (existingToast) existingToast.remove();
                var msg = document.createElement('div');
                msg.className = 'product-size-toast fixed top-4 left-1/2 -translate-x-1/2 z-[9999] px-5 py-3 rounded-lg bg-gray-900 text-white text-sm font-medium shadow-xl whitespace-nowrap';
                msg.textContent = 'Is color ke liye ye size available nahi hai';
                msg.style.opacity = '1';
                msg.style.transition = 'opacity 0.2s';
                document.body.appendChild(msg);
                setTimeout(function() {
                    msg.style.opacity = '0';
                    setTimeout(function() { if (msg.parentNode) msg.remove(); }, 300);
                }, 2800);
                return;
            }
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove active class from siblings
            const siblings = sizeItem.parentElement.querySelectorAll('.size-item');
            siblings.forEach(sib => {
                sib.classList.remove('active', 'border-black', 'bg-black', 'text-white');
                sib.classList.add('border-line');
            });
            
            // Add active class to clicked item
            sizeItem.classList.add('active', 'border-black', 'bg-black', 'text-white');
            sizeItem.classList.remove('border-line');
            
            // Update selected size text
            const selectedSize = sizeItem.getAttribute('data-size');
            const sizeText = document.querySelector('.selected-size');
            if (sizeText) {
                sizeText.textContent = selectedSize;
            }

            // Auto-select inventory color that matches this size (if needed)
            const currentInvColor = getSelectedInventoryColor();
            const matchForSize = findInventoryOption(currentInvColor, selectedSize)
                || findInventoryOption('', selectedSize);
            if (matchForSize && matchForSize.color) {
                const invItems = document.querySelectorAll('.inventory-color-item');
                invItems.forEach(function(el) {
                    const isMatch = String(el.getAttribute('data-color') || '').toLowerCase()
                        === String(matchForSize.color || '').toLowerCase();
                    el.classList.toggle('active', isMatch);
                    el.classList.toggle('border-black', isMatch);
                });
                const invLabel = document.querySelector('.selected-inventory-color');
                if (invLabel) invLabel.textContent = matchForSize.color;
                const productInfor = document.querySelector('.product-infor');
                if (productInfor) productInfor.setAttribute('data-default-inventory-color', matchForSize.color);
            }

            if (typeof window.updateProductVariantPrice === 'function') {
                window.updateProductVariantPrice();
            }
        });
        
        function readProductQty(el) {
            if (!el) return 1;
            const raw = el.tagName === 'INPUT' ? el.value : el.textContent;
            let n = parseInt(String(raw).trim(), 10);
            if (isNaN(n) || n < 1) n = 1;
            return Math.min(n, 9999);
        }
        function writeProductQty(el, n) {
            if (!el) return;
            n = Math.max(1, Math.min(parseInt(n, 10) || 1, 9999));
            if (el.tagName === 'INPUT') el.value = String(n);
            else el.textContent = String(n);
        }
        // Quantity controls (+/- only; typing handled on blur/change)
        document.addEventListener('click', function(e) {
            const quantityBlock = e.target.closest('.quantity-block');
            if (!quantityBlock) return;
            
            const minusIcon = e.target.closest('.ph-minus');
            const plusIcon = e.target.closest('.ph-plus');
            const quantityElement = quantityBlock.querySelector('.quantity');
            
            if (!quantityElement || quantityElement.readOnly || quantityElement.disabled) return;
            
            if (minusIcon) {
                e.preventDefault();
                e.stopPropagation();
                writeProductQty(quantityElement, readProductQty(quantityElement) - 1);
            }
            
            if (plusIcon) {
                e.preventDefault();
                e.stopPropagation();
                writeProductQty(quantityElement, readProductQty(quantityElement) + 1);
            }
        });
        document.addEventListener('change', function(e) {
            const q = e.target.closest('.product-infor .quantity-block .quantity');
            if (!q || q.tagName !== 'INPUT') return;
            writeProductQty(q, readProductQty(q));
        });
        document.addEventListener('blur', function(e) {
            const q = e.target.closest('.product-infor .quantity-block .quantity');
            if (!q || q.tagName !== 'INPUT') return;
            writeProductQty(q, readProductQty(q));
        }, true);
        
        // Add to cart / Buy it now — handled by assets/js/cart.js (product detail + listing + quick view)
        
        // Show notification (fallback if cart.js not loaded)
        function showNotification(message, type = 'success') {
            const existing = document.querySelector('.notification');
            if (existing) existing.remove();
            
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.3s';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        window.showNotification = window.showNotification || showNotification;
    })();

    // Product image lightbox — keep web/mobile on the same slide as the gallery
    (function() {
        'use strict';

        function initImagePopup() {
            const productDetail = document.querySelector('.product-detail.style-grouped');
            if (!productDetail || typeof Swiper === 'undefined') return;

            const popupImg = productDetail.querySelector('.popup-img');
            if (!popupImg) return;

            const closePopupBtn = popupImg.querySelector('.close-popup-btn');
            const mainSwiperEl = productDetail.querySelector('.product-gallery-main') || productDetail.querySelector('.mySwiper2');
            const thumbSwiperEl = productDetail.querySelector('.product-gallery-thumbs') || productDetail.querySelector('.mySwiper');
            if (!mainSwiperEl) return;

            let popupSwiper = null;

            function getMainImages() {
                return Array.from(mainSwiperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate) img'));
            }

            function getActiveIndex() {
                var main = window.swiper2 || (mainSwiperEl && mainSwiperEl.swiper) || null;
                if (main && typeof main.realIndex === 'number') return main.realIndex;
                if (main && typeof main.activeIndex === 'number') return main.activeIndex;
                return 0;
            }

            function syncPopupSlides() {
                var wrapper = popupImg.querySelector('.swiper-wrapper');
                if (!wrapper) return 0;
                var images = getMainImages();
                if (!images.length) return 0;
                wrapper.innerHTML = images.map(function(img) {
                    var src = img.currentSrc || img.src || '';
                    var alt = (img.getAttribute('alt') || '').replace(/"/g, '&quot;');
                    return '<div class="swiper-slide"><img src="' + src + '" alt="' + alt + '" class="product-lightbox-img" /></div>';
                }).join('');
                return images.length;
            }

            function destroyPopupSwiper() {
                if (popupSwiper) {
                    popupSwiper.destroy(true, true);
                    popupSwiper = null;
                }
            }

            function openPopup(index) {
                var count = syncPopupSlides();
                if (!count) return;
                index = Math.max(0, Math.min(parseInt(index, 10) || 0, count - 1));

                destroyPopupSwiper();
                popupImg.classList.add('open');
                document.body.style.overflow = 'hidden';

                var nextBtn = popupImg.querySelector('.swiper-button-next');
                var prevBtn = popupImg.querySelector('.swiper-button-prev');
                popupSwiper = new Swiper(popupImg, {
                    loop: false,
                    slidesPerView: 1,
                    spaceBetween: 0,
                    centeredSlides: true,
                    initialSlide: index,
                    navigation: {
                        nextEl: nextBtn,
                        prevEl: prevBtn,
                    },
                });
                // Ensure exact slide after layout (mobile Swiper can mis-resolve initialSlide)
                popupSwiper.slideTo(index, 0, false);
            }

            function closePopup() {
                popupImg.classList.remove('open');
                document.body.style.overflow = '';
                destroyPopupSwiper();
            }

            // Main gallery image → open lightbox at the currently visible slide
            mainSwiperEl.addEventListener('click', function(e) {
                var img = e.target.closest('img');
                if (!img || !mainSwiperEl.contains(img)) return;
                e.preventDefault();
                e.stopPropagation();
                openPopup(getActiveIndex());
            });

            // Thumbnail → show that image in the main gallery (same on web & mobile)
            if (thumbSwiperEl) {
                thumbSwiperEl.addEventListener('click', function(e) {
                    var slide = e.target.closest('.swiper-slide');
                    if (!slide || !thumbSwiperEl.contains(slide)) return;
                    e.preventDefault();
                    e.stopPropagation();
                    var slides = Array.from(thumbSwiperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)'));
                    var index = slides.indexOf(slide);
                    if (index < 0) return;
                    var main = window.swiper2 || (mainSwiperEl && mainSwiperEl.swiper);
                    if (main) main.slideTo(index);
                });
            }

            // Double-tap / second click path: open lightbox from active thumb
            if (thumbSwiperEl) {
                thumbSwiperEl.addEventListener('dblclick', function(e) {
                    var slide = e.target.closest('.swiper-slide');
                    if (!slide) return;
                    var slides = Array.from(thumbSwiperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)'));
                    var index = slides.indexOf(slide);
                    if (index < 0) return;
                    openPopup(index);
                });
            }

            if (closePopupBtn) {
                closePopupBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closePopup();
                });
            }

            popupImg.addEventListener('click', function(e) {
                if (e.target.closest('.swiper-button-next') ||
                    e.target.closest('.swiper-button-prev') ||
                    e.target.closest('.swiper-slide') ||
                    e.target.closest('.close-popup-btn')) {
                    return;
                }
                if (e.target === popupImg) closePopup();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && popupImg.classList.contains('open')) {
                    closePopup();
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initImagePopup);
        } else {
            initImagePopup();
        }
    })();

    // Pincode Checker Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const pincodeInput = document.getElementById('pincode-input');
        const checkBtn = document.getElementById('check-pincode-btn');
        const deliveryInfo = document.getElementById('delivery-info');
        const deliveryEstimateText = document.getElementById('delivery-estimate-text');
        const productOrderAmount = {{ json_encode((float) $initialDisplayPrice) }};
        const freeShippingThreshold = {{ json_encode((float) \App\Models\Setting::get('free_shipping_threshold', 499)) }};
        const productQualifiesFreeShipping = productOrderAmount >= freeShippingThreshold;

        // Check pincode on button click
        checkBtn.addEventListener('click', checkDelivery);

        // Check pincode on Enter key
        pincodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkDelivery();
            }
        });

        // Auto-check when 6 digits are entered
        pincodeInput.addEventListener('input', function() {
            const pincode = this.value.trim();
            if (pincode.length === 6 && /^\d{6}$/.test(pincode)) {
                setTimeout(() => checkDelivery(), 500); // Small delay for better UX
            }
        });

        function checkDelivery() {
            const pincode = pincodeInput.value.trim();
            
            // Validate pincode
            if (!pincode || pincode.length !== 6 || !/^\d{6}$/.test(pincode)) {
                showDeliveryError('Please enter a valid 6-digit pincode');
                return;
            }

            // Show loading state
            checkBtn.textContent = 'Checking...';
            checkBtn.disabled = true;
            deliveryInfo.classList.add('hidden');

            // Make API call
            fetch('/api/shipping/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    pincode: pincode,
                    weight: 1,
                    cod_amount: 0,
                    order_amount: productOrderAmount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    showDeliverySuccess(data.data);
                } else {
                    showDeliveryError(data.message || 'Delivery not available to this pincode');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showDeliveryError('Error checking delivery. Please try again.');
            })
            .finally(() => {
                checkBtn.textContent = 'Check';
                checkBtn.disabled = false;
            });
        }

        function showDeliverySuccess(deliveryData) {
            const shippingCharge = parseFloat(deliveryData.shipping_charge) || 0;
            const estimatedDelivery = deliveryData.estimated_delivery || '3-5 business days';
            const provider = deliveryData.provider || 'Standard';
            const showShippingRow = !productQualifiesFreeShipping && shippingCharge > 0;

            deliveryInfo.innerHTML = `
                <div class="delivery-result-box delivery-result-box--success">
                    <div class="delivery-result-header">
                        <i class="ph ph-check-circle text-green-600"></i>
                        <span>Delivery Available</span>
                    </div>
                    <div class="delivery-result-rows">
                        ${productQualifiesFreeShipping ? `
                        <div class="delivery-result-row">
                            <span>Shipping:</span>
                            <span>Free on orders above ₹${freeShippingThreshold.toFixed(0)}</span>
                        </div>` : ''}
                        ${showShippingRow ? `
                        <div class="delivery-result-row">
                            <span>Shipping Charge:</span>
                            <span>₹${shippingCharge.toFixed(2)}</span>
                        </div>` : ''}
                        <div class="delivery-result-row">
                            <span>Estimated Delivery:</span>
                            <span>${estimatedDelivery}</span>
                        </div>
                        <div class="delivery-result-row">
                            <span>Service Provider:</span>
                            <span class="capitalize">${provider}</span>
                        </div>
                    </div>
                </div>
            `;
            
            // Update the main delivery estimate (element removed from UI)
            if (deliveryEstimateText) deliveryEstimateText.textContent = estimatedDelivery;
            
            deliveryInfo.classList.remove('hidden');
        }

        function showDeliveryError(message) {
            deliveryInfo.innerHTML = `
                <div class="delivery-result-box delivery-result-box--error">
                    <div class="delivery-result-header">
                        <i class="ph ph-x-circle text-red-600"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `;
            
            // Reset the main delivery estimate (element removed from UI)
            if (deliveryEstimateText) deliveryEstimateText.textContent = 'Enter pincode to check delivery';
            
            deliveryInfo.classList.remove('hidden');
        }
    });
</script>
