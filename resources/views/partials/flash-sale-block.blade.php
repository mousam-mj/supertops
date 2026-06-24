@if(setting_flag('home_section_flash_sale_enabled', false))
<div class="flash-sale-block relative mt-14 md:mt-20">
    <div class="bg-img absolute top-0 left-0 w-full h-full z-[-1]">
        <img src="{{ setting_image_url(\App\Models\Setting::get('home_flash_sale_bg_image'), 'assets/images/banner/bg-flash-sale-organic.png') }}" alt="" class="w-full h-full object-cover">
    </div>
    <div class="container relative z-[1] flex max-md:flex-wrap items-center md:justify-end justify-center">
        <div class="bg-img sm:w-7/12 max-md:pt-8 w-[90%] relative md:pr-[100px] md:absolute md:top-1/2 md:-translate-y-1/2 md:left-0 z-[0]">
            <img src="{{ setting_image_url(\App\Models\Setting::get('home_flash_sale_image'), 'assets/images/image-flash-sale-organic.png') }}" alt="" class="w-full object-cover">
        </div>
        <div class="right flex items-center md:justify-center md:w-5/12 w-full lg:py-[156px] md:py-24 max-md:pt-3 max-md:pb-8">
            <div class="text-content text-center md:text-left">
                <div class="heading2">{{ \App\Models\Setting::get('home_flash_sale_heading', 'Flash Sale!') }}</div>
                <div class="body1 mt-3">{{ \App\Models\Setting::get('home_flash_sale_text', 'Get 20% off on selected items!') }}</div>
                @php $flashUrl = setting_link_url(\App\Models\Setting::get('home_flash_sale_button_url'), route('shop')); @endphp
                <a href="{{ $flashUrl }}" class="button-main bg-white text-black hover:bg-black hover:text-white lg:mt-9 md:mt-6 mt-4 inline-block">{{ \App\Models\Setting::get('home_flash_sale_button_text', 'Shop Now') }}</a>
            </div>
        </div>
    </div>
</div>
@endif
