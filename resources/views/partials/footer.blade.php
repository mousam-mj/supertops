<div id="footer" class="footer mt-8" style="position: relative; z-index: 10; display: block !important; visibility: visible !important; width: 100%; clear: both;">
    <div class="footer-main bg-surface">
        <div class="container">
            <div class="content-footer md:py-[60px] py-10 flex justify-between flex-wrap gap-y-8">
                <div class="company-infor basis-1/4 max-lg:basis-full pr-7">
                    <a href="{{{ route('home') }}}" class="logo inline-block">
                        @php $footerLogo = \App\Models\Setting::get('site_logo'); @endphp
                        <img src="{{ $footerLogo ? asset('storage/' . $footerLogo) : asset('assets/images/perch-logo.png') }}" alt="{{ \App\Models\Setting::get('site_name', 'Perch') }}" />
                    </a>
                    @php
                        $footerEmail = \App\Models\Setting::get('contact_email', 'ecom@perchbottle.in');
                        $footerPhone = \App\Models\Setting::get('contact_phone', '');
                        $footerHelpline = \App\Models\Setting::get('helpline_number', '');
                        $addr = \App\Models\Setting::get('contact_address', '');
                        $city = \App\Models\Setting::get('contact_city', '');
                        $state = \App\Models\Setting::get('contact_state', '');
                        $pincode = \App\Models\Setting::get('contact_pincode', '');
                        $footerAddress = trim(implode(', ', array_filter([$addr, $city, $state, $pincode]))) ?: 'Delhi, India';
                    @endphp
                    <div class="flex gap-3 mt-3">
                        <div class="flex flex-col">
                            <span class="text-button">Mail:</span>
                            <span class="text-button mt-3">Phone:</span>
                            @if($footerHelpline)<span class="text-button mt-3">Helpline:</span>@endif
                            <span class="text-button mt-3">Address:</span>
                        </div>
                        <div class="flex flex-col">
                            <span>{{ $footerEmail }}</span>
                            <span class="mt-[14px]">{{ $footerPhone }}</span>
                            @if($footerHelpline)<span class="mt-[14px]">{{ $footerHelpline }}</span>@endif
                            <span class="mt-3 pt-1">{{ $footerAddress }}</span>
                        </div>
                    </div>
                </div>
                <div class="right-content flex flex-wrap gap-y-8 basis-3/4 max-lg:basis-full">
                    <div class="list-nav flex justify-between basis-2/3 max-md:basis-full gap-4">
                        <div class="item flex flex-col basis-1/3">
                            <div class="text-button-uppercase pb-3">Infomation</div>
                            <a class="caption1 has-line-before duration-300 w-fit" href="{{ route('about') }}">About Us</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{ route('contact') }}">Contact us</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="#!"> Career </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('my-account') }}}"> My Account</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('order-tracking') }}}"> Order & Returns</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('faqs') }}}">FAQs </a>
                        </div>
                        <div class="item flex flex-col basis-1/3">
                            <div class="text-button-uppercase pb-3">Quick Shop</div>
                            <a class="caption1 has-line-before duration-300 w-fit" href="{{{ route('shop') }}}">Women</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('shop') }}}">Men </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('shop') }}}">Clothes </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('shop') }}}"> Accessories </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="#!">Blog </a>
                        </div>
                        <div class="item flex flex-col basis-1/3">
                            <div class="text-button-uppercase pb-3">Customer Services</div>
                            <a class="caption1 has-line-before duration-300 w-fit" href="{{{ route('faqs') }}}">FAQs</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('faqs') }}}">Shipping</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('terms-and-conditions') }}}">Terms & Conditions</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('privacy-policy') }}}">Privacy Policy</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('return-and-refund') }}}">Return & Refund</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('cancellation-policy') }}}">Cancellation Policy</a>
                        </div>
                    </div>
                    <div class="newsletter basis-1/3 pl-7 max-md:basis-full max-md:pl-0">
                        <div class="text-button-uppercase">Newsletter</div>
                        <div class="caption1 mt-3">Sign up for our newsletter and get 10% off your first purchase</div>
                        <div class="input-block w-full h-[52px] mt-4">
                            <form class="w-full h-full relative" method="POST" action="{{{ route('newsletter.subscribe') }}}">
                                @csrf
                                <input type="email" name="email" placeholder="Enter your e-mail" class="caption1 w-full h-full pl-4 pr-14 rounded-xl border border-line" required />
                                <button type="submit" class="w-[44px] h-[44px] bg-black flex items-center justify-center rounded-xl absolute top-1 right-1">
                                    <i class="ph ph-arrow-right text-xl text-white"></i>
                                </button>
                            </form>
                        </div>
                        <div class="list-social flex items-center gap-6 mt-4">
                            @php $sfb = \App\Models\Setting::get('facebook_url'); @endphp
                            @if($sfb)<a href="{{ $sfb }}" target="_blank"><div class="icon-facebook text-2xl text-black"></div></a>@endif
                            @php $sig = \App\Models\Setting::get('instagram_url'); @endphp
                            @if($sig)<a href="{{ $sig }}" target="_blank"><div class="icon-instagram text-2xl text-black"></div></a>@endif
                            @php $stw = \App\Models\Setting::get('twitter_url'); @endphp
                            @if($stw)<a href="{{ $stw }}" target="_blank"><div class="icon-twitter text-2xl text-black"></div></a>@endif
                            @php $syt = \App\Models\Setting::get('youtube_url'); @endphp
                            @if($syt)<a href="{{ $syt }}" target="_blank"><div class="icon-youtube text-2xl text-black"></div></a>@endif
                            @php $spin = \App\Models\Setting::get('pinterest_url'); @endphp
                            @if($spin)<a href="{{ $spin }}" target="_blank"><div class="icon-pinterest text-2xl text-black"></div></a>@endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom py-3 flex items-center justify-between gap-5 max-lg:justify-center max-lg:flex-col border-t border-line">
                <div class="left flex items-center gap-8">
                    <div class="copyright caption1 text-secondary">{{ \App\Models\Setting::get('copyright_text', '©2025 Perch. All Rights Reserved.') ?: '©2025 Perch. All Rights Reserved.' }}</div>
                    <div class="select-block flex items-center gap-5 max-md:hidden">
                        <div class="choose-language flex items-center gap-1.5">
                            <select name="language" id="chooseLanguageFooter" class="caption2 bg-transparent">
                                <option value="English">English</option>
                                <option value="Espana">Espana</option>
                                <option value="France">France</option>
                            </select>
                            <i class="ph ph-caret-down text-xs text-[#1F1F1F]"></i>
                        </div>
                        <div class="choose-currency flex items-center gap-1.5">
                            <select name="currency" id="chooseCurrencyFooter" class="caption2 bg-transparent">
                                <option value="INR" selected>INR</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                            </select>
                            <i class="ph ph-caret-down text-xs text-[#1F1F1F]"></i>
                        </div>
                    </div>
                </div>
                <div class="right flex items-center gap-2">
                    <div class="caption1 text-secondary">Payment:</div>
                    <div class="payment-img">
                        <img src="{{ asset('assets/images/payment/Frame-0.png') }}" alt="payment" class="w-9" />
                    </div>
                    <div class="payment-img">
                        <img src="{{ asset('assets/images/payment/Frame-1.png') }}" alt="payment" class="w-9" />
                    </div>
                    <div class="payment-img">
                        <img src="{{ asset('assets/images/payment/Frame-2.png') }}" alt="payment" class="w-9" />
                    </div>
                    <div class="payment-img">
                        <img src="{{ asset('assets/images/payment/Frame-3.png') }}" alt="payment" class="w-9" />
                    </div>
                    <div class="payment-img">
                        <img src="{{ asset('assets/images/payment/Frame-4.png') }}" alt="payment" class="w-9" />
                    </div>
                    <div class="payment-img">
                        <img src="{{ asset('assets/images/payment/Frame-5.png') }}" alt="payment" class="w-9" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top-btn" href="#top-nav"><i class="ph-bold ph-caret-up"></i></a>
