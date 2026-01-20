<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'Perch Bottle')</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/perch-logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}" />
    <style>
        /* Header hover states */
        .user-icon .login-popup {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s, visibility 0.3s, transform 0.3s;
            right: 0;
        }
        .user-icon:hover .login-popup {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
    </head>

    
<body>
    @include('partials.header')
    
    {{-- Session Messages --}}
    @if(session('success'))
        <div class="bg-green-500 text-white py-3 px-4 text-center relative z-50" id="session-message">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">✓ {{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('session-message').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white py-3 px-4 text-center relative z-50" id="session-error">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">✕ {{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('session-error').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-500 text-black py-3 px-4 text-center relative z-50" id="session-warning">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">⚠️ {{ session('warning') }}</span>
                    @if(session('email_sent') === false)
                        <form method="POST" action="{{ route('email.resend') }}" class="inline-block ml-4">
                            @csrf
                            <button type="submit" class="bg-black text-white px-4 py-1 rounded hover:bg-gray-800 text-sm">
                                Resend Verification Email
                            </button>
                        </form>
                    @endif
                </div>
                <button onclick="document.getElementById('session-warning').style.display='none'" class="ml-4 text-black hover:text-gray-700 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-500 text-white py-3 px-4 text-center relative z-50" id="session-info">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">ℹ️ {{ session('info') }}</span>
                </div>
                <button onclick="document.getElementById('session-info').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif
    
    {{-- Email Verification Notice --}}
    @auth
        @if(!auth()->user()->email_verified_at && !session('warning'))
        <div class="bg-yellow-500 text-black py-3 px-4 text-center relative z-50">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">⚠️ Please verify your email address.</span>
                    <span class="ml-2">Check your inbox for the verification link.</span>
                </div>
                <form method="POST" action="{{ route('email.resend') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="bg-black text-white px-4 py-1 rounded hover:bg-gray-800 text-sm">
                        Resend Email
                    </button>
                </form>
            </div>
        </div>
        @endif
    @endauth
    
    @yield('content')
    
    @include('partials.footer')
    
    <!-- Search Modal -->
    <div class="modal-search-block">
        <div class="modal-search-main md:p-10 p-6 rounded-[32px]">
            <div class="form-search relative w-full">
                <form method="GET" action="{{ route('shop') }}">
                    <i class="ph ph-magnifying-glass absolute heading5 right-6 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    <input type="text" name="search" placeholder="Searching..." class="text-button-lg h-14 rounded-2xl border border-line w-full pl-6 pr-12" />
                </form>
            </div>
            <div class="keyword mt-8">
                <div class="heading5">Feature keywords Today</div>
                <div class="list-keyword flex items-center flex-wrap gap-3 mt-4">
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{ route('shop', ['search' => 'Dress']) }}'">Dress</button>
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{ route('shop', ['search' => 'T-shirt']) }}'">T-shirt</button>
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{ route('shop', ['search' => 'Underwear']) }}'">Underwear</button>
                    <button type="button" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white" onclick="window.location.href='{{ route('shop', ['search' => 'Top']) }}'">Top</button>
                </div>
            </div>
            <div class="list-recent mt-8">
                <div class="heading6">Recently viewed products</div>
                <div class="list-product pb-5 hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 mt-4">
                    @php
                        $recentProducts = \App\Models\Product::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(4)
                            ->get();
                    @endphp
                    @if($recentProducts->count() > 0)
                        @foreach($recentProducts as $product)
                            <div class="product-item grid-type">
                                @include('partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-8">
                            <p class="body1 text-secondary">No recent products</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wishlist Modal -->
    <div class="modal-wishlist-block">
        <div class="modal-wishlist-main py-6">
            <div class="heading px-6 pb-3 flex items-center justify-between relative">
                <div class="heading5">Wishlist</div>
                <div class="close-btn absolute right-6 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                    <i class="ph ph-x text-sm"></i>
                </div>
            </div>
            <div class="list-product px-6"></div>
            <div class="footer-modal p-6 border-t bg-white border-line absolute bottom-0 left-0 w-full text-center">
                <a href="{{ route('wishlist') }}" class="button-main w-full text-center uppercase"> View All Wish List</a>
                <div class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">Or continue shopping</div>
            </div>
        </div>
    </div>
    
    <!-- Cart Modal -->
    <div class="modal-cart-block">
        <div class="modal-cart-main flex">
            <div class="left w-1/2 border-r border-line py-6 max-md:hidden">
                <div class="heading5 px-6 pb-3">You May Also Like</div>
                <div class="list px-6">
                    <!-- Products will be loaded dynamically -->
                </div>
            </div>
            <div class="right cart-block md:w-1/2 w-full py-6 relative overflow-hidden">
                <div class="heading px-6 pb-3 flex items-center justify-between relative">
                    <div class="heading5">Shopping Cart</div>
                    <div class="close-btn absolute right-6 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                        <i class="ph ph-x text-sm"></i>
                    </div>
                </div>
                <div class="time countdown-cart px-6">
                    <div class="flex items-center gap-3 px-5 py-3 bg-green rounded-lg">
                        <p class="text-3xl">🔥</p>
                        <div class="caption1">
                            Your cart will expire in <span class="text-red caption1 font-semibold"><span class="minute">04</span>:<span class="second">59</span></span> minutes!<br />
                            Please checkout now before your items sell out!
                        </div>
                    </div>
                </div>
                <div class="heading banner mt-3 px-6">
                    <div class="text">
                        Buy <span class="text-button"> $<span class="more-price">150</span>.00 </span>
                        <span>more to get </span>
                        <span class="text-button">freeship</span>
                    </div>
                    <div class="tow-bar-block mt-3">
                        <div class="progress-line"></div>
                    </div>
                </div>
                <div class="list-cart px-6 overflow-y-auto max-h-[400px]">
                    <!-- Cart items will be loaded dynamically -->
                </div>
                <div class="footer-cart p-6 border-t border-line bg-white absolute bottom-0 left-0 w-full">
                    <div class="total flex items-center justify-between mb-4">
                        <div class="text-button-uppercase">Total:</div>
                        <div class="text-title">$<span class="total-price">0.00</span></div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="button-main w-full text-center uppercase">Checkout</a>
                    <a href="{{ route('cart.index') }}" class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">View Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.scripts')
    @yield('scripts')
    
    <script>
        // Header interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuMobileIcon = document.querySelector('.menu-mobile-icon');
            const menuMobile = document.getElementById('menu-mobile');
            const closeMenuBtn = document.querySelector('.close-menu-mobile-btn');
            
            if (menuMobileIcon && menuMobile) {
                menuMobileIcon.addEventListener('click', function() {
                    menuMobile.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            if (closeMenuBtn && menuMobile) {
                closeMenuBtn.addEventListener('click', function() {
                    menuMobile.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            // Search icon click to open modal
            const searchIcon = document.querySelector('.search-icon');
            const searchModal = document.querySelector('.modal-search-block');
            if (searchIcon && searchModal) {
                searchIcon.addEventListener('click', function() {
                    searchModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            // Close search modal
            const closeSearchModal = function() {
                if (searchModal) {
                    searchModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            };
            
            // Close on backdrop click
            if (searchModal) {
                searchModal.addEventListener('click', function(e) {
                    if (e.target === searchModal) {
                        closeSearchModal();
                    }
                });
            }
            
            // Close on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (searchModal && searchModal.classList.contains('active')) {
                        closeSearchModal();
                    }
                    if (menuMobile && menuMobile.classList.contains('active')) {
                        menuMobile.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            });
            
            // Wishlist icon click
            const wishlistIcon = document.querySelector('.wishlist-icon');
            if (wishlistIcon) {
                wishlistIcon.addEventListener('click', function() {
                    window.location.href = '{{ route("wishlist") }}';
                });
            }
            
            // Cart icon click
            const cartIcon = document.querySelector('.cart-icon');
            if (cartIcon) {
                cartIcon.addEventListener('click', function() {
                    window.location.href = '{{ route("cart.index") }}';
                });
            }
        });
    </script>
</body>
</html>
