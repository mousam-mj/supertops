@extends('layouts.app')

@section('title', ($category ? $category->name : 'Shop') . ' - Anvogue')

@section('content')
<div class="shop-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-block mb-6 md:mb-8">
            <nav class="flex items-center gap-2 caption1">
                <a href="{{ route('home') }}" class="text-secondary hover:text-black duration-300">Home</a>
                <span class="text-secondary">/</span>
                @if($category)
                    <a href="{{ route('shop') }}" class="text-secondary hover:text-black duration-300">Shop</a>
                    <span class="text-secondary">/</span>
                    <span class="text-black font-semibold">{{ $category->name }}</span>
                @else
                    <span class="text-black font-semibold">Shop</span>
                @endif
            </nav>
        </div>

        <!-- Category Header -->
        @if($category)
            <div class="category-header mb-8 md:mb-12 text-center">
                <h1 class="heading2 md:heading1 mb-3">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="body1 text-secondary max-w-2xl mx-auto">{{ $category->description }}</p>
                @endif
            </div>
        @else
            <div class="category-header mb-8 md:mb-12 text-center">
                <h1 class="heading2 md:heading1 mb-3">All Products</h1>
                <p class="body1 text-secondary max-w-2xl mx-auto">Browse our complete collection</p>
            </div>
        @endif

        <!-- Sub-categories -->
        @if($category && $category->children->count() > 0)
            <div class="sub-categories mb-10 md:mb-12">
                <h3 class="heading5 mb-6 text-center md:text-left">Browse by Sub-category</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($category->children as $subCategory)
                        <a href="{{ route('category', $subCategory->slug) }}" 
                           class="sub-category-card group relative p-6 md:p-8 bg-white border border-line rounded-2xl hover:border-black hover:bg-black hover:text-white duration-300 text-center overflow-hidden">
                            <div class="relative z-10">
                                <div class="heading6 mb-2">{{ $subCategory->name }}</div>
                                @if($subCategory->children->count() > 0)
                                    <div class="caption1 text-secondary group-hover:text-white/80 mt-2">
                                        {{ $subCategory->children->count() }} {{ $subCategory->children->count() == 1 ? 'item' : 'items' }}
                                    </div>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-br from-black/0 to-black/0 group-hover:from-black/5 group-hover:to-black/10 duration-300"></div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Products Section -->
        <div class="products-section">
            <div class="flex items-center justify-between mb-6 md:mb-8 pb-4 border-b border-line">
                <div class="text-secondary body1">
                    @if($category)
                        Showing products in <span class="text-black font-semibold">{{ $category->name }}</span>
                    @else
                        Showing all products
                    @endif
                </div>
            </div>

            <div class="products-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @if($category && $category->children->count() > 0)
                    @foreach($category->children as $subCategory)
                        @if($subCategory->children->count() > 0)
                            @foreach($subCategory->children as $product)
                                <div class="product-item group">
                                    <div class="product-card bg-white rounded-2xl overflow-hidden border border-line hover:border-black duration-300">
                                        <div class="product-thumb bg-surface relative overflow-hidden aspect-[3/4]">
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-secondary text-center px-4">{{ $product->name }}</span>
                                            </div>
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 duration-300"></div>
                                        </div>
                                        <div class="product-info p-4">
                                            <div class="product-name text-title mb-1 line-clamp-2">{{ $product->name }}</div>
                                            <div class="product-category caption1 text-secondary">{{ $subCategory->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @elseif($category)
                    <div class="col-span-full text-center py-16 md:py-20">
                        <div class="max-w-md mx-auto">
                            <i class="ph ph-package text-6xl text-secondary mb-4"></i>
                            <p class="body1 text-secondary mb-6">No products found in this category yet.</p>
                            <a href="{{ route('shop') }}" class="button-main inline-block">Browse All Categories</a>
                        </div>
                    </div>
                @else
                    <!-- Show all main categories -->
                    @foreach($categories as $mainCategory)
                        <a href="{{ route('category', $mainCategory->slug) }}" 
                           class="product-item group block">
                            <div class="product-card bg-white rounded-2xl overflow-hidden border border-line hover:border-black duration-300">
                                <div class="product-thumb bg-surface relative overflow-hidden aspect-[3/4]">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-secondary text-center px-4 heading6">{{ $mainCategory->name }}</span>
                                    </div>
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 duration-300"></div>
                                </div>
                                <div class="product-info p-4 text-center">
                                    <div class="product-name text-title mb-1">{{ $mainCategory->name }}</div>
                                    <div class="product-category caption1 text-secondary">
                                        @if($mainCategory->children->count() > 0)
                                            {{ $mainCategory->children->count() }} {{ $mainCategory->children->count() == 1 ? 'sub-category' : 'sub-categories' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>

            @if($category && $category->children->count() > 0 && $category->children->sum(fn($c) => $c->children->count()) == 0)
                <div class="col-span-full text-center py-16 md:py-20">
                    <div class="max-w-md mx-auto">
                        <i class="ph ph-package text-6xl text-secondary mb-4"></i>
                        <p class="body1 text-secondary mb-6">Products will be added soon in this category.</p>
                        <a href="{{ route('shop') }}" class="button-main inline-block">Browse All Categories</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
