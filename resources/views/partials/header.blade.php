<div id="top-nav" class="top-nav style-two md:h-[44px] h-[30px]" style="position: relative !important; top: 0 !important; bottom: auto !important; display: block !important; visibility: visible !important; background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important; border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;">
            <div class="container mx-auto h-full">
                <div class="top-nav-main flex justify-between max-md:justify-center h-full">
                    <div class="left-content flex items-center gap-5 max-md:hidden">
                        <div class="choose-type choose-language flex items-center gap-1.5">
                            <div class="select relative">
                                <p class="selected caption2 text-white">English</p>
                                <ul class="list-option" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <li data-item="English" class="caption2 active" style="color: white !important;">English</li>
                                    <li data-item="Espana" class="caption2" style="color: white !important;">Espana</li>
                                    <li data-item="France" class="caption2" style="color: white !important;">France</li>
                                </ul>
                            </div>
                            <i class="ph ph-caret-down text-xs text-white"></i>
                        </div>
                        <div class="choose-type choose-currency flex items-center gap-1.5">
                            <div class="select relative">
                                <p class="selected caption2 text-white">{{ \App\Models\Setting::get('currency', 'INR') }}</p>
                                <ul class="list-option" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <li data-item="INR" class="caption2 {{ \App\Models\Setting::get('currency', 'INR') === 'INR' ? 'active' : '' }}" style="color: white !important;">INR</li>
                                    <li data-item="USD" class="caption2 {{ \App\Models\Setting::get('currency', 'INR') === 'USD' ? 'active' : '' }}" style="color: white !important;">USD</li>
                                    <li data-item="EUR" class="caption2 {{ \App\Models\Setting::get('currency', 'INR') === 'EUR' ? 'active' : '' }}" style="color: white !important;">EUR</li>
                                    <li data-item="GBP" class="caption2 {{ \App\Models\Setting::get('currency', 'INR') === 'GBP' ? 'active' : '' }}" style="color: white !important;">GBP</li>
                                </ul>
                            </div>
                            <i class="ph ph-caret-down text-xs text-white"></i>
                        </div>
                    </div>
                    <div class="text-center text-button-uppercase text-white flex items-center">{{ \App\Models\Setting::get('free_shipping_text', 'FREE SHIPPING ON ALL ORDERS OVER ₹75') }}</div>
                    <div class="right-content flex items-center gap-5 max-md:hidden">
                        @php $fb = \App\Models\Setting::get('facebook_url'); @endphp
                        @if($fb)<a href="{{ $fb }}" target="_blank"><i class="icon-facebook text-white"></i></a>@endif
                        @php $ig = \App\Models\Setting::get('instagram_url'); @endphp
                        @if($ig)<a href="{{ $ig }}" target="_blank"><i class="icon-instagram text-white"></i></a>@endif
                        @php $yt = \App\Models\Setting::get('youtube_url'); @endphp
                        @if($yt)<a href="{{ $yt }}" target="_blank"><i class="icon-youtube text-white"></i></a>@endif
                        @php $tw = \App\Models\Setting::get('twitter_url'); @endphp
                        @if($tw)<a href="{{ $tw }}" target="_blank"><i class="icon-twitter text-white"></i></a>@endif
                        @php $pin = \App\Models\Setting::get('pinterest_url'); @endphp
                        @if($pin)<a href="{{ $pin }}" target="_blank"><i class="icon-pinterest text-white"></i></a>@endif
                    </div>
                </div>
            </div>
        </div>

        <div id="header" class="relative w-full" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important; border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;">
            <div class="header-menu style-one relative w-full md:h-[74px] h-[56px]" style="background: rgba(15, 15, 15, 0.98) !important; background-color: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important;">
                <div class="container mx-auto h-full">
                    <div class="header-main flex justify-between h-full">
                        <div class="menu-mobile-icon  flex items-center">
                            <i class="icon-category text-2xl" style="color: white !important;"></i>
                            <a href="{{{ route('home') }}}" class="flex items-center px-10">
                                @php $logo = \App\Models\Setting::get('site_logo'); @endphp
                                <span class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Ricimart</span>
                            </a>
                        </div>
                        
                        <div class="menu-main h-full max-lg:hidden">
                            <ul class="flex items-center gap-8 h-full">
                                <li class="h-full">
                                    <a href="#!" class="text-button-uppercase duration-300 h-full flex items-center justify-center" style="color: white !important;"> Categories </a>
                                    <div class="mega-menu absolute top-[74px] left-0 w-screen shadow-lg" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;">
                                        <div class="container">
                                            <div class="flex justify-between py-8">
                                                <div class="nav-link basis-2/3 grid grid-cols-4 gap-y-8">
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">📱 Phone Cases</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Premium Cases </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Clear Cases </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Wallet Cases </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Rugged Cases </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">🔌 Chargers</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Fast Chargers </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Wireless Chargers </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Car Chargers </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> USB Cables </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">🎧 Headphones</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Wireless Earbuds </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Over-Ear Headphones </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Gaming Headsets </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Sports Earbuds </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">🛡️ Protection</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Screen Protectors </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Tempered Glass </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Camera Protectors </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Privacy Screen </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">🔋 Power Banks</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> 10000mAh </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> 20000mAh </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Wireless Power Bank </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Fast Charging </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">📱 Stands & Mounts</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Phone Stands </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Car Mounts </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Desk Stands </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Gaming Mounts </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">🎵 Audio Accessories</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Bluetooth Speakers </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Aux Cables </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Adapters </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Splitters </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="nav-item">
                                                        <div class="text-button-uppercase pb-2 font-semibold" style="color: white !important;">💾 Storage & More</div>
                                                        <ul>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Memory Cards </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> OTG Cables </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Selfie Sticks </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 cursor-pointer"> Pop Sockets </a></li>
                                                            <li><a href="{{{ route('shop') }}}" class="link text-secondary duration-300 view-all-btn"> View All </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="banner-ads-block pl-2.5 basis-1/3">
                                            <a href="{{{ route('shop') }}}" class="banner-ads-item bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl relative block overflow-hidden cursor-pointer shadow-lg">
                                                        <div class="text-content py-14 pl-8 relative z-[1]">
                                                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm">Save ₹500</div>
                                                            <div class="heading6 mt-2 text-white">Premium Phone Cases <br />Collection</div>
                                                            <div class="body1 mt-3 text-white/90">Starting at <span class="text-yellow-300 font-bold">₹299</span></div>
                                                        </div>
                                                <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                                                    </a>
                                            <a href="{{{ route('shop') }}}" class="banner-ads-item bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl relative block overflow-hidden cursor-pointer mt-8 shadow-lg">
                                                        <div class="text-content py-14 pl-8 relative z-[1]">
                                                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm">30% OFF</div>
                                                            <div class="heading6 mt-2 text-white">Fast Chargers <br />& Power Banks</div>
                                                            <div class="body1 mt-3 text-white/90">Starting at <span class="text-yellow-300 font-bold">₹499</span></div>
                                                        </div>
                                                <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="h-full relative">
                                    <a href="#!" class="text-button-uppercase duration-300 h-full flex items-center justify-center" style="color: white !important;"> Blog </a>
                                    <div class="sub-menu py-3 px-5 -left-10 absolute rounded-b-xl" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1) !important;">
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
                                    <a href="#!" class="text-button-uppercase duration-300 h-full flex items-center justify-center" style="color: white !important;"> Pages </a>
                                    <div class="sub-menu py-3 px-5 -left-10 absolute rounded-b-xl" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1) !important;">
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
                                <i class="ph-bold ph-magnifying-glass text-2xl" style="color: white !important;"></i>
                                <div class="line absolute w-px h-6 -right-6" style="background: rgba(255, 255, 255, 0.1) !important;"></div>
                            </div>
                            <div class="list-action flex items-center gap-4">
                                <div class="user-icon flex items-center justify-center cursor-pointer relative">
                                    <i class="ph-bold ph-user text-2xl" style="color: white !important;"></i>
                                    <div class="login-popup absolute top-[74px] w-[320px] p-7 rounded-xl box-shadow-sm" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1) !important;">
                                        @auth
                                            <div class="text-center mb-4">
                                                <div class="body1 font-medium" style="color: white !important;">{{ Auth::user()->name }}</div>
                                                <div class="caption1" style="color: rgba(255, 255, 255, 0.8) !important;">{{ Auth::user()->email }}</div>
                                            </div>
                                            <a href="{{{ route('my-account') }}}" class="button-main w-full text-center" style="background: linear-gradient(45deg, #ff00cc, #3333ff) !important; color: white !important;">My Account</a>
                                            @if(Auth::user()->role === 'admin')
                                                <a href="{{{ route('admin.dashboard') }}}" class="button-main w-full text-center mt-3" style="background: rgba(255, 255, 255, 0.1) !important; color: white !important; border: 1px solid rgba(255, 255, 255, 0.2) !important;">Dashboard</a>
                                            @endif
                                            <div class="bottom mt-4 pt-4 border-t" style="border-color: rgba(255, 255, 255, 0.1) !important;"></div>
                                            <form method="POST" action="{{{ route('logout') }}}">
                                                @csrf
                                                <button type="submit" class="body1 hover:underline w-full text-left" style="color: white !important;">Logout</button>
                                            </form>
                                        @else
                                            <a href="{{{ route('login') }}}" class="button-main w-full text-center" style="background: linear-gradient(45deg, #ff00cc, #3333ff) !important; color: white !important;">Login</a>
                                            <div class="text-center mt-3 pb-4" style="color: rgba(255, 255, 255, 0.8) !important;">
                                                Don't have an account?
                                                <a href="{{{ route('register') }}}" class="pl-1 hover:underline" style="color: #00ffee !important;">Register </a>
                                        </div>
                                            <a href="{{{ route('admin.dashboard') }}}" class="button-main w-full text-center" style="background: rgba(255, 255, 255, 0.1) !important; color: white !important; border: 1px solid rgba(255, 255, 255, 0.2) !important;">Dashboard</a>
                                            <div class="bottom mt-4 pt-4 border-t" style="border-color: rgba(255, 255, 255, 0.1) !important;"></div>
                                            <a href="#!" class="body1 hover:underline" style="color: white !important;">Support</a>
                                        @endauth
                                    </div>
                                </div>
                                <a href="javascript:void(0)" role="button" class="max-md:hidden wishlist-icon flex items-center relative cursor-pointer no-underline text-inherit" onclick="var m=document.querySelectorAll('.modal-wishlist-block .modal-wishlist-main');var el=m.length?m[m.length-1]:null;if(el){el.classList.add('open');document.body.style.overflow='hidden';if(window.handleItemModalWishlist)window.handleItemModalWishlist();}return false">
                                    <i class="ph-bold ph-heart text-2xl" style="color: white !important;"></i>
                                    <span class="quantity wishlist-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                                </a>
                                <a href="javascript:void(0)" role="button" class="max-md:hidden cart-icon flex items-center relative cursor-pointer no-underline text-inherit" onclick="var m=document.querySelectorAll('.modal-cart-block .modal-cart-main');var el=m.length?m[m.length-1]:null;if(el){el.classList.add('open');document.body.style.overflow='hidden';if(window.loadCartItems)window.loadCartItems();}return false">
                                    <i class="ph-bold ph-handbag text-2xl" style="color: white !important;"></i>
                                    <span class="quantity cart-quantity absolute -right-1.5 -top-1.5 text-xs text-white bg-black w-4 h-4 flex items-center justify-center rounded-full">0</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="menu-mobile" class="" style="background: rgba(0, 0, 0, 0.85) !important;">
                <div class="menu-container h-full" style="background: rgba(15, 15, 15, 0.95) !important; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); color: white !important; border-right: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);">
                    <div class="container h-full">
                <div class="menu-main h-full overflow-x-hidden scroll2" style="color: white !important;">
                            <div class="heading py-4 relative flex items-center justify-center border-b" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                                <div class="close-menu-mobile-btn absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full flex items-center justify-center cursor-pointer transition-all" style="background: rgba(255, 255, 255, 0.1) !important; color: white !important;" onmouseover="this.style.background='rgba(0, 255, 238, 0.3)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='scale(1)'">
                                    <i class="ph ph-x text-lg"></i>
                                </div>
                        <a href="{{{ route('home') }}}" class="logo text-3xl font-bold text-center bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Ricimart</a>
                            </div>
                            <div class="form-search relative mt-4 px-4">
                                <form method="GET" action="{{{ route('shop') }}}">
                                    <div class="relative">
                                        <i class="ph ph-magnifying-glass text-xl absolute left-4 top-1/2 -translate-y-1/2 cursor-pointer" style="color: rgba(255, 255, 255, 0.6) !important;"></i>
                                    <input type="text" 
                                           name="search" 
                                           placeholder="What are you looking for?" 
                                           value="{{ request()->get('search') }}"
                                               class="h-12 rounded-xl border text-sm w-full pl-12 pr-4 transition-all" style="background: rgba(255, 255, 255, 0.05) !important; color: white !important; border-color: rgba(255, 255, 255, 0.2) !important;" onfocus="this.style.borderColor='rgba(0, 255, 238, 0.5)'; this.style.background='rgba(255, 255, 255, 0.08)'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.2)'; this.style.background='rgba(255, 255, 255, 0.05)'" />
                                    </div>
                                </form>
                            </div>
                    
                            <div class="list-nav mt-6 px-4">
                        @php
                            // Mobile Accessories Categories - Hardcoded for mobile menu
                            $mobileCategories = [
                                [
                                    'name' => '📱 Phone Cases',
                                    'slug' => 'phone-cases',
                                    'children' => [
                                        ['name' => 'Premium Cases', 'slug' => 'premium-cases'],
                                        ['name' => 'Clear Cases', 'slug' => 'clear-cases'],
                                        ['name' => 'Wallet Cases', 'slug' => 'wallet-cases'],
                                        ['name' => 'Rugged Cases', 'slug' => 'rugged-cases'],
                                        ['name' => 'Leather Cases', 'slug' => 'leather-cases'],
                                        ['name' => 'Silicone Cases', 'slug' => 'silicone-cases'],
                                    ]
                                ],
                                [
                                    'name' => '🔌 Chargers',
                                    'slug' => 'chargers',
                                    'children' => [
                                        ['name' => 'Fast Chargers', 'slug' => 'fast-chargers'],
                                        ['name' => 'Wireless Chargers', 'slug' => 'wireless-chargers'],
                                        ['name' => 'Car Chargers', 'slug' => 'car-chargers'],
                                        ['name' => 'USB-C Cables', 'slug' => 'usb-c-cables'],
                                        ['name' => 'Lightning Cables', 'slug' => 'lightning-cables'],
                                    ]
                                ],
                                [
                                    'name' => '🎧 Headphones & Audio',
                                    'slug' => 'headphones-audio',
                                    'children' => [
                                        ['name' => 'Wireless Earbuds', 'slug' => 'wireless-earbuds'],
                                        ['name' => 'Over-Ear Headphones', 'slug' => 'over-ear-headphones'],
                                        ['name' => 'Gaming Headsets', 'slug' => 'gaming-headsets'],
                                        ['name' => 'Sports Earbuds', 'slug' => 'sports-earbuds'],
                                    ]
                                ],
                                [
                                    'name' => '🔋 Power Banks',
                                    'slug' => 'power-banks',
                                    'children' => [
                                        ['name' => 'Portable Power Banks', 'slug' => 'portable-power-banks'],
                                        ['name' => 'Wireless Power Banks', 'slug' => 'wireless-power-banks'],
                                        ['name' => 'Solar Power Banks', 'slug' => 'solar-power-banks'],
                                    ]
                                ],
                                [
                                    'name' => '🛡️ Protection & Accessories',
                                    'slug' => 'protection-accessories',
                                    'children' => [
                                        ['name' => 'Screen Protectors', 'slug' => 'screen-protectors'],
                                        ['name' => 'Tempered Glass', 'slug' => 'tempered-glass'],
                                        ['name' => 'Phone Stands', 'slug' => 'phone-stands'],
                                        ['name' => 'Car Mounts', 'slug' => 'car-mounts'],
                                        ['name' => 'Pop Sockets', 'slug' => 'pop-sockets'],
                                    ]
                                ],
                            ];
                        @endphp
                        
                        <ul>
                            @foreach($mobileCategories as $category)
                                <li class="mb-2">
                                    <a href="{{{ route('shop') }}}" class="text-lg font-semibold flex items-center justify-between py-3 px-4 rounded-lg transition-all" style="color: white !important; background: transparent;" onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.color='#00ffee'" onmouseout="this.style.background='transparent'; this.style.color='white'">
                                        {{ $category['name'] }}
                                            <span class="text-right">
                                                <i class="ph ph-caret-right text-lg" style="color: rgba(255, 255, 255, 0.6) !important;"></i>
                                            </span>
                                        </a>
                                    @if(isset($category['children']) && count($category['children']) > 0)
                                        <div class="sub-nav-mobile" style="background: rgba(15, 15, 15, 0.98) !important; color: white !important;">
                                            <div class="back-btn flex items-center gap-3 px-4 py-3 cursor-pointer transition-all" style="color: white !important; border-bottom: 1px solid rgba(255, 255, 255, 0.1);" onmouseover="this.style.color='#00ffee'; this.style.background='rgba(255, 255, 255, 0.05)'" onmouseout="this.style.color='white'; this.style.background='transparent'">
                                                <i class="ph ph-caret-left text-xl"></i>
                                                <span class="font-semibold">Back</span>
                                            </div>
                                            <div class="list-nav-item w-full grid grid-cols-2 pt-4 pb-6 px-4 gap-4">
                                                @foreach($category['children'] as $subCategory)
                                                    <div class="nav-item">
                                                        <a href="{{{ route('shop') }}}" class="text-title duration-300 block py-2 px-3 rounded-lg transition-all" style="color: white !important; background: transparent;" onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.color='#00ffee'" onmouseout="this.style.background='transparent'; this.style.color='white'">{{ $subCategory['name'] }}</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                                                            <li class="mb-2">
                                <a href="{{{ route('shop') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all" style="color: white !important; background: transparent;" onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.color='#00ffee'" onmouseout="this.style.background='transparent'; this.style.color='white'">Shop</a>
                                                            </li>
                                                            <li class="mb-2">
                                <a href="{{{ route('about') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all" style="color: white !important; background: transparent;" onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.color='#00ffee'" onmouseout="this.style.background='transparent'; this.style.color='white'">About Us</a>
                                                            </li>
                                                            <li class="mb-2">
                                <a href="{{{ route('contact') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all" style="color: white !important; background: transparent;" onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.color='#00ffee'" onmouseout="this.style.background='transparent'; this.style.color='white'">Contact Us</a>
                                                            </li>
                                                            <li class="mb-2">
                                <a href="{{{ route('faqs') }}}" class="text-lg font-semibold flex items-center py-3 px-4 rounded-lg transition-all" style="color: white !important; background: transparent;" onmouseover="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.color='#00ffee'" onmouseout="this.style.background='transparent'; this.style.color='white'">FAQs</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
