<div id="header" class="relative w-full">
    <div class="header-menu style-one relative bg-white w-full md:h-[74px] h-[56px]">
        <div class="container mx-auto h-full">
            <div class="header-main flex justify-between h-full">
                <div class="menu-mobile-icon lg:hidden flex items-center">
                    <i class="icon-category text-2xl"></i>
                </div>
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('assets/images/edx.png') }}" alt="EDX Logo" style="height: 50px;">
                </a>
                <div class="menu-main h-full max-lg:hidden">
                    <ul class="flex items-center gap-8 h-full">
                        <li class="h-full relative">
                            <a href="{{ route('home') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center gap-1 {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        </li>
                        <li class="h-full">
                            <a href="{{ route('frontend.edx-world') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center {{ request()->routeIs('frontend.edx-world') ? 'active' : '' }}">EDX World</a>
                        </li>
                        <li class="h-full">
                            <a href="{{ route('frontend.quality-path') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center {{ request()->routeIs('frontend.quality-path') ? 'active' : '' }}">Quality Path</a>
                        </li>
                        <li class="h-full">
                            <a href="{{ route('frontend.range') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center {{ request()->routeIs('frontend.range') ? 'active' : '' }}">Range</a>
                        </li>
                        <li class="h-full">
                            <a href="{{ route('frontend.industries') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center {{ request()->routeIs('frontend.industries') ? 'active' : '' }}">Industries</a>
                        </li>
                        <li class="h-full">
                            <a href="{{ route('frontend.applications') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center {{ request()->routeIs('frontend.applications') ? 'active' : '' }}">Applications</a>
                        </li>
                        <li class="h-full">
                            <a href="{{ route('frontend.contact') }}" class="text-button-uppercase duration-300 h-full flex items-center justify-center {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div class="right flex gap-12 z-[1]">
                    <div class="max-md:hidden search-icon flex items-center cursor-pointer relative">
                        <i class="ph-bold ph-magnifying-glass text-2xl"></i>
                        <div class="line absolute bg-line w-px h-6 -right-6"></div>
                    </div>
                    <div class="list-action flex items-center gap-4">
                        <a href="{{ route('frontend.quota-list.index') }}" class="max-md:hidden cart-icon quota-bag-link cursor-pointer no-underline text-inherit" title="Quota list">
                            <i class="ph-bold ph-handbag text-2xl" aria-hidden="true"></i>
                            <span class="cart-quota-badge cart-quota-badge--empty" aria-label="Items in quota list">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div id="menu-mobile" class="">
        <div class="menu-container bg-white h-full">
            <div class="container h-full">
                <div class="menu-main h-full overflow-hidden">
                    <div class="heading py-2 relative flex items-center justify-center">
                        <div class="close-menu-mobile-btn absolute left-0 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-surface flex items-center justify-center">
                            <i class="ph ph-x text-sm"></i>
                        </div>
                        <a href="{{ route('home') }}" class="logo text-3xl font-semibold text-center">EDX</a>
                    </div>
                    <div class="form-search relative mt-2">
                        <i class="ph ph-magnifying-glass text-xl absolute left-3 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                        <input type="text" placeholder="What are you looking for?" class="h-12 rounded-lg border border-line text-sm w-full pl-10 pr-4" />
                    </div>
                    <div class="list-nav mt-6">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}" class="text-xl font-semibold flex items-center justify-between">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.edx-world') }}" class="text-xl font-semibold flex items-center justify-between mt-5">EDX World</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.quality-path') }}" class="text-xl font-semibold flex items-center justify-between mt-5">Quality Path</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.range') }}" class="text-xl font-semibold flex items-center justify-between mt-5">Range</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.industries') }}" class="text-xl font-semibold flex items-center justify-between mt-5">Industries</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.applications') }}" class="text-xl font-semibold flex items-center justify-between mt-5">Applications</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.contact') }}" class="text-xl font-semibold flex items-center justify-between mt-5">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu bar for mobile -->
    <div class="menu_bar fixed bg-white bottom-0 left-0 w-full h-[70px] sm:hidden z-[101]">
        <div class="menu_bar-inner grid grid-cols-4 items-center h-full">
            <a href="{{ route('home') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="ph-bold ph-house text-2xl block"></span>
                <span class="menu_bar-title caption2 font-semibold">Home</span>
            </a>
            <a href="{{ route('frontend.range') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="ph-bold ph-list text-2xl block"></span>
                <span class="menu_bar-title caption2 font-semibold">Category</span>
            </a>
            <a href="{{ route('frontend.range') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <span class="ph-bold ph-magnifying-glass text-2xl block"></span>
                <span class="menu_bar-title caption2 font-semibold">Search</span>
            </a>
            <a href="{{ route('frontend.quota-list.index') }}" class="menu_bar-link flex flex-col items-center gap-1">
                <div class="cart-icon">
                    <span class="ph-bold ph-handbag text-2xl block" aria-hidden="true"></span>
                    <span class="cart-quota-badge cart-quota-badge--empty" aria-label="Items in quota list">0</span>
                </div>
                <span class="menu_bar-title caption2 font-semibold">Quota</span>
            </a>
        </div>
    </div>
</div>
