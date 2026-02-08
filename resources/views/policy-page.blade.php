@extends('layouts.app')

@section('title', $page->title . ' - Perch Bottle')

@section('content')
<div class="page-content policy-page-content">
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">{{ $page->title }}</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2">{{ $page->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="policy-page-block md:py-20 py-10">
        <div class="container">
            <div class="content max-w-4xl mx-auto">
                <div class="body1 text-secondary policy-page-body">
                    @if(!empty(trim((string)$page->content)))
                        {!! $page->content !!}
                    @else
                        <p>Content for this page is being updated. Please check back later or <a href="{{ route('contact') }}" class="text-button hover:underline">contact us</a> for more information.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.policy-page-body { line-height: 1.7; }
.policy-page-body p { margin-bottom: 1rem; color: inherit; }
.policy-page-body p:first-child { margin-top: 0; }
.policy-page-body h5,
.policy-page-body .heading5 { font-weight: 600; color: #000 !important; margin-top: 2rem; margin-bottom: 0.5rem; font-size: 1.125rem; display: block; }
.policy-page-body h6,
.policy-page-body .heading6 { font-weight: 600; color: #000 !important; margin-top: 1.5rem; margin-bottom: 0.5rem; font-size: 1rem; display: block; }
.policy-page-body a,
.policy-page-body .text-button { color: var(--color-button, #667eea); text-decoration: none; }
.policy-page-body a:hover,
.policy-page-body .text-button:hover { text-decoration: underline; }
.policy-page-body ul { list-style: disc; padding-left: 1.5rem; margin: 1rem 0; }
.policy-page-body li { margin-bottom: 0.5rem; }
.policy-page-body .mt-8 { margin-top: 2rem; }
.policy-page-body .mt-6 { margin-top: 1.5rem; }
</style>
@endsection
