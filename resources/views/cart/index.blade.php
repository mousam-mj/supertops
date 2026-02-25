@extends('layouts.app')

@section('title', 'Cart - Perch Bottle')

@section('content')
<style>
    /* Cart - compact breadcrumb, reduce gap */
    .cart-page-content .cart-breadcrumb { min-height: unset !important; }
    .cart-page-content .cart-breadcrumb .breadcrumb-main { min-height: unset !important; }
</style>
<div class="page-content cart-page-content">
    <!-- Menu bar (mobile) -->
    <div class="menu_bar fixed bg-white bottom-0 left-0 w-full h-[70px] sm:hidden z-[101]">
        <div class="menu_bar-inner grid grid-cols-4 items-center h-full">
            <a href="{{ route('home') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="ph-bold ph-house text-2xl block"></span>
                <span class="menu_bar-title caption2 font-semibold">Home</span>
            </a>
            <a href="{{ route('shop') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="ph-bold ph-list text-2xl block"></span>
                <span class="menu_bar-title caption2 font-semibold">Category</span>
            </a>
            <a href="{{ route('search') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="ph-bold ph-magnifying-glass text-2xl block"></span>
                <span class="menu_bar-title caption2 font-semibold">Search</span>
            </a>
            <a href="{{ route('cart.index') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <div class="cart-icon relative">
                    <span class="ph-bold ph-handbag text-2xl block"></span>
                    <span class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                </div>
                <span class="menu_bar-title caption2 font-semibold">Cart</span>
            </a>
        </div>
    </div>

    <!-- Compact breadcrumb - minimal gap -->
    <div class="breadcrumb-block cart-breadcrumb">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container py-4 relative">
                <div class="main-content w-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">Shopping Cart</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-1">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2 capitalize">Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-block md:py-6 py-4">
            <div class="container">
                <div class="content-main flex justify-between max-xl:flex-col gap-y-8">
                    <div class="xl:w-2/3 xl:pr-3 w-full">
                        <div class="time countdown-cart bg-green py-3 px-5 flex items-center rounded-lg">
                            <div class="heding5">🔥</div>
                            <div class="caption1 pl-2">
                                Your cart will expire in
                                <span class="min text-red text-button fw-700"><span class="minute">10</span> : <span class="second">00</span></span>
                                <span> minutes! Please checkout now before your items sell out!</span>
                            </div>
                        </div>
                        <div class="heading banner mt-5">
                            <div class="text">
                                Buy
                                <span class="text-button"> ₹<span class="more-price">250</span>.00 </span>
                                <span>more to get </span>
                                <span class="text-button">freeship</span>
                            </div>
                            <div class="tow-bar-block mt-4">
                                <div class="progress-line" style="width: 50%"></div>
                            </div>
                        </div>
                        <div class="list-product w-full sm:mt-7 mt-5">
                            <div class="w-full">
                                <div class="heading bg-surface bora-4 pt-4 pb-4">
                                    <div class="flex">
                                        <div class="w-2/5">
                                            <div class="text-button text-center">Products</div>
                                        </div>
                                        <div class="w-1/12">
                                            <div class="text-button text-center">Price</div>
                                        </div>
                                        <div class="w-1/6">
                                            <div class="text-button text-center">Quantity</div>
                                        </div>
                                        <div class="w-1/6">
                                            <div class="text-button text-center">Total Price</div>
                                        </div>
                                        <div class="w-1/12">
                                            <div class="text-button text-center">Action</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-product-main w-full mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-1/3 xl:pl-12 w-full">
                        <div class="checkout-block bg-surface p-6 rounded-2xl">
                            <div class="heading5">Order Summary</div>
                            <div class="total-block py-5 flex justify-between border-b border-line">
                                <div class="text-title">Subtotal</div>
                                <div class="text-title">₹<span class="total-product">136</span><span>.00</span></div>
                            </div>
                            <div class="ship-block py-5 flex justify-between border-b border-line">
                                <div class="text-title">Shipping</div>
                                <div class="choose-type flex gap-12">
                                    <div class="left">
                                        <div class="type">
                                            <input id="shipping" type="radio" name="ship" />
                                            <label class="pl-1" for="shipping">Free Shipping:</label>
                                        </div>
                                        <div class="type mt-1">
                                            <input id="local" type="radio" name="ship" value="{30}" />
                                            <label class="text-on-surface-variant1 pl-1" for="local">Local:</label>
                                        </div>
                                        <div class="type mt-1">
                                            <input id="flat" type="radio" name="ship" value="{40}" />
                                            <label class="text-on-surface-variant1 pl-1" for="flat">Flat Rate:</label>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="ship">₹0.00</div>
                                        <div class="local text-on-surface-variant1 mt-1">₹30.00</div>
                                        <div class="flat text-on-surface-variant1 mt-1">₹40.00</div>
                                    </div>
                                </div>
                            </div>
                            <div class="total-cart-block pt-4 pb-4 flex justify-between">
                                <div class="heading5">Total</div>
                                <div class=""><span class="heading5">₹</span><span class="total-cart heading5">116</span><span class="heading5">.00</span></div>
                            </div>
                            <div class="block-button flex flex-col items-center gap-y-4 mt-5">
                                <form action="{{ route('checkout.index') }}" method="GET" id="checkout-form" style="width: 100%; margin: 0;">
                                    <button type="submit" class="checkout-btn button-main w-full text-center py-3 px-5 bg-black text-white hover:bg-gray-800 rounded-lg transition-colors duration-300 uppercase tracking-wider cursor-pointer" id="checkout-link">Process To Checkout</button>
                                </form>
                                <a class="text-button hover-underline" href="{{ route('home') }}">Continue shopping </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

