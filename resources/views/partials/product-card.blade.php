<a href="{{ route('product.show', $product->slug ?? '#') }}" class="product-item grid-type group" data-item="{{ $product->id ?? '1' }}">
    <div class="product-main cursor-pointer block">
        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
            @if(isset($product->is_new_arrival) && $product->is_new_arrival)
                <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
            @elseif(isset($product->sale_price) && $product->sale_price && isset($product->price) && $product->price > $product->sale_price)
                <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
            @endif
            
            <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative cursor-pointer" data-product-id="{{ $product->id ?? '' }}">
                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                    <i class="ph ph-heart text-lg"></i>
                </div>
                <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2 cursor-pointer" data-product-id="{{ $product->id ?? '' }}">
                    <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                    <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                    <i class="ph ph-check-circle text-lg checked-icon"></i>
                </div>
            </div>
            
            <div class="product-img w-full h-full aspect-[3/4] relative overflow-hidden">
                @php
                    // Helper function to get image URL (handles both storage and asset paths)
                    $getImageUrl = function($path) {
                        if (!$path) return asset('assets/images/product/perch-bottal.webp');
                        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
                            return asset($path);
                        }
                        return asset('storage/' . $path);
                    };
                    
                    $mainImage = $getImageUrl($product->image ?? null);
                    $hoverImage = null;
                    if (isset($product->images) && is_array($product->images) && count($product->images) > 0) {
                        $hoverImage = $getImageUrl($product->images[0]);
                    }
                @endphp
                
                <img class="w-full h-full object-cover duration-700 absolute inset-0" src="{{ $mainImage }}" alt="{{ $product->name ?? 'Product' }}" />
                @if($hoverImage && $hoverImage !== $mainImage)
                    <img class="w-full h-full object-cover duration-700 absolute inset-0 opacity-0 group-hover:opacity-100" src="{{ $hoverImage }}" alt="{{ $product->name ?? 'Product' }}" />
                @endif
            </div>
            
            <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white cursor-pointer" data-product-id="{{ $product->id ?? '' }}" data-product-slug="{{ $product->slug ?? '' }}">
                    <span class="max-lg:hidden">Quick View</span>
                    <i class="ph ph-eye lg:hidden text-xl"></i>
                </div>
                <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white cursor-pointer" data-product-id="{{ $product->id ?? '' }}">
                    <span class="max-lg:hidden">Add To Cart</span>
                    <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="product-infor mt-4 lg:mb-7">
            <div class="product-name text-title duration-300 hover:text-secondary">{{ $product->name ?? 'Product Name' }}</div>
            <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                <div class="product-price text-title">${{ number_format(($product->sale_price ?? $product->price ?? 0), 2) }}</div>
                @if(isset($product->sale_price) && $product->sale_price && isset($product->price) && $product->price > $product->sale_price)
                    <div class="product-origin-price caption1 text-secondary2">
                        <del>${{ number_format($product->price, 2) }}</del>
                    </div>
                    @php
                        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                    @endphp
                    @if($discount > 0)
                        <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-{{ $discount }}%</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</a>
