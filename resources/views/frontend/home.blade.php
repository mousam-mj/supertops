@extends('layouts.frontend')

@section('title', 'EDX Rulmenti Romania S.R.L. - Ball Bearings & Industrial Products')

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
            <!-- Sidebar: catalog data (categories, search, overview facets) -->
            <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12">
                @include('frontend.partials.catalog-sidebar', ['categories' => $categories ?? collect(), 'facets' => $facets ?? ['cages' => [], 'rows' => []]])
            </div>

            <!-- Product List -->
            <div class="list-product-block style-list lg:w-3/4 md:w-2/3 w-full md:pl-3">
                <div class="filter-heading flex items-center justify-between gap-5 flex-wrap">
                    <div class="left flex has-line items-center flex-wrap gap-5">
                        <div class="min flex items-center gap-1">
                            <div>Products:</div>
                            <div class="min-price">{{ $productTotal ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <div class="list-product flex flex-col gap-8 mt-7">
                    @forelse($products ?? [] as $product)
                    @php
                        $s = $product->specifications;
                        if (is_string($s)) {
                            $s = json_decode($s, true);
                        }
                        $s = is_array($s) ? $s : [];
                    @endphp
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
                                        <div class="product-price text-title bg-green px-3 py-0.5 inline-block rounded-full">{{ $product->category->name ?? 'Deep Groove Ball Bearing' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1 mt-3">
                                        <div>Bore diameter:</div>
                                        <div class="min-price">{{ $s['bore_diameter'] ?? '—' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Outside diameter:</div>
                                        <div class="min-price">{{ $s['outside_diameter'] ?? '—' }}</div>
                                    </div>
                                    <div class="min flex items-center gap-1">
                                        <div>Width:</div>
                                        <div class="min-price">{{ $s['width'] ?? '—' }}</div>
                                    </div>
                                </div>
                            </a>
                            <div class="action w-fit flex flex-col items-center justify-center flex-shrink-0">
                                <button type="button" class="button-main whitespace-nowrap py-2 px-9 max-lg:px-5 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white edx-add-quota-btn" data-product-id="{{ $product->id }}">
                                    Add to Quota List
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 text-secondary">
                        <p>No products in the database yet. Run <code class="text-black">php artisan db:seed</code> or visit the range page.</p>
                        <a href="{{ route('frontend.range') }}" class="inline-block mt-4 button-main py-2 px-8 rounded-full">Product range</a>
                    </div>
                    @endforelse
                </div>

                @if(($products ?? collect())->count() > 0 && ($productTotal ?? 0) > ($products ?? collect())->count())
                <div class="mt-10 text-center">
                    <a href="{{ route('frontend.range') }}" class="button-main inline-block py-3 px-10 rounded-full">View full range</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
