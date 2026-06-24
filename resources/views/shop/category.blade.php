@extends('layouts.app')

@section('title', ($category->name ?? 'Category') . ' - Perch Bottle')

@section('content')
@php
    $isSubCategoryPage = ! empty($category->parent_id);
    $heroImage = $category->hero_image;
    if (! $heroImage && ! $isSubCategoryPage) {
        $heroImage = $mainCategory->hero_image ?? null;
    }
    $heroButtonText = $category->hero_button_text ?? ($mainCategory->hero_button_text ?? 'Shop Now');
    $subCategoriesList = $subCategories ?? collect();
    $showCategoryBlocks = ! $isSubCategoryPage && $subCategoriesList->isNotEmpty();
    $testimonialText = $category->testimonial_text ?? ($mainCategory->testimonial_text ?? null);
    $defaultTestimonial = "I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face.";
    $promoBannerImages = $category->banner_images ?? ($mainCategory->banner_images ?? []);
    $promoBannerTexts = $category->banner_texts ?? ($mainCategory->banner_texts ?? []);
    $promoBannerImages = is_array($promoBannerImages) ? $promoBannerImages : [];
    $promoBannerTexts = is_array($promoBannerTexts) ? $promoBannerTexts : [];
    $promoCount = (int) ($mainCategory->promo_banner_count ?? 3);
    $promoCount = max(1, min(6, $promoCount));
    $promoBannerDefaults = [
        asset('assets/images/product/Bottle-1.webp'),
        asset('assets/images/product/Bottle-4.webp'),
        asset('assets/images/product/Bottle-8.webp'),
    ];
    $bottomBannerImages = $mainCategory->bottom_banner_images ?? [];
    $bottomBannerImages = is_array($bottomBannerImages) ? $bottomBannerImages : [];
    $gridColsClass = match (true) {
        $subCategoriesList->count() <= 2 => 'md:grid-cols-2 max-w-3xl mx-auto',
        $subCategoriesList->count() <= 4 => 'md:grid-cols-2 lg:grid-cols-4',
        default => 'md:grid-cols-3 lg:grid-cols-3',
    };
    $promoGridClass = match ($promoCount) {
        1 => 'md:grid-cols-1 max-w-md mx-auto',
        2 => 'md:grid-cols-2 max-w-3xl mx-auto',
        default => 'md:grid-cols-3',
    };
@endphp

{{-- 1. Top hero banner --}}
<div class="list-banner relative">
    @if($heroImage)
        <div class="banner-img w-full">
            <img src="{{ storage_asset($heroImage) }}" alt="{{ $category->name }}" class="w-full duration-500">
        </div>
    @else
        <div class="banner-img w-full">
            <img src="{{ asset('assets/images/slider/11b-scaled.webp') }}" alt="{{ $category->name }}" class="w-full duration-500">
        </div>
    @endif
    <div class="absolute bottom-0 left-0 right-0 flex flex-col items-center justify-end gap-5 pb-8 pt-8 z-10 pointer-events-none">
        <a href="{{ route('shop') }}" class="pointer-events-auto button-main order-2">{{ $heroButtonText }}</a>
    </div>
</div>

{{-- 2. What's new (this main category only, no filter tabs) --}}
<div class="what-new-block filter-product-block md:pt-20 pt-10">
    <div class="container">
        <div class="heading flex flex-col items-center text-center">
            <div class="heading3">What's new</div>
        </div>
        <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
            @forelse($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-secondary">No products available</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- 3. Subcategory cards (main category pages only) --}}
@if($showCategoryBlocks)
<div class="collection-block mt-5">
    <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
        <div class="banner-block md:pt-10 pt-6">
            <div class="container">
                <div class="list-banner grid {{ $gridColsClass }} gap-[20px] justify-items-center">
                    @foreach($subCategoriesList as $subCat)
                        @php
                            $subImage = $subCat->image ? storage_asset($subCat->image) : asset('assets/images/product/Bottle-1.webp');
                        @endphp
                        <a href="{{ route('category', $subCat->slug) }}" class="banner-item banner-card-stable relative bg-surface block rounded-[20px] overflow-hidden duration-500 w-full">
                            <div class="banner-img w-full overflow-hidden">
                                <img src="{{ $subImage }}" alt="{{ $subCat->name }}" class="w-full aspect-[4/5] object-cover duration-500">
                            </div>
                            <span class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">{{ $heroButtonText }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- 4. Testimonial --}}
<div class="quote-block bg-linear py-[60px] md:mt-10 mt-6">
    <div class="container flex items-center justify-center">
        <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"{{ $testimonialText ?? $defaultTestimonial }}"</div>
    </div>
</div>

{{-- 5. Promotional blocks --}}
<div class="banner-block md:pt-10 pt-6 pb-5 px-4 sm:px-5">
    <div class="container">
        <div class="list-banner grid {{ $promoGridClass }} gap-[20px]">
            @for($i = 0; $i < $promoCount; $i++)
                @php
                    $promoImage = ! empty($promoBannerImages[$i]) ? storage_asset($promoBannerImages[$i]) : ($promoBannerDefaults[$i] ?? $promoBannerDefaults[0]);
                    $promoAlt = trim((string) ($promoBannerTexts[$i] ?? ''));
                    if ($promoAlt === '') {
                        $promoAlt = $category->name;
                    }
                @endphp
                <a href="{{ route('shop') }}" class="banner-item banner-card-stable relative bg-surface block rounded-[20px] overflow-hidden duration-500 w-full">
                    <div class="banner-img w-full overflow-hidden">
                        <img src="{{ $promoImage }}" alt="{{ $promoAlt }}" class="w-full aspect-[4/5] object-cover duration-500">
                    </div>
                    <span class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</span>
                </a>
            @endfor
        </div>
    </div>
</div>

{{-- 6. Bottom banner (4 images) --}}
@if(count(array_filter($bottomBannerImages)) > 0)
<div class="banner-block md:pt-6 pt-4 pb-8 px-4 sm:px-5">
    <div class="container">
        <div class="list-banner grid sm:grid-cols-2 lg:grid-cols-4 gap-[20px]">
            @for($i = 0; $i < 4; $i++)
                @if(! empty($bottomBannerImages[$i]))
                    <a href="{{ route('shop') }}" class="banner-item banner-card-stable relative bg-surface block rounded-[20px] overflow-hidden duration-500 banner-zoom-only w-full">
                        <div class="banner-img w-full overflow-hidden">
                            <img src="{{ storage_asset($bottomBannerImages[$i]) }}" alt="{{ $category->name }}" class="w-full aspect-[4/5] object-cover duration-500">
                        </div>
                    </a>
                @endif
            @endfor
        </div>
    </div>
</div>
@elseif($mainCategory && $mainCategory->bottom_banner_image)
<div class="banner-block md:pt-6 pt-4 pb-8 px-4 sm:px-5">
    <div class="container">
        <a href="{{ route('shop') }}" class="banner-item relative block rounded-[20px] overflow-hidden duration-500 banner-zoom-only">
            <img src="{{ storage_asset($mainCategory->bottom_banner_image) }}" alt="{{ $category->name }}" class="w-full object-cover max-h-[420px]">
        </a>
    </div>
</div>
@endif

<div class="container">
    <div class="benefit-block md:mt-10 mt-6 py-10 px-2.5 bg-surface rounded-3xl">
        @include('partials.benefit-items')
    </div>
</div>

@include('partials.instagram-feed-slider')

@endsection
