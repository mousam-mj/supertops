@php
    use App\Support\AboutPageContent;

    $heroBg = setting_banner_picture_urls('about_us_banner_image', 'about_us_banner_image_mobile', AboutPageContent::imageDefaults()['about_us_banner_image']);
    $chooseImage = setting_banner_picture_urls('about_us_choose_image', 'about_us_choose_image_mobile', AboutPageContent::imageDefaults()['about_us_choose_image']);
    $growthImage = setting_banner_picture_urls('about_us_growth_image', 'about_us_growth_image_mobile', AboutPageContent::imageDefaults()['about_us_growth_image']);

    $heroTextColorStored = trim((string) \App\Models\Setting::get('about_us_hero_text_color', ''));
    $heroTextColorClass = banner_text_color_class($heroTextColorStored !== '' ? $heroTextColorStored : null);
    $heroTextAlignClass = banner_text_align_class(AboutPageContent::setting('about_us_hero_text_align'));
    $heroTextFlexClass = banner_text_align_flex_class(AboutPageContent::setting('about_us_hero_text_align'));

    $introParagraphs = preg_split("/\n\s*\n/", trim(AboutPageContent::setting('about_us_intro_body'))) ?: [];
    $growthParagraphs = preg_split("/\n\s*\n/", trim(AboutPageContent::setting('about_us_growth_body'))) ?: [];

    $whyItems = [];
    for ($wi = 1; $wi <= 5; $wi++) {
        $line = trim(AboutPageContent::setting('about_us_why_'.$wi));
        if ($line !== '') {
            $whyItems[] = $line;
        }
    }
@endphp
<style>
    .about-page-hero.about-hero--fullbg {
        background-image: url('{{ $heroBg['mobile'] }}') !important;
    }
    @media (min-width: 768px) {
        .about-page-hero.about-hero--fullbg {
            background-image: url('{{ $heroBg['desktop'] }}') !important;
        }
    }
</style>
<div class="slider-block style-one about-page-hero about-hero--fullbg relative z-0 overflow-hidden rounded-b-[28px] md:rounded-b-[40px] xl:py-[100px] px-4 md:py-20 py-14 w-full">
    <div class="slider-main relative z-[1] h-full w-full flex flex-col {{ $heroTextFlexClass }} {{ $heroTextColorClass }}">
        <div class="text-content w-full max-w-4xl px-4">
            <div class="text-sub-display {{ $heroTextAlignClass }}">{{ AboutPageContent::setting('about_us_hero_subtitle') }}</div>
            <div class="heading2 {{ $heroTextAlignClass }} md:mt-4 mt-2">{{ AboutPageContent::setting('about_us_hero_heading') }}</div>
        </div>
    </div>
</div>
<div class="about md:pt-20 pt-10">
    <div class="about-us-block">
        <div class="container">
            <div class="text flex items-center justify-center">
                <div class="content md:w-5/6 w-full">
                    <div class="heading4 font-medium text-center">{{ AboutPageContent::setting('about_us_intro_heading') }}</div>
                    <div class="text-sub-display text-center">{{ AboutPageContent::setting('about_us_intro_subheading') }}</div>
                    <div class="body1 text-center md:mt-7 mt-5">
                        @foreach($introParagraphs as $index => $paragraph)
                            @if($index > 0)<br><br>@endif{!! nl2br(e(trim($paragraph))) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="choose-us-block md:pt-20 pt-14 pb-7">
    <div class="container flex max-lg:flex-col max-lg:gap-y-8 items-center justify-between">
        <div class="bg-img lg:w-7/12 lg:pr-[45px] md:w-1/2 w-5/6">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ $chooseImage['mobile'] }}">
                <img src="{{ $chooseImage['desktop'] }}" alt="" class="w-full rounded-2xl">
            </picture>
        </div>
        <div class="content lg:w-5/12 lg:pl-[45px]">
            <div class="heading4 font-medium">{{ AboutPageContent::setting('about_us_choose_heading') }}</div>
            <div class="body1 mt-3">{{ AboutPageContent::setting('about_us_choose_body') }}</div>
            <div class="list-feature lg:mt-10 mt-6">
                <div class="text-sub-display pb-7">{{ AboutPageContent::setting('about_us_choose_feature_label') }}</div>
                @foreach([
                    ['icon' => 'icon-return', 'title' => AboutPageContent::setting('about_us_feature_1_title'), 'text' => AboutPageContent::setting('about_us_feature_1_text')],
                    ['icon' => 'icon-category', 'title' => AboutPageContent::setting('about_us_feature_2_title'), 'text' => AboutPageContent::setting('about_us_feature_2_text')],
                    ['icon' => 'icon-guarantee', 'title' => AboutPageContent::setting('about_us_feature_3_title'), 'text' => AboutPageContent::setting('about_us_feature_3_text')],
                ] as $index => $feature)
                    <div class="item flex items-center gap-5 {{ $index > 0 ? 'lg:mt-8 mt-4' : '' }} p-5" style="background-color: antiquewhite; border-radius: 50px;">
                        <div class="icon bg-[#D1D0F9] rounded-full">
                            <i class="{{ $feature['icon'] }} md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                        </div>
                        <div class="text-content">
                            <div class="heading6">{{ $feature['title'] }}</div>
                            <div class="body1 text-secondary mt-2">{{ $feature['text'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="body1 font-normal mt-3">{{ AboutPageContent::setting('about_us_choose_footer') }}</div>
        </div>
    </div>
</div>
<div class="quote-block bg-linear py-[60px]">
    <div class="container items-center justify-center">
        <div class="heading4 font-medium text-center">{{ AboutPageContent::setting('about_us_quote_heading') }}</div>
        <div class="body1 mt-7 text-center">{{ AboutPageContent::setting('about_us_quote_body') }}</div>
        <div class="heading6 mt-7 font-medium text-center">{{ AboutPageContent::setting('about_us_quote_subheading') }}</div>
    </div>
</div>
<div class="why-choose-us md:pt-20 pt-10">
    <div class="container">
        <div class="content flex max-lg:flex-col items-center justify-between gap-y-8">
            <div class="left lg:w-1/2 sm:w-2/3 w-full lg:pr-4">
                <div class="bg-img">
                    <picture>
                        <source media="(max-width: 767px)" srcset="{{ $growthImage['mobile'] }}">
                        <img src="{{ $growthImage['desktop'] }}" alt="" class="w-full rounded-2xl">
                    </picture>
                </div>
            </div>
            <div class="right lg:w-1/2 lg:pl-16">
                <div class="heading4">{{ AboutPageContent::setting('about_us_growth_heading') }}</div>
                <div class="body1 mt-5">
                    @foreach($growthParagraphs as $index => $paragraph)
                        @if($index > 0)<br><br>@endif{!! nl2br(e(trim($paragraph))) !!}
                    @endforeach
                </div>
                <div class="text-sub-display mt-7">{{ AboutPageContent::setting('about_us_why_choose_label') }}</div>
                <div class="list-feature mt-6 pt-6 border-t border-line">
                    @foreach($whyItems as $index => $item)
                        <div class="item flex items-center justify-between pb-3 border-b border-line {{ $index > 0 ? 'mt-3' : '' }}">
                            <div class="body1">{{ $item }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="benefit-block md:pt-20 pt-10">
    <div class="container">
        @include('partials.benefit-items')
    </div>
</div>
