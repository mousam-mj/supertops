@extends('layouts.app')

@section('title', 'Register - Perch Bottle')

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
                                                                <a href="{{ route('login') }}" class="link text-secondary duration-300 active"> Login/Register </a>
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
                    <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                        <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                            <div class="text-content">
                                <div class="heading2 text-center">Register</div>
                                <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                                    <a href="{{ route('home') }}">Homepage</a>
                                    <i class="ph ph-caret-right text-sm text-secondary2"></i>
                                    <div class="text-secondary2 capitalize">Register</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-block md:py-20 py-10">
            <div class="container">
                <div class="content-main flex gap-y-8 max-md:flex-col">
                    <div class="left md:w-1/2 w-full lg:pr-[60px] md:pr-[40px] md:border-r border-line">
                        <div class="heading4">Create Account</div>
                        
                        <!-- General Error Message -->
                        <div id="general-error" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                <div class="flex-1">
                                    <div class="font-medium text-red-800 mb-2" id="general-error-title">Registration Failed</div>
                                    <div class="text-sm text-red-700" id="general-error-message"></div>
                                </div>
                            </div>
                        </div>
                        
                        <form class="md:mt-7 mt-4" id="mobile-register-form">
                            <div class="name">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reg-name" type="text" placeholder="Full Name *" required />
                                <!-- Name Error Message -->
                                <div id="name-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                        <div class="text-sm font-medium text-red-800" id="name-error-message"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mobile mt-5">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reg-mobile" type="tel" placeholder="Mobile Number (10 digits) *" maxlength="10" required />
                                <!-- Mobile Error Message -->
                                <div id="mobile-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                        <div class="text-sm font-medium text-red-800" id="mobile-error-message"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="email mt-5">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reg-email" type="email" placeholder="Email Address *" required />
                                <!-- Email Error Message -->
                                <div id="email-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                        <div class="text-sm font-medium text-red-800" id="email-error-message"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="password mt-5">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reg-password" type="password" placeholder="Password *" required />
                                <!-- Password Error Message -->
                                <div id="password-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                        <div class="text-sm font-medium text-red-800" id="password-error-message"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="confirm-password mt-5">
                                <input class="border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reg-confirm-password" type="password" placeholder="Confirm Password *" required />
                                <!-- Confirm Password Error Message -->
                                <div id="confirm-password-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <i class="ph ph-warning-circle text-red-600 text-lg mt-0.5"></i>
                                        <div class="text-sm font-medium text-red-800" id="confirm-password-error-message"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="block-input">
                                    <input type="checkbox" name="agree" id="agree" required />
                                    <i class="ph-fill ph-check-square icon-checkbox text-2xl"></i>
                                </div>
                                <label for="agree" class="pl-2 cursor-pointer text-secondary2"
                                    >I agree to the
                                    <a href="#!" class="text-black hover:underline pl-1">Terms of User</a>
                                </label>
                            </div>
                            <div class="block-button md:mt-7 mt-4">
                                <button type="submit" class="button-main w-full bg-black text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-800 transition-colors" id="send-otp-btn" style="display: block !important; visibility: visible !important;">Send OTP</button>
                            </div>
                        </form>
                        
                        <!-- OTP Verification Section (Hidden Initially) -->
                        <div id="otp-verification-section" class="hidden mt-8 p-6 bg-gray-50 rounded-lg">
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="ph ph-device-mobile text-green-600 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Verify Your Mobile Number</h3>
                                <p class="text-gray-600">We've sent a 6-digit OTP to</p>
                                <p class="font-semibold text-gray-900" id="reg-mobile-display">+91 XXXXXXXXXX</p>
                                
                                <!-- Development OTP Display -->
                                <div id="dev-otp-display" class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                                    <div class="text-sm font-medium text-yellow-800 mb-1">🧪 Development Mode - Test OTP:</div>
                                    <div class="text-2xl font-mono font-bold text-yellow-900 tracking-wider" id="dev-otp-code"></div>
                                    <div class="text-xs text-yellow-700 mt-1">Copy this OTP to test the verification</div>
                                </div>
                            </div>
                            
                            <form id="otp-verify-form">
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter OTP</label>
                                    <input type="text" id="reg-otp-input" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center text-lg font-mono tracking-widest" placeholder="000000" maxlength="6" required>
                                    <div id="reg-otp-error" class="text-red-600 text-sm mt-2 hidden"></div>
                                </div>
                                
                                <div class="flex gap-3 mb-4">
                                    <button type="submit" class="flex-1 bg-black text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                        Complete Registration
                                    </button>
                                    <button type="button" id="reg-resend-otp-btn" class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors disabled:opacity-50" disabled>
                                        Resend
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <button type="button" id="back-to-form-btn" class="text-gray-500 hover:text-gray-700">
                                        Back to Form
                                    </button>
                                </div>
                                
                                <div id="reg-otp-timer" class="text-center text-sm text-gray-500 mt-4">
                                    Resend OTP in <span id="reg-timer-count">60</span> seconds
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="right md:w-1/2 w-full lg:pl-[60px] md:pl-[40px] flex items-center">
                        <div class="text-content">
                            <div class="heading4">Already have an account?</div>
                                <div class="text-secondary">Welcome back. Sign in to access your personalized experience, saved preferences, and more. We{String.raw`'re`} thrilled to have you with us again!</div>
                                <div class="block-button md:mt-7 mt-4">
                                    <a href="{{ route('login') }}" class="button-main">Login</a>
                                </div>
                                
                                <!-- Helper text -->
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-700">
                                        <i class="ph ph-info mr-1"></i>
                                        If your mobile number or email is already registered, please use the login option instead.
                                    </p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<style>
/* Ensure Send OTP button is always visible */
#send-otp-btn {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    background-color: #000 !important;
    color: white !important;
    border: none !important;
    padding: 12px 16px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    width: 100% !important;
    cursor: pointer !important;
}

#send-otp-btn:hover {
    background-color: #333 !important;
}

#send-otp-btn:disabled {
    background-color: #666 !important;
    cursor: not-allowed !important;
}

/* Ensure form is visible */
#mobile-register-form {
    display: block !important;
    visibility: visible !important;
}

.button-main {
    display: block !important;
    visibility: visible !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let registrationMobile = '';
    
    // Helper functions to show errors in UI
    function clearAllErrors() {
        // Hide all error containers
        const errorElements = ['general-error', 'name-error', 'mobile-error', 'email-error', 'password-error', 'confirm-password-error'];
        errorElements.forEach(id => {
            const element = document.getElementById(id);
            if (element) element.classList.add('hidden');
        });
    }
    
    function showGeneralError(message, title = 'Registration Failed') {
        clearAllErrors();
        const titleElement = document.getElementById('general-error-title');
        const messageElement = document.getElementById('general-error-message');
        const containerElement = document.getElementById('general-error');
        
        if (titleElement) titleElement.textContent = title;
        if (messageElement) messageElement.textContent = message;
        if (containerElement) {
            containerElement.classList.remove('hidden');
            containerElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    function showFieldError(field, message) {
        const errorContainer = document.getElementById(field + '-error');
        const errorMessage = document.getElementById(field + '-error-message');
        
        if (errorContainer && errorMessage) {
            errorMessage.textContent = message;
            errorContainer.classList.remove('hidden');
        }
    }
    
    function showRegistrationErrors(data) {
        clearAllErrors();
        
        let mainMessage = data.message || 'Registration failed';
        
        // Show field-specific errors
        if (data.errors) {
            console.log('Validation errors:', data.errors);
            
            if (data.errors.mobile) {
                showFieldError('mobile', data.errors.mobile.join(', '));
            }
            if (data.errors.name) {
                showFieldError('name', data.errors.name.join(', '));
            }
            if (data.errors.email) {
                showFieldError('email', data.errors.email.join(', '));
            }
            if (data.errors.password) {
                showFieldError('password', data.errors.password.join(', '));
            }
            if (data.errors.password_confirmation) {
                showFieldError('confirm-password', data.errors.password_confirmation.join(', '));
            }
        }
        
        // Show general error with helpful message
        if (mainMessage.includes('already registered')) {
            showGeneralError('This mobile number or email is already registered. Please use the login option instead.', 'Account Already Exists');
        } else {
            showGeneralError(mainMessage);
        }
    }
    
    // Ensure Send OTP button is visible on page load
    const sendOtpBtn = document.getElementById('send-otp-btn');
    if (sendOtpBtn) {
        sendOtpBtn.style.display = 'block';
        sendOtpBtn.style.visibility = 'visible';
        sendOtpBtn.style.opacity = '1';
        sendOtpBtn.style.backgroundColor = '#000';
        sendOtpBtn.style.color = 'white';
        sendOtpBtn.style.border = 'none';
        sendOtpBtn.style.padding = '12px 16px';
        sendOtpBtn.style.borderRadius = '8px';
        sendOtpBtn.style.fontWeight = '600';
        sendOtpBtn.style.width = '100%';
        sendOtpBtn.style.cursor = 'pointer';
        sendOtpBtn.textContent = 'Send OTP';
        console.log('Send OTP button initialized and made visible');
    } else {
        console.error('Send OTP button not found!');
    }
    
    // Also ensure the form is visible
    const registerForm = document.getElementById('mobile-register-form');
    if (registerForm) {
        registerForm.style.display = 'block';
        registerForm.style.visibility = 'visible';
        console.log('Registration form made visible');
    }
    
    // Additional timeout to override any conflicting styles
    setTimeout(() => {
        const btn = document.getElementById('send-otp-btn');
        if (btn) {
            btn.style.display = 'block !important';
            btn.style.visibility = 'visible !important';
            btn.style.opacity = '1 !important';
            btn.classList.remove('hidden');
            console.log('Button visibility enforced with timeout');
        }
    }, 100);
    
    // Mobile Registration Form
    document.getElementById('mobile-register-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('reg-name').value.trim();
        const mobile = document.getElementById('reg-mobile').value.trim();
        const email = document.getElementById('reg-email').value.trim();
        const password = document.getElementById('reg-password').value.trim();
        const confirmPassword = document.getElementById('reg-confirm-password').value.trim();
        const agree = document.getElementById('agree').checked;
        
        // Clear any existing errors
        clearAllErrors();
        
        // Validate required fields
        if (!name || !mobile || !email || !password || !confirmPassword || !agree) {
            showGeneralError('Please fill all required fields and agree to terms', 'Missing Information');
            return;
        }
        
        // Validate password match
        if (password !== confirmPassword) {
            showFieldError('confirm-password', 'Passwords do not match');
            return;
        }
        
        // Validate password strength
        if (password.length < 6) {
            showFieldError('password', 'Password must be at least 6 characters long');
            return;
        }
        
        if (mobile.length !== 10 || !/^[6-9]\d{9}$/.test(mobile)) {
            alert('Please enter a valid 10-digit mobile number');
            return;
        }
        
        registrationMobile = mobile;
        
        // Debug the request data
        const requestData = {
            name: name,
            mobile: mobile,
            email: email
        };
        console.log('Sending registration request:', requestData);
        
        // Send OTP for registration
        fetch('/api/auth/register/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                name: name,
                mobile: mobile,
                email: email,
                password: password,
                password_confirmation: confirmPassword
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            // Always try to parse JSON, regardless of status
            return response.json();
        })
        .then(data => {
            console.log('Registration OTP Response:', data);
            
            // Handle both success and error responses
            if (data && data.success) {
                // Show OTP verification section
                document.getElementById('mobile-register-form').style.display = 'none';
                document.getElementById('otp-verification-section').classList.remove('hidden');
                document.getElementById('reg-mobile-display').textContent = `+91 ${mobile}`;
                document.getElementById('reg-otp-input').focus();
                startRegistrationTimer();
                
                // Show OTP in development mode for testing
                if (data.otp) {
                    console.log('Development OTP:', data.otp);
                    const otpCodeElement = document.getElementById('dev-otp-code');
                    const otpDisplayElement = document.getElementById('dev-otp-display');
                    const otpInput = document.getElementById('reg-otp-input');
                    
                    if (otpCodeElement && otpDisplayElement) {
                        otpCodeElement.textContent = data.otp;
                        otpDisplayElement.classList.remove('hidden');
                    }
                    
                    // Auto-fill OTP for development/testing
                    if (otpInput) {
                        otpInput.value = data.otp;
                        // Auto-submit after a short delay
                        setTimeout(() => {
                            document.getElementById('otp-verify-form').dispatchEvent(new Event('submit'));
                        }, 1500);
                    }
                }
            } else if (data && data.success === false) {
                // Handle error response - show in UI
                showRegistrationErrors(data);
            } else {
                // Handle unexpected response format
                console.error('Unexpected response format:', data);
                showGeneralError('Unexpected response from server. Please try again.');
            }
        })
        .catch(error => {
            console.error('Registration OTP Error:', error);
            console.error('Error details:', error.message);
            
            // Check if it's a network error or server response error
            if (error.message && error.message.includes('HTTP error! status:')) {
                showGeneralError('There was an issue with your request. Please try again.', 'Request Failed');
            } else {
                showGeneralError('Failed to send OTP. Please check your internet connection and try again.', 'Connection Error');
            }
        });
    });
    
    // OTP Verification Form
    document.getElementById('otp-verify-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const otp = document.getElementById('reg-otp-input').value.trim();
        
        if (otp.length !== 6) {
            showOTPError('Please enter a valid 6-digit OTP');
            return;
        }
        
        // Verify OTP and complete registration
        fetch('/api/auth/register/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                mobile: registrationMobile,
                otp: otp
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect automatically without alert
                const redirectUrl = data.redirect_url || '{{ route("home") }}';
                window.location.replace(redirectUrl);
            } else {
                showOTPError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showOTPError('Verification failed. Please try again.');
        });
    });
    
    // Resend OTP
    document.getElementById('reg-resend-otp-btn').addEventListener('click', function() {
        if (this.disabled) return;
        
        fetch('/api/auth/register/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                name: document.getElementById('reg-name').value,
                mobile: registrationMobile,
                email: document.getElementById('reg-email').value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                startRegistrationTimer();
                alert('OTP resent successfully!');
            } else {
                alert('Failed to resend OTP: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to resend OTP. Please try again.');
        });
    });
    
    // Back to form
    document.getElementById('back-to-form-btn').addEventListener('click', function() {
        document.getElementById('otp-verification-section').classList.add('hidden');
        document.getElementById('mobile-register-form').style.display = 'block';
        document.getElementById('reg-otp-input').value = '';
        hideOTPError();
    });
    
    // Auto-verify on 6 digits
    document.getElementById('reg-otp-input').addEventListener('input', function() {
        const otp = this.value.trim();
        hideOTPError();
        
        if (otp.length === 6) {
            document.getElementById('otp-verify-form').dispatchEvent(new Event('submit'));
        }
    });
    
    // Helper functions
    function startRegistrationTimer() {
        let timeLeft = 60;
        const timerElement = document.getElementById('reg-timer-count');
        const resendBtn = document.getElementById('reg-resend-otp-btn');
        
        resendBtn.disabled = true;
        
        const timer = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                document.getElementById('reg-otp-timer').innerHTML = 'You can now resend OTP';
            }
        }, 1000);
    }
    
    function showOTPError(message) {
        const errorElement = document.getElementById('reg-otp-error');
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }
    
    function hideOTPError() {
        document.getElementById('reg-otp-error').classList.add('hidden');
    }
    
    // Clear errors when user starts typing
    ['reg-name', 'reg-mobile', 'reg-email', 'reg-password', 'reg-confirm-password'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                clearAllErrors();
            });
        }
    });
    
    // Mobile number formatting
    document.getElementById('reg-mobile').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});
</script>
@endsection
