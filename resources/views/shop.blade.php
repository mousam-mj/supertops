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

        <!-- Search and Filters -->
        <div class="filters-section bg-white border border-line rounded-2xl p-6 mb-8">
            <form method="GET" action="{{ route('shop') }}" id="shop-filters-form">
                @if($category)
                    <input type="hidden" name="category" value="{{ $category->slug }}" />
                @endif
                
                <div class="grid md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block caption1 text-secondary mb-2">Search Products</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request()->get('search') }}" 
                               placeholder="Search by name, description..." 
                               class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" />
                    </div>
                    
                    <!-- Price Range -->
                    <div>
                        <label class="block caption1 text-secondary mb-2">Min Price</label>
                        <input type="number" 
                               name="min_price" 
                               value="{{ request()->get('min_price') }}" 
                               placeholder="Min" 
                               min="0"
                               class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" />
                    </div>
                    
                    <div>
                        <label class="block caption1 text-secondary mb-2">Max Price</label>
                        <input type="number" 
                               name="max_price" 
                               value="{{ request()->get('max_price') }}" 
                               placeholder="Max" 
                               min="0"
                               class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" />
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-line">
                    <div>
                        <label class="block caption1 text-secondary mb-2">Sort By</label>
                        <select name="sort" class="px-4 py-3 border border-line rounded-lg focus:border-black outline-none">
                            <option value="default" {{ request()->get('sort') == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="price_low" {{ request()->get('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request()->get('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request()->get('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ request()->get('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                            <option value="newest" {{ request()->get('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        </select>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="button-main">Apply Filters</button>
                        <a href="{{ route('shop') }}" class="button-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Section -->
        <div class="products-section">
            <div class="flex items-center justify-between mb-6 md:mb-8 pb-4 border-b border-line">
                <div class="text-secondary body1">
                    @if(request()->get('search'))
                        Showing {{ $products->total() }} results for "<span class="text-black font-semibold">{{ request()->get('search') }}</span>"
                    @elseif($category)
                        Showing {{ $products->total() }} products in <span class="text-black font-semibold">{{ $category->name }}</span>
                    @else
                        Showing {{ $products->total() }} products
                    @endif
                </div>
            </div>

            <div class="products-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                @else
                    <div class="col-span-full text-center py-16 md:py-20">
                        <div class="max-w-md mx-auto">
                            <i class="ph ph-package text-6xl text-secondary mb-4"></i>
                            <p class="body1 text-secondary mb-6">No products found in this category yet.</p>
                            <a href="{{ route('shop') }}" class="button-main inline-block">Browse All Categories</a>
                        </div>
                    </div>
                @endif
            </div>
            
            @if(isset($products) && $products->hasPages())
                <div class="pagination-block mt-10 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif

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
