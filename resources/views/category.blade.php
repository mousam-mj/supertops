@extends('layouts.app')

@section('title', ($category ? $category->name : 'Category') . ' - Perch Bottle')

@section('content')
<div class="category-page">
    <!-- Breadcrumb with Category Banner -->
    <div class="breadcrumb-block style-img">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">{{ $category ? $category->name : 'Category' }}</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <div class="text-secondary2 capitalize">{{ $category ? $category->name : 'Category' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @if($category && $category->image)
                <div class="list-banner sm:-mt-[75px]">
                    <div class="banner-img w-full relative">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full duration-500" />
                        <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category->name }}</div>
                        <a href="{{ route('category', $category->slug) }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
                    </div>
                </div>
            @else
                <div class="list-banner sm:-mt-[75px]">
                    <div class="banner-img w-full relative">
                        <img src="{{ asset('assets/images/slider/11b-scaled.webp') }}" alt="Category" class="w-full duration-500" />
                        <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category ? $category->name : 'Category' }}</div>
                        <a href="{{ route('shop') }}" class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Category Banners -->
    <div class="banner-block relative">
        <div class="list-banner">
            @if($category && $category->image)
                <a href="{{ route('category', $category->slug) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full duration-500" />
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category->name }}</div>
                    <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                </a>
            @else
                <a href="{{ route('shop') }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ asset('assets/images/slider/09-1-scaled.webp') }}" alt="Category" class="w-full duration-500" />
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category ? $category->name : 'Shop' }}</div>
                    <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                </a>
            @endif
        </div>
    </div>

    <!-- Collection Block -->
    <div class="collection-block mt-5">
        <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
            <div class="banner-block md:pt-20 pt-10">
                <div class="container">
                    <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                        @php
                            $subCategories = $category ? $category->children()->where('is_active', true)->limit(6)->get() : \App\Models\Category::whereNull('parent_id')->where('is_active', true)->limit(6)->get();
                            $defaultImages = ['Bottle-1.webp', 'Bottle-4.webp', 'Bottle-8.webp'];
                        @endphp
                        @forelse($subCategories as $index => $subCat)
                            <a href="{{ route('category', $subCat->slug) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                <div class="banner-img w-full">
                                    @if($subCat->image)
                                        <img src="{{ asset('storage/' . $subCat->image) }}" alt="{{ $subCat->name }}" class="w-full duration-500" />
                                    @else
                                        @php
                                            $imageIndex = $index % 3;
                                            $image = $defaultImages[$imageIndex] ?? 'Bottle-1.webp';
                                        @endphp
                                        <img src="{{ asset('assets/images/product/' . $image) }}" alt="{{ $subCat->name }}" class="w-full duration-500" />
                                    @endif
                                </div>
                                <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $subCat->name }}</div>
                                <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                            </a>
                        @empty
                            @php
                                $mainCategories = \App\Models\MainCategory::where('is_active', true)->limit(6)->get();
                            @endphp
                            @foreach($mainCategories as $index => $mainCat)
                                <a href="{{ route('shop', ['main_category' => $mainCat->slug]) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                    <div class="banner-img w-full">
                                        @if($mainCat->image)
                                            <img src="{{ asset('storage/' . $mainCat->image) }}" alt="{{ $mainCat->name }}" class="w-full duration-500" />
                                        @else
                                            @php
                                                $imageIndex = $index % 3;
                                                $image = $defaultImages[$imageIndex] ?? 'Bottle-1.webp';
                                            @endphp
                                            <img src="{{ asset('assets/images/product/' . $image) }}" alt="{{ $mainCat->name }}" class="w-full duration-500" />
                                        @endif
                                    </div>
                                    <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $mainCat->name }}</div>
                                    <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                                </a>
                            @endforeach
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quote Block -->
    <div class="quote-block bg-linear py-[60px] mt-10">
        <div class="container flex items-center justify-center">
            <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face."</div>
        </div>
    </div>

    <!-- Another Banner -->
    <div class="banner-block relative">
        <div class="list-banner">
            <a href="{{ route('shop') }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                <div class="banner-img w-full">
                    <img src="{{ asset('assets/images/slider/03b-scaled.webp') }}" alt="Shop" class="w-full duration-500" />
                </div>
                <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category ? $category->name : 'Shop' }}</div>
                <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
            </a>
        </div>
    </div>

    <!-- What's New Section -->
    <div class="what-new-block filter-product-block md:pt-20 pt-10">
        <div class="container">
            <div class="heading flex flex-col items-center text-center">
                <div class="heading3">What's new</div>
                <div class="menu-tab bg-surface rounded-2xl mt-6">
                    <div class="menu flex items-center gap-2 p-1 relative">
                        <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                        @php
                            $productTypes = ['all', 'featured', 'new', 'sale'];
                            $activeType = request()->get('type', 'all');
                        @endphp
                        @foreach($productTypes as $type)
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black {{ $activeType === $type ? 'active' : '' }}" data-item="{{ $type }}">
                                {{ $type === 'all' ? 'All' : ($type === 'featured' ? 'Featured' : ($type === 'new' ? 'New' : 'Sale')) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
                @forelse($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-secondary">No products found in this category.</p>
                    </div>
                @endforelse
            </div>
            
            @if($products->hasPages())
                <div class="pagination-block mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Brand Logos -->
    <div class="brand-block md:py-20 py-10">
        <div class="container">
            <div class="swiper swiper-brand h-[36px]">
                <div class="swiper-wrapper">
                    @for($i = 1; $i <= 7; $i++)
                        <div class="swiper-slide">
                            <div class="brand-item relative flex items-center justify-center h-[36px]">
                                <img src="{{ asset('assets/images/perch-logo.png') }}" alt="Brand {{ $i }}" class="h-full w-auto duration-500 relative object-cover" />
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching for product types
    const tabItems = document.querySelectorAll('.tab-item[data-item]');
    const indicator = document.querySelector('.indicator');
    
    tabItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            const type = this.getAttribute('data-item');
            
            // Update active tab
            tabItems.forEach(tab => tab.classList.remove('active'));
            this.classList.add('active');
            
            // Move indicator
            if (indicator) {
                const itemWidth = 100 / tabItems.length;
                indicator.style.left = (index * itemWidth) + '%';
                indicator.style.width = itemWidth + '%';
            }
            
            // Filter products (you can implement AJAX filtering here)
            window.location.href = '{{ route("category", $category->slug ?? "") }}?type=' + type;
        });
    });
    
    // Initialize Swiper for brands
    if (typeof Swiper !== 'undefined') {
        new Swiper('.swiper-brand', {
            slidesPerView: 'auto',
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
                1280: {
                    slidesPerView: 6,
                },
            },
        });
    }
});
</script>
@endsection
