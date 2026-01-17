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
    
    {{-- Session Messages --}}
    @if(session('success'))
        <div class="bg-green-500 text-white py-3 px-4 text-center relative z-50" id="session-message">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">✓ {{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('session-message').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white py-3 px-4 text-center relative z-50" id="session-error">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">✕ {{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('session-error').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-500 text-black py-3 px-4 text-center relative z-50" id="session-warning">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">⚠️ {{ session('warning') }}</span>
                    @if(session('email_sent') === false)
                        <form method="POST" action="{{ route('email.resend') }}" class="inline-block ml-4">
                            @csrf
                            <button type="submit" class="bg-black text-white px-4 py-1 rounded hover:bg-gray-800 text-sm">
                                Resend Verification Email
                            </button>
                        </form>
                    @endif
                </div>
                <button onclick="document.getElementById('session-warning').style.display='none'" class="ml-4 text-black hover:text-gray-700 text-xl">×</button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-500 text-white py-3 px-4 text-center relative z-50" id="session-info">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">ℹ️ {{ session('info') }}</span>
                </div>
                <button onclick="document.getElementById('session-info').style.display='none'" class="ml-4 text-white hover:text-gray-200 text-xl">×</button>
            </div>
        </div>
    @endif
    
    {{-- Email Verification Notice --}}
    @auth
        @if(!auth()->user()->email_verified_at && !session('warning'))
        <div class="bg-yellow-500 text-black py-3 px-4 text-center relative z-50">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex-1 text-center">
                    <span class="font-semibold">⚠️ Please verify your email address.</span>
                    <span class="ml-2">Check your inbox for the verification link.</span>
                </div>
                <form method="POST" action="{{ route('email.resend') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="bg-black text-white px-4 py-1 rounded hover:bg-gray-800 text-sm">
                        Resend Email
                    </button>
                </form>
            </div>
        </div>
        @endif
    @endauth
    
    @yield('content')
    
    @include('partials.scripts')
    @yield('scripts')
</body>
</html>
