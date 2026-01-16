@extends('layouts.app')

@section('title', 'Shopping Cart - Perch Bottle')

@section('content')
<div class="cart-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-block mb-6 md:mb-8">
            <nav class="flex items-center gap-2 caption1">
                <a href="{{ route('home') }}" class="text-secondary hover:text-black duration-300">Home</a>
                <span class="text-secondary">/</span>
                <span class="text-black font-semibold">Shopping Cart</span>
            </nav>
        </div>

        <h1 class="heading2 md:heading1 mb-8 md:mb-12">Shopping Cart</h1>

        @php
            // Debug: Check cart items
            $cartItemsCount = $cartItems->count();
        @endphp

        @if($cartItemsCount > 0)
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="cart-items space-y-4">
                        @foreach($cartItems as $item)
                            <div class="cart-item bg-white border border-line rounded-2xl p-4 md:p-6 flex flex-col md:flex-row gap-4 md:gap-6" data-cart-id="{{ $item->id }}">
                                <!-- Product Image -->
                                <div class="product-image flex-shrink-0">
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="block">
                                        @php
                                            // Helper function to get image URL (handles both storage and asset paths)
                                            $getImageUrl = function($path) {
                                                if (!$path) return asset('assets/images/product/perch-bottal.webp');
                                                if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
                                                    return asset($path);
                                                }
                                                return asset('storage/' . $path);
                                            };
                                            $productImage = $getImageUrl($item->product->image ?? null);
                                        @endphp
                                        <img src="{{ $productImage }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-lg" />
                                    </a>
                                </div>

                                <!-- Product Info -->
                                <div class="product-info flex-1">
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="block mb-2">
                                        <h3 class="text-title hover:text-secondary duration-300">{{ $item->product->name }}</h3>
                                    </a>
                                    
                                    @if($item->size || $item->color)
                                        <div class="caption1 text-secondary mb-2">
                                            @if($item->size)
                                                <span>Size: {{ $item->size }}</span>
                                            @endif
                                            @if($item->color)
                                                <span class="{{ $item->size ? 'ml-2' : '' }}">Color: {{ $item->color }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="product-price-block flex items-center gap-2 mb-4">
                                        <div class="product-price text-title">
                                            ${{ number_format($item->product->sale_price ?? $item->product->price ?? 0, 2) }}
                                        </div>
                                        @if($item->product->sale_price && $item->product->price > $item->product->sale_price)
                                            <div class="product-origin-price caption1 text-secondary2">
                                                <del>${{ number_format($item->product->price, 2) }}</del>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-4">
                                        <div class="quantity-selector flex items-center border border-line rounded-full overflow-hidden">
                                            <button type="button" 
                                                    class="quantity-btn px-3 py-1 hover:bg-black hover:text-white duration-300 decrease-qty" 
                                                    data-cart-id="{{ $item->id }}">-</button>
                                            <input type="number" 
                                                   class="quantity-input w-16 text-center border-0 outline-none" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1" 
                                                   data-cart-id="{{ $item->id }}" 
                                                   readonly />
                                            <button type="button" 
                                                    class="quantity-btn px-3 py-1 hover:bg-black hover:text-white duration-300 increase-qty" 
                                                    data-cart-id="{{ $item->id }}">+</button>
                                        </div>
                                        <button type="button" 
                                                class="remove-item-btn text-red caption1 hover:underline" 
                                                data-cart-id="{{ $item->id }}">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="item-subtotal text-right">
                                    <div class="text-title">${{ number_format($item->subtotal, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="button-main inline-block">Continue Shopping</a>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="cart-summary bg-white border border-line rounded-2xl p-6 sticky top-20">
                        <h2 class="heading5 mb-6">Order Summary</h2>
                        
                        <div class="summary-details space-y-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="body1 text-secondary">Subtotal</span>
                                <span class="text-title">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="body1 text-secondary">Shipping</span>
                                <span class="text-title">
                                    @if($shipping > 0)
                                        ${{ number_format($shipping, 2) }}
                                    @else
                                        Free
                                    @endif
                                </span>
                            </div>
                            <div class="border-t border-line pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="heading6">Total</span>
                                    <span class="heading4">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="button-main w-full text-center block mb-4">
                            Proceed to Checkout
                        </a>

                        <div class="text-center">
                            <a href="{{ route('shop') }}" class="caption1 text-secondary hover:text-black duration-300">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart text-center py-16 md:py-20">
                <div class="max-w-md mx-auto">
                    <i class="ph ph-shopping-cart text-6xl text-secondary mb-4"></i>
                    <h2 class="heading4 mb-4">Your cart is empty</h2>
                    <p class="body1 text-secondary mb-6">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('shop') }}" class="button-main inline-block">Start Shopping</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiBaseUrl = '/api/cart';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Update quantity
    function updateQuantity(cartId, quantity) {
        fetch(`${apiBaseUrl}/update/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Remove item
    function removeItem(cartId) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        fetch(`${apiBaseUrl}/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Quantity controls
    document.querySelectorAll('.increase-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const input = document.querySelector(`input[data-cart-id="${cartId}"]`);
            const currentQty = parseInt(input.value) || 1;
            updateQuantity(cartId, currentQty + 1);
        });
    });

    document.querySelectorAll('.decrease-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const input = document.querySelector(`input[data-cart-id="${cartId}"]`);
            const currentQty = parseInt(input.value) || 1;
            if (currentQty > 1) {
                updateQuantity(cartId, currentQty - 1);
            }
        });
    });

    // Remove item buttons
    document.querySelectorAll('.remove-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            removeItem(cartId);
        });
    });
});
</script>
@endsection

