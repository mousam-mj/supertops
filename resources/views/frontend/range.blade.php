@extends('layouts.frontend')

@section('title', 'Product Range - EDX Rulmenti Romania')

@section('styles')
<style>
    /* Scoped to range page only — never target global .ph (breaks all icons) */
    .range-page .edx-range-badge {
        --tw-bg-opacity: 1;
        background-color: rgb(236 33 39);
        color: #fff !important;
    }
    .range-page .edx-range-accent-text {
        color: rgb(236 33 39);
    }
</style>
@endsection

@section('content')
<div class="range-page">
<!-- Breadcrumb -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">{{ $rangeCategory?->name ?? 'Bearing' }}</div>
                    @if(!empty($rangeCategory))
                        <div class="heading6 mt-2 font-semibold text-white/95 leading-snug max-w-3xl">{{ $rangeCategory->name }}</div>
                    @endif
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div class="capitalize">{{ $rangeCategory?->name ?? 'Bearing' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shop-product breadcrumb1 lg:py-20 md:py-14 py-10">
    <div class="container">
        <div class="flex max-md:flex-wrap max-md:flex-col-reverse gap-y-8">
            <!-- Sidebar: same dynamic filters as home -->
            <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12">
                @include('frontend.partials.catalog-sidebar', ['categories' => $categories ?? collect(), 'facets' => $facets ?? ['cages' => [], 'rows' => []]])
            </div>

            <!-- Product List -->
            <div class="list-product-block style-list lg:w-3/4 md:w-2/3 w-full md:pl-3">
                <div class="filter-heading flex items-center justify-between gap-5 flex-wrap">
                    <div class="left flex has-line items-center flex-wrap gap-5">
                        <div class="min flex items-center gap-1">
                            <div>Products:</div>
                            <div class="min-price">{{ $products->total() }}</div>
                        </div>
                    </div>
                    <div class="sort-product right flex items-center gap-3">
                        <label for="select-filter" class="caption1 capitalize">Sort by</label>
                        <div class="select-block relative">
                            <select id="select-filter" name="select-filter" class="caption1 py-2 pl-3 md:pr-20 pr-10 rounded-lg border border-line" onchange="window.location.href=this.value">
                                <option value="{{ route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="{{ route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            </select>
                            <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                        </div>
                    </div>
                </div>

                <div class="list-product flex flex-col gap-8 mt-7">
                    @forelse($products as $product)
                    <div class="product-item list-type edxpro" data-product-id="{{ $product->id }}">
                        <div class="product-main cursor-pointer flex lg:items-center sm:justify-between gap-7 max-lg:gap-5 p-4">
                            <a href="{{ route('frontend.product', $product->slug) }}" class="flex sm:items-center gap-7 max-lg:gap-4 max-lg:flex-wrap lg:w-2/3 lg:flex-shrink-0 max-lg:w-full max-sm:flex-col max-sm:w-1/2 flex-1 min-w-0 no-underline text-inherit">
                                <div class="product-thumb bg-white relative overflow-hidden rounded-2xl block max-sm:w-1/2">
                                    <div class="product-img w-full rounded-2xl overflow-hidden">
                                        <img class="w-full duration-700" src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 200px;">
                                    </div>
                                </div>
                                <div class="product-infor max-sm:w-full">
                                    <div class="product-name heading6 inline-block duration-300">{{ $product->sku ?? $product->name }}</div>
                                    <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                        <div class="product-price text-title bg-green px-3 py-0.5 inline-block rounded-full">{{ $product->category->name ?? 'Bearing' }}</div>
                                    </div>
                                    @if($product->specifications)
                                    @php $specs = is_array($product->specifications) ? $product->specifications : json_decode($product->specifications, true); @endphp
                                    @if($specs)
                                    <div class="min flex items-center gap-1 mt-3">
                                        <div>Bore diameter:</div>
                                        <div class="min-price">{{ $specs['bore_diameter'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Outside diameter:</div>
                                        <div class="min-price">{{ $specs['outside_diameter'] ?? 'N/A' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Width:</div>
                                        <div class="min-price">{{ $specs['width'] ?? 'N/A' }}</div>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </a>
                            <div class="action w-fit flex flex-col items-center justify-center flex-shrink-0">
                                {{-- edx-add-quota-btn: layout JS + POST /quota-list/add. Not add-cart-btn / quick-shop-btn (theme main.js breaks quota). --}}
                                <button type="button" class="button-main whitespace-nowrap py-2 px-9 max-lg:px-5 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white edx-add-quota-btn" data-product-id="{{ $product->id }}">
                                    Add to Quota List
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-lg text-gray-500">No products found.</p>
                        <a href="{{ route('frontend.range') }}" class="mt-4 inline-block button-main py-2 px-6 rounded-full">View All Products</a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="list-pagination w-full flex items-center gap-4 mt-10">
                    @if($products->onFirstPage())
                    <button class="opacity-50 cursor-not-allowed">&lt;&lt;</button>
                    @else
                    <a href="{{ $products->url(1) }}">&lt;&lt;</a>
                    <a href="{{ $products->previousPageUrl() }}">&lt;</a>
                    @endif

                    @foreach($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" class="{{ $page == $products->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">&gt;</a>
                    <a href="{{ $products->url($products->lastPage()) }}">&gt;&gt;</a>
                    @else
                    <button class="opacity-50 cursor-not-allowed">&gt;&gt;</button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
