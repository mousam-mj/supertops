@extends('layouts.app')

@section('title', ($page->title ?? 'About Us') . ' - Perch Bottle')

@section('content')
<div class="page-content about-page-content">
    @include('partials.about-page-structured')
</div>
@endsection
