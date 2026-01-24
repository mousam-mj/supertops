@extends('layouts.app')

@section('title', 'My Account - Perch Bottle')

@section('content')
<div id="menu-mobile" class="">
                <div class="menu-container bg-white h-full">
                    <div class="container h-full">
                        <div class="menu-main h-full overflow-hidden">
                            <div class="heading py-2 relative flex items-center justify-center">
                                <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                                    <i class="ph ph-x text-sm"></i>
                                </div>
                                <a href="{{ route('home') }}" class="logo text-3xl font-semibold text-center">Anvogue</a>
                            </div>
                            <div class="form-search relative mt-2">
                                <i class="ph ph-magnifying-glass text-xl absolute left-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                                <input type="text" placeholder="What are you looking for?" class="h-12 rounded-lg border border-line text-sm w-full pl-10 pr-4" />
                            </div>
                            <div class="list-nav mt-6">
                                <ul>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between"
                                            >Demo
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
                                                        <a href="{{ route('home') }}" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion2.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 2 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion3.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 3 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion4.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 4 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion5.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 5 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion6.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 6 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion7.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 7 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion8.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 8 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion9.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 9 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion10.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 10 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion11.html" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 11 </a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="underwear.html" class="nav-item-mobile link text-secondary duration-300"> Home Underwear </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic1.html" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic2.html" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 2 </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic3.html" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 3 </a>
                                                    </li>
                                                    <li>
                                                        <a href="pet.html" class="nav-item-mobile link text-secondary duration-300"> Home Pet Store </a>
                                                    </li>
                                                    <li>
                                                        <a href="jewelry.html" class="nav-item-mobile link text-secondary duration-300"> Home Jewelry </a>
                                                    </li>
                                                    <li>
                                                        <a href="furniture.html" class="nav-item-mobile link text-secondary duration-300"> Home Furniture </a>
                                                    </li>
                                                    <li>
                                                        <a href="watch.html" class="nav-item-mobile link text-secondary duration-300"> Home Watch </a>
                                                    </li>
                                                    <li>
                                                        <a href="toys.html" class="nav-item-mobile link text-secondary duration-300"> Home Toys Kid </a>
                                                    </li>
                                                    <li>
                                                        <a href="yoga.html" class="nav-item-mobile link text-secondary duration-300"> Home Yoga </a>
                                                    </li>
                                                    <li>
                                                        <a href="organic.html" class="nav-item-mobile link text-secondary duration-300"> Home Organic </a>
                                                    </li>
                                                    <li>
                                                        <a href="marketplace.html" class="nav-item-mobile link text-secondary duration-300"> Home Marketplace </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Features
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
                                                        <div class="text-button-uppercase pb-1">For Men</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Starting From 50% Off </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Outerwear | Coats </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Sweaters | Cardigans </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shirt | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Skincare</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Faces Skin </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Eyes Makeup </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Lip Polish </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Hair Care </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Health</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Cented Candle </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Health Drinks </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Yoga Clothes </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Yoga Equipment </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Women</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Starting From 60% Off </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Dresses | Jumpsuits </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> T-shirts | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Accessories | Jewelry </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Kid</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Kids Bed </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Boy's Toy </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Baby Blanket </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Newborn Clothing </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Home</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Furniture | Decor </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Table | Living Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Chair | Work Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Lighting | Bed Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Shop
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
                                                        <div class="text-button-uppercase pb-1">Shop Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Breadcrumb IMG </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Breadcrumb 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Breadcrumb 2 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Collection </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Filter Canvas </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Filter Options </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Filter Dropdown </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Sidebar List </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Default </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Default Grid </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Default List </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300 cursor-pointer"> Shop Full Width </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shop') }}" class="link text-secondary duration-300"> Shop Square </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Pages</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{{ route('wishlist') }}" class="link text-secondary duration-300"> Wish List </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('search') }}" class="link text-secondary duration-300"> Search Result </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('cart.index') }}" class="link text-secondary duration-300"> Shopping Cart </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('login') }}" class="link text-secondary duration-300"> Login/Register </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('forgot-password') }}" class="link text-secondary duration-300"> Forgot Password </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('order-tracking') }}" class="link text-secondary duration-300"> Order Tracking </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('my-account') }}" class="link text-secondary duration-300 active"> My Account </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
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

            <div class="breadcrumb-block style-shared">
                <div class="breadcrumb-main bg-linear overflow-hidden">
                    <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                        <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                            <div class="text-content">
                                <div class="heading2 text-center">My Account</div>
                                <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                    <a href="{{ route('home') }}">Homepage</a>
                                    <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                    <div class="text-secondary2 capitalize">My Account</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-account-block md:py-20 py-10">
            <div class="container">
                <div class="content-main lg:px-[60px] md:px-4 flex gap-y-8 max-md:flex-col w-full">
                    <div class="left md:w-1/3 w-full xl:pr-[3.125rem] lg:pr-[28px] md:pr-[16px]">
                        <div class="user-infor bg-surface md:px-8 px-5 md:py-10 py-6 md:rounded-[20px] rounded-xl">
                            <div class="heading flex flex-col items-center justify-center">
                                <div class="avatar">
                                    <img src="{{ asset('assets/images/avatar/1.png" alt="avatar" class="md:w-[140px] w-[120px] md:h-[140px] h-[120px] rounded-full') " />
                                </div>
                                <div class="name heading6 mt-4 text-center">Tony Nguyen</div>
                                <div class="mail heading6 font-normal normal-case text-secondary text-center mt-1">hi.avitex@gmail.com</div>
                            </div>
                            <div class="menu-tab list-category w-full max-w-none lg:mt-10 mt-6">
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white active" data-item="dashboard">
                                    <span class="ph ph-house-line text-xl"></span>
                                    <strong class="heading6">Dashboard</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="orders">
                                    <span class="ph ph-package text-xl"></span>
                                    <strong class="heading6">History Orders</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="address">
                                    <span class="ph ph-tag text-xl"></span>
                                    <strong class="heading6">My Address</strong>
                                </a>
                                <a href="#!" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5" data-item="setting">
                                    <span class="ph ph-gear-six text-xl"></span>
                                    <strong class="heading6">Setting</strong>
                                </a>
                                <a href="{{ route('login') }}" class="category-item flex items-center gap-3 w-full px-5 py-4 rounded-lg cursor-pointer duration-300 hover:bg-white mt-1.5">
                                    <span class="ph ph-sign-out text-xl"></span>
                                    <strong class="heading6">Logout</strong>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="right list-filter md:w-2/3 w-full pl-2.5">
                        <div class="filter-item text-content w-full active" data-item="dashboard">
                            <div class="overview grid sm:grid-cols-3 gap-5">
                                <div class="overview-item flex items-center justify-between p-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="counter">
                                        <span class="text-secondary">Awaiting Pickup</span>
                                        <h5 class="heading5 mt-1">4</h5>
                                    </div>
                                    <span class="ph ph-hourglass-medium text-4xl"></span>
                                </div>
                                <div class="overview-item flex items-center justify-between p-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="counter">
                                        <span class="text-secondary">Cancelled Orders</span>
                                        <h5 class="heading5 mt-1">12</h5>
                                    </div>
                                    <span class="ph ph-receipt-x text-4xl"></span>
                                </div>
                                <div class="overview-item flex items-center justify-between p-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="counter">
                                        <span class="text-secondary">Total Number of Orders</span>
                                        <h5 class="heading5 mt-1">200</h5>
                                    </div>
                                    <span class="ph ph-package text-4xl"></span>
                                </div>
                            </div>
                            <div class="recent_order pt-5 px-5 pb-2 mt-7 border border-line rounded-xl">
                                <h6 class="heading6">Recent Orders</h6>
                                <div class="list overflow-x-auto w-full mt-5">
                                    <table class="w-full max-[1400px]:w-[700px] max-md:w-[700px]">
                                        <thead class="border-b border-line">
                                            <tr>
                                                <th scope="col" class="pb-3 text-left text-sm font-bold uppercase text-secondary whitespace-nowrap">Order</th>
                                                <th scope="col" class="pb-3 text-left text-sm font-bold uppercase text-secondary whitespace-nowrap">Products</th>
                                                <th scope="col" class="pb-3 text-left text-sm font-bold uppercase text-secondary whitespace-nowrap">Pricing</th>
                                                <th scope="col" class="pb-3 text-right text-sm font-bold uppercase text-secondary whitespace-nowrap">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="item duration-300 border-b border-line">
                                                <th scope="row" class="py-3 text-left">
                                                    <strong class="text-title">54312452</strong>
                                                </th>
                                                <td class="py-3">
                                                    <a href="{{ route('product.show', $product->slug ?? '#') }}" class="product flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sweatshirt" class="flex-shrink-0 w-12 h-12 rounded') " />
                                                        <div class="info flex flex-col">
                                                            <strong class="product_name text-button">Contrasting sweatshirt</strong>
                                                            <span class="product_tag caption1 text-secondary">Women, Clothing</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="py-3 price">$45.00</td>
                                                <td class="py-3 text-right">
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-yellow text-yellow caption1 font-semibold">Pending</span>
                                                </td>
                                            </tr>
                                            <tr class="item duration-300 border-b border-line">
                                                <th scope="row" class="py-3 text-left">
                                                    <strong class="text-title">54312452</strong>
                                                </th>
                                                <td class="py-3">
                                                    <a href="{{ route('product.show', $product->slug ?? '#') }}" class="product flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="Faux-leather trousers" class="flex-shrink-0 w-12 h-12 rounded') " />
                                                        <div class="info flex flex-col">
                                                            <strong class="product_name text-button">Faux-leather trousers</strong>
                                                            <span class="product_tag caption1 text-secondary">Women, Clothing</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="py-3 price">$45.00</td>
                                                <td class="py-3 text-right">
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-purple text-purple caption1 font-semibold">Delivery</span>
                                                </td>
                                            </tr>
                                            <tr class="item duration-300 border-b border-line">
                                                <th scope="row" class="py-3 text-left">
                                                    <strong class="text-title">54312452</strong>
                                                </th>
                                                <td class="py-3">
                                                    <a href="{{ route('product.show', $product->slug ?? '#') }}" class="product flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="V-neck knitted top" class="flex-shrink-0 w-12 h-12 rounded') " />
                                                        <div class="info flex flex-col">
                                                            <strong class="product_name text-button">V-neck knitted top</strong>
                                                            <span class="product_tag caption1 text-secondary">Women, Clothing</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="py-3 price">$45.00</td>
                                                <td class="py-3 text-right">
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-success text-success caption1 font-semibold">Completed</span>
                                                </td>
                                            </tr>
                                            <tr class="item duration-300 border-b border-line">
                                                <th scope="row" class="py-3 text-left">
                                                    <strong class="text-title">54312452</strong>
                                                </th>
                                                <td class="py-3">
                                                    <a href="{{ route('product.show', $product->slug ?? '#') }}" class="product flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sweatshirt" class="flex-shrink-0 w-12 h-12 rounded') " />
                                                        <div class="info flex flex-col">
                                                            <strong class="product_name text-button">Contrasting sweatshirt</strong>
                                                            <span class="product_tag caption1 text-secondary">Women, Clothing</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="py-3 price">$45.00</td>
                                                <td class="py-3 text-right">
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-yellow text-yellow caption1 font-semibold">Pending</span>
                                                </td>
                                            </tr>
                                            <tr class="item duration-300 border-b border-line">
                                                <th scope="row" class="py-3 text-left">
                                                    <strong class="text-title">54312452</strong>
                                                </th>
                                                <td class="py-3">
                                                    <a href="{{ route('product.show', $product->slug ?? '#') }}" class="product flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="Faux-leather trousers" class="flex-shrink-0 w-12 h-12 rounded') " />
                                                        <div class="info flex flex-col">
                                                            <strong class="product_name text-button">Faux-leather trousers</strong>
                                                            <span class="product_tag caption1 text-secondary">Women, Clothing</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="py-3 price">$45.00</td>
                                                <td class="py-3 text-right">
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-purple text-purple caption1 font-semibold">Delivery</span>
                                                </td>
                                            </tr>
                                            <tr class="item duration-300">
                                                <th scope="row" class="py-3 text-left">
                                                    <strong class="text-title">54312452</strong>
                                                </th>
                                                <td class="py-3">
                                                    <a href="{{ route('product.show', $product->slug ?? '#') }}" class="product flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/product/1000x1000.png" alt="V-neck knitted top" class="flex-shrink-0 w-12 h-12 rounded') " />
                                                        <div class="info flex flex-col">
                                                            <strong class="product_name text-button">V-neck knitted top</strong>
                                                            <span class="product_tag caption1 text-secondary">Women, Clothing</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="py-3 price">$45.00</td>
                                                <td class="py-3 text-right">
                                                    <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-red text-red caption1 font-semibold">Canceled</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item tab_order text-content overflow-hidden w-full p-7 border border-line rounded-xl" data-item="orders">
                            <h6 class="heading6">Your Orders</h6>
                            <div class="w-full overflow-x-auto">
                                <div class="menu-tab relative grid grid-cols-5 max-lg:w-[500px] max-md:max-w-max border-b border-line mt-3">
                                    <div class="indicator absolute bottom-0 w-1/5 h-0.5 bg-black duration-500"></div>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black active">all</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">pending</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">delivery</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">completed</button>
                                    <button class="tab-item relative px-3 py-2.5 text-button text-secondary text-center duration-300 hover:text-black">canceled</button>
                                </div>
                            </div>
                            <div class="list_order">
                                <div class="order_item mt-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="flex flex-wrap items-center justify-between gap-4 p-5 border-b border-line">
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order Number:</strong>
                                            <strong class="order_number text-button uppercase">s184989823</strong>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order status:</strong>
                                            <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-purple text-purple caption1 font-semibold">Delivery</span>
                                        </div>
                                    </div>
                                    <div class="list_prd px-5">
                                        <div class="prd_item flex flex-wrap items-center justify-between gap-3 py-5 border-b border-line">
                                            <a href="{{ route('product.show', $product->slug ?? '#') }}" class="flex items-center gap-5">
                                                <div class="bg-img flex-shrink-0 md:w-[100px] w-20 aspect-square rounded-lg overflow-hidden">
                                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sheepskin sweatshirt" class="w-full h-full object-cover') " />
                                                </div>
                                                <div>
                                                    <div class="prd_name text-title">Contrasting sheepskin sweatshirt</div>
                                                    <div class="caption1 text-secondary mt-2">
                                                        <span class="prd_size uppercase">XL</span>
                                                        <span>/</span>
                                                        <span class="prd_color capitalize">Yellow</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="text-title">
                                                <span class="prd_quantity">1</span>
                                                <span> X </span>
                                                <span class="prd_price">$45.00</span>
                                            </div>
                                        </div>
                                        <div class="prd_item flex flex-wrap items-center justify-between gap-3 py-5 border-b border-line">
                                            <a href="{{ route('product.show', $product->slug ?? '#') }}" class="flex items-center gap-5">
                                                <div class="bg-img flex-shrink-0 md:w-[100px] w-20 aspect-square rounded-lg overflow-hidden">
                                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sheepskin sweatshirt" class="w-full h-full object-cover') " />
                                                </div>
                                                <div>
                                                    <div class="prd_name text-title">Contrasting sheepskin sweatshirt</div>
                                                    <div class="caption1 text-secondary mt-2">
                                                        <span class="prd_size uppercase">XL</span>
                                                        <span>/</span>
                                                        <span class="prd_color capitalize">White</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="text-title">
                                                <span class="prd_quantity">2</span>
                                                <span> X </span>
                                                <span class="prd_price">$70.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-4 p-5">
                                        <button class="button-main btn_order_detail">Order Details</button>
                                        <button class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white">Cancel Order</button>
                                    </div>
                                </div>
                                <div class="order_item mt-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="flex flex-wrap items-center justify-between gap-4 p-5 border-b border-line">
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order Number:</strong>
                                            <strong class="order_number text-button uppercase">s184989824</strong>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order status:</strong>
                                            <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-yellow text-yellow caption1 font-semibold">Pending</span>
                                        </div>
                                    </div>
                                    <div class="list_prd px-5">
                                        <div class="prd_item flex flex-wrap items-center justify-between gap-3 py-5 border-b border-line">
                                            <a href="{{ route('product.show', $product->slug ?? '#') }}" class="flex items-center gap-5">
                                                <div class="bg-img flex-shrink-0 md:w-[100px] w-20 aspect-square rounded-lg overflow-hidden">
                                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sheepskin sweatshirt" class="w-full h-full object-cover') " />
                                                </div>
                                                <div>
                                                    <div class="prd_name text-title">Contrasting sheepskin sweatshirt</div>
                                                    <div class="caption1 text-secondary mt-2">
                                                        <span class="prd_size uppercase">L</span>
                                                        <span>/</span>
                                                        <span class="prd_color capitalize">Pink</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="text-title">
                                                <span class="prd_quantity">1</span>
                                                <span> X </span>
                                                <span class="prd_price">$69.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-4 p-5">
                                        <button class="button-main btn_order_detail">Order Details</button>
                                        <button class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white">Cancel Order</button>
                                    </div>
                                </div>
                                <div class="order_item mt-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="flex flex-wrap items-center justify-between gap-4 p-5 border-b border-line">
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order Number:</strong>
                                            <strong class="order_number text-button uppercase">s184989824</strong>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order status:</strong>
                                            <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-success text-success caption1 font-semibold">Completed</span>
                                        </div>
                                    </div>
                                    <div class="list_prd px-5">
                                        <div class="prd_item flex flex-wrap items-center justify-between gap-3 py-5 border-b border-line">
                                            <a href="{{ route('product.show', $product->slug ?? '#') }}" class="flex items-center gap-5">
                                                <div class="bg-img flex-shrink-0 md:w-[100px] w-20 aspect-square rounded-lg overflow-hidden">
                                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sheepskin sweatshirt" class="w-full h-full object-cover') " />
                                                </div>
                                                <div>
                                                    <div class="prd_name text-title">Contrasting sheepskin sweatshirt</div>
                                                    <div class="caption1 text-secondary mt-2">
                                                        <span class="prd_size uppercase">L</span>
                                                        <span>/</span>
                                                        <span class="prd_color capitalize">White</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="text-title">
                                                <span class="prd_quantity">1</span>
                                                <span> X </span>
                                                <span class="prd_price">$32.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-4 p-5">
                                        <button class="button-main btn_order_detail">Order Details</button>
                                        <button class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white">Cancel Order</button>
                                    </div>
                                </div>
                                <div class="order_item mt-5 border border-line rounded-lg box-shadow-xs">
                                    <div class="flex flex-wrap items-center justify-between gap-4 p-5 border-b border-line">
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order Number:</strong>
                                            <strong class="order_number text-button uppercase">s184989824</strong>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <strong class="text-title">Order status:</strong>
                                            <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 bg-red text-red caption1 font-semibold">Canceled</span>
                                        </div>
                                    </div>
                                    <div class="list_prd px-5">
                                        <div class="prd_item flex flex-wrap items-center justify-between gap-3 py-5 border-b border-line">
                                            <a href="{{ route('product.show', $product->slug ?? '#') }}" class="flex items-center gap-5">
                                                <div class="bg-img flex-shrink-0 md:w-[100px] w-20 aspect-square rounded-lg overflow-hidden">
                                                    <img src="{{ asset('assets/images/product/1000x1000.png" alt="Contrasting sheepskin sweatshirt" class="w-full h-full object-cover') " />
                                                </div>
                                                <div>
                                                    <div class="prd_name text-title">Contrasting sheepskin sweatshirt</div>
                                                    <div class="caption1 text-secondary mt-2">
                                                        <span class="prd_size uppercase">M</span>
                                                        <span>/</span>
                                                        <span class="prd_color capitalize">Black</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="text-title">
                                                <span class="prd_quantity">1</span>
                                                <span> X </span>
                                                <span class="prd_price">$49.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-4 p-5">
                                        <button class="button-main btn_order_detail">Order Details</button>
                                        <button class="button-main bg-surface border border-line hover:bg-black text-black hover:text-white">Cancel Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item tab_address text-content w-full p-7 border border-line rounded-xl" data-item="address">
                            <form>
                                <button type="button" class="tab_btn flex items-center justify-between w-full pb-1.5 border-b border-line active" data-item="billing">
                                    <strong class="heading6">Billing address</strong>
                                    <span class="ph ph-caret-down text-2xl ic_down duration-300"></span>
                                </button>
                                <div class="form_address active" data-item="billing">
                                    <div class="grid sm:grid-cols-2 gap-4 gap-y-5 mt-5">
                                        <div class="first-name">
                                            <label for="billingFirstName" class="caption1 capitalize">First Name <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingFirstName" type="text" required />
                                        </div>
                                        <div class="last-name">
                                            <label for="billingLastName" class="caption1 capitalize">Last Name <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingLastName" type="text" required />
                                        </div>
                                        <div class="company">
                                            <label for="billingCompany" class="caption1 capitalize">Company name (optional)</label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingCompany" type="text" required />
                                        </div>
                                        <div class="country">
                                            <label for="billingCountry" class="caption1 capitalize">Country / Region <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingCountry" type="text" required />
                                        </div>
                                        <div class="street">
                                            <label for="billingStreet" class="caption1 capitalize">street address <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingStreet" type="text" required />
                                        </div>
                                        <div class="city">
                                            <label for="billingCity" class="caption1 capitalize">Town / city <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingCity" type="text" required />
                                        </div>
                                        <div class="state">
                                            <label for="billingState" class="caption1 capitalize">state <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingState" type="text" required />
                                        </div>
                                        <div class="zip">
                                            <label for="billingZip" class="caption1 capitalize">ZIP <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingZip" type="text" required />
                                        </div>
                                        <div class="phone">
                                            <label for="billingPhone" class="caption1 capitalize">Phone <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingPhone" type="text" required />
                                        </div>
                                        <div class="email">
                                            <label for="billingEmail" class="caption1 capitalize">Email <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="billingEmail" type="email" required />
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="tab_btn flex items-center justify-between w-full mt-10 pb-1.5 border-b border-line" data-item="shipping">
                                    <strong class="heading6">Shipping address</strong>
                                    <span class="ph ph-caret-down text-2xl ic_down duration-300"></span>
                                </button>
                                <div class="form_address" data-item="shipping">
                                    <div class="grid sm:grid-cols-2 gap-4 gap-y-5 mt-5">
                                        <div class="first-name">
                                            <label for="shippingFirstName" class="caption1 capitalize">First Name <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingFirstName" type="text" required />
                                        </div>
                                        <div class="last-name">
                                            <label for="shippingLastName" class="caption1 capitalize">Last Name <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingLastName" type="text" required />
                                        </div>
                                        <div class="company">
                                            <label for="shippingCompany" class="caption1 capitalize">Company name (optional)</label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingCompany" type="text" required />
                                        </div>
                                        <div class="country">
                                            <label for="shippingCountry" class="caption1 capitalize">Country / Region <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingCountry" type="text" required />
                                        </div>
                                        <div class="street">
                                            <label for="shippingStreet" class="caption1 capitalize">street address <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingStreet" type="text" required />
                                        </div>
                                        <div class="city">
                                            <label for="shippingCity" class="caption1 capitalize">Town / city <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingCity" type="text" required />
                                        </div>
                                        <div class="state">
                                            <label for="shippingState" class="caption1 capitalize">state <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingState" type="text" required />
                                        </div>
                                        <div class="zip">
                                            <label for="shippingZip" class="caption1 capitalize">ZIP <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingZip" type="text" required />
                                        </div>
                                        <div class="phone">
                                            <label for="shippingPhone" class="caption1 capitalize">Phone <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingPhone" type="text" required />
                                        </div>
                                        <div class="email">
                                            <label for="shippingEmail" class="caption1 capitalize">Email <span class="text-red">*</span></label>
                                            <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="shippingEmail" type="email" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="block-button lg:mt-10 mt-6">
                                    <button type="submit" class="button-main bg-black">Update Address</button>
                                </div>
                            </form>
                        </div>
                        <div class="filter-item text-content w-full p-7 border border-line rounded-xl" data-item="setting">
                            <form>
                                <div class="heading5 pb-4">Information</div>
                                <div class="upload_image col-span-full">
                                    <label for="uploadImage">Upload Avatar: <span class="text-red">*</span></label>
                                    <div class="flex flex-wrap items-center gap-5 mt-3">
                                        <div class="bg_img flex-shrink-0 relative w-[7.5rem] h-[7.5rem] rounded-lg overflow-hidden bg-surface">
                                            <span class="ph ph-image text-5xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-secondary"></span>
                                            <img src="{{ asset('assets/images/avatar/1.png" alt="avatar" class="upload_img relative z-[1] w-full h-full object-cover') " />
                                        </div>
                                        <div>
                                            <strong class="text-button">Upload File:</strong>
                                            <p class="caption1 text-secondary mt-1">JPG 120x120px</p>
                                            <div class="upload_file flex items-center gap-3 w-[220px] mt-3 px-3 py-2 border border-line rounded">
                                                <label for="uploadImage" class="caption2 py-1 px-3 rounded bg-line whitespace-nowrap cursor-pointer">Choose File</label>
                                                <input type="file" name="uploadImage" id="uploadImage" accept="image/*" class="caption2 cursor-pointer" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-4 gap-y-5 mt-5">
                                    <div class="first-name">
                                        <label for="firstName" class="caption1 capitalize">First Name <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="firstName" type="text" value="Tony" placeholder="First name" required />
                                    </div>
                                    <div class="last-name">
                                        <label for="lastName" class="caption1 capitalize">Last Name <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="lastName" type="text" value="Nguyen" placeholder="Last name" required />
                                    </div>
                                    <div class="phone-number">
                                        <label for="phoneNumber" class="caption1 capitalize">Phone Number <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="phoneNumber" type="text" value="(+12) 345 678 910" placeholder="Phone number" required />
                                    </div>
                                    <div class="email">
                                        <label for="email" class="caption1 capitalize">Email Address <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="email" type="email" value="hi.avitex@gmail.com" placeholder="Email address" required />
                                    </div>
                                    <div class="gender">
                                        <label for="gender" class="caption1 capitalize">Gender <span class="text-red">*</span></label>
                                        <div class="select-block mt-2">
                                            <select class="border border-line px-4 py-3 w-full rounded-lg" id="gender" name="gender" value="default">
                                                <option value="default" disabled>Choose Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <span class="ph ph-caret-down arrow-down text-lg"></span>
                                        </div>
                                    </div>
                                    <div class="birth">
                                        <label for="birth" class="caption1">Day of Birth <span class="text-red">*</span></label>
                                        <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="birth" type="date" placeholder="Day of Birth" required />
                                    </div>
                                </div>
                                <div class="heading5 pb-4 lg:mt-10 mt-6">Change Password</div>
                                <div class="pass">
                                    <label for="password" class="caption1">Current password <span class="text-red">*</span></label>
                                    <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="password" type="password" placeholder="Password *" required />
                                </div>
                                <div class="new-pass mt-5">
                                    <label for="newPassword" class="caption1">New password <span class="text-red">*</span></label>
                                    <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="newPassword" type="password" placeholder="New Password *" required />
                                </div>
                                <div class="confirm-pass mt-5">
                                    <label for="confirmPassword" class="caption1">Confirm new password <span class="text-red">*</span></label>
                                    <input class="border-line mt-2 px-4 py-3 w-full rounded-lg" id="confirmPassword" type="password" placeholder="Confirm Password *" required />
                                </div>
                                <div class="block-button lg:mt-10 mt-6">
                                    <button class="button-main">Save Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
