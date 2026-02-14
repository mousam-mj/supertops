@extends('layouts.app')

@section('title', 'Checkout - Perch Bottle')

@section('content')
<style>
    /* Checkout - compact breadcrumb, reduce gap */
    .checkout-page-content .checkout-breadcrumb { min-height: unset !important; }
    .checkout-page-content .checkout-breadcrumb .breadcrumb-main { min-height: unset !important; }
    
    /* Checkout Page Dark Theme - Ensure All Text is Visible */
    .checkout-page-content *,
    .checkout-block *,
    .checkout-page-content .heading2,
    .checkout-page-content .heading5,
    .checkout-page-content .text-title,
    .checkout-page-content .text-button,
    .checkout-page-content .text-on-surface,
    .checkout-page-content .text-on-surface-variant1,
    .checkout-page-content label,
    .checkout-page-content .caption1,
    .checkout-page-content .login *,
    .checkout-page-content .information *,
    .checkout-page-content .form-checkout *,
    .checkout-page-content .payment-block *,
    .checkout-page-content .list-payment *,
    .checkout-page-content .type *,
    .checkout-page-content .infor *,
    .checkout-page-content .checkout-block *,
    .checkout-page-content .list-product-checkout *,
    .checkout-page-content .discount-block *,
    .checkout-page-content .ship-block *,
    .checkout-page-content .total-cart-block * {
        color: white !important;
    }
    
    /* Remove white backgrounds - Use dark theme */
    .checkout-page-content .bg-white,
    .checkout-page-content .bg-surface,
    .checkout-page-content .login,
    .checkout-page-content .form-login-block,
    .checkout-page-content .form-checkout form,
    .checkout-page-content .bg-linear,
    .checkout-page-content .breadcrumb-main,
    .checkout-page-content .breadcrumb-block,
    .checkout-page-content .text-content {
        background: transparent !important;
    }
    
    /* Order summary card - Dark glass effect */
    .checkout-page-content .right .checkout-block {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(15px) !important;
        -webkit-backdrop-filter: blur(15px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 15px !important;
        padding: 20px !important;
    }
    
    /* Product items in order summary */
    .checkout-page-content .list-product-checkout .item,
    .checkout-page-content .list-product-checkout .product-item {
        background: transparent !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    /* Payment options background */
    .checkout-page-content .type {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    /* Login box */
    .checkout-page-content .login {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
    }
    
    /* Form inputs - Dark theme */
    .checkout-page-content input,
    .checkout-page-content select,
    .checkout-page-content textarea {
        background: rgba(255, 255, 255, 0.05) !important;
        color: white !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    
    .checkout-page-content input:focus,
    .checkout-page-content select:focus,
    .checkout-page-content textarea:focus {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(0, 255, 238, 0.5) !important;
        outline: none !important;
    }
    
    .checkout-page-content input::placeholder,
    .checkout-page-content textarea::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }
    
    /* Select dropdown options */
    .checkout-page-content select option {
        background: rgba(15, 15, 15, 0.98) !important;
        color: white !important;
    }
    
    /* Radio buttons and checkboxes */
    .checkout-page-content input[type="radio"],
    .checkout-page-content input[type="checkbox"] {
        accent-color: #00ffee !important;
    }
    
    /* Order summary section */
    .checkout-page-content .checkout-block {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-color: rgba(255, 255, 255, 0.1) !important;
        padding: 20px;
        border-radius: 15px;
    }
    
    /* Place Order button */
    .checkout-page-content .button-main {
        background: linear-gradient(45deg, #ff00cc, #3333ff) !important;
        color: white !important;
        border: none !important;
    }
    
    /* Mobile menu bar */
    .checkout-page-content .menu_bar {
        background: rgba(15, 15, 15, 0.95) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    
    .checkout-page-content .menu_bar * {
        color: white !important;
    }
    
    /* Remove any white backgrounds */
    .checkout-page-content .bg-white {
        background: rgba(255, 255, 255, 0.05) !important;
    }
    
    /* Form borders */
    .checkout-page-content .border,
    .checkout-page-content .border-line {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
</style>
<div class="page-content checkout-page-content">
    <!-- Menu bar (mobile) -->
    <div class="menu_bar fixed bottom-0 left-0 w-full h-[70px] sm:hidden z-[101]" style="background: rgba(15, 15, 15, 0.95) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);">
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
    <div class="breadcrumb-block checkout-breadcrumb" style="background: transparent !important;">
        <div class="breadcrumb-main bg-linear overflow-hidden" style="background: transparent !important;">
            <div class="container py-4 relative">
                <div class="main-content w-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content" style="background: transparent !important;">
                        <div class="heading2 text-center" style="color: white !important;">Checkout</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-1">
                            <a href="{{ route('home') }}" style="color: white !important;">Homepage</a>
                            <i class="ph ph-caret-right text-sm" style="color: rgba(255, 255, 255, 0.6) !important;"></i>
                            <span class="capitalize" style="color: rgba(255, 255, 255, 0.6) !important;">Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-block md:py-6 py-4">
            <div class="container">
                <div class="content-main flex max-lg:flex-col-reverse gap-y-10 justify-between">
                    <div class="left lg:w-1/2">
                        <div class="login py-3 px-4 flex justify-between rounded-lg" style="background: rgba(255, 255, 255, 0.05) !important; backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);">
                            <div class="left flex items-center"><span class="text-on-surface-variant1 pr-4">Already have an account? </span><a href="{{ route('login') }}?redirect={{ urlencode(route('checkout.index')) }}" class="text-button text-on-surface hover:underline cursor-pointer">Login</a></div>
                            <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout.index')) }}" class="right flex items-center"><i class="ph ph-caret-right fs-20 cursor-pointer"></i></a>
                        </div>
                        <div class="form-login-block mt-3">
                            <form class="p-5 border rounded-lg" style="background: rgba(255, 255, 255, 0.05) !important; backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border-color: rgba(255, 255, 255, 0.1) !important;">
                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div class="email">
                                        <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="username" type="email" placeholder="Username or email" required />
                                    </div>
                                    <div class="pass">
                                        <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="password" type="password" placeholder="Password" required />
                                    </div>
                                </div>
                                <div class="block-button mt-3">
                                    <button class="button-main button-blue-hover">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="information mt-5">
                            <div class="heading5">Information</div>
                            @if(auth()->check() && $addresses && $addresses->count() > 0)
                                <div class="mt-4 mb-4">
                                    <label class="caption1 capitalize mb-2 block">Select Saved Address:</label>
                                    <div class="select-block">
                                        <select class="border border-line px-4 py-3 w-full rounded-lg" id="savedAddressSelect" onchange="fillAddressFromSaved(this.value)">
                                            <option value="">Use New Address</option>
                                            @foreach($addresses as $address)
                                                <option value="{{ $address->id }}" data-address='@json($address)' {{ $address->is_default ? 'selected' : '' }}>
                                                    {{ $address->label ?? 'Address' }} - {{ $address->address_line_1 }}, {{ $address->city }}
                                                    @if($address->is_default) (Default) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="ph ph-caret-down arrow-down"></i>
                                    </div>
                                    <input type="hidden" id="selectedAddressId" name="shipping_address_id" value="{{ $defaultAddress->id ?? '' }}">
                                </div>
                            @endif
                            <div class="form-checkout mt-5">
                                <form onsubmit="return false;" id="checkout-form-element">
                                    <div class="grid sm:grid-cols-2 gap-4 gap-y-5 flex-wrap">
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="firstName" type="text" placeholder="First Name *" value="{{ $userFirstName ?? ($defaultAddress ? explode(' ', $defaultAddress->full_name)[0] : '') }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="lastName" type="text" placeholder="Last Name *" value="{{ $userLastName ?? ($defaultAddress ? (explode(' ', $defaultAddress->full_name)[1] ?? '') : '') }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="email" type="email" placeholder="Email Address *" value="{{ $user->email ?? '' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="phoneNumber" type="tel" placeholder="Phone Numbers *" value="{{ $user->phone ?? ($defaultAddress->phone ?? '') }}" required />
                                        </div>
                                        <div class="col-span-full select-block">
                                            <select class="border border-line px-4 py-3 w-full rounded-lg" id="region" name="region">
                                                <option value="default">Choose Country/Region</option>
                                                <option value="India" {{ ($defaultAddress && $defaultAddress->state == 'India') ? 'selected' : '' }}>India</option>
                                                <option value="France" {{ ($defaultAddress && $defaultAddress->state == 'France') ? 'selected' : '' }}>France</option>
                                                <option value="Singapore" {{ ($defaultAddress && $defaultAddress->state == 'Singapore') ? 'selected' : '' }}>Singapore</option>
                                            </select>
                                            <i class="ph ph-caret-down arrow-down"></i>
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="city" type="text" placeholder="Town/City *" value="{{ $defaultAddress->city ?? '' }}" required />
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="apartment" type="text" placeholder="Street,..." value="{{ $defaultAddress->address_line_1 ?? '' }}" required />
                                        </div>
                                        <div class="select-block">
                                            <select class="border border-line px-4 py-3 w-full rounded-lg" id="country" name="country">
                                                <option value="default">Choose State</option>
                                                <option value="India" {{ ($defaultAddress && $defaultAddress->state == 'India') ? 'selected' : '' }}>India</option>
                                                <option value="France" {{ ($defaultAddress && $defaultAddress->state == 'France') ? 'selected' : '' }}>France</option>
                                                <option value="Singapore" {{ ($defaultAddress && $defaultAddress->state == 'Singapore') ? 'selected' : '' }}>Singapore</option>
                                            </select>
                                            <i class="ph ph-caret-down arrow-down"></i>
                                        </div>
                                        <div class="">
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="postal" type="text" placeholder="Postal Code *" value="{{ $defaultAddress->pincode ?? '' }}" required />
                                        </div>
                                        <div class="col-span-full">
                                            <textarea class="border border-line px-4 py-3 w-full rounded-lg" id="note" name="note" placeholder="Write note..."></textarea>
                                        </div>
                                    </div>
                                    <div class="payment-block md:mt-10 mt-6">
                                        <div class="heading5" style="color: white !important;">Payment Method</div>
                                        <div class="list-payment mt-5">
                                            <div class="type p-5 border rounded-lg" style="background: rgba(255, 255, 255, 0.05) !important; backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border-color: rgba(255, 255, 255, 0.1) !important;">
                                                <input class="cursor-pointer" type="radio" id="delivery" name="payment" value="cod" checked />
                                                <label class="text-button pl-2 cursor-pointer" for="delivery" style="color: white !important;">💵 Cash On Delivery</label>
                                                <div class="infor">
                                                    <div class="text-on-surface-variant1 pt-4" style="color: rgba(255, 255, 255, 0.8) !important;">Pay cash when your order is delivered. No online payment required. Our delivery partner will collect the payment at your doorstep.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-button md:mt-10 mt-6">
                                        <button type="button" class="button-main w-full py-3 px-5 bg-black text-white hover:bg-gray-800 rounded-lg transition-colors duration-300 uppercase tracking-wider cursor-pointer" id="place-order-btn" style="display: block !important; visibility: visible !important;" onclick="console.log('Button clicked via inline'); if(typeof window.handleOrderSubmission === 'function'){window.handleOrderSubmission(event);}else{console.error('handleOrderSubmission not available');} return false;">Place Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="right lg:w-5/12">
                        <div class="checkout-block" style="background: rgba(255, 255, 255, 0.05) !important; backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1) !important; border-radius: 15px; padding: 20px;">
                            <div class="heading5 pb-3" style="color: white !important;">Your Order</div>
                            <div class="list-product-checkout"></div>
                            <div class="discount-block py-5 flex justify-between border-b" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                                <div class="text-title" style="color: white !important;">Discounts</div>
                                <div class="text-title" style="color: white !important;">-₹<span class="discount">0</span><span>.00</span></div>
                            </div>
                            <div class="ship-block py-5 flex justify-between border-b" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                                <div class="text-title" style="color: white !important;">Shipping</div>
                                <div class="text-title" style="color: white !important;">Free</div>
                            </div>
                            <div class="total-cart-block pt-5 flex justify-between">
                                <div class="heading5" style="color: white !important;">Total</div>
                                <div class="heading5 total-cart" style="color: white !important;">₹0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Define functions IMMEDIATELY - NO IIFE, execute directly
// Function to validate form
function validateForm() {
        const errors = [];
        
        const firstName = document.getElementById('firstName')?.value.trim();
        const lastName = document.getElementById('lastName')?.value.trim();
        const email = document.getElementById('email')?.value.trim();
        const phone = document.getElementById('phoneNumber')?.value.trim();
        const city = document.getElementById('city')?.value.trim();
        const address = document.getElementById('apartment')?.value.trim();
        const state = document.getElementById('country')?.value;
        const pincode = document.getElementById('postal')?.value.trim();
        
        if (!firstName) errors.push('First Name is required');
        if (!lastName) errors.push('Last Name is required');
        if (!email) {
            errors.push('Email is required');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.push('Please enter a valid email address');
        }
        if (!phone) errors.push('Phone Number is required');
        if (!city) errors.push('City is required');
        if (!address) errors.push('Address is required');
        if (!state || state === 'default') errors.push('Please select a State');
        if (!pincode) errors.push('Postal Code is required');
        
        return errors;
    }
    
    // Function to show error popup
    function showErrorPopup(errors) {
        const errorMessage = errors.join('\n');
        alert('Please fix the following errors:\n\n' + errorMessage);
    }
    
    // Function to handle order submission
    function handleOrderSubmission(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    }
    
    console.log('handleOrderSubmission called');
    
    const submitBtn = document.getElementById('place-order-btn');
    if (!submitBtn) {
        console.error('Place Order button not found');
        alert('Place Order button not found. Please refresh the page.');
        return false;
    }
    
    // Validate form
    const validationErrors = validateForm();
    if (validationErrors.length > 0) {
        showErrorPopup(validationErrors);
        return false;
    }
    
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Placing Order...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = {
        first_name: document.getElementById('firstName').value.trim(),
        last_name: document.getElementById('lastName').value.trim(),
        email: document.getElementById('email').value.trim(),
        phone: document.getElementById('phoneNumber').value.trim(),
        region: document.getElementById('region').value,
        city: document.getElementById('city').value.trim(),
        address: document.getElementById('apartment').value.trim(),
        state: document.getElementById('country').value,
        pincode: document.getElementById('postal').value.trim(),
        notes: document.getElementById('note')?.value.trim() || '',
        payment_method: document.querySelector('input[name="payment"]:checked')?.value || 'cod'
    };
    
    // Get shipping cost
    const shippingRadio = document.querySelector('input[name="ship"]:checked');
    let shipping = 0;
    if (shippingRadio) {
        if (shippingRadio.value) {
            shipping = parseFloat(shippingRadio.value.replace(/[{}]/g, '')) || 0;
        } else if (shippingRadio.id === 'local') {
            shipping = 30;
        } else if (shippingRadio.id === 'flat') {
            shipping = 40;
        }
    }
    
    // Get discount
    const discountElement = document.querySelector('.discount');
    const discount = discountElement ? parseFloat(discountElement.textContent) || 0 : 0;
    
    // Check if user is logged in
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    
    // Get selected address ID if available
    const selectedAddressId = document.getElementById('selectedAddressId')?.value;
    
    // Prepare order data based on login status
    let orderData;
    if (isLoggedIn) {
        // For logged in users, use address_id if selected, otherwise send shipping_address
        if (selectedAddressId) {
            orderData = {
                shipping_address_id: selectedAddressId,
                payment_method: formData.payment_method,
                notes: formData.notes,
                shipping_charge: shipping
            };
        } else {
            orderData = {
                shipping_address: {
                    first_name: formData.first_name,
                    last_name: formData.last_name,
                    email: formData.email,
                    phone: formData.phone,
                    address_line_1: formData.address,
                    city: formData.city,
                    state: formData.state,
                    pincode: formData.pincode
                },
                payment_method: formData.payment_method,
                notes: formData.notes,
                shipping_charge: shipping
            };
        }
    } else {
        // For guests, send guest_info - ensure all fields are present
        orderData = {
            guest_info: {
                first_name: formData.first_name || '',
                last_name: formData.last_name || '',
                email: formData.email || '',
                phone: formData.phone || '',
                address: formData.address || '',
                city: formData.city || '',
                state: formData.state || '',
                pincode: formData.pincode || ''
            },
            payment_method: formData.payment_method || 'cod',
            notes: formData.notes || '',
            shipping_charge: shipping || 0
        };
        
        console.log('Guest order data:', orderData);
    }
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Log the data being sent
    console.log('Order data being sent:', orderData);
    console.log('Form data collected:', formData);
    
    // Submit order (web route uses session auth so logged-in user is recognized)
    fetch('/place-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify(orderData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => {
                console.error('API Error:', err);
                // Show validation errors in a better format
                let errorMessage = err.message || 'Failed to place order';
                if (err.errors) {
                    const errorList = Object.values(err.errors).flat().join('\n');
                    errorMessage = errorMessage + '\n\n' + errorList;
                }
                throw new Error(errorMessage);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Order response:', data);
        
        if (data.success && data.data && data.data.id) {
            // Redirect to order success page
            console.log('Redirecting to order success page:', `/order-success/${data.data.id}`);
            window.location.href = `/order-success/${data.data.id}`;
        } else {
            throw new Error(data.message || 'Failed to place order. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error placing order:', error);
        alert(error.message || 'An error occurred. Please try again.');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Make functions globally available IMMEDIATELY
window.handleOrderSubmission = handleOrderSubmission;
window.validateForm = validateForm;
window.showErrorPopup = showErrorPopup;

console.log('Functions defined and made global:', {
    handleOrderSubmission: typeof window.handleOrderSubmission,
    validateForm: typeof window.validateForm,
    showErrorPopup: typeof window.showErrorPopup
});

// Test if button exists immediately
console.log('Testing button existence...');
const testBtn = document.getElementById('place-order-btn');
console.log('Button found:', testBtn);
if (testBtn) {
    console.log('Button exists, setting up immediate handler');
    testBtn.onclick = function(e) {
        console.log('Button clicked via immediate handler!');
        e.preventDefault();
        e.stopPropagation();
        if (window.handleOrderSubmission) {
            window.handleOrderSubmission(e);
        } else {
            console.error('handleOrderSubmission not available');
        }
        return false;
    };
}

// IIFE for initialization
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    function initCheckout() {
        console.log('Initializing checkout form...');
        
        // Ensure Place Order button is visible
        const placeOrderBtn = document.getElementById('place-order-btn');
        if (placeOrderBtn) {
            placeOrderBtn.style.display = 'block';
            placeOrderBtn.style.visibility = 'visible';
            placeOrderBtn.style.opacity = '1';
            console.log('Place Order button found');
        } else {
            console.error('Place Order button not found!');
        }
        
        // Handle checkout form submission
        const checkoutForm = document.querySelector('.form-checkout form');
        const submitBtn = document.getElementById('place-order-btn');
        
        console.log('Checkout form:', checkoutForm);
        console.log('Submit button:', submitBtn);
        
        // Handle button click - use direct onclick to ensure it works
        if (submitBtn) {
            console.log('Setting up button click handler for:', submitBtn);
            console.log('handleOrderSubmission available:', typeof window.handleOrderSubmission);
            
            // Remove any existing onclick
            submitBtn.onclick = null;
            
            // Set up new click handler using direct onclick
            submitBtn.onclick = function(e) {
                console.log('Button clicked! Event:', e);
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }
                
                if (window.handleOrderSubmission) {
                    console.log('Calling handleOrderSubmission');
                    window.handleOrderSubmission(e);
                } else {
                    console.error('handleOrderSubmission not available');
                    alert('Please wait for page to load completely');
                }
                return false;
            };
            
            // Also add event listener as backup
            submitBtn.addEventListener('click', function(e) {
                console.log('Button clicked via addEventListener!');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                if (window.handleOrderSubmission) {
                    window.handleOrderSubmission(e);
                }
                return false;
            }, true);
            
            console.log('Button click handler set up successfully');
        } else {
            console.error('Place Order button not found in initCheckout!');
        }
        
        // Handle form submit
        if (checkoutForm && window.handleOrderSubmission) {
            console.log('Setting up form submit handler');
            checkoutForm.addEventListener('submit', function(e) {
                console.log('Form submit triggered!');
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                window.handleOrderSubmission(e);
                return false;
            }, true);
        }
    }
    
    // Initialize immediately and multiple times to ensure it works
    console.log('Initializing checkout handlers...');
    console.log('Document ready state:', document.readyState);
    console.log('handleOrderSubmission available:', typeof window.handleOrderSubmission);
    
    // Try immediately
    initCheckout();
    
    // Also try when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded fired');
            initCheckout();
        });
    }
    
    // Try after short delays
    // Function to fill address form from saved address
    window.fillAddressFromSaved = function(addressId) {
        const selectElement = document.getElementById('savedAddressSelect');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
        if (!addressId || !selectedOption || !selectedOption.dataset.address) {
            // Clear address ID if "Use New Address" is selected
            document.getElementById('selectedAddressId').value = '';
            return;
        }
        
        try {
            const address = JSON.parse(selectedOption.dataset.address);
            
            // Set the address ID
            document.getElementById('selectedAddressId').value = addressId;
            
            // Split full name into first and last name
            const nameParts = (address.full_name || '').split(' ', 2);
            const firstName = nameParts[0] || '';
            const lastName = nameParts[1] || '';
            
            // Fill form fields
            if (document.getElementById('firstName')) {
                document.getElementById('firstName').value = firstName;
            }
            if (document.getElementById('lastName')) {
                document.getElementById('lastName').value = lastName;
            }
            if (document.getElementById('phoneNumber')) {
                document.getElementById('phoneNumber').value = address.phone || '';
            }
            if (document.getElementById('city')) {
                document.getElementById('city').value = address.city || '';
            }
            if (document.getElementById('apartment')) {
                document.getElementById('apartment').value = address.address_line_1 || '';
            }
            if (document.getElementById('postal')) {
                document.getElementById('postal').value = address.pincode || '';
            }
            
            // Set state/country dropdowns
            const stateValue = address.state || '';
            const countrySelect = document.getElementById('country');
            const regionSelect = document.getElementById('region');
            
            if (countrySelect && stateValue) {
                for (let option of countrySelect.options) {
                    if (option.value === stateValue || option.text.includes(stateValue)) {
                        countrySelect.value = option.value;
                        break;
                    }
                }
            }
            
            if (regionSelect && stateValue) {
                for (let option of regionSelect.options) {
                    if (option.value === stateValue || option.text.includes(stateValue)) {
                        regionSelect.value = option.value;
                        break;
                    }
                }
            }
        } catch (error) {
            console.error('Error parsing address data:', error);
        }
    };
    
    // On load: fill form from pre-selected saved address (ensures phone is fetched)
    function tryFillSavedAddressOnLoad() {
        var sel = document.getElementById('savedAddressSelect');
        if (sel && sel.value && window.fillAddressFromSaved) {
            window.fillAddressFromSaved(sel.value);
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', tryFillSavedAddressOnLoad);
    } else {
        tryFillSavedAddressOnLoad();
    }
    setTimeout(tryFillSavedAddressOnLoad, 150);
    
    setTimeout(function() {
        console.log('Timeout 100ms - initializing');
        initCheckout();
    }, 100);
    
    setTimeout(function() {
        console.log('Timeout 500ms - initializing');
        initCheckout();
    }, 500);
    
    setTimeout(function() {
        console.log('Timeout 1000ms - initializing');
        initCheckout();
    }, 1000);
    
    // Also try on window load
    window.addEventListener('load', function() {
        console.log('Window load fired');
        setTimeout(function() {
            initCheckout();
        }, 100);
    });
})();
</script>
@endsection
