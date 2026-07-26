<?php

use App\Models\Setting;

if (! function_exists('benefit_block_items')) {
    /**
     * Four icon boxes shown on homepage, category pages, etc.
     *
     * @return list<array{icon: string, title: string, text: string}>
     */
    function benefit_block_items(): array
    {
        $defaults = [
            [
                'icon' => 'icon-phone-call',
                'title' => '24/7 Customer Service',
                'text' => "We're here to help you with any questions or concerns you have, 24/7.",
            ],
            [
                'icon' => 'icon-return',
                'title' => '14-Day Money Back',
                'text' => "If you're not satisfied with your purchase, simply return it within 14 days for a refund.",
            ],
            [
                'icon' => 'icon-guarantee',
                'title' => 'Our Guarantee',
                'text' => 'We stand behind our products and services and guarantee your satisfaction.',
            ],
            [
                'icon' => 'icon-delivery-truck',
                'title' => 'Shipping worldwide',
                'text' => 'We ship our products worldwide, making them accessible to customers everywhere.',
            ],
        ];

        $items = [];

        foreach ($defaults as $i => $default) {
            $n = $i + 1;
            $title = trim((string) Setting::get("benefit_{$n}_title", ''));
            $text = trim((string) Setting::get("benefit_{$n}_text", ''));
            $icon = trim((string) Setting::get("benefit_{$n}_icon", ''));

            $items[] = [
                'icon' => $icon !== '' ? $icon : $default['icon'],
                'title' => $title !== '' ? $title : $default['title'],
                'text' => $text !== '' ? $text : $default['text'],
            ];
        }

        return $items;
    }
}

if (! function_exists('product_benefit_items')) {
    /**
     * Three trust badges below Add to Cart on the product page.
     *
     * @return list<array{icon: string, title: string, text: string}>
     */
    function product_benefit_items(): array
    {
        $defaults = [
            [
                'icon' => 'icon-delivery-truck',
                'title' => 'Free shipping',
                'text' => 'Free shipping on orders over ₹499.',
            ],
            [
                'icon' => 'icon-phone-call',
                'title' => 'Support everyday',
                'text' => 'Support from 8:30 AM to 10:00 PM everyday',
            ],
            [
                'icon' => 'icon-return',
                'title' => '100 Day Returns',
                'text' => 'Not impressed? Get a refund. You have 100 days to break our hearts.',
            ],
        ];

        $items = [];

        foreach ($defaults as $i => $default) {
            $n = $i + 1;
            $title = trim((string) Setting::get("product_benefit_{$n}_title", ''));
            $text = trim((string) Setting::get("product_benefit_{$n}_text", ''));
            $icon = trim((string) Setting::get("product_benefit_{$n}_icon", ''));

            $items[] = [
                'icon' => $icon !== '' ? $icon : $default['icon'],
                'title' => $title !== '' ? $title : $default['title'],
                'text' => $text !== '' ? $text : $default['text'],
            ];
        }

        return $items;
    }
}
