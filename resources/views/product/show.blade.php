@extends('layouts.app')

@section('title', $product->name . ' - Perch Bottle')

@section('content')
<div class="product-detail-page pb-20">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="breadcrumb-block mb-6 md:mb-8">
            <nav class="flex items-center gap-2 caption1">
                <a href="{{ route('home') }}" class="text-secondary hover:text-black duration-300">Home</a>
                <span class="text-secondary">/</span>
                <a href="{{ route('shop') }}" class="text-secondary hover:text-black duration-300">Shop</a>
                @if($product->category)
                    <span class="text-secondary">/</span>
                    <a href="{{ route('category', $product->category->slug) }}" class="text-secondary hover:text-black duration-300">{{ $product->category->name }}</a>
                @endif
                <span class="text-secondary">/</span>
                <span class="text-black font-semibold">{{ $product->name }}</span>
            </nav>
        </div>

        <!-- Product Detail -->
        <div class="grid lg:grid-cols-2 gap-8 md:gap-12 mb-12">
            <!-- Product Images -->
            <div class="product-images">
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
                    if (!$product->image && $product->images && is_array($product->images) && count($product->images) > 0) {
                        $mainImage = $getImageUrl($product->images[0]);
                    }
                @endphp
                
                <div class="main-image mb-4 rounded-2xl overflow-hidden bg-surface">
                    <img src="{{ $mainImage }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover aspect-square" 
                         id="main-product-image" />
                </div>

                <!-- Thumbnail Images -->
                @if($product->images && is_array($product->images) && count($product->images) > 1)
                    <div class="thumbnail-images grid grid-cols-4 gap-3">
                        @if($product->image)
                            @php $thumbImage = $getImageUrl($product->image); @endphp
                            <div class="thumbnail-item cursor-pointer rounded-lg overflow-hidden border-2 border-black" data-image="{{ $thumbImage }}">
                                <img src="{{ $thumbImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover aspect-square" />
                            </div>
                        @endif
                        @foreach($product->images as $index => $image)
                            @php $thumbImage = $getImageUrl($image); @endphp
                            <div class="thumbnail-item cursor-pointer rounded-lg overflow-hidden border-2 border-transparent hover:border-black duration-300" data-image="{{ $thumbImage }}">
                                <img src="{{ $thumbImage }}" alt="{{ $product->name }} - Image {{ $index + 1 }}" class="w-full h-full object-cover aspect-square" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info">
                @if($product->is_new_arrival)
                    <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full mb-4">New</div>
                @elseif($product->sale_price && $product->price > $product->sale_price)
                    <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full mb-4">Sale</div>
                @endif

                <h1 class="heading2 md:heading1 mb-4">{{ $product->name }}</h1>

                @if($product->category)
                    <p class="caption1 text-secondary mb-4">
                        Category: <a href="{{ route('category', $product->category->slug) }}" class="text-black hover:underline">{{ $product->category->name }}</a>
                    </p>
                @endif

                <div class="product-price-block flex items-center gap-3 mb-6">
                    <div class="product-price heading4">
                        ${{ number_format($product->sale_price ?? $product->price ?? 0, 2) }}
                    </div>
                    @if($product->sale_price && $product->price > $product->sale_price)
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

                @if($product->description)
                    <div class="product-description body1 text-secondary mb-6">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                @endif

                @if($product->short_description)
                    <div class="product-short-description body2 text-secondary mb-6">
                        {{ $product->short_description }}
                    </div>
                @endif

                <!-- Product Actions -->
                <div class="product-actions space-y-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="quantity-selector flex items-center border border-line rounded-full overflow-hidden">
                            <button type="button" class="quantity-btn px-4 py-2 hover:bg-black hover:text-white duration-300" id="decrease-qty">-</button>
                            <input type="number" id="product-quantity" value="1" min="1" max="{{ $product->stock_quantity ?? 999 }}" class="w-16 text-center border-0 outline-none" />
                            <button type="button" class="quantity-btn px-4 py-2 hover:bg-black hover:text-white duration-300" id="increase-qty">+</button>
                        </div>
                        <button type="button" class="button-main flex-1 add-to-cart-btn" data-product-id="{{ $product->id }}">
                            Add To Cart
                        </button>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="button" class="add-wishlist-btn flex items-center gap-2 px-6 py-3 border border-line rounded-full hover:border-black duration-300" data-product-id="{{ $product->id }}">
                            <i class="ph ph-heart text-lg"></i>
                            <span>Add To Wishlist</span>
                        </button>
                        <button type="button" class="compare-btn flex items-center gap-2 px-6 py-3 border border-line rounded-full hover:border-black duration-300" data-product-id="{{ $product->id }}">
                            <i class="ph ph-arrow-counter-clockwise text-lg"></i>
                            <span>Compare</span>
                        </button>
                    </div>
                </div>

                <!-- Product Meta -->
                <div class="product-meta space-y-3 pt-6 border-t border-line">
                    @if($product->sku)
                        <div class="flex items-center gap-2">
                            <span class="caption1 text-secondary2">SKU:</span>
                            <span class="caption1">{{ $product->sku }}</span>
                        </div>
                    @endif
                    @if(isset($product->stock_quantity))
                        <div class="flex items-center gap-2">
                            <span class="caption1 text-secondary2">Availability:</span>
                            @if($product->stock_quantity > 0)
                                <span class="caption1 text-green">In Stock ({{ $product->stock_quantity }} available)</span>
                            @else
                                <span class="caption1 text-red">Out of Stock</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        @if($product->description || $product->short_description)
            <div class="product-tabs mb-12">
                <div class="border-b border-line mb-6">
                    <nav class="flex items-center gap-8">
                        <button class="tab-button active px-4 py-3 border-b-2 border-black font-semibold" data-tab="description">Description</button>
                        <button class="tab-button px-4 py-3 border-b-2 border-transparent hover:border-black duration-300" data-tab="reviews">Reviews</button>
                    </nav>
                </div>

                <div class="tab-content">
                    <div id="description-tab" class="tab-panel active">
                        <div class="body1 text-secondary">
                            {!! $product->description ? nl2br(e($product->description)) : '<p>No description available.</p>' !!}
                        </div>
                    </div>
                    <div id="reviews-tab" class="tab-panel hidden">
                        <div class="body1 text-secondary">
                            <p>Reviews coming soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="related-products">
                <h2 class="heading3 mb-8 text-center">You May Also Like</h2>
                <div class="list-product grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Thumbnail image switching
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        const mainImage = document.getElementById('main-product-image');

        thumbnailItems.forEach(item => {
            item.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-image');
                if (mainImage && imageSrc) {
                    mainImage.src = imageSrc;
                    
                    // Update active thumbnail
                    thumbnailItems.forEach(thumb => {
                        thumb.classList.remove('border-black');
                        thumb.classList.add('border-transparent');
                    });
                    this.classList.remove('border-transparent');
                    this.classList.add('border-black');
                }
            });
        });

        // Quantity controls
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const quantityInput = document.getElementById('product-quantity');

        if (decreaseBtn && quantityInput) {
            decreaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        }

        if (increaseBtn && quantityInput) {
            increaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value) || 1;
                let maxValue = parseInt(quantityInput.getAttribute('max')) || 999;
                if (currentValue < maxValue) {
                    quantityInput.value = currentValue + 1;
                }
            });
        }

        // Tab switching
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanels = document.querySelectorAll('.tab-panel');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Update buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'border-black');
                    btn.classList.add('border-transparent');
                });
                this.classList.add('active', 'border-black');
                this.classList.remove('border-transparent');

                // Update panels
                tabPanels.forEach(panel => {
                    panel.classList.add('hidden');
                    panel.classList.remove('active');
                });
                const targetPanel = document.getElementById(targetTab + '-tab');
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    targetPanel.classList.add('active');
                }
            });
        });
    });
</script>
@endsection

