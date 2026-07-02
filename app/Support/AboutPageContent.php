<?php

namespace App\Support;

class AboutPageContent
{
    /** Inserted in stored HTML; replaced on render with admin benefit icons. */
    public const BENEFIT_MARKER = '<!--PERCH_BENEFIT_BLOCK-->';

    /** @return array<string, string> Theme asset paths for About Us image settings. */
    public static function imageDefaults(): array
    {
        return [
            'about_us_banner_image' => 'assets/images/banner/bg-feature-pet1.png',
            'about_us_choose_image' => 'assets/images/instagram/p1(1).webp',
            'about_us_growth_image' => 'assets/images/instagram/p1(3).webp',
        ];
    }

    /** @return array<string, string> Default copy for About Us settings fields. */
    public static function settingsDefaults(): array
    {
        return [
            'about_us_hero_subtitle' => 'Welcome to Perch.',
            'about_us_hero_heading' => 'Everyday lifestyle essentials. Thoughtfully designed.',
            'about_us_hero_text_color' => '',
            'about_us_hero_text_align' => 'center',
            'about_us_intro_heading' => 'About Perch',
            'about_us_intro_subheading' => 'Modern Lifestyle Brand for Everyday Essentials',
            'about_us_intro_body' => "Perch is a modern lifestyle brand creating thoughtfully designed everyday essentials for work, home, travel, and everything in between. What started with premium insulated bottles has evolved into a growing collection across drinkware, barware, kitchenware, tiffin boxes, and utility essentials — with many more categories launching soon.\n\nBuilt for people who value design, functionality, and quality, Perch brings together products that look good, feel premium, and perform effortlessly in everyday life.",
            'about_us_choose_heading' => 'Designed for Modern Living',
            'about_us_choose_body' => 'At Perch, we believe everyday products should simplify life while elevating it. Every product is designed with a clear purpose - to blend seamlessly into your routine.',
            'about_us_choose_feature_label' => 'Our range is: -',
            'about_us_feature_1_title' => 'Functional & durable',
            'about_us_feature_1_text' => 'made for daily, long-term use',
            'about_us_feature_2_title' => 'Minimal & modern',
            'about_us_feature_2_text' => 'clean designs that never go out of style',
            'about_us_feature_3_title' => 'Safe & reliable',
            'about_us_feature_3_text' => 'crafted using high-quality, food-grade materials',
            'about_us_choose_footer' => 'From keeping beverages hot or cold, to organising meals, upgrading your bar setup, or improving your kitchen experience - Perch products are made to work beautifully, every day.',
            'about_us_quote_heading' => 'A Lifestyle Brand, Not Just Products',
            'about_us_quote_body' => "Perch goes beyond utility. We're building a lifestyle brand rooted in conscious choices, modern aesthetics, and everyday practicality. Our focus is on: - Premium materials that are safe, sustainable, and long-lasting - Thoughtful innovation that solves real-life needs - Timeless designs that complement modern homes and lifestyles",
            'about_us_quote_subheading' => "We design essentials you'll reach for every day — not trends you'll replace tomorrow.",
            'about_us_growth_heading' => 'Growing With You',
            'about_us_growth_body' => "As lifestyles evolve, so do we. Perch is continuously expanding into new categories while staying true to our core values of quality, functionality, and design.\n\nWhether it's your morning coffee, office lunch, home bar, kitchen shelf, or travel bag — Perch is designed to be a part of your everyday moments.",
            'about_us_why_choose_label' => 'Why Choose Perch?',
            'about_us_why_1' => 'Premium lifestyle brand for everyday essentials',
            'about_us_why_2' => 'Designed in India for modern, urban living',
            'about_us_why_3' => 'High-quality drinkware, barware, kitchenware & more',
            'about_us_why_4' => 'Functional, minimal, and durable products',
            'about_us_why_5' => 'Built for work, home, travel, and gifting',
        ];
    }

    public static function setting(string $key): string
    {
        $defaults = array_merge(self::imageDefaults(), self::settingsDefaults());

        return (string) \App\Models\Setting::get($key, $defaults[$key] ?? '');
    }

    public static function settingImage(string $key): string
    {
        $stored = trim((string) \App\Models\Setting::get($key, ''));

        return setting_image_url($stored, self::imageDefaults()[$key] ?? '');
    }

    public static function defaultHtml(): string
    {
        return <<<'HTML'
<div class="slider-block style-one about-page-hero about-hero--fullbg relative z-0 overflow-hidden rounded-b-[28px] md:rounded-b-[40px] xl:py-[100px] px-4 md:py-20 py-14 w-full" style="background-image: url('/assets/images/banner/bg-feature-pet1.png');">
    <div class="slider-main relative z-[1] h-full w-full flex flex-col {{ $heroTextFlexClass }} {{ $heroTextColorClass }}">
        <div class="text-content w-full max-w-4xl px-4">
            <div class="text-sub-display text-center">Welcome to Perch.</div>
            <div class="heading2 text-center md:mt-4 mt-2">Everyday lifestyle essentials. Thoughtfully designed.</div>
        </div>
    </div>
</div>
<div class="about md:pt-20 pt-10">
    <div class="about-us-block">
        <div class="container">
            <div class="text flex items-center justify-center">
                <div class="content md:w-5/6 w-full">
                    <div class="heading4 font-medium text-center">About Perch</div>
                    <div class="text-sub-display text-center">Modern Lifestyle Brand for Everyday Essentials</div>
                    <div class="body1 text-center md:mt-7 mt-5">
                        Perch is a modern lifestyle brand creating thoughtfully designed everyday essentials for work, home, travel, and everything in between. What started with premium insulated bottles has evolved into a growing collection across drinkware, barware, kitchenware, tiffin boxes, and utility essentials — with many more categories launching soon.<br><br>
                        Built for people who value design, functionality, and quality, Perch brings together products that look good, feel premium, and perform effortlessly in everyday life.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="choose-us-block md:pt-20 pt-14 pb-7">
    <div class="container flex max-lg:flex-col max-lg:gap-y-8 items-center justify-between">
        <div class="bg-img lg:w-7/12 lg:pr-[45px] md:w-1/2 w-5/6">
            <img src="/assets/images/instagram/p1(1).webp" alt="" class="w-full rounded-2xl">
        </div>
        <div class="content lg:w-5/12 lg:pl-[45px]">
            <div class="heading4 font-medium">Designed for Modern Living</div>
            <div class="body1 mt-3">At Perch, we believe everyday products should simplify life while elevating it. Every product is designed with a clear purpose - to blend seamlessly into your routine.</div>
            <div class="list-feature lg:mt-10 mt-6">
                <div class="text-sub-display pb-7">Our range is: -</div>
                <div class="item flex items-center gap-5 p-5" style="background-color: antiquewhite; border-radius: 50px;">
                    <div class="icon bg-[#D1D0F9] rounded-full">
                        <i class="icon-return md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                    </div>
                    <div class="text-content">
                        <div class="heading6">Functional &amp; durable</div>
                        <div class="body1 text-secondary mt-2">made for daily, long-term use</div>
                    </div>
                </div>
                <div class="item flex items-center gap-5 lg:mt-8 mt-4 p-5" style="background-color: antiquewhite; border-radius: 50px;">
                    <div class="icon bg-[#D1D0F9] rounded-full">
                        <i class="icon-category md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                    </div>
                    <div class="text-content">
                        <div class="heading6">Minimal &amp; modern</div>
                        <div class="body1 text-secondary mt-2">clean designs that never go out of style</div>
                    </div>
                </div>
                <div class="item flex items-center gap-5 lg:mt-8 mt-4 p-5" style="background-color: antiquewhite; border-radius: 50px;">
                    <div class="icon bg-[#D1D0F9] rounded-full">
                        <i class="icon-guarantee md:text-3xl text-2xl flex items-center justify-center md:w-[68px] md:h-[68px] w-14 h-14"></i>
                    </div>
                    <div class="text-content">
                        <div class="heading6">Safe &amp; reliable</div>
                        <div class="body1 text-secondary mt-2">crafted using high-quality, food-grade materials</div>
                    </div>
                </div>
            </div>
            <div class="body1 font-normal mt-3">From keeping beverages hot or cold, to organising meals, upgrading your bar setup, or improving your kitchen experience - Perch products are made to work beautifully, every day.</div>
        </div>
    </div>
</div>
<div class="quote-block bg-linear py-[60px]">
    <div class="container items-center justify-center">
        <div class="heading4 font-medium text-center">A Lifestyle Brand, Not Just Products</div>
        <div class="body1 mt-7 text-center">Perch goes beyond utility. We're building a lifestyle brand rooted in conscious choices, modern aesthetics, and everyday practicality. Our focus is on: - Premium materials that are safe, sustainable, and long-lasting - Thoughtful innovation that solves real-life needs - Timeless designs that complement modern homes and lifestyles</div>
        <div class="heading6 mt-7 font-medium text-center">We design essentials you'll reach for every day — not trends you'll replace tomorrow.</div>
    </div>
</div>
<div class="why-choose-us md:pt-20 pt-10">
    <div class="container">
        <div class="content flex max-lg:flex-col items-center justify-between gap-y-8">
            <div class="left lg:w-1/2 sm:w-2/3 w-full lg:pr-4">
                <div class="bg-img">
                    <img src="/assets/images/instagram/p1(3).webp" alt="" class="w-full rounded-2xl">
                </div>
            </div>
            <div class="right lg:w-1/2 lg:pl-16">
                <div class="heading4">Growing With You</div>
                <div class="body1 mt-5">As lifestyles evolve, so do we. Perch is continuously expanding into new categories while staying true to our core values of quality, functionality, and design.<br><br>
                Whether it's your morning coffee, office lunch, home bar, kitchen shelf, or travel bag — Perch is designed to be a part of your everyday moments.</div>
                <div class="text-sub-display mt-7">Why Choose Perch?</div>
                <div class="list-feature mt-6 pt-6 border-t border-line">
                    <div class="item flex items-center justify-between pb-3 border-b border-line">
                        <div class="body1">Premium lifestyle brand for everyday essentials</div>
                    </div>
                    <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                        <div class="body1">Designed in India for modern, urban living</div>
                    </div>
                    <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                        <div class="body1">High-quality drinkware, barware, kitchenware &amp; more</div>
                    </div>
                    <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                        <div class="body1">Functional, minimal, and durable products</div>
                    </div>
                    <div class="item flex items-center justify-between pb-3 border-b border-line mt-3">
                        <div class="body1">Built for work, home, travel, and gifting</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--PERCH_BENEFIT_BLOCK-->
HTML;
    }

    /** True when DB content is placeholder / legacy policy text, not the full About layout. */
    public static function isPlaceholder(?string $content): bool
    {
        $content = trim((string) $content);
        if ($content === '') {
            return true;
        }

        $needles = [
            'Edit this page to add content',
            'Customer Support',
            '7-Day Returns',
            'Perch Bottle is your trusted brand',
            'Easy Replacement',
            'Pan India Shipping',
        ];

        foreach ($needles as $needle) {
            if (str_contains($content, $needle)) {
                return true;
            }
        }

        return ! str_contains($content, 'about-page-hero');
    }
}
