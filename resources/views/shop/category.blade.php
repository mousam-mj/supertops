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
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between"
                                            >Drinkware
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
                                                        <a href="fashion2.php" class="nav-item-mobile link text-secondary duration-300 active"> Home Fashion 2 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion3.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 3 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion4.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 4 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion5.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 5 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion6.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 6 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion7.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 7 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion8.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 8 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion9.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 9 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion10.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 10 </a>
                                                    </li>
                                                    <li>
                                                        <a href="fashion11.php" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 11 </a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="underwear.php" class="nav-item-mobile link text-secondary duration-300"> Home Underwear </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic1.php" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic2.php" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 2 </a>
                                                    </li>
                                                    <li>
                                                        <a href="cosmetic3.php" class="nav-item-mobile link text-secondary duration-300"> Home Cosmetic 3 </a>
                                                    </li>
                                                    <li>
                                                        <a href="pet.php" class="nav-item-mobile link text-secondary duration-300"> Home Pet Store </a>
                                                    </li>
                                                    <li>
                                                        <a href="jewelry.php" class="nav-item-mobile link text-secondary duration-300"> Home Jewelry </a>
                                                    </li>
                                                    <li>
                                                        <a href="furniture.php" class="nav-item-mobile link text-secondary duration-300"> Home Furniture </a>
                                                    </li>
                                                    <li>
                                                        <a href="watch.php" class="nav-item-mobile link text-secondary duration-300"> Home Watch </a>
                                                    </li>
                                                    <li>
                                                        <a href="toys.php" class="nav-item-mobile link text-secondary duration-300"> Home Toys Kid </a>
                                                    </li>
                                                    <li>
                                                        <a href="yoga.php" class="nav-item-mobile link text-secondary duration-300"> Home Yoga </a>
                                                    </li>
                                                    <li>
                                                        <a href="organic.php" class="nav-item-mobile link text-secondary duration-300"> Home Organic </a>
                                                    </li>
                                                    <li>
                                                        <a href="marketplace.php" class="nav-item-mobile link text-secondary duration-300"> Home Marketplace </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#!" class="text-xl font-semibold flex items-center justify-between mt-5"
                                            >Barware
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
                                            >Kitchenware
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
                <a href="{{ route('category', $category->slug) }}" class="absolute bottom-8 left-1/2 -translate-x-1/2 button-main z-10">{{ $heroButtonText }}</a>
            </div> 
        </div> 
            
        </div>
         
        @php
            $additionalBannerImage = $category->additional_banner_image ?? ($mainCategory->additional_banner_image ?? null);
            $additionalBannerText = $category->additional_banner_text ?? ($mainCategory->additional_banner_text ?? null);
        @endphp
        <div class="banner-block relative">
            <div class="list-banner">
                <a href="{{ route('category', $category->slug) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
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
            $defaultCollectionTexts = ['Drinkware', 'Barware', 'Kitchenware'];
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
                                    $slugForLookup = \Illuminate\Support\Str::slug($collectionText);
                                    $catForCard = \App\Models\Category::where('is_active', true)->where('name', $collectionText)->first()
                                        ?? \App\Models\Category::where('is_active', true)->whereRaw('LOWER(slug) = ?', [strtolower($slugForLookup)])->first();
                                    if (!$catForCard && in_array(strtolower($collectionText), ['kichenware', 'kitchenware'])) {
                                        $catForCard = \App\Models\Category::where('is_active', true)->where('name', 'Kitchenware')->first()
                                            ?? \App\Models\Category::where('is_active', true)->whereRaw('LOWER(slug) IN (?, ?)', ['kitchenware', 'kichenware'])->first();
                                    }
                                    $collectionSlug = $catForCard ? $catForCard->slug : $category->slug;
                                @endphp
                                <a href="{{ route('category', $collectionSlug) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
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

        
        <div class="what-new-block filter-product-block md:pt-20 pt-10" data-filter-type="main-category">
            <div class="container">
                <div class="heading flex flex-col items-center text-center">
                    <div class="heading3">What's new</div>
                    <div class="menu-tab bg-surface rounded-2xl mt-6">
                        <div class="menu flex items-center gap-2 p-1 relative">
                            <div class="indicator absolute top-1 bottom-1 bg-white rounded-full shadow-md duration-300"></div>
                            <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black active" data-item="all">All</div>
                            @foreach($mainCategories ?? [] as $mainCat)
                                <div class="tab-item relative text-secondary text-button-uppercase py-2 px-5 cursor-pointer duration-300 hover:text-black" data-item="{{ $mainCat->slug }}">{{ $mainCat->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="list-product four-product hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 md:mt-10 mt-6">
                    @forelse($featuredProducts as $product)
                        <div class="what-new-product-wrap" data-main-category="{{ $product->category->mainCategory->slug ?? 'all' }}">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-secondary">No products available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
        (function() {
            var block = document.querySelector('.what-new-block[data-filter-type="main-category"]');
            if (!block) return;
            var tabs = block.querySelectorAll('.menu-tab .tab-item[data-item]');
            var wraps = block.querySelectorAll('.what-new-product-wrap');
            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    var slug = this.getAttribute('data-item');
                    block.querySelectorAll('.menu-tab .tab-item').forEach(function(t){ t.classList.remove('active'); });
                    this.classList.add('active');
                    wraps.forEach(function(w) {
                        var cat = w.getAttribute('data-main-category');
                        if (slug === 'all' || cat === slug) { w.style.display = ''; } else { w.style.display = 'none'; }
                    });
                });
            });
        })();
        </script>
        @endpush

        <div class="banner-block relative">
            <div class="list-banner">
                <a href="{{ route('category', $category->slug) }}" class="banner-item relative bg-surface block overflow-hidden duration-500">
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
                        <a href="{{ route('category', $category->slug) }}" class="button-main md:mt-7 mt-3">{{ $heroButtonText }}</a>
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
                        <a href="{{ route('category', $category->slug) }}" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
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
                        <a href="{{ route('category', $category->slug) }}" class="button-main md:mt-8 mt-3" tabindex="0">Shop Now</a>
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
