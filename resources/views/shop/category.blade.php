@extends('layouts.app')

@section('title', ($category->name ?? 'Category') . ' - Perch Bottle')

@section('content')
@php
    $isSubCategoryPage = ! empty($category->parent_id);
    $heroImage = $category->hero_image;
    $heroImageMobile = $category->hero_image_mobile;
    if (! $heroImage && ! $isSubCategoryPage) {
        $heroImage = $mainCategory->hero_image ?? null;
    }
    if (! $heroImageMobile && ! $isSubCategoryPage) {
        $heroImageMobile = $mainCategory->hero_image_mobile ?? null;
    }
    $heroButtonText = $category->hero_button_text ?? ($mainCategory->hero_button_text ?? 'Shop Now');
    $shopCategoryDefault = route('shop', ['category' => $category->slug]);
    $heroButtonUrl = setting_link_url(
        $category->hero_button_url ?? ($mainCategory->hero_button_url ?? null),
        $shopCategoryDefault
    );
    $heroShowText = $isSubCategoryPage
        ? ($category->hero_show_text ?? true)
        : ($mainCategory->hero_show_text ?? true);
    $promoShowText = $mainCategory->promo_show_text ?? true;
    $promoButtonText = trim((string) ($mainCategory->promo_button_text ?? '')) ?: 'Shop Now';
    $subcategoryCardsShowText = $mainCategory->subcategory_cards_show_text ?? true;
    $heroTextColorClass = banner_text_color_class(
        $isSubCategoryPage
            ? ($category->hero_text_color ?? null)
            : ($mainCategory->hero_text_color ?? null)
    );
    $promoTextColorClass = banner_text_color_class($mainCategory->promo_text_color ?? null);
    $subCategoriesList = $subCategories ?? collect();
    $heroSectionEnabled = $mainCategory?->hero_section_enabled ?? true;
    $whatsNewSectionEnabled = $mainCategory?->whats_new_section_enabled ?? true;
    $subcategoryCardsSectionEnabled = $mainCategory?->subcategory_cards_section_enabled ?? true;
    $testimonialSectionEnabled = $mainCategory?->testimonial_section_enabled ?? true;
    $promoSectionEnabled = $mainCategory?->promo_section_enabled ?? true;
    $benefitsSectionEnabled = $mainCategory?->benefits_section_enabled ?? true;
    $instagramSectionEnabled = $mainCategory?->instagram_section_enabled ?? true;
    $showCategoryBlocks = ! $isSubCategoryPage && $subCategoriesList->isNotEmpty() && $subcategoryCardsSectionEnabled;
    $testimonialText = $category->testimonial_text ?? ($mainCategory->testimonial_text ?? null);
    $defaultTestimonial = "I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face.";
    $promoBannerImages = $category->banner_images ?? ($mainCategory->banner_images ?? []);
    $promoBannerImagesMobile = $category->banner_images_mobile ?? ($mainCategory->banner_images_mobile ?? []);
    $promoBannerTexts = $category->banner_texts ?? ($mainCategory->banner_texts ?? []);
    $promoBannerUrls = $category->banner_urls ?? ($mainCategory->banner_urls ?? []);
    $promoBannerImages = is_array($promoBannerImages) ? $promoBannerImages : [];
    $promoBannerImagesMobile = is_array($promoBannerImagesMobile) ? $promoBannerImagesMobile : [];
    $promoBannerTexts = is_array($promoBannerTexts) ? $promoBannerTexts : [];
    $promoBannerUrls = is_array($promoBannerUrls) ? $promoBannerUrls : [];
    $promoCount = (int) ($mainCategory->promo_banner_count ?? 3);
    $promoCount = max(1, min(6, $promoCount));
    $promoBannerDefaults = [
        asset('assets/images/product/Bottle-1.webp'),
        asset('assets/images/product/Bottle-4.webp'),
        asset('assets/images/product/Bottle-8.webp'),
    ];
    $bottomBannerImages = $mainCategory->bottom_banner_images ?? [];
    $bottomBannerImagesMobile = $mainCategory->bottom_banner_images_mobile ?? [];
    $bottomBannerImages = is_array($bottomBannerImages) ? $bottomBannerImages : [];
    $bottomBannerImagesMobile = is_array($bottomBannerImagesMobile) ? $bottomBannerImagesMobile : [];
    while (count($bottomBannerImages) < 4) {
        $bottomBannerImages[] = null;
    }
    $bottomBannerBlockUrls = $mainCategory->bottom_banner_block_urls ?? [];
    $bottomBannerBlockUrls = is_array($bottomBannerBlockUrls) ? $bottomBannerBlockUrls : [];
    while (count($bottomBannerBlockUrls) < 4) {
        $bottomBannerBlockUrls[] = null;
    }
    $showBottomBlocks = ($mainCategory->bottom_banner_blocks_enabled ?? true) && count(array_filter($bottomBannerImages)) > 0;
    $gridColsClass = match (true) {
        $subCategoriesList->count() <= 2 => 'two-block-category-grid grid-cols-2 mx-auto',
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
@if($heroSectionEnabled)
<div class="list-banner relative category-hero-banner">
    @if($heroImage)
        <div class="banner-img w-full">
            @include('partials.responsive-banner-img', [
                'desktop' => $heroImage,
                'mobile' => $heroImageMobile,
                'alt' => $category->name,
                'class' => 'w-full h-full object-cover duration-500',
            ])
        </div>
    @else
        <div class="banner-img w-full">
            <img src="{{ asset('assets/images/slider/11b-scaled.webp') }}" alt="{{ $category->name }}" class="w-full h-full object-cover duration-500">
        </div>
    @endif
    @if($heroShowText)
    @php
        $heroOverlayText = trim((string) ($category->hero_text ?? ($mainCategory->hero_text ?? '')));
    @endphp
    <div class="banner-text-overlay {{ $heroTextColorClass }}">
        @if($heroOverlayText !== '')
            <div class="heading3 banner-overlay-heading">{{ $heroOverlayText }}</div>
        @endif
        <a href="{{ $heroButtonUrl }}" class="button-main">{{ $heroButtonText }}</a>
    </div>
    @endif
</div>
@endif

{{-- 2. What's new (this main category only, no filter tabs) --}}
@if($whatsNewSectionEnabled)
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
@endif

{{-- 3. Subcategory cards (main category pages only) --}}
@if($showCategoryBlocks)
<div class="collection-block category-subcategory-blocks mt-5">
    <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
        <div class="banner-block md:pt-10 pt-6">
            <div class="container">
                <div class="list-banner grid {{ $gridColsClass }} gap-4 md:gap-6 justify-items-center">
                    @foreach($subCategoriesList as $subCat)
                        @php
                            $subImageMobile = $subCat->image_mobile ?: $subCat->image;
                            $subImage = $subCat->image ? storage_asset($subCat->image) : asset('assets/images/product/Bottle-1.webp');
                            $subImageMobileUrl = $subImageMobile ? storage_asset($subImageMobile) : $subImage;
                            $subShopUrl = setting_link_url(
                                $subCat->hero_button_url ?? null,
                                route('shop', ['category' => $subCat->slug])
                            );
                        @endphp
                        <a href="{{ $subShopUrl }}" class="banner-item banner-card-stable banner-size-fixed banner-aspect-1-1 relative bg-surface block rounded-[20px] overflow-hidden w-full">
                            <div class="banner-img w-full overflow-hidden">
                                @if($subCat->image_mobile)
                                    <img src="{{ $subImage }}" alt="{{ $subCat->name }}" class="w-full h-full object-cover object-center hidden md:block">
                                    <img src="{{ $subImageMobileUrl }}" alt="{{ $subCat->name }}" class="w-full h-full object-cover object-center md:hidden">
                                @else
                                    <img src="{{ $subImage }}" alt="{{ $subCat->name }}" class="w-full h-full object-cover object-center">
                                @endif
                            </div>
                            @if($subcategoryCardsShowText)
                            <div class="banner-text-overlay">
                                <span class="button-main">{{ $heroButtonText }}</span>
                            </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- 4. Testimonial --}}
@if($testimonialSectionEnabled)
<div class="quote-block bg-linear py-[60px] md:mt-10 mt-6">
    <div class="container flex items-center justify-center">
        <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"{{ $testimonialText ?? $defaultTestimonial }}"</div>
    </div>
</div>
@endif

{{-- 5. Promotional blocks --}}
@if($promoSectionEnabled)
<div class="banner-block md:pt-10 pt-6 pb-5 px-4 sm:px-5">
    <div class="container">
        <div class="list-banner grid {{ $promoGridClass }} gap-[20px]">
            @for($i = 0; $i < $promoCount; $i++)
                @php
                    $promoImagePath = $promoBannerImages[$i] ?? null;
                    $promoImageMobilePath = $promoBannerImagesMobile[$i] ?? null;
                    $promoImage = ! empty($promoImagePath) ? storage_asset($promoImagePath) : ($promoBannerDefaults[$i] ?? $promoBannerDefaults[0]);
                    $promoAlt = trim((string) ($promoBannerTexts[$i] ?? ''));
                    if ($promoAlt === '') {
                        $promoAlt = $category->name;
                    }
                    $promoDisplayText = trim((string) ($promoBannerTexts[$i] ?? ''));
                    $promoHref = setting_link_url($promoBannerUrls[$i] ?? null, $shopCategoryDefault);
                @endphp
                <a href="{{ $promoHref }}" class="banner-item banner-card-stable banner-size-fixed relative bg-surface block rounded-[20px] overflow-hidden duration-500 w-full">
                    <div class="banner-img w-full overflow-hidden">
                        @if(! empty($promoImagePath))
                            @include('partials.responsive-banner-img', [
                                'desktop' => $promoImagePath,
                                'mobile' => $promoImageMobilePath,
                                'alt' => $promoAlt,
                                'class' => 'w-full h-full object-cover duration-500',
                            ])
                        @else
                            <img src="{{ $promoImage }}" alt="{{ $promoAlt }}" class="w-full h-full object-cover duration-500">
                        @endif
                    </div>
                    @if($promoShowText)
                    <div class="banner-text-overlay {{ $promoTextColorClass }}">
                        @if($promoDisplayText !== '')
                            <div class="heading4 banner-overlay-heading">{{ $promoDisplayText }}</div>
                        @endif
                        <span class="button-main">{{ $promoButtonText }}</span>
                    </div>
                    @endif
                </a>
            @endfor
        </div>
    </div>
</div>
@endif

{{-- 6. Bottom sale banner (split text + image) --}}
@if($mainCategory && ! $isSubCategoryPage)
    @include('partials.category-bottom-sale-banner', ['mainCategory' => $mainCategory])
@endif

{{-- 7. Bottom banner (4 image blocks) --}}
@if($showBottomBlocks)
<div class="banner-block md:pt-6 pt-4 pb-8 px-4 sm:px-5">
    <div class="container">
        <div class="list-banner grid sm:grid-cols-2 lg:grid-cols-4 gap-[20px]">
            @for($i = 0; $i < 4; $i++)
                @if(! empty($bottomBannerImages[$i]))
                    @php
                        $blockUrl = setting_link_url($bottomBannerBlockUrls[$i] ?? null, $shopCategoryDefault);
                    @endphp
                    <a href="{{ $blockUrl }}" class="banner-item banner-card-stable banner-size-fixed relative bg-surface block rounded-[20px] overflow-hidden duration-500 banner-zoom-only w-full">
                        <div class="banner-img w-full overflow-hidden">
                            @include('partials.responsive-banner-img', [
                                'desktop' => $bottomBannerImages[$i],
                                'mobile' => $bottomBannerImagesMobile[$i] ?? null,
                                'alt' => $category->name,
                                'class' => 'w-full h-full object-cover duration-500',
                            ])
                        </div>
                    </a>
                @endif
            @endfor
        </div>
    </div>
</div>
@endif

@if($benefitsSectionEnabled)
<div class="container">
    <div class="benefit-block md:mt-10 mt-6 py-10 px-2.5 bg-surface rounded-3xl">
        @include('partials.benefit-items')
    </div>
</div>
@endif

@if($instagramSectionEnabled)
@include('partials.instagram-feed-slider')
@endif

@endsection
