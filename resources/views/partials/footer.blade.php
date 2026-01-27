<div id="footer" class="footer" style="position: relative; z-index: 10; display: block !important; visibility: visible !important; width: 100%; clear: both; margin-top: 0;">
    <div class="footer-main bg-surface">
        <div class="container">
            <div class="content-footer md:py-[60px] py-10 flex justify-between flex-wrap gap-y-8">
                <div class="company-infor basis-1/4 max-lg:basis-full pr-7">
                    <a href="{{{ route('home') }}}" class="logo inline-block">
                        <img src="{{ asset('assets/images/perch-logo.png') }}" alt="Perch Logo" />
                    </a>
                    @php
                        $setting = \App\Models\Setting::first();
                    @endphp
                    <div class="flex gap-3 mt-3">
                        <div class="flex flex-col">
                            <span class="text-button">Mail:</span>
                            <span class="text-button mt-3">Phone:</span>
                            <span class="text-button mt-3">Address:</span>
                        </div>
                        <div class="flex flex-col">
                            <span>{{ $setting->email ?? 'info@perch.in' }}</span>
                            <span class="mt-[14px]">{{ $setting->phone ?? '91-9874563210' }}</span>
                            <span class="mt-3 pt-1">{{ $setting->address ?? 'Delhi India' }}</span>
                        </div>
                    </div>
                </div>
                <div class="right-content flex flex-wrap gap-y-8 basis-3/4 max-lg:basis-full">
                    <div class="list-nav flex justify-between basis-2/3 max-md:basis-full gap-4">
                        <div class="item flex flex-col basis-1/3">
                            <div class="text-button-uppercase pb-3">Infomation</div>
                            <a class="caption1 has-line-before duration-300 w-fit" href="{{{ route('contact') }}}">Contact us </a>
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
                            <a class="caption1 has-line-before duration-300 w-fit" href="{{{ route('faqs') }}}">FAQs </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('faqs') }}}">Shipping </a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('faqs') }}}">Privacy Policy</a>
                            <a class="caption1 has-line-before duration-300 w-fit pt-2" href="{{{ route('order-tracking') }}}">Return & Refund</a>
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
                            <a href="https://www.facebook.com/" target="_blank">
                                <div class="icon-facebook text-2xl text-black"></div>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank">
                                <div class="icon-instagram text-2xl text-black"></div>
                            </a>
                            <a href="https://www.twitter.com/" target="_blank">
                                <div class="icon-twitter text-2xl text-black"></div>
                            </a>
                            <a href="https://www.youtube.com/" target="_blank">
                                <div class="icon-youtube text-2xl text-black"></div>
                            </a>
                            <a href="https://www.pinterest.com/" target="_blank">
                                <div class="icon-pinterest text-2xl text-black"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom py-3 flex items-center justify-between gap-5 max-lg:justify-center max-lg:flex-col border-t border-line">
                <div class="left flex items-center gap-8">
                    <div class="copyright caption1 text-secondary">©2025 Perch. All Rights Reserved.</div>
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
