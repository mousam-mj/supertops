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
            <!-- Sidebar Filters -->
            <div class="sidebar lg:w-1/4 md:w-1/3 w-full md:pr-12">
                <!-- Products Type Filter -->
                <div class="filter-type-block pb-8 border-b border-line">
                    <div class="heading6">Products Type</div>
                    <div class="list-type filter-type menu-tab mt-4">
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">T-Shirt</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Dress</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Top</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Swimwear</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Shirt</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Underwear</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Sets</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                        <div class="item tab-item flex items-center justify-between cursor-pointer">
                            <div class="type-name text-secondary has-line-before hover:text-black capitalize">Accessories</div>
                            <div class="text-secondary2 number">6</div>
                        </div>
                    </div>
                </div>

                <!-- Size Filter -->
                <div class="filter-size pb-8 border-b border-line mt-8">
                    <div class="heading6">Size</div>
                    <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                        <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line">XS</div>
                        <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line">S</div>
                        <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line">M</div>
                        <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line">L</div>
                        <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line">XL</div>
                        <div class="size-item text-button w-[44px] h-[44px] flex items-center justify-center rounded-full border border-line">2XL</div>
                        <div class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line">Freesize</div>
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="filter-price pb-8 border-b border-line mt-8">
                    <div class="heading6">Price Range</div>
                    <div class="tow-bar-block mt-5">
                        <div class="progress"></div>
                    </div>
                    <div class="range-input">
                        <input class="range-min" type="range" min="0" max="300" value="0">
                        <input class="range-max" type="range" min="0" max="300" value="300">
                    </div>
                    <div class="price-block flex items-center justify-between flex-wrap mt-4">
                        <div class="min flex items-center gap-1">
                            <div>Min price:</div>
                            <div class="min-price">$0</div>
                        </div>
                        <div class="min flex items-center gap-1">
                            <div>Max price:</div>
                            <div class="max-price">$300</div>
                        </div>
                    </div>
                </div>

                <!-- Colors Filter -->
                <div class="filter-color pb-8 border-b border-line mt-8">
                    <div class="heading6">colors</div>
                    <div class="list-color flex items-center flex-wrap gap-3 gap-y-4 mt-4">
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-[#F4C5BF] w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">pink</div>
                        </div>
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-red w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">red</div>
                        </div>
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-green w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">green</div>
                        </div>
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-yellow w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">yellow</div>
                        </div>
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-purple w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">purple</div>
                        </div>
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-black w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">black</div>
                        </div>
                        <div class="color-item px-3 py-[5px] flex items-center justify-center gap-2 rounded-full border border-line">
                            <div class="color bg-[#F6EFDD] w-5 h-5 rounded-full"></div>
                            <div class="caption1 capitalize">white</div>
                        </div>
                    </div>
                </div>

                <!-- Brands Filter -->
                <div class="filter-brand pb-8 mt-8">
                    <div class="heading6">Brands</div>
                    <div class="list-brand mt-4">
                        <div class="brand-item flex items-center justify-between">
                            <div class="left flex items-center cursor-pointer">
                                <div class="block-input">
                                    <input type="checkbox" name="adidas" id="adidas">
                                    <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                </div>
                                <label for="adidas" class="brand-name capitalize pl-2 cursor-pointer">adidas</label>
                            </div>
                            <div class="text-secondary2 number">12</div>
                        </div>
                        <div class="brand-item flex items-center justify-between">
                            <div class="left flex items-center cursor-pointer">
                                <div class="block-input">
                                    <input type="checkbox" name="hermes" id="hermes">
                                    <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                </div>
                                <label for="hermes" class="brand-name capitalize pl-2 cursor-pointer">hermes</label>
                            </div>
                            <div class="text-secondary2 number">12</div>
                        </div>
                        <div class="brand-item flex items-center justify-between">
                            <div class="left flex items-center cursor-pointer">
                                <div class="block-input">
                                    <input type="checkbox" name="zara" id="zara">
                                    <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                </div>
                                <label for="zara" class="brand-name capitalize pl-2 cursor-pointer">zara</label>
                            </div>
                            <div class="text-secondary2 number">12</div>
                        </div>
                        <div class="brand-item flex items-center justify-between">
                            <div class="left flex items-center cursor-pointer">
                                <div class="block-input">
                                    <input type="checkbox" name="nike" id="nike">
                                    <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                </div>
                                <label for="nike" class="brand-name capitalize pl-2 cursor-pointer">nike</label>
                            </div>
                            <div class="text-secondary2 number">12</div>
                        </div>
                        <div class="brand-item flex items-center justify-between">
                            <div class="left flex items-center cursor-pointer">
                                <div class="block-input">
                                    <input type="checkbox" name="gucci" id="gucci">
                                    <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                </div>
                                <label for="gucci" class="brand-name capitalize pl-2 cursor-pointer">gucci</label>
                            </div>
                            <div class="text-secondary2 number">12</div>
                        </div>
                    </div>
                </div>
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
                    <div class="sort-product right flex items-center gap-3">
                        <label for="select-filter" class="caption1 capitalize">Sort by</label>
                        <div class="select-block relative">
                            <select id="select-filter" name="select-filter" class="caption1 py-2 pl-3 md:pr-20 pr-10 rounded-lg border border-line">
                                <option value="Sorting">Sorting</option>
                                <option value="soldQuantityHighToLow">Best Selling</option>
                                <option value="discountHighToLow">Best Discount</option>
                                <option value="priceHighToLow">Price High To Low</option>
                                <option value="priceLowToHigh">Price Low To High</option>
                            </select>
                            <i class="ph ph-caret-down absolute top-1/2 -translate-y-1/2 md:right-4 right-2"></i>
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
                                <div class="action w-fit flex flex-col items-center justify-center pointer-events-none">
                                    <span class="quick-shop-btn button-main whitespace-nowrap py-2 px-9 max-lg:px-5 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white">
                                        Add to Quota List
                                    </span>
                                </div>
                            </div>
                        </a>
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
