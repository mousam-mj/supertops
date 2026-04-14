@extends('layouts.frontend')

@section('title', 'Product Range - EDX Rulmenti Romania')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">DABB</div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div class="capitalize">Bearing</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shop-product breadcrumb1 lg:py-20 md:py-14 py-10">
    <div class="container">
        <div class="flex max-md:flex-wrap max-md:flex-col-reverse gap-y-8">
            <!-- Sidebar Filters -->
            <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12">
                <!-- Category Filter -->
                <div class="filter-type-block pb-8 border-b border-line">
                    <div class="heading6">Products Type</div>
                    <div class="list-type filter-type menu-tab mt-4">
                        @foreach($categories as $category)
                        <a href="{{ route('frontend.range', ['category' => $category->slug]) }}" 
                           class="item tab-item flex items-center justify-between cursor-pointer {{ request('category') == $category->slug ? 'active' : '' }}" 
                           data-item="{{ $category->slug }}">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">{{ $category->name }}</div>
                            <div class="text-secondary2 number">{{ $category->products_count ?? $category->products()->count() }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Search Filter -->
                <div class="filter-search pb-8 border-b border-line mt-8">
                    <div class="heading6">Search</div>
                    <form action="{{ route('frontend.range') }}" method="GET" class="mt-4">
                        @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by name or SKU..." 
                                   class="w-full py-3 pl-4 pr-10 rounded-lg border border-line">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                                <i class="ph ph-magnifying-glass text-xl"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bore Diameter Filter -->
                <div class="filter-size pb-8 border-b border-line mt-8">
                    <div class="heading6">Bore Diameter (mm)</div>
                    <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                        <a href="{{ route('frontend.range', array_merge(request()->except('bore'), ['bore' => '0-20'])) }}" 
                           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('bore') == '0-20' ? 'bg-black text-white' : '' }}">0-20</a>
                        <a href="{{ route('frontend.range', array_merge(request()->except('bore'), ['bore' => '20-50'])) }}" 
                           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('bore') == '20-50' ? 'bg-black text-white' : '' }}">20-50</a>
                        <a href="{{ route('frontend.range', array_merge(request()->except('bore'), ['bore' => '50-100'])) }}" 
                           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('bore') == '50-100' ? 'bg-black text-white' : '' }}">50-100</a>
                        <a href="{{ route('frontend.range', array_merge(request()->except('bore'), ['bore' => '100+'])) }}" 
                           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('bore') == '100+' ? 'bg-black text-white' : '' }}">100+</a>
                    </div>
                </div>
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
                                <option value="{{ route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price Low To High</option>
                                <option value="{{ route('frontend.range', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price High To Low</option>
                            </select>
                            <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
                        </div>
                    </div>
                </div>

                <div class="list-product flex flex-col gap-8 mt-7">
                    @forelse($products as $product)
                    <div class="product-item list-type edxpro">
                        <a href="{{ route('frontend.product', $product->slug) }}" class="product-main cursor-pointer flex lg:items-center sm:justify-between gap-7 max-lg:gap-5 p-4">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl block max-sm:w-1/2">
                                <div class="product-img w-full rounded-2xl overflow-hidden">
                                    <img class="w-full duration-700" src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 200px;">
                                </div>
                            </div>
                            <div class="flex sm:items-center gap-7 max-lg:gap-4 max-lg:flex-wrap lg:w-2/3 lg:flex-shrink-0 max-lg:w-full max-sm:flex-col max-sm:w-1/2">
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
                                <div class="action w-fit flex flex-col items-center justify-center">
                                    <div class="quick-shop-btn button-main whitespace-nowrap py-2 px-9 max-lg:px-5 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white">
                                        Add to Quota List
                                    </div>
                                </div>
                            </div>
                        </a>
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
@endsection
