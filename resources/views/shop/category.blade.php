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
                                <a href="{ route('home') }" class="logo text-3xl font-semibold text-center">Perch</a>
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
                                                        <a href="{ route('home') }" class="nav-item-mobile link text-secondary duration-300"> Home Fashion 1 </a>
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
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Starting From 50% Off </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Outerwear | Coats </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Sweaters | Cardigans </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Shirt | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Skincare</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Faces Skin </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Eyes Makeup </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Lip Polish </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Hair Care </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Health</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Cented Candle </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Health Drinks </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Yoga Clothes </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Yoga Equipment </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Women</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Starting From 60% Off </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Dresses | Jumpsuits </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> T-shirts | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Accessories | Jewelry </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Kid</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Kids Bed </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Boy's Toy </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Baby Blanket </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Newborn Clothing </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">For Home</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Furniture | Decor </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Table | Living Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Chair | Work Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Lighting | Bed Room </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 view-all-btn"> View All </a>
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
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Breadcrumb IMG </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Breadcrumb 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Breadcrumb 2 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Collection </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Filter Canvas </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Filter Options </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Filter Dropdown </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Sidebar List </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Shop Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Shop Default </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Shop Default Grid </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Shop Default List </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300 cursor-pointer"> Shop Full Width </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('shop') }" class="link text-secondary duration-300"> Shop Square </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Pages</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('wishlist') }" class="link text-secondary duration-300"> Wish List </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('search') }" class="link text-secondary duration-300"> Search Result </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('cart.index') }" class="link text-secondary duration-300"> Shopping Cart </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('login') }" class="link text-secondary duration-300"> Login/Register </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('forgot-password') }" class="link text-secondary duration-300"> Forgot Password </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('order-tracking') }" class="link text-secondary duration-300"> Order Tracking </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('my-account') }" class="link text-secondary duration-300"> My Account </a>
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
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Defaults </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Countdown Timer </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Grouped </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Frequently Bought Together </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Out Of Stock </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Variable </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Features</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products External </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products On Sale </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products With Discount </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products With Sidebar </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300"> Products Fixed Price </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Layout</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Left </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Thumbnails Bottom </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Grid 1 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Grid 2 Scrolling </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Combined 1 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Combined 2 </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-1">Products Styles</div>
                                                        <ul>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Style 01 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Style 02 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Style 03 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Style 04 </a>
                                                            </li>
                                                            <li>
                                                                <a href="{ route('product.show', $product->slug ?? '#') }" class="link text-secondary duration-300 cursor-pointer"> Products Style 05 </a>
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
                                                        <a href="{ route('blog') }" class="link text-secondary duration-300"> Blog Default </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('blog') }" class="link text-secondary duration-300"> Blog List </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('blog') }" class="link text-secondary duration-300"> Blog Grid </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('blog.show', $post->slug ?? '#') }" class="link text-secondary duration-300"> Blog Detail 1 </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('blog.show', $post->slug ?? '#') }" class="link text-secondary duration-300"> Blog Detail 2 </a>
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
                                                        <a href="{ route('about') }" class="link text-secondary duration-300"> About Us </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('contact') }" class="link text-secondary duration-300"> Contact Us </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('stores') }" class="link text-secondary duration-300"> Store List </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('404') }" class="link text-secondary duration-300"> 404 </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('faqs') }" class="link text-secondary duration-300"> FAQs </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('coming-soon') }" class="link text-secondary duration-300"> Coming Soon </a>
                                                    </li>
                                                    <li>
                                                        <a href="{ route('feedbacks') }" class="link text-secondary duration-300"> Customer Feedbacks </a>
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
                    <a href="{ route('home') }" class="menu_bar-link flex flex-col items-center gap-1">
                        <span class="ph-bold ph-house text-2xl block"></span>
                        <span class="menu_bar-title caption2 font-semibold">Home</span>
                    </a>
                    <a href="{ route('shop') }" class="menu_bar-link flex flex-col items-center gap-1">
                        <span class="ph-bold ph-list text-2xl block"></span>
                        <span class="menu_bar-title caption2 font-semibold">Category</span>
                    </a>
                    <a href="{ route('search') }" class="menu_bar-link flex flex-col items-center gap-1">
                        <span class="ph-bold ph-magnifying-glass text-2xl block"></span>
                        <span class="menu_bar-title caption2 font-semibold">Search</span>
                    </a>
                    <a href="{ route('cart.index') }" class="menu_bar-link flex flex-col items-center gap-1">
                        <div class="cart-icon relative">
                            <span class="ph-bold ph-handbag text-2xl block"></span>
                            <span class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                        </div>
                        <span class="menu_bar-title caption2 font-semibold">Cart</span>
                    </a>
                </div>
            </div>
            <div class="list-banner sm:-mt-[75px]">
                    <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/slider/11b-scaled.webp" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">Palettes</div>
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                
            </div> 
        </div> 
            
        </div>
         
        <div class="banner-block relative">
           
                <div class="list-banner">
                    <a href="/shop-breadcrumb1.html" class="banner-item relative bg-surface block  overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/slider/09-1-scaled.webp" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">Palettes</div>
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                </div>
            
        </div>
        <div class="collection-block mt-5">
            
            <div class="list-collection relative section-swiper-navigation sm:px-5 px-4">
                <div class="banner-block md:pt-20 pt-10">
            <div class="container">
                <div class="list-banner grid md:grid-cols-3 gap-[20px]">
                    <a href="{ route('shop') }" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/product/Bottle-1.webp" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Drinkware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{ route('shop') }" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/product/Bottle-4.webp" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Barware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{ route('shop') }" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/product/Bottle-8.webp" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Kichenware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{ route('shop') }" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/product/Bottle-1.webp" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Drinkware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{ route('shop') }" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/product/Bottle-4.webp" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Barware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                    <a href="{ route('shop') }" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/product/Bottle-8.webp" alt="bg-img" class="w-full duration-500" />
                        </div>
                        <div class="heading4 absolute top-8 left-1/2 -translate-x-1/2 whitespace-nowrap">Kichenware</div>
                        <div class="button-main absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
                </div>
            </div>
        </div>
        
            </div>
        </div>

        <div class="quote-block bg-linear py-[60px] mt-10">
            <div class="container flex items-center justify-center">
                <div class="heading3 md:leading-[50px] font-medium lg:w-3/4 px-4 text-center">"I absolutely love this shop! The products are high-quality and the customer service is excellent. I always leave with exactly what I need and a smile on my face."</div>
            </div>
        </div>

        <div class="banner-block relative">
           
                <div class="list-banner">
                    <a href="/shop-breadcrumb1.html" class="banner-item relative bg-surface block  overflow-hidden duration-500">
                        <div class="banner-img w-full">
                            <img src="{{ asset(\'assets/images/slider/03b-scaled.webp" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="heading4 absolute bottom-12 left-1/2 -translate-x-1/2 whitespace-nowrap">Palettes</div>
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2">Shop Now</div>
                    </a>
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
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
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
                                        <img src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                                    </div>
                                </div>

                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">$30.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$42.00</del>
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
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
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
                                    <div class="product-price text-title">$40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$50.00</del>
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
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
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
                                        <img src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Yellow</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Red</div>
                                    </div>
                                    <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                                        <img src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="color" class="rounded-xl w-full h-full object-cover" />
                                        <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">Green</div>
                                    </div>
                                </div>

                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
                                    <div class="product-price text-title">$30.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$42.00</del>
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
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
                                    <img class="w-full h-full object-cover duration-700" src="{{ asset(\'assets/images/product/perch-bottal.webp" alt="img" />
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
                                    <div class="product-price text-title">$40.00</div>
                                    <div class="product-origin-price caption1 text-secondary2">
                                        <del>$50.00</del>
                                    </div>
                                    <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="banner-block style-toys-kids">
            <div class="container">
                <div class="content md:rounded-[28px] rounded-2xl overflow-hidden relative">
                    <img src="{{ asset(\'assets/images/banner/bg-banner-toys.png" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover z-[-1]">
                    <div class="text-content xl:w-1/3 w-2/3 xl:pl-[120px] md:pl-20 pl-10 md:py-[85px] py-12">
                        <div class="text-sub-display">Sale Up To 50% Off Today!</div>
                        <div class="heading2 md:mt-4 mt-2">Created to be loved for a lifetime</div>
                        <a href="/shop-breadcrumb-img.html" class="button-main md:mt-7 mt-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="banner-block pt-5 px-5">
            <div class="container">
            <div class="list-banner grid lg:grid-cols-2 sm:grid-cols-2 gap-[20px]">
                <a href="/shop-breadcrumb1.html" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ asset(\'assets/images/banner/perch123(2).webp" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="banner-content absolute left-[30px] bottom-[30px]">
                        <div class="heading4">Check &amp; Coutour</div>
                        <div class="text-button text-black relative inline-block pb-1 border-b-2 border-black duration-500 mt-2">Shop Now</div>
                    </div>
                </a>
                <a href="/shop-breadcrumb1.html" class="banner-item relative bg-surface block rounded-[20px] overflow-hidden duration-500">
                    <div class="banner-img w-full">
                        <img src="{{ asset(\'assets/images/banner/perch123(2).webp" alt="bg-img" class="w-full duration-500">
                    </div>
                    <div class="banner-content absolute left-[30px] bottom-[30px]">
                        <div class="heading4">Palettes</div>
                        <div class="text-button text-black relative inline-block pb-1 border-b-2 border-black duration-500 mt-2">Shop Now</div>
                    </div>
                </a>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="slider-item slick-slide slick-current slick-active" >

                                <div class="bg-[#EBFCF5] h-full w-full relative flex max-sm:flex-col-reverse items-center lg:rounded-[40px] rounded-xl overflow-hidden mt-10">
                                    <img src="{{ asset(\'assets/images/slider/bg-toys.png" alt="bg" class="absolute top-0 left-0 w-full h-full object-cover">
                                    <div class="text-content sm:w-1/3 max-sm:pt-10 max-sm:pb-[40px] flex flex-col items-center justify-center z-[1]">
                                        <div class="text-sub-display">Sale! Up To 50% Off!</div>
                                        <div class="heading1 text-center md:mt-4 mt-2">Perch Bottle <br class="max-xl:hidden">on sale</div>
                                        <a href="/shop-breadcrumb-img.html" class="button-main md:mt-8 mt-3" tabindex="0">Shop Now</a>
                                    </div>
                                    <div class="sub-img sm:w-2/3 w-full h-full sm:pl-10">
                                        <img src="{{ asset(\'assets/images/banner/perch123(1).webp" alt="bg-toys1" class="w-full h-full object-cover z-[1] relative">
                                    </div>
                                <div style="position: absolute; top: 8px; left: 8px; z-index: 1000; cursor: pointer; opacity: 1; transition: opacity 200ms; width: 24px; height: 24px;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56 54"><defs><style>.cls-1{fill:#001e36;}.cls-2{fill:#31a8ff;}</style></defs><title>Add to Photoshop Extension</title><g id="Layer_2" data-name="Layer 2"><g id="Surfaces"><g id="Photo_Surface" data-name="Photo Surface"><g id="Outline_no_shadow" data-name="Outline no shadow"><rect class="cls-1" width="56" height="54" rx="9.91383"></rect></g></g></g><g id="Outlined_Mnemonics_Logos" data-name="Outlined Mnemonics &amp; Logos"><g id="Ps"><path class="cls-2" d="M11.63571,37.7063V14.06323c0-.17236.07422-.259.22217-.259q.59106,0,1.40576-.01856.81372-.0183,1.75781-.03686.94336-.01831,1.99805-.03711,1.05468-.01831,2.09033-.01855a13.90366,13.90366,0,0,1,4.73584.70312,8.22066,8.22066,0,0,1,3.08984,1.887,7.24021,7.24021,0,0,1,1.6836,2.6084,8.66365,8.66365,0,0,1,.51757,2.97852,8.21981,8.21981,0,0,1-1.36914,4.884,7.73031,7.73031,0,0,1-3.6997,2.79346,14.72217,14.72217,0,0,1-5.18018.86963q-.81445,0-1.14648-.01856-.33325-.01832-.999-.01855v7.28906a.2945.2945,0,0,1-.333.333H11.895Q11.6357,38.0022,11.63571,37.7063Zm5.10644-19.46216v7.65894q.48048.03735.8877.03711h1.2207a8.72661,8.72661,0,0,0,2.64551-.36988,3.99058,3.99058,0,0,0,1.88769-1.22119,3.55281,3.55281,0,0,0,.7212-2.36792,3.74033,3.74033,0,0,0-.53662-2.03491A3.45133,3.45133,0,0,0,21.959,18.63281a6.85543,6.85543,0,0,0-2.70117-.46264q-.8877,0-1.57227.01855Q17,18.20777,16.74215,18.24414Z"></path><path class="cls-2" d="M43.53986,24.4231a13.0493,13.0493,0,0,0-2.66564-.77686,11.68613,11.68613,0,0,0-2.57129-.29614,4.79162,4.79162,0,0,0-1.38769.1665,1.2462,1.2462,0,0,0-.72168.46265,1.16569,1.16569,0,0,0-.18457.6289.9824.9824,0,0,0,.22168.59205,2.52063,2.52063,0,0,0,.77734.61059,15.472,15.472,0,0,0,1.62793.7583,16.142,16.142,0,0,1,3.53321,1.6836,5.37415,5.37415,0,0,1,1.813,1.90551,5.07861,5.07861,0,0,1,.53662,2.36792,5.31526,5.31526,0,0,1-.88818,3.05249,5.83656,5.83656,0,0,1-2.57129,2.05347,10.3516,10.3516,0,0,1-4.1626.74023,15.04788,15.04788,0,0,1-3.12646-.29614,11.45955,11.45955,0,0,1-2.49805-.74.47883.47883,0,0,1-.25879-.44409V32.89624a.21749.21749,0,0,1,.09278-.20361.17935.17935,0,0,1,.20312.01855,10.80533,10.80533,0,0,0,2.99756,1.12842,11.7417,11.7417,0,0,0,2.70117.35156,4.15006,4.15006,0,0,0,1.90528-.333,1.04519,1.04519,0,0,0,.61035-.96191,1.22388,1.22388,0,0,0-.55469-.925,9.19418,9.19418,0,0,0-2.25732-1.073,13.60639,13.60639,0,0,1-3.27442-1.665,5.63914,5.63914,0,0,1-1.73877-1.94238,5.09656,5.09656,0,0,1-.53711-2.34961,5.30352,5.30352,0,0,1,.77735-2.7749A5.64634,5.64634,0,0,1,34.344,20.05713a7.6279,7.6279,0,0,1,3.74425-.93447,23.40265,23.40265,0,0,1,3.12.04534,10.64682,10.64682,0,0,1,2.443.81515.3364.3364,0,0,1,.22168.20362,1.01923,1.01923,0,0,1,.0371.27734v3.73706a.24881.24881,0,0,1-.11084.22193A.24266.24266,0,0,1,43.53986,24.4231Z"></path></g></g></g></svg></div></div>
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
                                    <img src="{{ asset(\'assets/images/instagram/p1(1).webp" alt="0" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset(\'assets/images/instagram/p1(2).webp" alt="1" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset(\'assets/images/instagram/p1(3).webp" alt="2" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset(\'assets/images/instagram/p1(4).webp" alt="3" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset(\'assets/images/instagram/p1(5).webp" alt="4" class="h-full w-full duration-500 relative" />
                                    <div class="icon w-12 h-12 bg-white hover:bg-black duration-500 flex items-center justify-center rounded-2xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[1]">
                                        <div class="icon-instagram text-2xl text-black"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/" target="_blank" class="item relative block rounded-[32px] overflow-hidden">
                                    <img src="{{ asset(\'assets/images/instagram/p1(1).webp" alt="5" class="h-full w-full duration-500 relative" />
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
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="1" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="2" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="3" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="4" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="5" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="6" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="brand-item relative flex items-center justify-center h-[36px]">
                                    <img src="{{ asset(\'assets/images/perch-logo.png" alt="7" class="h-full w-auto duration-500 relative object-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
