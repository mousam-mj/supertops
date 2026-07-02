@php
    $mc = $mainCategory ?? null;
    if (! $mc || ! ($mc->bottom_banner_section_enabled ?? true)) {
        return;
    }
    $showText = $mc->bottom_banner_show_text ?? true;
    $subtext = trim((string) ($mc->bottom_banner_subtext ?? ''));
    $heading = trim((string) ($mc->bottom_banner_text ?? ''));
    $buttonText = trim((string) ($mc->bottom_banner_button_text ?? '')) ?: 'Shop Now';
    $buttonUrl = setting_link_url($mc->bottom_banner_button_url ?? null, route('shop'));
    $bgUrls = banner_picture_urls($mc->bottom_banner_bg_image, $mc->bottom_banner_bg_image_mobile, 'assets/images/slider/bg-toys.png');
    $productUrls = banner_picture_urls($mc->bottom_banner_image, $mc->bottom_banner_image_mobile, 'assets/images/banner/perch123(1).webp');
    if ($subtext === '') {
        $subtext = 'Sale! Up To 50% Off!';
    }
    if ($heading === '') {
        $heading = 'Perch Bottle on sale';
    }
@endphp
<div class="category-bottom-sale-banner container md:mt-10 mt-6 px-4 sm:px-5">
    <a href="{{ $buttonUrl }}" class="block rounded-xl md:rounded-[40px] overflow-hidden no-underline text-inherit">
        <div class="bg-[#EBFCF5] w-full relative flex max-sm:flex-col-reverse items-stretch min-h-[280px] md:min-h-[320px] max-h-[280px] md:max-h-[320px]">
            @if(trim((string) ($mc->bottom_banner_bg_image_mobile ?? '')) !== '')
                <img src="{{ $bgUrls['mobile'] }}" alt="" class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none md:hidden" aria-hidden="true" />
                <img src="{{ $bgUrls['desktop'] }}" alt="" class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none hidden md:block" aria-hidden="true" />
            @else
                <img src="{{ $bgUrls['desktop'] }}" alt="" class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none" aria-hidden="true" />
            @endif
            @if($showText)
            <div class="text-content sm:w-1/3 w-full max-sm:py-10 max-sm:px-6 sm:pl-10 md:pl-16 lg:pl-20 flex flex-col items-center sm:items-start justify-center z-[1] py-10 px-6 overflow-hidden">
                <div class="text-sub-display text-center sm:text-left line-clamp-2">{{ $subtext }}</div>
                <div class="heading1 text-center sm:text-left md:mt-4 mt-2 line-clamp-3">{{ $heading }}</div>
                <span class="button-main md:mt-8 mt-4 inline-block">{{ $buttonText }}</span>
            </div>
            @endif
            <div class="{{ $showText ? 'sm:w-2/3' : 'w-full' }} w-full min-h-[220px] sm:min-h-0 relative z-[1]">
                @if(trim((string) ($mc->bottom_banner_image_mobile ?? '')) !== '')
                    <img src="{{ $productUrls['mobile'] }}" alt="{{ $heading }}" class="w-full h-full min-h-[220px] sm:min-h-[280px] object-cover md:hidden" />
                    <img src="{{ $productUrls['desktop'] }}" alt="{{ $heading }}" class="w-full h-full min-h-[220px] sm:min-h-[280px] object-cover hidden md:block" />
                @else
                    <img src="{{ $productUrls['desktop'] }}" alt="{{ $heading }}" class="w-full h-full min-h-[220px] sm:min-h-[280px] object-cover" />
                @endif
            </div>
        </div>
    </a>
</div>
