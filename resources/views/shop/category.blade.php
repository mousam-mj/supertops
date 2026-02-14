@extends('layouts.app')

@section('title', 'Category - Perch Bottle')

@section('content')
<div id="menu-mobile" class="">
                <div class="menu-container bg-white h-full">
                    <div class="container h-full">
                        <div class="menu-main h-full overflow-x-hidden scroll2">
                            <div class="heading py-2 relative flex items-center justify-center">
                                <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                                    <i class="ph ph-x text-sm"></i>
                                </div>
                                <a href="{{ route('home') }}" class="logo text-3xl font-semibold text-center">Perch</a>
                            </div>
                            <div class="form-search relative mt-2">
                                <i class="ph ph-magnifying-glass text-xl absolute left-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                                <input type="text" placeholder="What are you looking for?" class="h-12 rounded-lg border border-line text-sm w-full pl-10 pr-4" />
                            </div>
                            
                            <div class="list-nav mt-6">
                                
                                <ul>
                                    <li>
                                        <a href="{{{ route('shop') }}}" class="text-xl font-semibold flex items-center justify-between"
                                            >📱 Phone Cases
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full grid grid-cols-2 pt-2 pb-6">
                                                <ul>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Premium Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Clear Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Wallet Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Rugged Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Leather Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Silicone Cases </a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Bumper Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Flip Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> Battery Cases </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="nav-item-mobile link text-secondary duration-300"> View All Cases </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{{ route('shop') }}}" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >🔌 Chargers
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <div class="nav-link grid grid-cols-2 gap-5 gap-y-6">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Fast Chargers</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> USB-C Fast Chargers </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Wireless Chargers </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Car Chargers </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Multi-Port Chargers </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Cables & Adapters</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> USB-C Cables </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Lightning Cables </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Micro USB Cables </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Adapters & Converters </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{{ route('shop') }}}" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >🎧 Headphones & Audio
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <div class="nav-link grid grid-cols-2 gap-5 gap-y-6 justify-between">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Wireless Audio</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Wireless Earbuds </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Over-Ear Headphones </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Gaming Headsets </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Sports Earbuds </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Wired Audio</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Wired Earbuds </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> In-Ear Headphones </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Audio Adapters </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> View All Audio </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{{ route('shop') }}}" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >🔋 Power Banks
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <ul class="w-full">
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Portable Power Banks </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Wireless Power Banks </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Solar Power Banks </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> High Capacity Banks </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{{ route('shop') }}}" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >🛡️ Protection & Accessories
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <ul class="w-full">
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Screen Protectors </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Tempered Glass </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Phone Stands </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Car Mounts </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> Pop Sockets </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300"> View All </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Product
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <div class="nav-link grid grid-cols-2 gap-5 gap-y-6 justify-between">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Defaults </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Countdown Timer </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Grouped </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Frequently Bought Together </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Out Of Stock </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Variable </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products External </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products On Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products With Discount </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products With Sidebar </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300"> Products Fixed Price </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Left </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Bottom </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Grid 1 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Grid 2 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Combined 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Combined 2 </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Styles</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 01 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 02 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 03 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 04 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('product.show', $product->slug ?? '#') }}" class="link text-secondary duration-300 cursor-pointer"> Products Style 05 </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Blog
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <ul class="w-full">
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Default </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog List </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Grid </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Detail 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Blog Detail 2 </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Pages
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full pt-2 pb-6">
                                                <ul class="w-full">
                                                    <li>
                                                        <a href="{{ route('about') }}" class="link text-secondary duration-300"> About Us </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('contact') }}" class="link text-secondary duration-300"> Contact Us </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Store List </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> 404 </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('faqs') }}" class="link text-secondary duration-300"> FAQs </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Coming Soon </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('home') }}" class="link text-secondary duration-300"> Customer Feedbacks </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu bar -->
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
            <div class="list-banner sm:-mt-[75px] relative">
                @php
                    $heroImage = $category->hero_image ?? ($mainCategory->hero_image ?? null);
                    $heroText = $category->hero_text ?? ($mainCategory->hero_text ?? null);
                    $heroButtonText = $category->hero_button_text ?? ($mainCategory->hero_button_text ?? 'Shop Now');
                @endphp
                @if($heroImage)
                    <div class="banner-img w-full">
                        <img src="{{ asset('storage/' . $heroImage) }}" alt="{{ $category->name }}" class="w-full duration-500">
                    </div>
                @else
                    <div class="banner-img w-full">
                        <img src="{{ asset('assets/images/slider/11b-scaled.webp') }}" alt="bg-img" class="w-full duration-500">
                    </div>
                @endif
                @if($heroText)
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap z-10">{{ $heroText }}</div>
                @else
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap z-10">{{ $category->name }}</div>
                @endif
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="absolute bottom-8 left-1/2 -translate-x-1/2 button-main z-10">{{ $heroButtonText }}</a>
            </div> 
        </div> 
            
        </div>
         
        @php
            $additionalBannerImage = $category->additional_banner_image ?? ($mainCategory->additional_banner_image ?? null);
            $additionalBannerText = $category->additional_banner_text ?? ($mainCategory->additional_banner_text ?? null);
        @endphp
        <div class="banner-block relative">
            <div class="list-banner">
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        @if($additionalBannerImage)
                            <img src="{{ asset('storage/' . $additionalBannerImage) }}" alt="{{ $additionalBannerText ?? $category->name }}" class="w-full duration-500">
                        @else
                            <img src="{{ asset('assets/images/slider/09-1-scaled.webp') }}" alt="bg-img" class="w-full duration-500">
                        @endif
                    </div>
                    @if($additionalBannerText)
                        <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $additionalBannerText }}</div>
                    @else
                        <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category->name }}</div>
                    @endif
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 button-main">{{ $heroButtonText }}</div>
                </a>
            </div>
        </div>
        @php
            $bannerImages = is_array($category->banner_images) && !empty($category->banner_images) 
                ? $category->banner_images 
                : (is_array($mainCategory->banner_images ?? null) && !empty($mainCategory->banner_images ?? null) 
                    ? $mainCategory->banner_images 
                    : []);
            $bannerTexts = is_array($category->banner_texts) && !empty($category->banner_texts) 
                ? $category->banner_texts 
                : (is_array($mainCategory->banner_texts ?? null) && !empty($mainCategory->banner_texts ?? null) 
                    ? $mainCategory->banner_texts 
                    : []);
            // Default images and texts for collection block
            $defaultCollectionImages = [
                'assets/images/product/Bottle-1.webp',
                'assets/images/product/Bottle-4.webp',
                'assets/images/product/Bottle-8.webp'
            ];
            $defaultCollectionTexts = ['Drinkware', 'Barware', 'Kichenware'];
        @endphp
        <div class="collection-block mt-5">
            <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
                <div class="banner-block md:pt-20 pt-10">
                    <div class="container">
                        <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                            @for($i = 0; $i < 3; $i++)
                                @php
                                    $collectionImage = !empty($bannerImages[$i]) ? asset('storage/' . $bannerImages[$i]) : asset($defaultCollectionImages[$i]);
                                    $collectionText = !empty($bannerTexts[$i]) ? $bannerTexts[$i] : $defaultCollectionTexts[$i];
                                @endphp
                                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                                    <div class="banner-img w-full">
                                        <img src="{{ $collectionImage }}" alt="{{ $collectionText }}" class="w-full duration-500">
                                    </div>
                                    <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $collectionText }}</div>
                                    <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">{{ $heroButtonText }}</div>
                                </a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $testimonialText = $category->testimonial_text ?? ($mainCategory->testimonial_text ?? null);
            $defaultTestimonial = "I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face.";
        @endphp
        <div class="quote-block bg-linear py-[60px] mt-10">
            <div class="container flex items-center justify-center">
                <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"{{ $testimonialText ?? $defaultTestimonial }}"</div>
            </div>
        </div>

        
        <div class="what-new-block filter-product-block md:pt-20 pt-10">
            <div class="container">
                <div class="heading flex flex-col items-center text-center">
                    <div class="heading3">What's new</div>
                    <div class="menu-tab bg-surface rounded-2xl mt-6">
                        <div class="menu flex items-center gap-2 p-1">
                            <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="top">top</div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black active" data-item="t-shirt">t-shirt</div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="dress">dress</div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="sets">sets</div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="shirt">shirt</div>
                        </div>
                    </div>
                </div>
                <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
                    <div class="product-item grid-type" data-item="1">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
                                <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                    <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-lg"></i>
                                    </div>
                                    <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                        <i class="ph ph-check-circle text-lg checked-icon"></i>
                                    </div>
                                </div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                </div>
                                <div class="countdown-time-block py-1.5 flex items-center justify-center">
                                    <div class="text-xs font-semibold uppercase text-red">
                                        <span class="countdown-day">24</span>
                                        <span>D : </span>
                                        <span class="countdown-hour">14</span>
                                        <span>H : </span>
                                        <span class="countdown-minute">36</span>
                                        <span>M : </span>
                                        <span class="countdown-second">51</span>
                                        <span>S</span>
                                    </div>
                                </div>
                                <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                    <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        <span class="max-lg:hidden">Quick View</span>
                                        <i class="ph ph-eye lg:hidden text-xl"></i>
                                    </div>
                                    <div class="quick-shop-btn text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white max-lg:hidden">Quick Shop</div>
                                    <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white lg:hidden">
                                        <span class="max-lg:hidden">Add To Cart</span>
                                        <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                                    </div>
                                    <div class="quick-shop-block absolute left-5 right-5 bg-white p-5 rounded-[20px]">
                                        <div class="list-size flex items-center justify-center flex-wrap gap-2">
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">S</div>
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">M</div>
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">L</div>
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">XL</div>
                                        </div>
                                        <div class="add-cart-btn button-main w-full text-center rounded-full py-3 mt-4">Add To cart</div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-infor mt-4 lg:mb-7">
                                <div class="product-sold sm:pb-4 pb-2">
                                    <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                        <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                            <span class="max-sm:text-xs">24</span>
                                        </div>
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                            <span class="max-sm:text-xs">96</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-name text-title duration-300">Raglan Sleeve T-shirt</div>

                                <div class="list-color list-color-image max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                                    </div>
                                </div>

                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">₹30.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>₹42.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-30%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item grid-type" data-item="3">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
                                <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                    <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-lg"></i>
                                    </div>
                                    <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                        <i class="ph ph-check-circle text-lg checked-icon"></i>
                                    </div>
                                </div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                </div>
                                <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                    <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        <span class="max-lg:hidden">Quick View</span>
                                        <i class="ph ph-eye lg:hidden text-xl"></i>
                                    </div>
                                    <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        <span class="max-lg:hidden">Add To Cart</span>
                                        <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="product-infor mt-4 lg:mb-7">
                                <div class="product-sold sm:pb-4 pb-2">
                                    <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                        <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                            <span class="max-sm:text-xs">12</span>
                                        </div>
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                            <span class="max-sm:text-xs">88</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-name text-title duration-300">Off-the-Shoulder Blouse</div>
                                <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                    <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item bg-yellow w-8 h-8 rounded-full duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">yellow</div>
                                    </div>
                                    <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">green</div>
                                    </div>
                                </div>

                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">₹40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>₹50.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item grid-type" data-item="4">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>
                                <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                    <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-lg"></i>
                                    </div>
                                    <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                        <i class="ph ph-check-circle text-lg checked-icon"></i>
                                    </div>
                                </div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                </div>
                                <div class="countdown-time-block py-1.5 flex items-center justify-center">
                                    <div class="text-xs font-semibold uppercase text-red">
                                        <span class="countdown-day">24</span>
                                        <span>D : </span>
                                        <span class="countdown-hour">14</span>
                                        <span>H : </span>
                                        <span class="countdown-minute">36</span>
                                        <span>M : </span>
                                        <span class="countdown-second">51</span>
                                        <span>S</span>
                                    </div>
                                </div>
                                <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                    <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        <span class="max-lg:hidden">Quick View</span>
                                        <i class="ph ph-eye lg:hidden text-xl"></i>
                                    </div>
                                    <div class="quick-shop-btn text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white max-lg:hidden">Quick Shop</div>
                                    <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white lg:hidden">
                                        <span class="max-lg:hidden">Add To Cart</span>
                                        <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                                    </div>
                                    <div class="quick-shop-block absolute left-5 right-5 bg-white p-5 rounded-[20px]">
                                        <div class="list-size flex items-center justify-center flex-wrap gap-2">
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">S</div>
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">M</div>
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">L</div>
                                            <div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black">XL</div>
                                        </div>
                                        <div class="add-cart-btn button-main w-full text-center rounded-full py-3 mt-4">Add To cart</div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-infor mt-4 lg:mb-7">
                                <div class="product-sold sm:pb-4 pb-2">
                                    <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                        <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                            <span class="max-sm:text-xs">24</span>
                                        </div>
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                            <span class="max-sm:text-xs">96</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-name text-title duration-300">Raglan Sleeve T-shirt</div>
                                <div class="list-color list-color-image max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                                    </div>
                                </div>

                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">₹30.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>₹42.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-30%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-item grid-type" data-item="5">
                        <div class="product-main cursor-pointer block">
                            <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
                                <div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>
                                <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
                                    <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
                                        <i class="ph ph-heart text-lg"></i>
                                    </div>
                                    <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
                                        <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
                                        <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
                                        <i class="ph ph-check-circle text-lg checked-icon"></i>
                                    </div>
                                </div>
                                <div class="product-img w-full h-full aspect-[3/4]">
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="img" />
                                </div>
                                <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5 max-lg:hidden">
                                    <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        <span class="max-lg:hidden">Quick View</span>
                                        <i class="ph ph-eye lg:hidden text-xl"></i>
                                    </div>
                                    <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                                        <span class="max-lg:hidden">Add To Cart</span>
                                        <i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="product-infor mt-4 lg:mb-7">
                                <div class="product-sold sm:pb-4 pb-2">
                                    <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
                                        <div class="progress-sold bg-red absolute left-0 top-0 h-full"></div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Sold: </span>
                                            <span class="max-sm:text-xs">12</span>
                                        </div>
                                        <div class="text-button-uppercase">
                                            <span class="text-secondary2 max-sm:text-xs">Available: </span>
                                            <span class="max-sm:text-xs">88</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-name text-title duration-300">Off-the-Shoulder Blouse</div>
                                <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
                                    <div class="color-item bg-red w-8 h-8 rounded-full duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item bg-yellow w-8 h-8 rounded-full duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">yellow</div>
                                    </div>
                                    <div class="color-item bg-green w-8 h-8 rounded-full duration-300 relative">
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">green</div>
                                    </div>
                                </div>

                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">₹40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>₹50.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="banner-block relative">
            <div class="list-banner">
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        @php
                            $middleBannerImage = $category->additional_banner_image ?? ($mainCategory->additional_banner_image ?? null);
                        @endphp
                        @if($middleBannerImage)
                            <img src="{{ asset('storage/' . $middleBannerImage) }}" alt="{{ $category->name }}" class="w-full duration-500">
                        @else
                            <img src="{{ asset('assets/images/slider/03b-scaled.webp') }}" alt="bg-img" class="w-full duration-500">
                        @endif
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">{{ $category->name }}</div>
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 button-main">{{ $heroButtonText }}</div>
                </a>
            </div>
        </div>

        @php
            $bottomBannerImage = $category->bottom_banner_image ?? ($mainCategory->bottom_banner_image ?? null);
            $bottomBannerText = $category->bottom_banner_text ?? ($mainCategory->bottom_banner_text ?? null);
        @endphp
        <div class="banner-block style-toys-kids">
            <div class="container">
                <div class="content md:rounded-[28px] rounded-2xl overflow-hidden relative">
                    @if($bottomBannerImage)
                        <img src="{{ asset('storage/' . $bottomBannerImage) }}" alt="{{ $category->name }}" class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
                    @else
                        <img src="{{ asset('assets/images/banner/bg-banner-toys.png') }}" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
                    @endif
                    <div class="text-content xl:w-1/3 w-2/3 xl:pl-[120px] md:pl-20 pl-10 md:py-[85px] py-12">
                        @if($bottomBannerText)
                            <div class="heading2 md:mt-4 mt-2">{{ $bottomBannerText }}</div>
                        @else
                            <div class="text-sub-display">Sale Up To 50% Off Today!</div>
                            <div class="heading2 md:mt-4 mt-2">Created to be loved for a lifetime</div>
                        @endif
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="button-main md:mt-7 mt-3">{{ $heroButtonText }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner-block pt-5 px-5">
            <div class="container">
                <div class="list-banner grid lg:grid-cols-2 sm:grid-cols-2 gap-[20px]">
                    @php
                        $twoBannerImages = [];
                        $twoBannerTexts = [];
                        if (!empty($bannerImages) && count($bannerImages) >= 2) {
                            $twoBannerImages = [$bannerImages[0], $bannerImages[1]];
                            $twoBannerTexts = [
                                !empty($bannerTexts[0]) ? $bannerTexts[0] : 'Check & Coutour',
                                !empty($bannerTexts[1]) ? $bannerTexts[1] : $category->name
                            ];
                        } else {
                            $twoBannerImages = [
                                asset('assets/images/banner/perch123(2).webp'),
                                asset('assets/images/banner/perch123(2).webp')
                            ];
                            $twoBannerTexts = ['Check & Coutour', $category->name];
                        }
                    @endphp
                    @for($i = 0; $i < 2; $i++)
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                            <div class="banner-img w-full">
                                @if(!empty($bannerImages) && count($bannerImages) >= 2 && !empty($bannerImages[$i]))
                                    <img src="{{ asset('storage/' . $bannerImages[$i]) }}" alt="{{ $twoBannerTexts[$i] }}" class="w-full duration-500">
                                @else
                                    <img src="{{ $twoBannerImages[$i] }}" alt="{{ $twoBannerTexts[$i] }}" class="w-full duration-500">
                                @endif
                            </div>
                            <div class="banner-content absolute left-[30px] bottom-[30px]">
                                <div class="heading4">{{ $twoBannerTexts[$i] }}</div>
                                <div class="text-button text-black relative inline-block pb-1 border-b-2 border-black duration-500 mt-2">Shop Now</div>
                            </div>
                        </a>
                    @endfor
                </div>
            </div>
        </div>

        <div class="container">
            <div class="slider-item slick-slide slick-current slick-active">
                <div class="bg-[#EBFCF5] h-full w-full relative flex max-sm:flex-col-reverse items-center lg:rounded-[40px] rounded-xl overflow-hidden mt-10">
                    <img src="{{ asset('assets/images/slider/bg-toys.png') }}" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover" />
                    <div class="text-content sm:w-1/3 max-sm:pt-10 max-sm:pb-[40px] flex flex-col items-center justify-center z-[1]">
                        <div class="text-sub-display">Sale! Up To 50% Off!</div>
                        <div class="heading1 text-center md:mt-4 mt-2">Perch Bottle <br class="max-xl:hidden">on sale</div>
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="button-main md:mt-8 mt-3" tabindex="0">Shop Now</a>
                    </div>
                    <div class="sub-img sm:w-2/3 w-full h-full sm:pl-10">
                        <img src="{{ asset('assets/images/banner/perch123(1).webp') }}" alt="bg-toys1" class="w-full h-full object-cover z-[1] relative" />
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="benefit-block md:mt-20 mt-10 py-10 px-2.5 bg-surface rounded-3xl">
                <div class="list-benefit grid items-start lg:grid-cols-4 grid-cols-2 gap-[30px]">
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-phone-call lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">24/7 Customer Service</div>
                        <div class="caption1 text-secondary text-center mt-3">We're here to help you with any questions or concerns you have, 24/7.</div>
                    </div>
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-return lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">14-Day Money Back</div>
                        <div class="caption1 text-secondary text-center mt-3">If you're not satisfied with your purchase, simply return it within 14 days for a refund.</div>
                    </div>
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-guarantee lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">Our Guarantee</div>
                        <div class="caption1 text-secondary text-center mt-3">We stand behind our products and services and guarantee your satisfaction.</div>
                    </div>
                    <div class="benefit-item flex flex-col items-center justify-center">
                        <i class="icon-delivery-truck lg:text-7xl text-5xl"></i>
                        <div class="heading6 text-center mt-5">Shipping worldwide</div>
                        <div class="caption1 text-secondary text-center mt-3">We ship our products worldwide, making them accessible to customers everywhere.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="instagram-block md:pt-20 pt-10">
            <div class="container">
                <div class="heading">
                    <div class="heading3 text-center">Perch On Instagram</div>
                    <div class="text-center mt-3">#perch.bottle</div>
                </div>
                <div class="list-instagram md:mt-10 mt-6">
                    <div class="swiper swiper-list-instagram">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1(1).webp') }}" alt="0" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1(2).webp') }}" alt="1" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1(3).webp') }}" alt="2" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1(4).webp') }}" alt="3" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1(5).webp') }}" alt="4" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset('assets/images/instagram/p1(1).webp') }}" alt="5" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="brand-block md:py-[60px] py-[32px]">
            <div class="container">
                <div class="list-brand">
                    <div class="swiper swiper-list-brand">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="1" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="2" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="3" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="4" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="5" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="6" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset('assets/images/perch-logo.png') }}" alt="7" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching for product types
    const tabItems = document.querySelectorAll('.tab-item[data-item]');
    const indicator = document.querySelector('.indicator');
    
    if (tabItems.length > 0 && indicator) {
        tabItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                const type = this.getAttribute('data-item');
                
                // Update active tab
                tabItems.forEach(tab => tab.classList.remove('active'));
                this.classList.add('active');
                
                // Move indicator
                const itemWidth = 100 / tabItems.length;
                indicator.style.left = (index * itemWidth) + '%';
                indicator.style.width = itemWidth + '%';
                
                // Filter products
                if (typeof window.categorySlug !== 'undefined') {
                    window.location.href = '{{{ route("category", $category->slug ?? "") }}}?type=' + type;
                }
            });
        });
    }
    
    // Initialize Swiper for brands
    if (typeof Swiper !== 'undefined') {
        const brandSwiper = document.querySelector('.swiper-list-brand');
        if (brandSwiper) {
            new Swiper('.swiper-list-brand', {
                slidesPerView: 'auto',
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                    1280: {
                        slidesPerView: 6,
                    },
                },
            });
        }
        
        // Initialize Instagram swiper if exists
        const instagramSwiper = document.querySelector('.swiper-list-instagram');
        if (instagramSwiper) {
            new Swiper('.swiper-list-instagram', {
                slidesPerView: 'auto',
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
            });
        }
    }
});
</script>
@endsection
