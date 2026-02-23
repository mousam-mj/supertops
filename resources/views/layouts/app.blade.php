<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'Ricimart - Premium Mobile Accessories Store | Phone Cases, Chargers & More')</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/perch-logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}" />
    <style>
        /* Dark Theme Base Styles */
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #0f0f0f !important;
            color: white !important;
            overflow-x: hidden;
        }
        
        /* Animated Gradient Background */
        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff00cc, #3333ff, #00ffee, #ff0066);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            z-index: -1;
            filter: blur(120px);
            opacity: 0.4;
            top: 0;
            left: 0;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Animated Floating Mobile Accessories Background */
        .floating-earphones {
            position: fixed;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1 !important;
            pointer-events: none;
            overflow: hidden;
        }
        
        .accessory {
            position: absolute;
            font-size: 45px;
            opacity: 0.25 !important;
            animation: floatAccessory 25s infinite ease-in-out;
            filter: drop-shadow(0 0 20px rgba(255, 0, 204, 0.4)) drop-shadow(0 0 10px rgba(0, 255, 238, 0.3));
            will-change: transform;
            transition: all 0.3s ease;
        }
        
        .accessory:hover {
            opacity: 0.5 !important;
            transform: scale(1.2);
        }
        
        .accessory:nth-child(1) {
            left: 8%;
            animation-delay: 0s;
            animation-duration: 20s;
            font-size: 50px;
        }
        
        .accessory:nth-child(2) {
            left: 18%;
            animation-delay: 1.5s;
            animation-duration: 24s;
            font-size: 45px;
        }
        
        .accessory:nth-child(3) {
            left: 28%;
            animation-delay: 3s;
            animation-duration: 22s;
            font-size: 55px;
        }
        
        .accessory:nth-child(4) {
            left: 38%;
            animation-delay: 0.5s;
            animation-duration: 26s;
            font-size: 48px;
        }
        
        .accessory:nth-child(5) {
            left: 48%;
            animation-delay: 2s;
            animation-duration: 21s;
            font-size: 52px;
        }
        
        .accessory:nth-child(6) {
            left: 58%;
            animation-delay: 4s;
            animation-duration: 25s;
            font-size: 46px;
        }
        
        .accessory:nth-child(7) {
            left: 68%;
            animation-delay: 1s;
            animation-duration: 23s;
            font-size: 54px;
        }
        
        .accessory:nth-child(8) {
            left: 78%;
            animation-delay: 2.5s;
            animation-duration: 27s;
            font-size: 44px;
        }
        
        .accessory:nth-child(9) {
            left: 12%;
            animation-delay: 5s;
            animation-duration: 19s;
            font-size: 49px;
        }
        
        .accessory:nth-child(10) {
            left: 22%;
            animation-delay: 1.2s;
            animation-duration: 24s;
            font-size: 51px;
        }
        
        .accessory:nth-child(11) {
            left: 32%;
            animation-delay: 3.5s;
            animation-duration: 22s;
            font-size: 47px;
        }
        
        .accessory:nth-child(12) {
            left: 42%;
            animation-delay: 0.8s;
            animation-duration: 26s;
            font-size: 53px;
        }
        
        .accessory:nth-child(13) {
            left: 52%;
            animation-delay: 2.2s;
            animation-duration: 20s;
            font-size: 45px;
        }
        
        .accessory:nth-child(14) {
            left: 62%;
            animation-delay: 4.5s;
            animation-duration: 25s;
            font-size: 50px;
        }
        
        .accessory:nth-child(15) {
            left: 72%;
            animation-delay: 1.8s;
            animation-duration: 23s;
            font-size: 48px;
        }
        
        .accessory:nth-child(16) {
            left: 15%;
            animation-delay: 3.2s;
            animation-duration: 21s;
            font-size: 52px;
        }
        
        .accessory:nth-child(17) {
            left: 25%;
            animation-delay: 0.3s;
            animation-duration: 27s;
            font-size: 46px;
        }
        
        .accessory:nth-child(18) {
            left: 35%;
            animation-delay: 2.8s;
            animation-duration: 24s;
            font-size: 49px;
        }
        
        .accessory:nth-child(19) {
            left: 45%;
            animation-delay: 1.5s;
            animation-duration: 22s;
            font-size: 51px;
        }
        
        .accessory:nth-child(20) {
            left: 55%;
            animation-delay: 4.2s;
            animation-duration: 26s;
            font-size: 47px;
        }
        
        @keyframes floatAccessory {
            0% {
                transform: translateY(120vh) rotate(0deg) scale(0.7);
                opacity: 0;
            }
            8% {
                opacity: 0.25;
            }
            50% {
                transform: translateY(40vh) rotate(180deg) scale(1.15);
                opacity: 0.35;
            }
            92% {
                opacity: 0.25;
            }
            100% {
                transform: translateY(-20vh) rotate(360deg) scale(0.7);
                opacity: 0;
            }
        }
        
        .accessory {
            animation: floatAccessory 25s infinite ease-in-out;
        }
        
        /* Add floating effect with slight horizontal movement */
        @keyframes floatHorizontal {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(20px); }
        }
        
        .accessory:nth-child(odd) {
            animation: floatAccessory 25s infinite ease-in-out, floatHorizontal 6s infinite ease-in-out;
        }
        
        /* Responsive - Reduce accessories on mobile */
        @media (max-width: 768px) {
            .accessory:nth-child(n+12) {
                display: none;
            }
            
            .accessory {
                font-size: 30px !important;
                opacity: 0.2 !important;
            }
        }
        
        #main-content {
            background: transparent !important;
            color: white !important;
        }
        
        /* Glassmorphism Effects */
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .glass-effect-strong {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        /* Dark Theme Text Colors */
        .text-secondary {
            color: #aaa !important;
        }
        
        .text-black {
            color: white !important;
        }
        
        /* Dark Theme Backgrounds */
        .bg-surface {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }
        
        .bg-white,
        .bg-surface,
        .bg-linear {
            background: transparent !important;
        }
        
        /* Only apply glass effect to specific containers */
        .checkout-block,
        .product-item,
        .card,
        .modal-cart-main,
        .modal-wishlist-main,
        .modal-search-main {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(to right, #00ffee, #ff00cc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Gradient Button */
        .gradient-button {
            background: linear-gradient(45deg, #ff00cc, #3333ff);
            color: white;
            border: none;
            transition: all 0.4s;
        }
        
        .gradient-button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px #ff00cc;
        }
        
        /* Card Hover Effects */
        .card-hover {
            transition: all 0.4s;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 25px #00ffee;
        }
        
        /* Ricimart Branding Styles */
        .ricimart-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .ricimart-gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        /* Enhanced Button Styles */
        .button-main {
            transition: all 0.3s ease;
        }
        .button-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        /* Card Hover Effects */
        .banner-item:hover {
            transform: scale(1.02);
            transition: transform 0.3s ease;
        }
        /* Modern Shadow Effects */
        .modern-shadow {
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        .modern-shadow-lg {
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        }
        /* Cart, Wishlist & Search icons - ensure clickable */
        .header-menu .cart-icon,
        .header-menu .wishlist-icon,
        .header-menu .search-icon {
            position: relative;
            z-index: 10;
            pointer-events: auto;
        }
        /* Header hover states */
        .user-icon .login-popup {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s, visibility 0.3s, transform 0.3s;
            right: 0;
        }
        .user-icon:hover .login-popup {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        /* Proper header order on all pages - Fixed at top */
        .site-header {
            display: block !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            z-index: 1000 !important;
        }
        
        .site-header #top-nav {
            position: relative !important;
            top: 0 !important;
            bottom: auto !important;
            display: block !important;
            visibility: visible !important;
        }
        
        .site-header #header {
            display: block !important;
            visibility: visible !important;
        }
        
        /* Add padding to body to account for fixed header */
        body {
            padding-top: 118px !important;
        }
        
        @media (max-width: 768px) {
            body {
                padding-top: 86px !important;
            }
        }
        
        /* Dark Theme Header - Consistent on Scroll */
        #top-nav {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            position: relative !important;
        }
        
        #top-nav *,
        #top-nav p,
        #top-nav span,
        #top-nav div,
        #top-nav a,
        #top-nav i {
            color: white !important;
        }
        
        #top-nav .list-option {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        
        #top-nav .list-option li {
            color: white !important;
        }
        
        #top-nav .list-option li:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #00ffee !important;
        }
        
        #header {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            position: relative !important;
        }
        
        /* Override header-menu white background */
        #header .header-menu,
        #header .header-menu.fixed,
        .header-menu,
        .header-menu.fixed {
            background: rgba(15, 15, 15, 0.98) !important;
            background-color: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
        }
        
        /* Override any CSS variable white */
        #header,
        #header .header-menu,
        #header .header-menu.fixed {
            --white: rgba(15, 15, 15, 0.98) !important;
        }
        
        #header *,
        #header i,
        #header .icon-category,
        #header .ph-bold,
        #header .ph,
        #header a,
        #header span,
        #header div,
        #header p,
        #header li,
        #header ul {
            color: white !important;
        }
        
        #header .line {
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        #header .button-main {
            background: linear-gradient(45deg, #ff00cc, #3333ff) !important;
            color: white !important;
        }
        
        #header .login-popup .text-black {
            color: white !important;
        }
        
        #header .login-popup a {
            color: white !important;
        }
        
        #header .login-popup .text-secondary {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Ensure header stays dark on scroll */
        .site-header.scrolled #top-nav,
        .site-header.scrolled #header {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
        }
        
        /* Override any scroll-based color changes */
        .site-header,
        .site-header.scrolled,
        .site-header.scrolled #top-nav,
        .site-header.scrolled #header {
            background: rgba(15, 15, 15, 0.98) !important;
        }
        
        /* Prevent any JavaScript-based color changes */
        #top-nav[style*="background"],
        #header[style*="background"] {
            background: rgba(15, 15, 15, 0.98) !important;
        }
        
        /* Force header colors on all states */
        .site-header #top-nav,
        .site-header #header,
        .site-header.scrolled #top-nav,
        .site-header.scrolled #header,
        body.scrolled .site-header #top-nav,
        body.scrolled .site-header #header {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
        }
        
        /* Ensure all header text stays white */
        .site-header #top-nav *,
        .site-header #header *,
        .site-header.scrolled #top-nav *,
        .site-header.scrolled #header *,
        body.scrolled .site-header #top-nav *,
        body.scrolled .site-header #header * {
            color: white !important;
        }
    </style>
    <script>
        // Prevent scroll-based header color changes
        (function() {
            'use strict';
            
            function enforceHeaderColors() {
                const topNav = document.getElementById('top-nav');
                const header = document.getElementById('header');
                
                if (topNav) {
                    topNav.style.setProperty('background', 'rgba(15, 15, 15, 0.98)', 'important');
                    topNav.style.setProperty('backdrop-filter', 'blur(20px)', 'important');
                    topNav.style.setProperty('-webkit-backdrop-filter', 'blur(20px)', 'important');
                }
                
                if (header) {
                    header.style.setProperty('background', 'rgba(15, 15, 15, 0.98)', 'important');
                    header.style.setProperty('backdrop-filter', 'blur(20px)', 'important');
                    header.style.setProperty('-webkit-backdrop-filter', 'blur(20px)', 'important');
                }
            }
            
            // Enforce colors on load
            enforceHeaderColors();
            
            // Enforce colors on scroll
            window.addEventListener('scroll', function() {
                enforceHeaderColors();
            }, { passive: true });
            
            // Enforce colors periodically to prevent override
            setInterval(enforceHeaderColors, 100);
            
            // Enforce colors on DOM mutations
            const observer = new MutationObserver(function(mutations) {
                enforceHeaderColors();
            });
            
            const siteHeader = document.querySelector('.site-header');
            if (siteHeader) {
                observer.observe(siteHeader, {
                    attributes: true,
                    attributeFilter: ['style', 'class'],
                    subtree: true
                });
            }
        })();
    </script>
    <style>
        /* Mega Menu Dark Theme */
        .mega-menu {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        }
        
        .mega-menu * {
            color: white !important;
        }
        
        .mega-menu .text-button-uppercase {
            color: white !important;
        }
        
        .mega-menu .link {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .mega-menu .link:hover {
            color: #00ffee !important;
        }
        
        /* Sub Menu Dark Theme */
        .sub-menu {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        
        .sub-menu * {
            color: white !important;
        }
        
        /* Login Popup Dark Theme */
        .login-popup {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        
        .login-popup * {
            color: white !important;
        }
        
        .login-popup .text-black {
            color: white !important;
        }
        
        /* Dark Theme Footer */
        .footer {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 50px !important;
            display: block !important;
            visibility: visible !important;
        }
        
        /* Dark Theme Links */
        a {
            color: white !important;
        }
        
        a:hover {
            color: #00ffee !important;
        }
        
        /* Dark Theme - All Text Elements Must Be White */
        .heading1, .heading2, .heading3, .heading4, .heading5, .heading6,
        h1, h2, h3, h4, h5, h6,
        .text-title, .text-button, .text-button-lg, .text-button-uppercase,
        .body1, .body2, .body3,
        .caption1, .caption2,
        p, span, div, label, li, td, th,
        .text-secondary, .text-secondary2,
        .breadcrumb-product *, .breadcrumb-block *,
        .product-detail *, .product-page-content *,
        .checkout *, .cart *,
        .shop-product *, .list-product-block * {
            color: white !important;
        }
        
        /* Semi-transparent text for secondary elements */
        .text-secondary {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .text-secondary2 {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        
        /* Override any black text classes */
        .text-black {
            color: white !important;
        }
        
        /* Dark Theme Borders */
        .border-line, .border {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Dark Theme Inputs */
        input, textarea, select {
            background: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        input::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Buttons */
        button, .button-main, .btn {
            color: white !important;
        }
        
        /* Product page specific */
        .product-detail *,
        .product-page-content * {
            color: white !important;
        }
        
        /* Checkout page specific */
        .checkout *,
        .checkout-page * {
            color: white !important;
        }
        
        /* Shop page specific */
        .shop-product *,
        .list-product-block * {
            color: white !important;
        }
        
        /* Breadcrumb styling */
        .breadcrumb-product *,
        .breadcrumb-block *,
        .breadcrumb-main * {
            color: white !important;
        }
        
        /* Override white backgrounds that hide text */
        .bg-white {
            background: rgba(255, 255, 255, 0.05) !important;
        }
        
        .bg-linear {
            background: transparent !important;
        }
        
        /* Ensure icons are visible */
        i, .ph {
            color: white !important;
        }
        
        /* Table text */
        table, table *, th, td {
            color: white !important;
        }
        
        /* Form elements */
        form *, label, .form-group * {
            color: white !important;
        }
        
        /* Dark Theme Modal */
        .modal-cart-main, .modal-wishlist-main, .modal-search-main {
            background: rgba(15, 15, 15, 0.95) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important;
        }
        
        /* Dark Theme Search Modal */
        .modal-search-block {
            background: rgba(0, 0, 0, 0.8) !important;
        }
        
        .modal-search-main {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important;
        }
        
        .modal-search-main .heading5,
        .modal-search-main .heading6 {
            color: white !important;
        }
        
        .modal-search-main .close-btn {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }
        
        .modal-search-main .close-btn:hover {
            background: rgba(255, 255, 255, 0.2) !important;
        }
        
        .modal-search-main .item {
            color: white !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        .modal-search-main .item:hover {
            background: rgba(0, 255, 238, 0.2) !important;
            color: #00ffee !important;
            border-color: #00ffee !important;
        }
        
        /* Dark Theme Product Cards */
        .product-item {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 25px rgba(0, 255, 238, 0.3);
        }
        
        /* Dark Theme Search Modal Overlay */
        .modal-search-block {
            background: rgba(0, 0, 0, 0.8) !important;
        }
        
        /* Dark Theme Mobile Menu */
        #menu-mobile {
            background: rgba(0, 0, 0, 0.8) !important;
        }
        
        #menu-mobile .menu-container {
            background: rgba(15, 15, 15, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            color: white !important;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        #menu-mobile a,
        #menu-mobile .text-xl,
        #menu-mobile .text-title,
        #menu-mobile .heading {
            color: white !important;
        }
        
        #menu-mobile .link,
        #menu-mobile .text-secondary {
            color: #aaa !important;
        }
        
        #menu-mobile input {
            background: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        #menu-mobile input::placeholder {
            color: #aaa !important;
        }
        
        #menu-mobile .sub-nav-mobile {
            background: rgba(15, 15, 15, 0.98) !important;
            color: white !important;
        }
        
        #menu-mobile .back-btn {
            color: white !important;
        }
        
        #menu-mobile .back-btn:hover {
            color: #00ffee !important;
        }
        
        #menu-mobile i {
            color: white !important;
        }
        
        /* Ensure search modal backdrop is dark */
        .modal-search-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: -1;
        }
    </style>
    </head>

    
<body>
    {{-- Cart, Wishlist & Search - load first, before any other script --}}
    <script>
    (function(){
        function openCart() {
            var all = document.querySelectorAll('.modal-cart-block .modal-cart-main');
            var m = all.length ? all[all.length - 1] : null;
            if (m) { m.classList.add('open'); document.body.style.overflow='hidden'; if(window.loadCartItems) window.loadCartItems(); }
            else location.href='{{ route("cart.index") }}';
        }
        function openWishlist() {
            var all = document.querySelectorAll('.modal-wishlist-block .modal-wishlist-main');
            var m = all.length ? all[all.length - 1] : null;
            if (m) { m.classList.add('open'); document.body.style.overflow='hidden'; if(window.handleItemModalWishlist) window.handleItemModalWishlist(); }
            else location.href='{{ route("wishlist") }}';
        }
        function openSearch() {
            var main = document.querySelector('.modal-search-block .modal-search-main');
            if (main) { main.classList.add('open'); document.body.style.overflow='hidden'; }
        }
        document.addEventListener('click', function(e) {
            if (e.target.closest('.cart-icon')) { e.preventDefault(); e.stopPropagation(); openCart(); }
            else if (e.target.closest('.wishlist-icon')) { e.preventDefault(); e.stopPropagation(); openWishlist(); }
            else if (e.target.closest('.search-icon')) { e.preventDefault(); e.stopPropagation(); openSearch(); }
        }, true);
    })();
    </script>
    {{-- Ensure purple top bar is always first (fix for checkout/contact same header) --}}
    <script>
    (function(){
        function moveTopNavFirst() {
            var topNav = document.getElementById('top-nav');
            if (topNav && topNav.parentNode && document.body.firstChild) {
                document.body.insertBefore(topNav, document.body.firstChild);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', moveTopNavFirst);
        } else {
            moveTopNavFirst();
        }
    })();
    </script>
    <div class="site-header">
        @include('partials.header')
    </div>
    
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
                        <form method="POST" action="{{{ route('email.resend') }}}" class="inline-block ml-4">
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
    
    {{-- Email Verification Notice - Disabled --}}

    <!-- Animated Floating Mobile Accessories Background -->
    <div class="floating-earphones">
        <div class="accessory">📱</div>
        <div class="accessory">🔌</div>
        <div class="accessory">🔋</div>
        <div class="accessory">🎧</div>
        <div class="accessory">📱</div>
        <div class="accessory">🔌</div>
        <div class="accessory">🔋</div>
        <div class="accessory">📱</div>
        <div class="accessory">🎧</div>
        <div class="accessory">🔌</div>
        <div class="accessory">📱</div>
        <div class="accessory">🔋</div>
        <div class="accessory">🎧</div>
        <div class="accessory">📱</div>
        <div class="accessory">🔌</div>
        <div class="accessory">🔋</div>
        <div class="accessory">📱</div>
        <div class="accessory">🎧</div>
        <div class="accessory">🔌</div>
        <div class="accessory">📱</div>
    </div>

    <main id="main-content" class="min-h-[50vh]" style="background: transparent !important; color: white !important; position: relative; z-index: 10 !important;">
        @yield('content')
    </main>

    @include('partials.footer')
    
    <!-- Search Modal - Dynamic live search -->
    <div class="modal-search-block" style="background: rgba(0, 0, 0, 0.8) !important;">
        <div class="modal-search-main md:p-10 p-6 rounded-[32px] relative" style="background: rgba(15, 15, 15, 0.98) !important; backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); color: white !important;">
            <div class="close-btn absolute top-6 right-6 w-10 h-10 rounded-full flex items-center justify-center duration-300 cursor-pointer z-10" style="background: rgba(255, 255, 255, 0.1) !important; color: white !important;" onmouseover="this.style.background='rgba(255, 255, 255, 0.2)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'" onclick="document.querySelector('.modal-search-block .modal-search-main')?.classList.remove('open');document.body.style.overflow=''">
                <i class="ph ph-x text-xl"></i>
            </div>
            <div class="form-search relative w-full">
                <form method="GET" action="{{{ route('search') }}}" id="searchModalForm">
                    <input type="text" name="q" id="searchModalInput" placeholder="What are you looking for?" class="text-button-lg h-14 rounded-2xl border w-full pl-6 pr-14" style="background: rgba(255, 255, 255, 0.05) !important; color: white !important; border-color: rgba(255, 255, 255, 0.2) !important;" autocomplete="off" />
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-full" style="color: white !important;" onmouseover="this.style.background='rgba(255, 255, 255, 0.1)'" onmouseout="this.style.background='transparent'">
                        <i class="ph ph-magnifying-glass heading5"></i>
                    </button>
                </form>
            </div>
            <div class="keyword mt-8">
                <div class="heading5" style="color: white !important;">Popular searches</div>
                <div class="list-keyword flex items-center flex-wrap gap-3 mt-4">
                    <button type="button" class="item px-4 py-1.5 border rounded-full cursor-pointer duration-300" style="color: white !important; border-color: rgba(255, 255, 255, 0.2) !important; background: transparent;" onmouseover="this.style.background='rgba(0, 255, 238, 0.2)'; this.style.color='#00ffee'; this.style.borderColor='#00ffee';" onmouseout="this.style.background='transparent'; this.style.color='white'; this.style.borderColor='rgba(255, 255, 255, 0.2)';" onclick="window.location.href='{{{ route('search', ['q' => 'Phone Case']) }}}'">Phone Case</button>
                    <button type="button" class="item px-4 py-1.5 border rounded-full cursor-pointer duration-300" style="color: white !important; border-color: rgba(255, 255, 255, 0.2) !important; background: transparent;" onmouseover="this.style.background='rgba(0, 255, 238, 0.2)'; this.style.color='#00ffee'; this.style.borderColor='#00ffee';" onmouseout="this.style.background='transparent'; this.style.color='white'; this.style.borderColor='rgba(255, 255, 255, 0.2)';" onclick="window.location.href='{{{ route('search', ['q' => 'Charger']) }}}'">Charger</button>
                    <button type="button" class="item px-4 py-1.5 border rounded-full cursor-pointer duration-300" style="color: white !important; border-color: rgba(255, 255, 255, 0.2) !important; background: transparent;" onmouseover="this.style.background='rgba(0, 255, 238, 0.2)'; this.style.color='#00ffee'; this.style.borderColor='#00ffee';" onmouseout="this.style.background='transparent'; this.style.color='white'; this.style.borderColor='rgba(255, 255, 255, 0.2)';" onclick="window.location.href='{{{ route('search', ['q' => 'Headphone']) }}}'">Headphone</button>
                    <button type="button" class="item px-4 py-1.5 border rounded-full cursor-pointer duration-300" style="color: white !important; border-color: rgba(255, 255, 255, 0.2) !important; background: transparent;" onmouseover="this.style.background='rgba(0, 255, 238, 0.2)'; this.style.color='#00ffee'; this.style.borderColor='#00ffee';" onmouseout="this.style.background='transparent'; this.style.color='white'; this.style.borderColor='rgba(255, 255, 255, 0.2)';" onclick="window.location.href='{{{ route('search', ['q' => 'Power Bank']) }}}'">Power Bank</button>
                </div>
            </div>
            <div class="search-results-dynamic mt-8" id="searchModalResults">
                <div class="heading6" id="searchResultsTitle" style="color: white !important;">Latest products</div>
                <div class="list-product pb-5 hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4 mt-4" id="searchModalProductList">
                    @php
                        $recentProducts = \App\Models\Product::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->limit(4)
                            ->get();
                    @endphp
                    @forelse($recentProducts as $product)
                        <div class="product-item grid-type search-default-product">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="body1" style="color: #aaa !important;">No products yet. Start typing to search.</p>
                        </div>
                    @endforelse
                </div>
                <div class="search-loading hidden text-center py-6" id="searchModalLoading">
                    <span class="body1" style="color: #aaa !important;">Searching...</span>
                </div>
                <a href="{{{ route('search') }}}" class="button-main w-full text-center mt-4 hidden" id="searchModalViewAll" style="background: linear-gradient(45deg, #ff00cc, #3333ff) !important; color: white !important;">View all results</a>
            </div>
        </div>
    </div>
    
    <!-- Wishlist Modal -->
    <div class="modal-wishlist-block">
        <div class="modal-wishlist-main py-6">
            <div class="heading px-6 pb-3 flex items-center justify-between relative">
                <div class="heading5">Wishlist</div>
                <div class="close-btn absolute right-6 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                    <i class="ph ph-x text-sm"></i>
                </div>
            </div>
            <div class="list-product px-6"></div>
            <div class="footer-modal p-6 border-t bg-white border-line absolute bottom-0 left-0 w-full text-center">
                <a href="{{{ route('wishlist') }}}" class="button-main w-full text-center uppercase"> View All Wish List</a>
                <div class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">Or continue shopping</div>
            </div>
        </div>
    </div>
    
    <!-- Quick View Modal -->
    <div class="modal-quickview-block">
        <div class="modal-quickview-main py-6">
            <div class="flex h-full max-md:flex-col-reverse gap-y-6">
                <div class="left lg:w-[388px] md:w-[300px] flex-shrink-0 px-6">
                    <div class="list-img max-md:flex items-center gap-4">
                        <div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>
                <div class="right w-full px-6">
                    <div class="heading pb-6 flex items-center justify-between relative">
                        <div class="heading5">Quick View</div>
                        <div class="close-btn absolute right-0 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                            <i class="ph ph-x text-sm"></i>
                        </div>
                    </div>
                    <div class="product-infor">
                        <div class="flex justify-between">
                            <div>
                                <div class="category caption2 text-secondary font-semibold uppercase"></div>
                                <div class="name heading4 mt-1"></div>
                            </div>
                            <div class="add-wishlist-btn w-10 h-10 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white" data-product-id="">
                                <i class="ph ph-heart text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                            <div class="product-price heading5"></div>
                            <div class="product-origin-price font-normal text-secondary2" style="display:none"><del></del></div>
                            <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full" style="display:none"></div>
                            <div class="desc text-secondary mt-3" style="display:none"></div>
                        </div>
                        <div class="list-action mt-6">
                            <div class="list-color flex items-center gap-2 flex-wrap mt-3" style="display:none"></div>
                            <div class="list-size flex items-center gap-2 flex-wrap mt-3" style="display:none"></div>
                            <div class="choose-quantity flex items-center gap-5 mt-3">
                                <div class="quantity-block md:p-3 flex items-center justify-between rounded-lg border border-line sm:w-[180px] w-[120px] flex-shrink-0">
                                    <i class="ph-bold ph-minus cursor-pointer body1 quantity-decrease-qv"></i>
                                    <div class="quantity body1 font-semibold">1</div>
                                    <i class="ph-bold ph-plus cursor-pointer body1 quantity-increase-qv"></i>
                                </div>
                                <div class="add-cart-btn button-main w-full text-center bg-white text-black border border-black cursor-pointer" data-product-id="">Add To Cart</div>
                            </div>
                            <a href="#" class="button-main w-full text-center mt-5 block view-product-link">View Full Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cart Modal -->
    <div class="modal-cart-block">
        <div class="modal-cart-main flex">
            <div class="left w-1/2 border-r border-line py-6 max-md:hidden">
                <div class="heading5 px-6 pb-3">You May Also Like</div>
                <div class="list px-6">
                    <!-- Products will be loaded dynamically -->
                </div>
            </div>
            <div class="right cart-block md:w-1/2 w-full py-6 relative overflow-hidden">
                <div class="heading px-6 pb-3 flex items-center justify-between relative">
                    <div class="heading5">Shopping Cart</div>
                    <div class="close-btn absolute right-6 top-0 w-6 h-6 rounded-full bg-surface flex items-center justify-center duration-300 cursor-pointer hover:bg-black hover:text-white">
                        <i class="ph ph-x text-sm"></i>
                    </div>
                </div>
                <div class="time countdown-cart px-6">
                    <div class="flex items-center gap-3 px-5 py-3 bg-green rounded-lg">
                        <p class="text-3xl">🔥</p>
                        <div class="caption1">
                            Your cart will expire in <span class="text-red caption1 font-semibold"><span class="minute">04</span>:<span class="second">59</span></span> minutes!<br />
                            Please checkout now before your items sell out!
                        </div>
                    </div>
                </div>
                <div class="heading banner mt-3 px-6">
                    <div class="text">
                        Buy <span class="text-button"> ₹<span class="more-price">150</span>.00 </span>
                        <span>more to get </span>
                        <span class="text-button">freeship</span>
                    </div>
                    <div class="tow-bar-block mt-3">
                        <div class="progress-line"></div>
                    </div>
                </div>
                <div class="list-cart px-6 overflow-y-auto max-h-[400px]">
                    <!-- Cart items will be loaded dynamically -->
                </div>
                <div class="footer-cart p-6 border-t border-line bg-white absolute bottom-0 left-0 w-full">
                    <div class="total flex items-center justify-between mb-4">
                        <div class="text-button-uppercase">Total:</div>
                        <div class="text-title">₹<span class="total-price">0.00</span></div>
                    </div>
                    <a href="{{{ route('checkout.index') }}}" class="button-main w-full text-center uppercase">Checkout</a>
                    <a href="{{{ route('cart.index') }}}" class="text-button-uppercase continue mt-4 text-center has-line-before cursor-pointer inline-block">View Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.scripts')
    @yield('scripts')
    
    <script>
        // Header interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuMobileIcon = document.querySelector('.menu-mobile-icon');
            const menuMobile = document.getElementById('menu-mobile');
            const closeMenuBtn = document.querySelector('.close-menu-mobile-btn');
            
            if (menuMobileIcon && menuMobile) {
                menuMobileIcon.addEventListener('click', function() {
                    menuMobile.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            if (closeMenuBtn && menuMobile) {
                closeMenuBtn.addEventListener('click', function() {
                    menuMobile.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            // Close search modal (backdrop click + ESC)
            const searchModal = document.querySelector('.modal-search-block');
            const searchModalMain = document.querySelector('.modal-search-block .modal-search-main');
            if (searchModal && searchModalMain) {
                searchModal.addEventListener('click', function(e) {
                    if (e.target === searchModal) {
                        searchModalMain.classList.remove('open');
                        document.body.style.overflow = '';
                    }
                });
                searchModalMain.addEventListener('click', function(e) { e.stopPropagation(); });
            }
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const sm = document.querySelector('.modal-search-block .modal-search-main');
                    if (sm && sm.classList.contains('open')) {
                        sm.classList.remove('open');
                        document.body.style.overflow = '';
                    }
                    if (menuMobile && menuMobile.classList.contains('active')) {
                        menuMobile.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            });

            // Dynamic live search in modal
            const searchInput = document.getElementById('searchModalInput');
            const searchList = document.getElementById('searchModalProductList');
            const searchTitle = document.getElementById('searchResultsTitle');
            const searchLoading = document.getElementById('searchModalLoading');
            const searchViewAll = document.getElementById('searchModalViewAll');
            const defaultProducts = searchList ? searchList.innerHTML : '';
            let searchTimeout = null;
            if (searchInput && searchList) {
                searchInput.addEventListener('input', function() {
                    const q = (this.value || '').trim();
                    clearTimeout(searchTimeout);
                    if (q.length >= 2) {
                        searchLoading.classList.remove('hidden');
                        searchList.classList.add('hidden');
                        searchViewAll.classList.add('hidden');
                        searchTimeout = setTimeout(function() {
                            fetch('{{ url("/search/ajax") }}?q=' + encodeURIComponent(q))
                                .then(r => r.text())
                                .then(html => {
                                    searchList.innerHTML = html || '<div class="col-span-full text-center py-8"><p class="body1 text-secondary">No products found</p></div>';
                                    searchList.classList.remove('hidden');
                                    searchTitle.textContent = 'Search results for "' + q + '"';
                                    searchViewAll.href = '{{ url("/search") }}?q=' + encodeURIComponent(q);
                                    searchViewAll.classList.remove('hidden');
                                })
                                .catch(function() {
                                    searchList.innerHTML = '<div class="col-span-full text-center py-8"><p class="body1 text-secondary">Search failed. Try again.</p></div>';
                                    searchList.classList.remove('hidden');
                                })
                                .finally(function() {
                                    searchLoading.classList.add('hidden');
                                    if (window.handleItemModalWishlist) window.handleItemModalWishlist();
                                    if (window.initQuickView) window.initQuickView?.();
                                });
                        }, 300);
                    } else {
                        searchList.innerHTML = defaultProducts;
                        searchList.classList.remove('hidden');
                        searchTitle.textContent = q.length ? 'Type at least 2 characters...' : 'Latest products';
                        searchViewAll.classList.add('hidden');
                        searchLoading.classList.add('hidden');
                    }
                });
                searchInput.addEventListener('focus', function() {
                    const q = (this.value || '').trim();
                    if (q.length >= 2) {
                        searchTitle.textContent = 'Search results for "' + q + '"';
                        searchViewAll.href = '{{ url("/search") }}?q=' + encodeURIComponent(q);
                        searchViewAll.classList.remove('hidden');
                    }
                });
            }
            
        });
    </script>
</body>
</html>
