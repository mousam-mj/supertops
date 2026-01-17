@extends('layouts.app')

@section('title', 'Checkout - Perch Bottle')

@section('content')
<div class="checkout-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-block mb-6 md:mb-8">
            <nav class="flex items-center gap-2 caption1">
                <a href="{{ route('home') }}" class="text-secondary hover:text-black duration-300">Home</a>
                <span class="text-secondary">/</span>
                <a href="{{ route('cart.index') }}" class="text-secondary hover:text-black duration-300">Cart</a>
                <span class="text-secondary">/</span>
                <span class="text-black font-semibold">Checkout</span>
            </nav>
        </div>

        <h1 class="heading2 md:heading1 mb-8 md:mb-12">Checkout</h1>

        <!-- Login/Register Option for Guests -->
        @if(!auth()->check())
        <div class="checkout-section bg-white border border-line rounded-2xl p-6 mb-6">
            <h2 class="heading5 mb-4">Have an Account?</h2>
            <p class="body2 text-secondary mb-4">Login or create an account to save your address and track orders easily.</p>
            <div class="flex gap-4">
                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="button-main">
                    Login
                </a>
                <a href="{{ route('register') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="button-secondary">
                    Create Account
                </a>
            </div>
            <div class="mt-4 pt-4 border-t border-line">
                <p class="caption1 text-secondary">Or continue as guest</p>
            </div>
        </div>
        @endif

        <form id="checkout-form" action="{{ route('checkout.index') }}" method="POST">
            @csrf
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <!-- Shipping Address -->
                    <div class="checkout-section bg-white border border-line rounded-2xl p-6 mb-6">
                        <h2 class="heading5 mb-6">Shipping Address</h2>
                        
                        @if(auth()->check() && $addresses->count() > 0)
                            <div class="addresses-list mb-6 space-y-3">
                                @foreach($addresses as $address)
                                    <label class="address-option flex items-start gap-3 p-4 border border-line rounded-lg cursor-pointer hover:border-black duration-300">
                                        <input type="radio" 
                                               name="address_id" 
                                               value="{{ $address->id }}" 
                                               class="mt-1" 
                                               {{ $address->is_default ? 'checked' : '' }} />
                                        <div class="flex-1">
                                            <div class="body1 font-semibold">{{ $address->first_name }} {{ $address->last_name }}</div>
                                            <div class="caption1 text-secondary mt-1">{{ $address->full_address }}</div>
                                            <div class="caption1 text-secondary">{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}</div>
                                            <div class="caption1 text-secondary">Phone: {{ $address->phone }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <a href="#" class="text-button text-secondary hover:text-black duration-300">+ Add New Address</a>
                        @else
                            <div class="address-form space-y-4">
                                <input type="hidden" name="is_guest" value="{{ !auth()->check() ? '1' : '0' }}" />
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block caption1 text-secondary mb-2">First Name *</label>
                                        <input type="text" name="first_name" id="first_name" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                    </div>
                                    <div>
                                        <label class="block caption1 text-secondary mb-2">Last Name *</label>
                                        <input type="text" name="last_name" id="last_name" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                    </div>
                                </div>
                                <div>
                                    <label class="block caption1 text-secondary mb-2">Email *</label>
                                    <input type="email" name="email" id="email" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                </div>
                                <div>
                                    <label class="block caption1 text-secondary mb-2">Phone *</label>
                                    <input type="tel" name="phone" id="phone" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                </div>
                                <div>
                                    <label class="block caption1 text-secondary mb-2">Address *</label>
                                    <textarea name="address" id="address" rows="3" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required></textarea>
                                </div>
                                <div class="grid md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block caption1 text-secondary mb-2">City *</label>
                                        <input type="text" name="city" id="city" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                    </div>
                                    <div>
                                        <label class="block caption1 text-secondary mb-2">State *</label>
                                        <input type="text" name="state" id="state" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                    </div>
                                    <div>
                                        <label class="block caption1 text-secondary mb-2">Pincode *</label>
                                        <input type="text" name="pincode" id="pincode" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Coupon Code -->
                    <div class="checkout-section bg-white border border-line rounded-2xl p-6 mb-6">
                        <h2 class="heading5 mb-4">Have a Coupon Code?</h2>
                        <div class="flex gap-3">
                            <input type="text" name="coupon_code" id="coupon_code" placeholder="Enter coupon code" class="flex-1 px-4 py-3 border border-line rounded-lg focus:border-black outline-none" />
                            <button type="button" id="apply-coupon-btn" class="button-secondary whitespace-nowrap">Apply</button>
                        </div>
                        <div id="coupon-message" class="mt-2 caption1"></div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-section bg-white border border-line rounded-2xl p-6">
                        <h2 class="heading5 mb-6">Payment Method</h2>
                        
                        <div class="payment-methods space-y-3">
                            <label class="payment-option flex items-center gap-3 p-4 border border-line rounded-lg cursor-pointer hover:border-black duration-300">
                                <input type="radio" name="payment_method" value="razorpay" class="mr-2" checked />
                                <div class="flex-1">
                                    <div class="body1 font-semibold">Online Payment (Razorpay)</div>
                                    <div class="caption1 text-secondary">Pay securely using credit/debit card or UPI</div>
                                </div>
                            </label>
                            <label class="payment-option flex items-center gap-3 p-4 border border-line rounded-lg cursor-pointer hover:border-black duration-300">
                                <input type="radio" name="payment_method" value="cod" class="mr-2" />
                                <div class="flex-1">
                                    <div class="body1 font-semibold">Cash on Delivery (COD)</div>
                                    <div class="caption1 text-secondary">Pay when you receive your order</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="order-summary bg-white border border-line rounded-2xl p-6 sticky top-20">
                        <h2 class="heading5 mb-6">Order Summary</h2>
                        
                        <div class="order-items space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                <div class="order-item flex gap-3">
                                    <div class="product-image flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg" />
                                        @else
                                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg" />
                                        @endif
                                    </div>
                                    <div class="product-info flex-1">
                                        <div class="body2">{{ $item->product->name }}</div>
                                        <div class="caption1 text-secondary">Qty: {{ $item->quantity }}</div>
                                        <div class="text-title mt-1">${{ number_format($item->subtotal, 2) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="summary-details space-y-4 mb-6 pt-6 border-t border-line">
                            <div class="flex justify-between items-center">
                                <span class="body1 text-secondary">Subtotal</span>
                                <span class="text-title" id="summary-subtotal">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div id="coupon-discount-row" class="flex justify-between items-center hidden">
                                <span class="body1 text-secondary">Coupon Discount</span>
                                <span class="text-title text-green-600" id="summary-coupon-discount">-$0.00</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="body1 text-secondary">Shipping</span>
                                <span class="text-title" id="summary-shipping">
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
                                    <span class="heading4" id="summary-total">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="button-main w-full text-center block">
                            Place Order
                        </button>

                        <div class="text-center mt-4">
                            <a href="{{ route('cart.index') }}" class="caption1 text-secondary hover:text-black duration-300">
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('assets/js/checkout.js') }}"></script>
@endpush


