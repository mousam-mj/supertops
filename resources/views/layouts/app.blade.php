<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'Anvogue')</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/perch-logo.png') }}" type="image/x-icon" />
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}" />
        <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}" />
    </head>

    
<body>
    @include('partials.header')
    
    @yield('content')
    
    @include('partials.scripts')
    @yield('scripts')
</body>
</html>
