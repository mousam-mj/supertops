@extends('layouts.app')

@section('title', ($page->title ?? 'About Us') . ' - Perch Bottle')

@section('content')
@php
    $aboutHeroBg = setting_image_url(\App\Models\Setting::get('about_us_banner_image'), 'assets/images/banner/bg-feature-pet1.png');
@endphp
<style>
    .about-page-hero.about-hero--fullbg {
        --about-hero-minh: clamp(22rem, 48vh, 38rem);
        isolation: isolate;
        min-height: var(--about-hero-minh);
        background-color: #9188c4;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
    }
    .about-page-hero.about-hero--fullbg > .slider-main {
        min-height: var(--about-hero-minh);
    }
    @media (max-width: 767.98px) {
        .about-page-hero .slider-main {
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
        }
        .about-page-hero .text-content {
            width: 100%;
            max-width: 22rem;
            margin-left: auto;
            margin-right: auto;
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        .about-page-hero .heading2 {
            font-size: clamp(1.2rem, 4.8vw, 1.65rem);
            line-height: 1.25;
        }
        .about-page-hero .sub-img {
            width: 100%;
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    }
    .about-page-content .about-page-hero.about-hero--fullbg {
        background-image: url('{{ $aboutHeroBg }}') !important;
    }
</style>
<div class="page-content about-page-content">
    @include('partials.about-page-body', ['content' => $page->content ?? ''])
</div>
@endsection
