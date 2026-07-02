@if(setting_flag('home_section_flash_sale_enabled', false))
@php
    $flashShowText = setting_flag('home_flash_sale_show_text', true);
    $flashTextColor = banner_text_color_class(\App\Models\Setting::get('home_flash_sale_text_color'));
    $flashUrl = setting_link_url(\App\Models\Setting::get('home_flash_sale_button_url'), route('shop'));
    $flashBg = setting_banner_picture_urls('home_flash_sale_bg_image', 'home_flash_sale_bg_image_mobile', 'assets/images/banner/bg-flash-sale-organic.png');
    $flashProduct = setting_banner_picture_urls('home_flash_sale_image', 'home_flash_sale_image_mobile', 'assets/images/image-flash-sale-organic.png');
@endphp
<div class="flash-sale-block relative mt-14 md:mt-20">
    <div class="bg-img absolute top-0 left-0 w-full h-full z-[-1]">
        <picture>
            <source media="(max-width: 767px)" srcset="{{ $flashBg['mobile'] }}">
            <img src="{{ $flashBg['desktop'] }}" alt="" class="w-full h-full object-cover">
        </picture>
    </div>
    <div class="container relative z-[1] flex max-md:flex-wrap items-center md:justify-end justify-center">
        <div class="bg-img sm:w-7/12 max-md:pt-8 w-[90%] relative md:pr-[100px] md:absolute md:top-1/2 md:-translate-y-1/2 md:left-0 z-[0]">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ $flashProduct['mobile'] }}">
                <img src="{{ $flashProduct['desktop'] }}" alt="" class="w-full object-cover">
            </picture>
        </div>
        @if($flashShowText)
        <div class="right flex items-center md:justify-center md:w-5/12 w-full lg:py-[156px] md:py-24 max-md:pt-3 max-md:pb-8">
            <div class="text-content text-center md:text-left {{ $flashTextColor }}">
                <div class="heading2">{{ \App\Models\Setting::get('home_flash_sale_heading', 'Flash Sale!') }}</div>
                <div class="body1 mt-3">{{ \App\Models\Setting::get('home_flash_sale_text', 'Get 20% off on selected items!') }}</div>
                <a href="{{ $flashUrl }}" class="button-main lg:mt-9 md:mt-6 mt-4 inline-block">{{ \App\Models\Setting::get('home_flash_sale_button_text', 'Shop Now') }}</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endif
