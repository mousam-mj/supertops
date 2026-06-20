@extends('layouts.app')

@section('title', ($category->name ?? 'Category') . ' - Perch Bottle')

@section('content')
@php
    $isSubCategoryPage = ! empty($category->parent_id);
    $heroImage = $category->hero_image;
    if (! $heroImage && ! $isSubCategoryPage) {
        $heroImage = $mainCategory->hero_image ?? null;
    }
    $heroText = $category->hero_text ?? ($mainCategory->hero_text ?? null);
    $heroButtonText = $category->hero_button_text ?? ($mainCategory->hero_button_text ?? 'Shop Now');
    $subCategoriesList = $subCategories ?? collect();
    $testimonialText = $category->testimonial_text ?? ($mainCategory->testimonial_text ?? null);
    $defaultTestimonial = "I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face.";
    $promoBannerImages = $category->banner_images ?? ($mainCategory->banner_images ?? []);
    $promoBannerTexts = $category->banner_texts ?? ($mainCategory->banner_texts ?? []);
    $promoBannerImages = is_array($promoBannerImages) ? $promoBannerImages : [];
    $promoBannerTexts = is_array($promoBannerTexts) ? $promoBannerTexts : [];
    $promoBannerDefaults = [
        asset('assets/images/product/Bottle-1.webp'),
        asset('assets/images/product/Bottle-4.webp'),
        asset('assets/images/product/Bottle-8.webp'),
    ];
@endphp

{{-- 1. Top hero banner only --}}
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
        <div class="pointer-events-auto order-1">
            <!-- @if($heroText)
                <div class="heading4 text-center whitespace-normal max-w-2xl px-4">{{ $heroText }}</div>
            @else
                <div class="heading4 text-center whitespace-nowrap">{{ $category->name }}</div>
            @endif -->
        </div>
        <a href="{{ route('shop') }}" class="pointer-events-auto button-main order-2">{{ $heroButtonText }}</a>
    </div>
</div>

{{-- 2. Category cards --}}
<div class="collection-block mt-5">
    <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
        <div class="banner-block md:pt-20 pt-10">
            <div class="container">
                @if($subCategoriesList->isNotEmpty())
                    <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                        @foreach($subCategoriesList as $subCat)
                            @php
                                $subImage = $subCat->image ? storage_asset($subCat->image) : asset('assets/images/product/Bottle-1.webp');
                            @endphp
                            <a href="{{ route('category', $subCat->slug) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                <div class="banner-img w-full">
                                    <img src="{{ $subImage }}" alt="{{ $subCat->name }}" class="w-full aspect-[4/5] object-cover duration-500">
                                </div>
                                <span class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">{{ $heroButtonText }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    @php
                        $siblingCategories = $mainCategory
                            ? \App\Models\Category::where('is_active', true)
                                ->where('main_category_id', $mainCategory->id)
                                ->whereNull('parent_id')
                                ->where('id', '!=', $category->id)
                                ->orderBy('sort_order')
                                ->get()
                            : collect();
                    @endphp
                    @if($siblingCategories->isNotEmpty())
                        <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                            @foreach($siblingCategories->take(3) as $sibCat)
                                @php $sibImage = $sibCat->image ? storage_asset($sibCat->image) : asset('assets/images/product/Bottle-1.webp'); @endphp
                                <a href="{{ route('category', $sibCat->slug) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                    <div class="banner-img w-full">
                                        <img src="{{ $sibImage }}" alt="{{ $sibCat->name }}" class="w-full aspect-[4/5] object-cover duration-500">
                                    </div>
                                    <span class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">{{ $heroButtonText }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

{{-- 3. What's new --}}
<div class="what-new-block filter-product-block md:pt-20 pt-10" data-filter-type="main-category">
    <div class="container">
        <div class="heading flex flex-col items-center text-center">
            <div class="heading3">What's new</div>
            <div class="menu-tab bg-surface rounded-2xl mt-6">
                <div class="menu flex items-center gap-2 p-1 relative">
                    <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                    <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black active" data-item="all">All</div>
                    @foreach($mainCategories ?? [] as $mainCat)
                        <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="{{ $mainCat->slug }}">{{ $mainCat->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
            @forelse($featuredProducts as $product)
                <div class="what-new-product-wrap" data-main-category="{{ $product->category->mainCategory->slug ?? 'all' }}">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-secondary">No products available</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@push('scripts')
<script>
(function() {
    var block = document.querySelector('.what-new-block[data-filter-type="main-category"]');
    if (!block) return;
    var tabs = block.querySelectorAll('.menu-tab .tab-item[data-item]');
    var wraps = block.querySelectorAll('.what-new-product-wrap');
    function syncIndicator() {
        var menu = block.querySelector('.menu-tab .menu');
        if (menu && typeof window.syncMenuTabIndicator === 'function') {
            window.syncMenuTabIndicator(menu);
        }
    }
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var slug = this.getAttribute('data-item');
            block.querySelectorAll('.menu-tab .tab-item').forEach(function(t){ t.classList.remove('active'); });
            this.classList.add('active');
            syncIndicator();
            wraps.forEach(function(w) {
                var cat = w.getAttribute('data-main-category');
                if (slug === 'all' || cat === slug) { w.style.display = ''; } else { w.style.display = 'none'; }
            });
        });
    });
    syncIndicator();
})();
</script>
@endpush

{{-- 4. Testimonial --}}
<div class="quote-block bg-linear py-[60px] md:mt-10 mt-6">
    <div class="container flex items-center justify-center">
        <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"{{ $testimonialText ?? $defaultTestimonial }}"</div>
    </div>
</div>

{{-- 5. Three small promotional banners (Admin → Main Categories → Promotional Banners) --}}
<div class="banner-block md:pt-10 pt-6 pb-5 px-4 sm:px-5">
    <div class="container">
        <div class="list-banner grid md:grid-cols-3 gap-[20px]">
            @for($i = 0; $i < 3; $i++)
                @php
                    $promoImage = ! empty($promoBannerImages[$i]) ? storage_asset($promoBannerImages[$i]) : ($promoBannerDefaults[$i] ?? $promoBannerDefaults[0]);
                    $promoAlt = trim((string) ($promoBannerTexts[$i] ?? ''));
                    if ($promoAlt === '') {
                        $promoAlt = $category->name;
                    }
                @endphp
                <a href="{{ route('shop') }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ $promoImage }}" alt="{{ $promoAlt }}" class="w-full aspect-[4/5] object-cover duration-500">
                    </div>
                    <span class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</span>
                </a>
            @endfor
        </div>
    </div>
</div>

<div class="container">
    <div class="benefit-block md:mt-10 mt-6 py-10 px-2.5 bg-surface rounded-3xl">
        @include('partials.benefit-items')
    </div>
</div>

@include('partials.instagram-feed-slider')

@endsection
