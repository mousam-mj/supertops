<?php

use App\Models\Setting;

if (! function_exists('free_shipping_threshold')) {
    function free_shipping_threshold(): float
    {
        return (float) Setting::get('free_shipping_threshold', 499);
    }
}

if (! function_exists('qualifies_for_free_shipping')) {
    function qualifies_for_free_shipping(float $orderAmount): bool
    {
        return $orderAmount >= free_shipping_threshold();
    }
}

if (! function_exists('apply_free_shipping')) {
    function apply_free_shipping(float $shippingCharge, float $orderAmount): float
    {
        return qualifies_for_free_shipping($orderAmount) ? 0.0 : $shippingCharge;
    }
}
