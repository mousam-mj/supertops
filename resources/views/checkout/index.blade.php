@extends('layouts.app')

@section('title', 'Checkout - Perch Bottle')

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
                                                                <a href="{{ route('my-account') }}" class="link text-secondary duration-300"> My Account </a>
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
                    <div class="container lg:pt-12 pt-10 pb-4 relative">
                        <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                            <div class="text-content">
                                <div class="heading2 text-center">Checkout</div>
                                <div class="link flex items-center justify-center gap-1 caption1 mt-2">
                                    <a href="{{ route('home') }}">Homepage</a>
                                    <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                    <div class="text-secondary2 capitalize">Checkout</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="checkout-block md:py-8 py-6">
            <div class="container">
                <div class="content-main flex max-lg:flex-col-reverse gap-y-10 justify-between">
                    <div class="left lg:w-1/2">
                        <div class="login bg-surface py-3 px-4 flex justify-between rounded-lg">
                            <div class="left flex items-center"><span class="text-on-surface-variant1 pr-4">Already have an account? </span><span class="text-button text-on-surface hover-underline cursor-pointer hover:underline">Login</span></div>
                            <div class="right"><i class="ph ph-caret-down fs-20 cursor-pointer"></i></div>
                        </div>
                        <div class="form-login-block mt-3">
                            <form class="p-5 border border-line rounded-lg">
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
                                            <input class="border-line px-4 py-3 w-full rounded-lg" id="phoneNumber" type="number" placeholder="Phone Numbers *" value="{{ $user->phone ?? ($defaultAddress->phone ?? '') }}" required />
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
                                        <div class="heading5">Choose payment Option:</div>
                                        <div class="list-payment mt-5">
                                            <div class="type bg-surface p-5 border border-line rounded-lg">
                                                <input class="cursor-pointer" type="radio" id="test" name="payment" value="test" checked />
                                                <label class="text-button pl-2 cursor-pointer" for="test">Test Payment (For Testing)</label>
                                                <div class="infor">
                                                    <div class="text-on-surface-variant1 pt-4">This is a test payment method. No actual payment will be processed. Order will be placed successfully.</div>
                                                </div>
                                            </div>
                                            <div class="type bg-surface p-5 border border-line rounded-lg mt-5">
                                                <input class="cursor-pointer" type="radio" id="credit" name="payment" value="razorpay" />
                                                <label class="text-button pl-2 cursor-pointer" for="credit">Credit Card</label>
                                                <div class="infor">
                                                    <div class="text-on-surface-variant1 pt-4">Make your payment directly into our bank account. Your order will not be shipped until the funds have cleared in our account.</div>
                                                    <div class="row">
                                                        <div class="col-12 mt-3">
                                                            <label for="cardNumberCredit">Card Numbers</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="cardNumberCredit" placeholder="ex.1234567290" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="dateCredit">Date</label>
                                                            <input class="border-line px-4 py-3 w-full rounded mt-2" type="date" id="dateCredit" name="date" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="ccvCredit">CCV</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="ccvCredit" placeholder="****" />
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-3">
                                                        <input type="checkbox" id="saveCredit" name="save" />
                                                        <label class="text-button" for="saveCredit">Save Card Details</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="type bg-surface p-5 border border-line rounded-lg mt-5">
                                                <input class="cursor-pointer" type="radio" id="delivery" name="payment" value="cod" />
                                                <label class="text-button pl-2 cursor-pointer" for="delivery">Cash on delivery</label>
                                                <div class="infor">
                                                    <div class="text-on-surface-variant1 pt-4">Make your payment directly into our bank account. Your order will not be shipped until the funds have cleared in our account.</div>
                                                    <div class="row">
                                                        <div class="col-12 mt-3">
                                                            <label for="cardNumberDelivery">Card Numbers</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="cardNumberDelivery" placeholder="ex.1234567290" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="dateDelivery">Date</label>
                                                            <input class="border-line px-4 py-3 w-full rounded mt-2" type="date" id="dateDelivery" name="date" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="ccvDelivery">CCV</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="ccvDelivery" placeholder="****" />
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-3">
                                                        <input type="checkbox" id="saveDelivery" name="save" />
                                                        <label class="text-button" for="saveDelivery">Save Card Details</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="type bg-surface p-5 border border-line rounded-lg mt-5">
                                                <input class="cursor-pointer" type="radio" id="apple" name="payment" />
                                                <label class="text-button pl-2 cursor-pointer" for="apple">Apple Pay</label>
                                                <div class="infor">
                                                    <div class="text-on-surface-variant1 pt-4">Make your payment directly into our bank account. Your order will not be shipped until the funds have cleared in our account.</div>
                                                    <div class="row">
                                                        <div class="col-12 mt-3">
                                                            <label for="cardNumberApple">Card Numbers</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="cardNumberApple" placeholder="ex.1234567290" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="dateApple">Date</label>
                                                            <input class="border-line px-4 py-3 w-full rounded mt-2" type="date" id="dateApple" name="date" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="ccvApple">CCV</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="ccvApple" placeholder="****" />
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-3">
                                                        <input type="checkbox" id="saveApple" name="save" />
                                                        <label class="text-button" for="saveApple">Save Card Details</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="type bg-surface p-5 border border-line rounded-lg mt-5">
                                                <input class="cursor-pointer" type="radio" id="paypal" name="payment" />
                                                <label class="text-button pl-2 cursor-pointer" for="paypal">PayPal</label>
                                                <div class="infor">
                                                    <div class="text-on-surface-variant1 pt-4">Make your payment directly into our bank account. Your order will not be shipped until the funds have cleared in our account.</div>
                                                    <div class="row">
                                                        <div class="col-12 mt-3">
                                                            <label for="cardNumberPaypal">Card Numbers</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="cardNumberPaypal" placeholder="ex.1234567290" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="datePaypal">Date</label>
                                                            <input class="border-line px-4 py-3 w-full rounded mt-2" type="date" id="datePaypal" name="date" />
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="ccvPaypal">CCV</label>
                                                            <input class="cursor-pointer border-line px-4 py-3 w-full rounded mt-2" type="text" id="ccvPaypal" placeholder="****" />
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-3">
                                                        <input type="checkbox" id="savePaypal" name="save" />
                                                        <label class="text-button" for="savePaypal">Save Card Details</label>
                                                    </div>
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
                        <div class="checkout-block">
                            <div class="heading5 pb-3">Your Order</div>
                            <div class="list-product-checkout"></div>
                            <div class="discount-block py-5 flex justify-between border-b border-line">
                                <div class="text-title">Discounts</div>
                                <div class="text-title">-$<span class="discount">0</span><span>.00</span></div>
                            </div>
                            <div class="ship-block py-5 flex justify-between border-b border-line">
                                <div class="text-title">Shipping</div>
                                <div class="text-title">Free</div>
                            </div>
                            <div class="total-cart-block pt-5 flex justify-between">
                                <div class="heading5">Total</div>
                                <div class="heading5 total-cart">$0.00</div>
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
        const errorMessage = errors.join('\\n');
        alert('Please fix the following errors:\\n\\n' + errorMessage);
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
        payment_method: document.querySelector('input[name="payment"]:checked')?.value || 'test'
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
    
    // Prepare order data based on login status
    let orderData;
    if (isLoggedIn) {
        // For logged in users, send shipping_address
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
            payment_method: formData.payment_method || 'test',
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
    
    // Submit order
    fetch('/api/orders', {
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
                    const errorList = Object.values(err.errors).flat().join('\\n');
                    errorMessage = errorMessage + '\\n\\n' + errorList;
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
