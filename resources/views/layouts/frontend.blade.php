<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EDX Rulmenti Romania S.R.L.')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/EDX-LOGO-RULMENTI.webp') }}" type="image/x-icon">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .spec-table {
            width: 100%;
            border-collapse: collapse;
        }
        .spec-table tr {
            border-bottom: 1px solid #ccc;
        }
        .spec-table td {
            padding: 12px 0;
            font-size: 14px;
        }
        .spec-table td:last-child {
            text-align: right;
        }
        .properties-section {
            grid-column: 1 / 2;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .properties-section {
                margin-top: 20px;
            }
        }
        
        /* Footer Styles */
        .footer {
            background-color: #0f0f0f;
            color: #ffffff;
            padding: 104px 0 0px;
            font-family: Muli, sans-serif;
        }
        .footer-container {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 0 20px;
        }
        .footer-column {
            flex: 1;
            min-width: 200px;
            margin-bottom: 30px;
            padding: 0 15px;
        }
        .logo-box {
            background-color: #e31e24;
            width: 150px;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }
        .logo-text {
            font-size: 50px;
            line-height: 1;
        }
        .logo-subtext {
            font-size: 14px;
            letter-spacing: 2px;
        }
        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .footer-column ul {
            list-style: none;
        }
        .footer-column ul li {
            margin-bottom: 16px;
            position: relative;
            padding-left: 15px;
        }
        .footer-column ul li::before {
            content: "■";
            color: #e31e24;
            font-size: 10px;
            position: absolute;
            left: 0;
            top: 2px;
        }
        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-column ul li a:hover {
            color: #fff;
        }
        .copyright {
            color: #ccc;
            font-size: 14px;
            font-family: Roboto, sans-serif;
        }
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: #aaa;
        }
        .contact-item i {
            color: #e31e24;
            margin-right: 15px;
            margin-top: 5px;
        }
        .footer-bottom {
            max-width: 1200px;
            margin: 40px auto 0;
            padding: 20px;
            border-top: 1px solid #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #888;
            font-size: 14px;
        }
        .social-links {
            display: flex;
            gap: 10px;
        }
        .social-links a {
            background-color: #e31e24;
            color: white;
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            border-radius: 2px;
            transition: opacity 0.3s;
        }
        .social-links a:hover {
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
            }
            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
        }
        
        /* Product item styles */
        .edxpro {
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 20px;
        }
        .product-item .product-main .product-infor {
            position: relative;
            width: 60%;
            border-right: 1px solid #ccc;
            padding-right: 20px;
        }
        .product-item .product-main .action {
            padding-left: 20px;
        }
        .list-pagination button {
            width: 40px;
            height: 40px;
            border: 1px solid #ccc;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s;
        }
        .list-pagination button:hover,
        .list-pagination button.active {
            background: #e31e24;
            color: #fff;
            border-color: #e31e24;
        }
        .bg-green {
            background-color: #22c55e !important;
            color: #fff !important;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    @include('frontend.partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.partials.footer')
    
    <!-- Scroll to Top -->
    <a class="scroll-to-top-btn" href="#top-nav"><i class="ph-bold ph-caret-up"></i></a>
    
    <!-- Search Modal -->
    <div class="modal-search-block">
        <div class="modal-search-main md:p-10 p-6 rounded-[32px]">
            <div class="form-search relative w-full">
                <i class="ph ph-magnifying-glass absolute heading5 right-6 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                <input type="text" placeholder="Search bearings..." class="text-button-lg h-14 rounded-2xl border border-line w-full pl-6 pr-12" />
            </div>
            <div class="keyword mt-8">
                <div class="heading5">Popular Searches</div>
                <div class="list-keyword flex items-center flex-wrap gap-3 mt-4">
                    <button class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">Ball Bearing</button>
                    <button class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">Roller Bearing</button>
                    <button class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">Pillow Block</button>
                    <button class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">Taper Roller</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript Files -->
    <script src="{{ asset('assets/js/phosphor-icons.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
