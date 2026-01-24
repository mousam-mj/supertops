<div id="top-nav" class="top-nav style-two bg-purple md:h-[44px] h-[30px]">
            <div class="container mx-auto h-full">
                <div class="top-nav-main flex justify-between max-md:justify-center h-full">
                    <div class="left-content flex items-center gap-5 max-md:hidden">
                        <div class="choose-type choose-language flex items-center gap-1.5">
                            <div class="select relative">
                                <p class="selected caption2 text-white">English</p>
                                <ul class="list-option bg-white">
                                    <li data-item="English" class="caption2 active">English</li>
                                    <li data-item="Espana" class="caption2">Espana</li>
                                    <li data-item="France" class="caption2">France</li>
                                </ul>
                            </div>
                            <i class="ph ph-caret-down text-xs text-white"></i>
                        </div>
                        <div class="choose-type choose-currency flex items-center gap-1.5">
                            <div class="select relative">
                                <p class="selected caption2 text-white">USD</p>
                                <ul class="list-option bg-white">
                                    <li data-item="USD" class="caption2 active">USD</li>
                                    <li data-item="EUR" class="caption2">EUR</li>
                                    <li data-item="GBP" class="caption2">GBP</li>
                                </ul>
                            </div>
                            <i class="ph ph-caret-down text-xs text-white"></i>
                        </div>
                    </div>
                    <div class="text-center text-button-uppercase text-white flex items-center">Free shipping on all orders over $50</div>
                    <div class="right-content flex items-center gap-5 max-md:hidden">
                        <a href="https://www.facebook.com/" target="_blank">
                            <i class="icon-facebook text-white"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank">
                            <i class="icon-instagram text-white"></i>
                        </a>
                        <a href="https://www.youtube.com/" target="_blank">
                            <i class="icon-youtube text-white"></i>
                        </a>
                        <a href="https://twitter.com/" target="_blank">
                            <i class="icon-twitter text-white"></i>
                        </a>
                        <a href="https://pinterest.com/" target="_blank">
                            <i class="icon-pinterest text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="header" class="relative w-full">
            <div class="header-menu style-one relative  w-full md:h-[74px] h-[56px]">
                <div class="container mx-auto h-full">
                    <div class="header-main flex justify-between h-full">
                        <div class="menu-mobile-icon  flex items-center">
                            <i class="icon-category text-2xl"></i>
                            <a href="{{{ route('home') }}}" class="flex items-center px-10">
                                <img src="{{ asset('assets/images/perch-logo.png') }}" alt="bg-img" />
                            </a>
                        </div>
                        
                        <div class="menu-main h-full max-lg:hidden">
                            <ul class="flex items-center gap-8 h-full">
                                <li class="h-full">
                                    <a href="#!" class="text-button-uppercase duration-300 h-full flex items-center justify-center"> Features </a>
                                    <div class="mega-menu absolute top-[74px] left-0 bg-white w-screen">
                                        <div class="container">
                                            <div class="flex justify-between py-8">
                                                <div class="nav-link basis-2/3 grid grid-cols-4 gap-y-8">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">For Men</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Starting From 50% Off </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Outerwear | Coats </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Sweaters | Cardigans </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Shirt | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">Massimo Dutti</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Shirt | Clothes </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Top | Overshirts </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> T-shirts | Clothes </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Swimwear | Underwear </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">Skincare</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Faces Skin </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Eyes Makeup </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Lip Polish </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Hair Care </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">Health</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Cented Candle </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Health Drinks </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Yoga Clothes </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Yoga Equipment </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">For Women</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Starting From 60% Off </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Dresses | Jumpsuits </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> T-shirts | Sweatshirts </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Accessories | Jewelry </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">For Kid</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Kids Bed </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Boy's Toy </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Baby Blanket </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Newborn Clothing </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2">For Home</div>
                                                        <ul>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Furniture | Decor </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Table | Living Room </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Chair | Work Room </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Lighting | Bed Room </a>
                                                            </li>
                                                            <li>
                                                        <a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="banner-ads-block pl-2.5 basis-1/3">
                                            <a href="{{{ route('shop') }}}" class="banner-ads-item bg-linear rounded-2xl relative block overflow-hidden cursor-pointer">
                                                        <div class="text-content py-14 pl-8 relative z-[1]">
                                                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm">Save $10</div>
                                                            <div class="heading6 mt-2">Dive into Savings <br />on Swimwear</div>
                                                            <div class="body1 mt-3 text-secondary">Starting at <span class="text-red">$59.99</span></div>
                                                        </div>
                                                <img src="{{ asset('assets/images/slider/bg2-2.png') }}" alt="bg-img" class="h-full w-auto absolute right-0 top-0 duration-700" />
                                                    </a>
                                            <a href="{{{ route('shop') }}}" class="banner-ads-item bg-linear rounded-2xl relative block overflow-hidden cursor-pointer mt-8">
                                                        <div class="text-content py-14 pl-8 relative z-[1]">
                                                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm">Save $10</div>
                                                            <div class="heading6 mt-2">20% off <br />accessories</div>
                                                            <div class="body1 mt-3 text-secondary">Starting at <span class="text-red">$59.99</span></div>
                                                        </div>
                                                <img src="{{ asset('assets/images/other/bg-feature.png') }}" alt="bg-img" class="h-full w-auto absolute right-0 top-0 duration-700" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="h-full relative">
                                    <a href="#!" class="text-button-uppercase duration-300 h-full flex items-center justify-center"> Blog </a>
                                    <div class="sub-menu py-3 px-5 -left-10 absolute bg-white rounded-b-xl">
                                        <ul class="w-full">
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Blog Default </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Blog List </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Blog Grid </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Blog Detail 1 </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Blog Detail 2 </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="h-full relative">
                                    <a href="#!" class="text-button-uppercase duration-300 h-full flex items-center justify-center"> Pages </a>
                                    <div class="sub-menu py-3 px-5 -left-10 absolute bg-white rounded-b-xl">
                                        <ul class="w-full">
                                            <li>
                                        <a href="{{{ route('about') }}}" class="link text-secondary duration-300"> About Us </a>
                                            </li>
                                            <li>
                                        <a href="{{{ route('contact') }}}" class="link text-secondary duration-300"> Contact Us </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Store List </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> 404 </a>
                                            </li>
                                            <li>
                                        <a href="{{{ route('faqs') }}}" class="link text-secondary duration-300"> FAQs </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Coming Soon </a>
                                            </li>
                                            <li>
                                        <a href="#!" class="link text-secondary duration-300"> Customer Feedbacks </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="right flex gap-12 z-[1]">
                            <div class="max-md:hidden search-icon flex items-center cursor-pointer relative">
                                <i class="ph-bold ph-magnifying-glass text-2xl"></i>
                                <div class="line absolute bg-line w-px h-6 -right-6"></div>
                            </div>
                            <div class="list-action flex items-center gap-4">
                                <div class="user-icon flex items-center justify-center cursor-pointer relative">
                                    <i class="ph-bold ph-user text-2xl"></i>
                                    <div class="login-popup absolute top-[74px] w-[320px] p-7 rounded-xl bg-white box-shadow-sm">
                                        @auth
                                            <div class="text-center mb-4">
                                                <div class="body1 text-black font-medium">{{ Auth::user()->name }}</div>
                                                <div class="caption1 text-secondary">{{ Auth::user()->email }}</div>
                                            </div>
                                            <a href="{{{ route('my-account') }}}" class="button-main w-full text-center">My Account</a>
                                            @if(Auth::user()->role === 'admin')
                                                <a href="{{{ route('admin.dashboard') }}}" class="button-main bg-white text-black border border-black w-full text-center mt-3">Dashboard</a>
                                            @endif
                                            <div class="bottom mt-4 pt-4 border-t border-line"></div>
                                            <form method="POST" action="{{{ route('logout') }}}">
                                                @csrf
                                                <button type="submit" class="body1 hover:underline w-full text-left">Logout</button>
                                            </form>
                                        @else
                                            <a href="{{{ route('login') }}}" class="button-main w-full text-center">Login</a>
                                            <div class="text-secondary text-center mt-3 pb-4">
                                                Don't have an account?
                                                <a href="{{{ route('register') }}}" class="text-black pl-1 hover:underline">Register </a>
                                            </div>
                                            <a href="{{{ route('admin.dashboard') }}}" class="button-main bg-white text-black border border-black w-full text-center">Dashboard</a>
                                            <div class="bottom mt-4 pt-4 border-t border-line"></div>
                                            <a href="#!" class="body1 hover:underline">Support</a>
                                        @endauth
                                    </div>
                                </div>
                                <div class="max-md:hidden wishlist-icon flex items-center relative cursor-pointer">
                                    <i class="ph-bold ph-heart text-2xl"></i>
                                    <span class="quantity wishlist-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                                </div>
                                <div class="max-md:hidden cart-icon flex items-center relative cursor-pointer">
                                    <i class="ph-bold ph-handbag text-2xl"></i>
                                    <span class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="menu-mobile" class="">
                <div class="menu-container bg-white h-full">
                    <div class="container h-full">
                <div class="menu-main h-full overflow-x-hidden scroll2">
                            <div class="heading py-2 relative flex items-center justify-center">
                                <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                                    <i class="ph ph-x text-sm"></i>
                                </div>
                        <a href="{{{ route('home') }}}" class="logo text-3xl font-semibold text-center">Perch</a>
                            </div>
                            <div class="form-search relative mt-2">
                                <form method="GET" action="{{{ route('shop') }}}">
                                    <i class="ph ph-magnifying-glass text-xl absolute left-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                                    <input type="text" 
                                           name="search" 
                                           placeholder="What are you looking for?" 
                                           value="{{ request()->get('search') }}"
                                           class="h-12 rounded-lg border border-line text-sm w-full pl-10 pr-4" />
                                </form>
                            </div>
                    
                            <div class="list-nav mt-6">
                        @php
                            $categories = \App\Models\Category::whereNull('parent_id')
                                ->with(['children.children'])
                                ->where('is_active', true)
                                ->orderBy('sort_order')
                                ->get();
                        @endphp
                        
                        <ul>
                            @foreach($categories as $category)
                                <li>
                                    <a href="#!" class="text-xl font-semibold flex items-center justify-between">
                                        {{ $category->name }}
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-xl"></i>
                                            </span>
                                        </a>
                                    @if($category->children->count() > 0)
                                        <div class="sub-nav-mobile">
                                            <div class="back-btn flex items-center gap-3">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                Back
                                            </div>
                                            <div class="list-nav-item w-full grid grid-cols-2 pt-2 pb-6">
                                                @foreach($category->children as $subCategory)
                                                    <div class="nav-item">
                                                        <a href="{{{ route('shop', ['category' => $subCategory->slug]) }}}" class="text-title duration-300">{{ $subCategory->name }}</a>
                                                        @if($subCategory->children->count() > 0)
                                                            <ul class="mt-2">
                                                                @foreach($subCategory->children as $childCategory)
                                                                    <li>
                                                                        <a href="{{{ route('shop', ['category' => $childCategory->slug]) }}}" class="link text-secondary duration-300">{{ $childCategory->name }}</a>
                                                            </li>
                                                                @endforeach
                                                        </ul>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                    </div>
                                                    </div>
                                    @endif
                                                            </li>
                            @endforeach
                                                            <li>
                                <a href="{{{ route('shop') }}}" class="text-xl font-semibold">Shop</a>
                                                            </li>
                                                            <li>
                                <a href="{{{ route('about') }}}" class="text-xl font-semibold">About Us</a>
                                                            </li>
                                                            <li>
                                <a href="{{{ route('contact') }}}" class="text-xl font-semibold">Contact Us</a>
                                                            </li>
                                                            <li>
                                <a href="{{{ route('faqs') }}}" class="text-xl font-semibold">FAQs</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
