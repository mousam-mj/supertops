@props([
    'desktop' => null,
    'mobile' => null,
    'default' => null,
    'alt' => '',
    'class' => 'w-full',
])
@php
    $urls = banner_picture_urls($desktop, $mobile, $default);
    $hasMobile = trim((string) $mobile) !== '';
@endphp
@if($hasMobile)
    <picture>
        <source media="(max-width: 767px)" srcset="{{ $urls['mobile'] }}">
        <img {{ $attributes->merge(['src' => $urls['desktop'], 'alt' => $alt, 'class' => $class]) }}>
    </picture>
@else
    <img {{ $attributes->merge(['src' => $urls['desktop'], 'alt' => $alt, 'class' => $class]) }}>
@endif
