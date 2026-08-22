<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M4HGBWXD');</script>
        <!-- End Google Tag Manager -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'Perch Bottle')</title>
        @php
            $siteFavicon = \App\Models\Setting::get('site_favicon');
            $siteFaviconUrl = $siteFavicon ? storage_asset($siteFavicon) : asset('favicon.ico');
        @endphp
        <link rel="shortcut icon" href="{{ $siteFaviconUrl }}" />
        <link rel="icon" href="{{ $siteFaviconUrl }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-scss.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/output-tailwind.css') }}" />
    
    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .quantity-block input.quantity[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
        .quantity-block input.quantity[type="number"]::-webkit-outer-spin-button,
        .quantity-block input.quantity[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Cart, Wishlist & Search icons - ensure clickable */
        .header-menu .cart-icon,
        .header-menu .wishlist-icon,
        .header-menu .search-icon {
            position: relative;
            z-index: 10;
            pointer-events: auto;
        }
        .header-menu .cart-quantity,
        .header-menu .wishlist-quantity {
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            min-width: 1rem;
            padding-left: 2px;
            padding-right: 2px;
            font-variant-numeric: tabular-nums;
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
        /* Proper header order on all pages (Contact/Checkout same): purple bar top, then white nav */
        .site-header {
            display: block !important;
            position: relative !important;
            width: 100%;
            z-index: 100;
        }
        .site-header #top-nav {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
            display: block !important;
            visibility: visible !important;
        }
        .site-header #header {
            display: block !important;
            visibility: visible !important;
        }
        /* Mobile slide menu: close control always visible (Phosphor CDN can fail → empty icon) */
        #menu-mobile .close-menu-mobile-btn {
            z-index: 30 !important;
            min-width: 2.25rem;
            min-height: 2.25rem;
            background-color: #fff !important;
            border: 1px solid var(--line, #e9e9e9) !important;
            color: #111 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        #menu-mobile .close-menu-mobile-btn:not(:has(svg))::after {
            content: '\00d7';
            font-size: 1.35rem;
            line-height: 1;
            font-weight: 300;
            display: block;
        }
        /* Hide broken / invisible Phosphor glyph when × fallback is used */
        #menu-mobile .close-menu-mobile-btn:not(:has(svg)) i.ph {
            display: none !important;
        }
        /* Full-height drawer; phone = full width, lg+ = narrow panel (matches header.scss) */
        #menu-mobile.open {
            inset: 0 !important;
            left: 0 !important;
            top: 0 !important;
            min-height: 100vh !important;
            min-height: 100dvh !important;
            height: auto !important;
            display: flex !important;
            flex-direction: column !important;
        }
        @media (max-width: 1023.98px) {
            #menu-mobile.open {
                width: 100% !important;
                max-width: 100vw !important;
                right: 0 !important;
            }
        }
        @media (min-width: 1024px) {
            #menu-mobile.open {
                width: min(380px, 92vw) !important;
                max-width: 380px !important;
            }
        }
        #menu-mobile.open .menu-container {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 100%;
        }
        #menu-mobile.open .menu-mobile-inner {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }
        body.mobile-menu-open .site-header #header,
        body.mobile-menu-open .site-header .header-menu {
            overflow: visible !important;
        }
        /* Hide Compare Product button site-wide */
        .compare-btn {
            display: none !important;
        }
        .modal-search-block .search-modal-top {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
        }
        .modal-search-block .search-modal-top form {
            position: relative;
            flex: 1 1 auto;
            min-width: 0;
        }
        .modal-search-block .search-modal-submit {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 9999px;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .modal-search-block .search-modal-submit:hover {
            background-color: rgba(0, 0, 0, 0.06);
            color: #111;
        }
        .modal-search-block .search-modal-close {
            flex-shrink: 0;
            width: 2.75rem;
            height: 2.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 9999px;
            background: #f3f4f6;
            color: #6b7280;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .modal-search-block .search-modal-close:hover {
            background-color: #111;
            color: #fff;
        }
        .modal-search-block #searchModalInput {
            padding-right: 3.25rem;
        }
        .modal-search-block .modal-search-main {
            display: flex !important;
            flex-direction: column;
            max-height: min(90vh, calc(100dvh - 2rem));
            height: auto;
            overflow: hidden !important;
            overscroll-behavior: contain;
        }
        /* Prevent closed search modal product CTAs from capturing clicks through the page */
        .modal-search-block {
            pointer-events: none !important;
        }
        .modal-search-block:not(:has(.modal-search-main.open)),
        .modal-search-block:not(:has(.modal-search-main.open)) * {
            pointer-events: none !important;
        }
        .modal-search-block:has(.modal-search-main.open) {
            pointer-events: auto !important;
        }
        .modal-search-block:has(.modal-search-main.open) .modal-search-main,
        .modal-search-block:has(.modal-search-main.open) .modal-search-main * {
            pointer-events: auto;
        }
        /* grid-type cards force visibility:visible on CTAs — hide them when search modal is closed */
        .modal-search-block:not(:has(.modal-search-main.open)) .product-card-actions,
        .modal-search-block:not(:has(.modal-search-main.open)) .product-card-actions * {
            visibility: hidden !important;
        }
        .modal-cart-block,
        .modal-wishlist-block,
        .modal-quickview-block {
            pointer-events: none !important;
        }
        .modal-cart-block:not(:has(.modal-cart-main.open)),
        .modal-cart-block:not(:has(.modal-cart-main.open)) *,
        .modal-wishlist-block:not(:has(.modal-wishlist-main.open)),
        .modal-wishlist-block:not(:has(.modal-wishlist-main.open)) *,
        .modal-quickview-block:not(:has(.modal-quickview-main.open)),
        .modal-quickview-block:not(:has(.modal-quickview-main.open)) * {
            pointer-events: none !important;
        }
        .modal-cart-block:has(.modal-cart-main.open),
        .modal-wishlist-block:has(.modal-wishlist-main.open),
        .modal-quickview-block:has(.modal-quickview-main.open) {
            pointer-events: auto !important;
        }
        #wishlist-product-list .remove-from-wishlist {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }
        #wishlist-product-list .product-tag {
            z-index: 2;
        }
        .modal-cart-block:not(:has(.modal-cart-main.open)) .product-card-actions,
        .modal-cart-block:not(:has(.modal-cart-main.open)) .product-card-actions * {
            visibility: hidden !important;
        }
        .modal-search-block .search-modal-body {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .modal-search-block .search-results-dynamic {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .modal-search-block .search-modal-results-scroll {
            flex: 1 1 auto;
            min-height: 0;
            /* Explicit cap so results scroll even when flex height is content-sized */
            max-height: min(52vh, calc(100dvh - 18rem));
            overflow-x: hidden;
            overflow-y: auto !important;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-y;
            padding-right: 0.25rem;
        }
        .modal-search-block .search-modal-results-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .modal-search-block .search-modal-results-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.25);
            border-radius: 999px;
        }
        body.search-modal-open {
            overflow: hidden !important;
            touch-action: none;
        }
        @media (max-width: 640px) {
            .modal-search-block .modal-search-main {
                max-height: min(92vh, calc(100dvh - 1.5rem));
            }
            .modal-search-block .search-modal-results-scroll {
                max-height: min(48vh, calc(100dvh - 16rem));
            }
        }
        /* Mobile bottom tab bar — override global span/body line-height so labels don’t stack/overlap */
        .mobile-app-nav {
            box-sizing: border-box;
            /* Above main/footer; below modals (101) and slide menu (#menu-mobile 102) */
            z-index: 99 !important;
            position: fixed !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            max-width: 100vw !important;
            margin: 0 !important;
            background-color: #fff !important;
            border-top: 1px solid var(--line, #e9e9e9);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.07);
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            isolation: isolate;
            touch-action: manipulation;
        }
        .mobile-app-nav__grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            align-items: stretch;
            min-height: 3.5rem;
            padding-top: 0.35rem;
            padding-bottom: 0.35rem;
            width: 100%;
            max-width: 100%;
        }
        .mobile-app-nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            gap: 0.125rem;
            min-width: 0;
            padding-left: 0.0625rem;
            padding-right: 0.0625rem;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
            line-height: 1 !important;
            font-size: inherit;
            touch-action: manipulation;
        }
        .mobile-app-nav__link i {
            display: block;
            line-height: 1 !important;
            font-size: 1.25rem;
            width: 1.25rem;
            height: 1.25rem;
            text-align: center;
            flex-shrink: 0;
        }
        @media (min-width: 400px) {
            .mobile-app-nav__link i {
                font-size: 1.375rem;
                width: 1.375rem;
                height: 1.375rem;
            }
        }
        .mobile-app-nav__icon-slot {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
            flex-shrink: 0;
        }
        .mobile-app-nav__label {
            display: block;
            width: 100%;
            font-size: 0.5rem;
            line-height: 1.1 !important;
            text-align: center;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0;
            padding: 0;
            font-weight: 600;
            letter-spacing: -0.03em;
        }
        @media (min-width: 360px) {
            .mobile-app-nav__label {
                font-size: 0.5625rem;
            }
        }
        @media (min-width: 400px) {
            .mobile-app-nav__label {
                font-size: 0.625rem;
                letter-spacing: -0.02em;
            }
        }
        .mobile-app-nav .cart-quantity.mobile-app-nav__badge {
            position: absolute;
            top: -2px;
            right: -6px;
            min-width: 15px;
            height: 15px;
            padding: 0 3px;
            font-size: 9px;
            line-height: 15px !important;
            font-weight: 700;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Breathing room before footer (avoids content flush against grey footer band) */
        #main-content {
            padding-bottom: 30px;
        }
        /* Mobile tab bar: footer bottom padding clears fixed nav — keep main padding modest */
        @media (max-width: 1023.98px) {
            #footer.footer {
                padding-bottom: calc(5.25rem + env(safe-area-inset-bottom, 0px) + 16px);
            }
            /* Keep product text/CTA under the tab bar in compositor order */
            #main-content .product-item .product-infor,
            #main-content .product-item .product-price-block {
                position: relative;
                z-index: 0 !important;
            }
        }
        /* Product card: action buttons below thumbnail (not over the image) */
        .product-item.grid-type .product-card-actions {
            position: static;
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
            pointer-events: auto;
            width: 100%;
            padding: 0;
            gap: 0.5rem;
        }
        .product-item.grid-type .product-card-actions .add-cart-btn,
        .product-item.grid-type .product-card-actions .buy-now-btn,
        .product-item.grid-type .product-card-actions .product-card-action-btn {
            width: 100%;
            height: auto;
            min-height: 40px;
            min-width: 0;
            flex: 1 1 0;
            padding: 10px 12px !important;
            border-radius: 9999px;
            font-size: 0.6875rem;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: 0.02em;
        }
        .product-item.grid-type .product-card-actions .btn-label-short {
            display: none;
        }
        .product-item.grid-type .product-card-actions .btn-label-full {
            display: inline;
        }
        @media (max-width: 639.98px) {
            .product-item.grid-type .product-card-actions {
                gap: 0.375rem;
            }
            .product-item.grid-type .product-card-actions .add-cart-btn,
            .product-item.grid-type .product-card-actions .buy-now-btn,
            .product-item.grid-type .product-card-actions .product-card-action-btn {
                min-height: 36px;
                padding: 8px 6px !important;
                font-size: 0.625rem;
                gap: 0.25rem !important;
            }
            .product-item.grid-type .product-card-actions .add-cart-btn i,
            .product-item.grid-type .product-card-actions .buy-now-btn i,
            .product-item.grid-type .product-card-actions .product-card-action-btn i {
                font-size: 0.9375rem;
            }
            .product-item.grid-type .product-card-actions .btn-label-full {
                display: none;
            }
            .product-item.grid-type .product-card-actions .btn-label-short {
                display: inline;
            }
        }
        @media (min-width: 640px) {
            .product-item.grid-type .product-card-actions .add-cart-btn,
            .product-item.grid-type .product-card-actions .buy-now-btn,
            .product-item.grid-type .product-card-actions .product-card-action-btn {
                font-size: 0.75rem;
            }
        }
        /* Best Sellers tabs — mobile segmented control */
        #home-best-sellers-section .heading {
            width: 100%;
            padding-inline: 0.25rem;
        }
        #home-best-sellers-section .menu-tab {
            max-width: 100%;
            width: 100%;
            overflow: hidden;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        #home-best-sellers-section .menu-tab::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        #home-best-sellers-section .menu-tab .menu {
            justify-content: stretch;
            width: 100%;
            max-width: 100%;
            margin-inline: auto;
        }
        #home-best-sellers-section .menu-tab .tab-item {
            z-index: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #home-best-sellers-section .menu-tab .tab-item.active {
            color: var(--black, #000);
        }
        #home-best-sellers-section .menu-tab .indicator {
            border-radius: 9999px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            border: none;
        }
        @media (max-width: 767.98px) {
            #home-best-sellers-section .menu-tab .menu {
                gap: 0.2rem;
            }
            #home-best-sellers-section .menu-tab .tab-item {
                flex: 1 1 0;
                min-width: 0;
                padding-left: 0.35rem;
                padding-right: 0.35rem;
                font-size: 0.6875rem;
                line-height: 1.15;
                letter-spacing: 0.03em;
            }
        }
        @media (min-width: 768px) {
            #home-best-sellers-section .menu-tab .menu {
                width: max-content;
                max-width: 100%;
            }
            #home-best-sellers-section .menu-tab .tab-item {
                flex: 0 1 auto;
            }
        }
        .menu-tab {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .menu-tab::-webkit-scrollbar {
            display: none;
            height: 0;
        }
        /* Product page Related Products: Swiper h-full was stretching thumbs past 3:4 ratio */
        .tab-features-block .list-product.six-product .swiper-list-product,
        .tab-features-block .list-product.six-product .related-products-swiper,
        .tab-features-block .list-product.six-product .swiper-slide {
            height: auto !important;
        }
        .tab-features-block .list-product.six-product .product-item .product-thumb .product-img {
            height: auto !important;
            width: 100%;
            aspect-ratio: 3 / 4;
        }
        .tab-features-block .list-product.six-product .product-item .product-main {
            height: auto;
        }
        /* Related products: don't clip card actions or nav arrows */
        .related-products-section {
            overflow: visible;
        }
        .related-products-slider {
            overflow: visible;
            padding-left: 52px;
            padding-right: 52px;
        }
        .related-products-slider .related-products-swiper {
            overflow: hidden;
        }
        .related-products-slider .swiper-wrapper {
            height: auto !important;
            align-items: stretch;
        }
        .related-products-slider .swiper-slide {
            height: auto !important;
            overflow: visible !important;
        }
        .related-products-slider .product-item,
        .related-products-slider .product-item .product-main {
            height: auto;
            overflow: visible;
        }
        .related-products-slider .product-item .product-infor {
            margin-bottom: 0 !important;
            padding-bottom: 2px;
        }
        .related-products-slider .product-item .product-card-actions {
            overflow: visible;
        }
        .related-products-slider .product-item .product-sold {
            display: none !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }
        /* Arrows sit in slider side padding — fully visible */
        .related-products-slider.section-swiper-navigation.style-outline .related-products-prev,
        .related-products-slider.section-swiper-navigation.style-outline .related-products-next,
        .related-products-slider.section-swiper-navigation.style-outline .swiper-button-prev2,
        .related-products-slider.section-swiper-navigation.style-outline .swiper-button-next2 {
            top: 26%;
            transform: translateY(-50%);
        }
        .related-products-slider .related-products-prev,
        .related-products-slider .swiper-button-prev2.related-products-prev {
            left: 0 !important;
            right: auto !important;
        }
        .related-products-slider .related-products-next,
        .related-products-slider .swiper-button-next2.related-products-next {
            right: 0 !important;
            left: auto !important;
        }
        @media (max-width: 639.98px) {
            .related-products-slider {
                padding-left: 42px;
                padding-right: 42px;
            }
        }
        .related-products-slider .swiper-button-lock {
            display: none !important;
        }
        /* Shopping cart drawer uses .list-cart (not .list-product); thumb size + object-fit */
        .modal-cart-block .modal-cart-main .list-product .item,
        .modal-cart-block .modal-cart-main .list-cart .item {
            align-items: flex-start;
        }
        .modal-cart-block .modal-cart-main .list-product .item .infor,
        .modal-cart-block .modal-cart-main .list-cart .item .infor {
            align-items: flex-start;
            flex: 1 1 auto;
            min-width: 0;
        }
        /* Full product title — no single-line ellipsis in cart drawer */
        .modal-cart-block .modal-cart-main .list-cart .item .name,
        .modal-cart-block .modal-cart-main .list-product .item .name {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: unset !important;
            word-break: break-word;
            hyphens: auto;
            line-height: 1.35;
            max-width: 100%;
        }
        .modal-cart-block .modal-cart-main .cart-line-details {
            min-width: 0;
            flex: 1 1 auto;
        }
        .modal-cart-block .modal-cart-main .cart-line-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            width: 100%;
            gap: 10px;
        }
        .modal-cart-block .modal-cart-main .cart-line-title-row .name {
            flex: 1 1 auto;
            min-width: 0;
        }
        .modal-cart-block .modal-cart-main .cart-line-title-row .remove-cart-btn {
            flex-shrink: 0;
        }
        /* Narrow screens: remove button below row so title uses full width */
        @media (max-width: 767.98px) {
            .modal-cart-block .modal-cart-main .list-cart .item.product-item,
            .modal-cart-block .modal-cart-main .list-product .item.product-item {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 0.75rem !important;
            }
            .modal-cart-block .modal-cart-main .list-cart .item .infor,
            .modal-cart-block .modal-cart-main .list-product .item .infor {
                width: 100% !important;
                max-width: 100% !important;
            }
            .modal-cart-block .modal-cart-main .list-cart .item .remove-cart-item,
            .modal-cart-block .modal-cart-main .list-product .item .remove-cart-item {
                align-self: flex-end;
            }
            /* localStorage cart (main.js): title + “Remove” were on one squeezed row */
            .modal-cart-block .modal-cart-main .cart-line-title-row {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 6px !important;
            }
            .modal-cart-block .modal-cart-main .cart-line-title-row .remove-cart-btn {
                align-self: flex-end;
            }
        }
        .modal-cart-block .modal-cart-main .list-product .item .bg-img,
        .modal-cart-block .modal-cart-main .list-cart .item .bg-img {
            width: 120px !important;
            min-width: 120px !important;
            max-width: 120px !important;
            height: 120px !important;
            min-height: 120px !important;
            flex-shrink: 0 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: rgba(255, 255, 255, 0.06);
        }
        .modal-cart-block .modal-cart-main .list-product .item .bg-img img,
        .modal-cart-block .modal-cart-main .list-cart .item .bg-img img {
            width: 100% !important;
            height: 100% !important;
            max-width: none !important;
            max-height: none !important;
            object-fit: cover !important;
            display: block !important;
        }
        @media (max-width: 575.98px) {
            .modal-cart-block .modal-cart-main .list-cart .item .bg-img,
            .modal-cart-block .modal-cart-main .list-product .item .bg-img {
                width: 112px !important;
                min-width: 112px !important;
                max-width: 112px !important;
                height: 112px !important;
                min-height: 112px !important;
            }
        }
        /* Cart drawer — You May Also Like cards */
        .modal-cart-block .modal-cart-main .left .list {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: stretch;
        }
        .modal-cart-block .modal-cart-main .left .list .cart-upsell-card {
            border: 1px solid var(--line, #e9e9e9);
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            background: #fff;
        }
        .modal-cart-block .modal-cart-main .left .list .cart-upsell-card .product-main {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .modal-cart-block .modal-cart-main .left .list .cart-upsell-card .product-infor {
            position: static;
            padding: 12px;
            margin-top: 0 !important;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .modal-cart-block .modal-cart-main .left .list .cart-upsell-card .product-name {
            font-size: 13px;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
            width: 100%;
        }
        .modal-cart-block .modal-cart-main .left .list .cart-upsell-card .product-price {
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            width: 100%;
        }
        .modal-cart-block .modal-cart-main .left .list .cart-upsell-card .list-action {
            display: none !important;
        }
        .modal-quickview-block .modal-quickview-main .product-infor > .flex.justify-between {
            align-items: flex-start;
        }
        .modal-quickview-block .add-wishlist-btn {
            flex-shrink: 0;
            margin-top: 2px;
        }
        .qv-specs > div {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 0.5rem 1rem;
            align-items: start;
        }
        /* Two-block category cards (Home + Drinkware/Barware subcategories) */
        .home-two-categories .list-collection,
        .home-two-categories .banner-block,
        .home-two-categories .banner-block > .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .two-block-category-grid {
            width: 100%;
            max-width: 34rem;
            margin-left: auto;
            margin-right: auto;
            justify-items: stretch;
            justify-content: center;
        }
        @media (min-width: 640px) {
            .two-block-category-grid {
                max-width: 42rem;
            }
        }
        @media (min-width: 768px) {
            .two-block-category-grid {
                max-width: 52rem;
            }
        }
        @media (min-width: 1024px) {
            .two-block-category-grid {
                max-width: 60rem;
            }
        }
        .home-two-categories .banner-item,
        .category-subcategory-blocks .two-block-category-grid .banner-item {
            max-width: 100%;
            width: 100%;
        }
        .home-two-categories .banner-item .banner-img,
        .category-subcategory-blocks .two-block-category-grid .banner-item .banner-img {
            overflow: hidden;
            line-height: 0;
        }
        .home-two-categories .banner-item .banner-img img,
        .category-subcategory-blocks .two-block-category-grid .banner-item .banner-img img,
        .home-two-categories .banner-item .banner-img picture,
        .home-two-categories .banner-item .banner-img picture img,
        .category-subcategory-blocks .two-block-category-grid .banner-item .banner-img picture,
        .category-subcategory-blocks .two-block-category-grid .banner-item .banner-img picture img {
            width: 100% !important;
            height: auto !important;
            max-height: none !important;
            object-fit: contain !important;
            object-position: center center;
            opacity: 1 !important;
        }
        .home-two-categories .banner-item .banner-img img,
        .category-subcategory-blocks .two-block-category-grid .banner-item .banner-img img {
            display: block;
            transform: scale(1);
            transform-origin: center center;
            transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .home-two-categories .banner-item.banner-size-fixed,
        .home-two-categories .banner-item.banner-size-fixed.banner-aspect-1-1,
        .category-subcategory-blocks .two-block-category-grid .banner-item.banner-size-fixed,
        .category-subcategory-blocks .two-block-category-grid .banner-item.banner-size-fixed.banner-aspect-1-1 {
            aspect-ratio: auto !important;
            height: auto !important;
        }
        .home-two-categories .banner-item.banner-size-fixed .banner-img,
        .category-subcategory-blocks .two-block-category-grid .banner-item.banner-size-fixed .banner-img {
            position: relative !important;
            inset: auto !important;
            width: 100% !important;
            height: auto !important;
        }
        .home-two-categories .banner-item::before,
        .home-two-categories .banner-item::after,
        .home-two-categories .banner-item:hover::before,
        .home-two-categories .banner-item:hover::after,
        .home-two-categories .banner-item:focus-within::before,
        .home-two-categories .banner-item:focus-within::after,
        .category-subcategory-blocks .two-block-category-grid .banner-item::before,
        .category-subcategory-blocks .two-block-category-grid .banner-item::after,
        .category-subcategory-blocks .two-block-category-grid .banner-item:hover::before,
        .category-subcategory-blocks .two-block-category-grid .banner-item:hover::after,
        .category-subcategory-blocks .two-block-category-grid .banner-item:focus-within::before,
        .category-subcategory-blocks .two-block-category-grid .banner-item:focus-within::after {
            display: none !important;
            content: none !important;
            background: none !important;
            background-color: transparent !important;
            opacity: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }
        .home-two-categories .banner-item,
        .home-two-categories .banner-item:hover,
        .home-two-categories .banner-item:focus,
        .home-two-categories .banner-item:focus-visible,
        .category-subcategory-blocks .two-block-category-grid .banner-item,
        .category-subcategory-blocks .two-block-category-grid .banner-item:hover,
        .category-subcategory-blocks .two-block-category-grid .banner-item:focus,
        .category-subcategory-blocks .two-block-category-grid .banner-item:focus-visible {
            text-decoration: none !important;
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }
        .home-two-categories .banner-item:hover .banner-img img,
        .home-two-categories .banner-item:focus-within .banner-img img,
        .category-subcategory-blocks .two-block-category-grid .banner-item:hover .banner-img img,
        .category-subcategory-blocks .two-block-category-grid .banner-item:focus-within .banner-img img {
            transform: scale(1.06) !important;
            opacity: 1 !important;
        }
        .home-two-categories .banner-item .banner-img picture,
        .category-subcategory-blocks .two-block-category-grid .banner-item .banner-img picture {
            display: block;
            line-height: 0;
        }
        .home-two-categories .banner-item.banner-zoom-only .banner-img,
        .home-two-categories .banner-item.banner-zoom-only .banner-img img {
            border-radius: inherit;
        }
        @media (max-width: 767.98px) {
            .home-two-categories .banner-item.banner-size-fixed,
            .home-two-categories .banner-item.banner-size-fixed.banner-aspect-1-1 {
                aspect-ratio: auto !important;
                height: auto !important;
            }
            .home-two-categories .banner-item.banner-size-fixed .banner-img img,
            .home-two-categories .banner-item .banner-img img {
                object-fit: contain !important;
                object-position: center center !important;
                height: auto !important;
            }
        }
        /* Best Sellers wide banner — zoom only, no dark hover overlay */
        .home-best-sellers-banner.banner-block .banner-item {
            position: relative;
            display: block;
            overflow: hidden;
            line-height: 0;
        }
        .home-best-sellers-banner.banner-block .banner-item::before,
        .home-best-sellers-banner.banner-block .banner-item:hover::before,
        .home-best-sellers-banner.banner-block .banner-item:focus-within::before {
            display: none !important;
            content: none !important;
            background-color: transparent !important;
            opacity: 0 !important;
        }
        .home-best-sellers-banner.banner-block .banner-item .banner-img {
            overflow: hidden;
            line-height: 0;
        }
        .home-best-sellers-banner.banner-block .banner-item .banner-img img {
            display: block;
            width: 100%;
            height: auto;
            transform: scale(1);
            transform-origin: center center;
            transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
            opacity: 1 !important;
        }
        .home-best-sellers-banner.banner-block .banner-item:hover .banner-img img,
        .home-best-sellers-banner.banner-block .banner-item:focus-visible .banner-img img,
        .home-best-sellers-banner.banner-block .banner-item:focus-within .banner-img img {
            transform: scale(1.04);
            opacity: 1 !important;
        }
        .home-best-sellers-banner--show-text .banner-content {
            line-height: normal;
        }
        .home-best-sellers-banner--show-text .banner-content .heading2,
        .home-best-sellers-banner--show-text .banner-content .text-button,
        .home-best-sellers-banner.banner-block .banner-item:hover .heading2,
        .home-best-sellers-banner.banner-block .banner-item:hover .heading4,
        .home-best-sellers-banner.banner-block .banner-item:hover .text-button,
        .home-best-sellers-banner.banner-block .banner-item:hover .button-main,
        .home-best-sellers-banner.banner-block .banner-item:focus-within .heading2,
        .home-best-sellers-banner.banner-block .banner-item:focus-within .heading4,
        .home-best-sellers-banner.banner-block .banner-item:focus-within .text-button,
        .home-best-sellers-banner.banner-block .banner-item:focus-within .button-main {
            background-color: transparent !important;
            opacity: 1 !important;
            transform: none !important;
        }
        .banner-block .banner-item.banner-zoom-only::before,
        .banner-block .banner-item.banner-card-stable::before {
            background-color: transparent !important;
        }
        .banner-block .banner-item.banner-zoom-only:hover::before,
        .banner-block .banner-item.banner-card-stable:hover::before {
            background-color: transparent !important;
        }
        /* Keep centered banner CTAs fixed during hover (preserve -translate-x-1/2) */
        .banner-block .banner-item .button-main.absolute.left-1\/2,
        .banner-block .banner-item .heading4.absolute.left-1\/2 {
            transform: translateX(-50%);
        }
        .banner-block .banner-item:hover .button-main.absolute.left-1\/2,
        .banner-block .banner-item:focus-within .button-main.absolute.left-1\/2,
        .banner-block .banner-item:hover .heading4.absolute.left-1\/2,
        .banner-block .banner-item:focus-within .heading4.absolute.left-1\/2 {
            transform: translateX(-50%) !important;
        }
        /* Legacy absolutely positioned CTAs only — flex overlay buttons use banner-text-tone rules */
        .banner-block .banner-item.banner-card-stable:hover > .button-main,
        .banner-block .banner-item.banner-card-stable:focus-within > .button-main {
            opacity: 1 !important;
            color: inherit;
            background-color: var(--black, #000) !important;
            border: none !important;
        }
        .banner-block .banner-item.banner-card-stable:hover .banner-text-overlay .button-main,
        .banner-block .banner-item.banner-card-stable:focus-within .banner-text-overlay .button-main {
            opacity: 1 !important;
            border: none !important;
        }
        .banner-block .banner-item.banner-card-stable:hover .banner-text-tone-white .button-main,
        .banner-block .banner-item.banner-card-stable:focus-within .banner-text-tone-white .button-main {
            background: #fff !important;
            color: #000 !important;
            border-color: #fff !important;
        }
        .banner-block .banner-item.banner-card-stable:hover .banner-text-tone-black .button-main,
        .banner-block .banner-item.banner-card-stable:focus-within .banner-text-tone-black .button-main {
            background: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }
        .banner-block .banner-item.banner-card-stable:hover .banner-text-overlay:not([class*="banner-text-tone"]) .button-main,
        .banner-block .banner-item.banner-card-stable:focus-within .banner-text-overlay:not([class*="banner-text-tone"]) .button-main {
            background: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }
        /* Absolutely positioned CTAs keep horizontal centering on hover */
        .banner-block .banner-item.banner-card-stable:hover .button-main.absolute.left-1\/2,
        .banner-block .banner-item.banner-card-stable:focus-within .button-main.absolute.left-1\/2 {
            transform: translateX(-50%) !important;
        }
        /* Flex overlay CTAs stay centered — never apply translateX(-50%) (that shifts them off-center) */
        .banner-block .banner-item .banner-text-overlay .button-main,
        .category-hero-banner .banner-text-overlay .button-main,
        .banner-block .banner-item:hover .banner-text-overlay .button-main,
        .banner-block .banner-item:focus-within .banner-text-overlay .button-main,
        .banner-block .banner-item.banner-card-stable:hover .banner-text-overlay .button-main,
        .banner-block .banner-item.banner-card-stable:focus-within .banner-text-overlay .button-main {
            transform: none !important;
            position: relative;
            left: auto;
            right: auto;
            margin-left: auto;
            margin-right: auto;
            align-self: center;
        }
        .banner-block .banner-item.banner-card-stable .banner-img,
        .banner-block .banner-item.banner-zoom-only .banner-img {
            overflow: hidden;
        }
        .banner-block .banner-item.banner-zoom-only .banner-img img,
        .banner-block .banner-item.banner-card-stable .banner-img img {
            transform: scale(1);
            transform-origin: center center;
            transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .banner-block .banner-item.banner-zoom-only:hover .banner-img img,
        .banner-block .banner-item.banner-zoom-only:focus-within .banner-img img,
        .banner-block .banner-item.banner-card-stable:hover .banner-img img,
        .banner-block .banner-item.banner-card-stable:focus-within .banner-img img {
            transform: scale(1.06);
            opacity: 1 !important;
        }
        .banner-block .banner-item.banner-zoom-only .banner-img img,
        .banner-block .banner-item.banner-card-stable .banner-img img {
            opacity: 1 !important;
        }
        /* Fixed-size banner cards: text overlays must not change block height */
        .banner-block .banner-item.banner-size-fixed,
        .category-hero-banner.list-banner {
            display: block;
            position: relative;
            overflow: hidden;
        }
        .banner-block .banner-item.banner-size-fixed {
            aspect-ratio: 1 / 1;
        }
        .category-hero-banner.list-banner {
            aspect-ratio: 16 / 5;
        }
        .banner-block .banner-item.banner-size-fixed .banner-img,
        .category-hero-banner .banner-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            line-height: 0;
        }
        @media (max-width: 767.98px) {
            .category-hero-banner .banner-img {
                position: relative;
                inset: auto;
                height: auto;
                background-color: var(--surface, #f3f3f3);
            }
        }
        .banner-block .banner-item.banner-size-fixed .banner-img img,
        .banner-block .banner-item.banner-size-fixed .banner-img picture,
        .banner-block .banner-item.banner-size-fixed .banner-img picture img,
        .category-hero-banner .banner-img img,
        .category-hero-banner .banner-img picture,
        .category-hero-banner .banner-img picture img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            object-position: center center;
            display: block;
            aspect-ratio: unset !important;
        }
        @media (max-width: 767.98px) {
            .category-hero-banner.list-banner {
                aspect-ratio: auto;
                height: auto;
            }
            .category-hero-banner .banner-img img,
            .category-hero-banner .banner-img picture,
            .category-hero-banner .banner-img picture img {
                height: auto !important;
                object-fit: contain !important;
            }
            .category-hero-banner .banner-text-overlay {
                padding: 1rem 0.75rem 1.25rem;
                gap: 0.5rem;
            }
        }
        .home-best-sellers-banner.banner-block .banner-item.banner-size-fixed {
            aspect-ratio: 16 / 5;
        }
        @media (max-width: 767.98px) {
            .home-best-sellers-banner.banner-block .banner-item.banner-size-fixed {
                aspect-ratio: 1 / 1;
            }
        }
        .banner-block .banner-item.banner-size-fixed .banner-img {
            background-color: var(--surface, #f5f5f5);
        }
        .banner-block .banner-item.banner-size-fixed .banner-img img,
        .banner-block .banner-item.banner-size-fixed .banner-img picture img,
        .category-subcategory-blocks .banner-item.banner-size-fixed .banner-img img {
            object-fit: cover !important;
            object-position: center center;
        }
        .home-two-categories .banner-item.banner-size-fixed .banner-img img,
        .category-subcategory-blocks .two-block-category-grid .banner-item.banner-size-fixed .banner-img img {
            object-fit: contain !important;
            object-position: center center;
            height: auto !important;
        }
        .banner-block .banner-item.banner-size-fixed .banner-text-overlay,
        .category-hero-banner .banner-text-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
            padding: 1.5rem 1rem 2rem;
            pointer-events: none;
        }
        .banner-block .banner-item.banner-size-fixed .banner-text-overlay .banner-overlay-heading,
        .category-hero-banner .banner-text-overlay .banner-overlay-heading {
            margin: 0;
            max-width: 100%;
            text-align: center;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
        }
        .banner-text-tone-white .banner-overlay-heading,
        .banner-text-tone-white .heading1,
        .banner-text-tone-white .heading2,
        .banner-text-tone-white .heading3,
        .banner-text-tone-white .heading4,
        .banner-text-tone-white .body1,
        .banner-text-tone-white .text-sub-display,
        .flash-sale-block .banner-text-tone-white .heading2,
        .flash-sale-block .banner-text-tone-white .body1 {
            color: #fff !important;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.45);
        }
        .banner-text-tone-black .banner-overlay-heading,
        .banner-text-tone-black .heading1,
        .banner-text-tone-black .heading2,
        .banner-text-tone-black .heading3,
        .banner-text-tone-black .heading4,
        .banner-text-tone-black .body1,
        .banner-text-tone-black .text-sub-display,
        .flash-sale-block .banner-text-tone-black .heading2,
        .flash-sale-block .banner-text-tone-black .body1 {
            color: #000 !important;
            text-shadow: none;
        }
        .banner-text-tone-white .text-button {
            color: #fff !important;
            border-color: #fff !important;
        }
        .banner-text-tone-black .text-button {
            color: #000 !important;
            border-color: #000 !important;
        }
        .banner-text-tone-white .button-main {
            background: #fff !important;
            color: #000 !important;
            border-color: #fff !important;
        }
        .banner-text-tone-white .button-main:hover {
            background: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }
        .banner-text-tone-black .button-main {
            background: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }
        .banner-text-tone-black .button-main:hover {
            background: #fff !important;
            color: #000 !important;
            border-color: #000 !important;
        }
        .banner-block .banner-item.banner-size-fixed .banner-text-overlay .button-main,
        .category-hero-banner .banner-text-overlay .button-main {
            pointer-events: auto;
            flex-shrink: 0;
        }
        .banner-block .banner-item.banner-size-fixed.banner-aspect-3-4,
        .banner-block .banner-item.banner-size-fixed.banner-aspect-1-1 {
            aspect-ratio: 1 / 1;
        }
        .home-best-sellers-banner.banner-block .banner-item.banner-size-fixed .banner-img img,
        .home-best-sellers-banner.banner-block .banner-item.banner-size-fixed .banner-img picture img {
            object-fit: cover !important;
        }
        @media (min-width: 768px) {
            .category-hero-banner .banner-img img,
            .category-hero-banner .banner-img picture img {
                object-fit: cover !important;
            }
        }
        .home-best-sellers-banner .banner-text-overlay {
            justify-content: center;
        }
        /* Product gallery fit handled in product/show.blade.php (1:1 + thumbs row) */
        /* Product page: horizontal thumb strip below main image on mobile */
        @media (max-width: 639.98px) {
            .product-detail.style-grouped .product-gallery-wrap {
                width: 100%;
                max-width: 100%;
                overflow: hidden;
            }
            .product-detail.style-grouped .product-gallery-inner {
                position: relative !important;
                top: auto !important;
                display: flex;
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }
            .product-detail.style-grouped .product-gallery-main {
                order: 1;
                width: 100%;
                margin-left: 0 !important;
            }
            .product-detail.style-grouped .product-gallery-main .swiper-slide img {
                width: 100%;
                aspect-ratio: 1 / 1;
                object-fit: cover;
                display: block;
            }
            .product-detail.style-grouped .product-gallery-thumbs {
                order: 2;
                position: relative !important;
                width: 100% !important;
                max-width: 100%;
                margin: 0 !important;
                overflow: hidden;
            }
            .product-detail.style-grouped .product-gallery-thumbs .swiper-wrapper {
                position: relative !important;
                top: auto !important;
                left: auto !important;
                flex-direction: row !important;
                width: auto !important;
                height: auto !important;
            }
            .product-detail.style-grouped .product-gallery-thumbs .swiper-slide {
                width: 68px !important;
                height: 68px !important;
                flex-shrink: 0;
                border-radius: 12px;
                overflow: hidden;
                opacity: 0.55;
            }
            .product-detail.style-grouped .product-gallery-thumbs .swiper-slide-thumb-active {
                opacity: 1;
                border: 2px solid var(--black, #000);
            }
            .product-detail.style-grouped .product-gallery-thumbs .swiper-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            .product-detail.style-grouped .featured-product.underwear .mySwiper .swiper-wrapper,
            .product-detail.style-grouped .featured-product.cosmetic .mySwiper .swiper-wrapper {
                position: relative !important;
                top: auto !important;
                left: auto !important;
            }
        }
        /* Product lightbox: same image framing on web + mobile */
        .product-detail .popup-img {
            z-index: 1100;
        }
        .product-detail .popup-img .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .product-detail .popup-img img,
        .product-detail .popup-img .product-lightbox-img {
            width: auto !important;
            height: auto !important;
            max-width: min(92vw, 1100px) !important;
            max-height: 88vh !important;
            object-fit: contain !important;
            margin: 0 auto;
        }
        @media (max-width: 767.98px) {
            .product-detail .popup-img img,
            .product-detail .popup-img .product-lightbox-img {
                max-width: 92vw !important;
                max-height: 80vh !important;
            }
            .product-detail .popup-img .close-popup-btn {
                top: 12px;
                right: 12px;
            }
        }
        /* Specifications tab — consistent left alignment */
        .product-detail .desc-item.specifications {
            display: block;
            width: 100%;
        }
        .product-detail .product-specs-table {
            width: 100%;
            max-width: 40rem;
            margin-left: auto;
            margin-right: auto;
        }
        .product-detail .product-spec-row {
            align-items: flex-start;
            text-align: left;
        }
        .product-detail .product-spec-label {
            text-align: left;
            line-height: 1.5;
            padding-top: 0;
        }
        .product-detail .product-spec-value {
            text-align: left !important;
            line-height: 1.5;
            margin: 0;
            white-space: pre-line;
            word-break: break-word;
        }
        .product-detail .product-spec-value p {
            margin: 0;
            text-align: left;
        }
        .hero-slider-nav {
            color: #fff;
            background: rgba(0,0,0,0.35);
            width: 44px;
            height: 44px;
            border-radius: 9999px;
            z-index: 6;
        }
        .hero-slider-nav::after {
            font-size: 18px;
        }
        /* Home hero — small clickable line indicators */
        #home-content .hero-slider-pagination.swiper-pagination {
            position: absolute !important;
            left: 50% !important;
            bottom: 14px !important;
            top: auto !important;
            width: auto !important;
            transform: translateX(-50%);
            display: flex !important;
            justify-content: center;
            align-items: center;
            gap: 6px;
            padding: 0;
            margin: 0;
            z-index: 8;
            pointer-events: auto;
        }
        #home-content .hero-slider-pagination .swiper-pagination-bullet {
            width: 16px !important;
            height: 3px !important;
            border-radius: 999px !important;
            border: none !important;
            background: rgba(255, 255, 255, 0.45) !important;
            margin: 0 !important;
            opacity: 1 !important;
            cursor: pointer;
            transition: width 0.25s ease, background-color 0.25s ease;
        }
        #home-content .hero-slider-pagination .swiper-pagination-bullet::before {
            display: none !important;
            content: none !important;
        }
        #home-content .hero-slider-pagination .swiper-pagination-bullet-active {
            width: 28px !important;
            background: #fff !important;
            transform: none !important;
        }
        /* Home hero — full banner visible (no crop), stable slide height */
        #home-content .slider-block.style-two.home-hero-slider {
            height: auto !important;
            min-height: 0;
            aspect-ratio: 16 / 6;
            max-height: min(820px, 88vh);
            background: #f3f3f3;
            overflow: hidden;
        }
        @media (max-width: 1023.98px) {
            #home-content .slider-block.style-two.home-hero-slider {
                aspect-ratio: 4 / 3;
                max-height: min(560px, 72vh);
            }
        }
        @media (max-width: 767.98px) {
            #home-content .slider-block.style-two.home-hero-slider {
                aspect-ratio: auto !important;
                max-height: none !important;
                height: calc(100dvh - 86px) !important;
                min-height: calc(100dvh - 86px) !important;
            }
            #home-content .slider-block.style-two.home-hero-slider .sub-img img,
            #home-content .slider-block.style-two.home-hero-slider .sub-img picture,
            #home-content .slider-block.style-two.home-hero-slider .sub-img picture img {
                object-fit: cover !important;
                object-position: center center;
            }
        }
        #home-content .slider-block.style-two.home-hero-slider .slider-main,
        #home-content .slider-block.style-two.home-hero-slider .swiper.swiper-slider,
        #home-content .slider-block.style-two.home-hero-slider .swiper-wrapper,
        #home-content .slider-block.style-two.home-hero-slider .swiper-slide,
        #home-content .slider-block.style-two.home-hero-slider .slider-item {
            height: 100% !important;
            min-height: 0;
        }
        #home-content .slider-block.style-two.home-hero-slider .sub-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            line-height: 0;
            background: #f3f3f3;
        }
        #home-content .slider-block.style-two.home-hero-slider .sub-img img,
        #home-content .slider-block.style-two.home-hero-slider .sub-img picture,
        #home-content .slider-block.style-two.home-hero-slider .sub-img picture img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
            object-position: center center;
            display: block;
        }
        #home-content .slider-block.style-two.home-hero-slider .swiper-slide-active .sub-img img {
            animation: none;
            transform: none;
        }
        #home-content .slider-block.style-two .hero-slide-overlay .button-main:empty {
            display: none !important;
        }
        #home-content .slider-block.style-two .hero-slide-overlay .button-main {
            flex-shrink: 0;
        }
        .breadcrumb-product .product-nav-links {
            flex: 1 1 auto;
        }
        @media (max-width: 639.98px) {
            .breadcrumb-product .product-nav-links {
                justify-content: space-between;
            }
            .breadcrumb-product .prev-btn,
            .breadcrumb-product .next-btn {
                border: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .quantity-block {
                align-items: center !important;
            }
            .quantity-block i {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 2rem;
                height: 2rem;
            }
        }
        .modal-cart-block .modal-cart-main .list-product .item .infor > div:not(.bg-img) {
            min-width: 0;
            flex: 1;
        }
        .modal-cart-block .modal-cart-main .list-product .item .name {
            word-break: break-word;
        }
    </style>
    </head>

    
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M4HGBWXD"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    {{-- Storage path for JS (respects STORAGE_PUBLIC_PATH=media) --}}
    <script>window.STORAGE_PATH = '{{ ltrim(parse_url(config("filesystems.disks.public.url"), PHP_URL_PATH) ?? "/storage", "/") }}';</script>
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
        var searchModalScrollY = 0;
        function lockSearchBodyScroll() {
            searchModalScrollY = window.scrollY || window.pageYOffset || 0;
            document.body.classList.add('search-modal-open');
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + searchModalScrollY + 'px';
            document.body.style.left = '0';
            document.body.style.right = '0';
            document.body.style.width = '100%';
        }
        function unlockSearchBodyScroll() {
            document.body.classList.remove('search-modal-open');
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            document.body.style.width = '';
            window.scrollTo(0, searchModalScrollY);
        }
        function openSearch() {
            var main = document.querySelector('.modal-search-block .modal-search-main');
            if (main) {
                main.classList.add('open');
                lockSearchBodyScroll();
                var input = document.getElementById('searchModalInput');
                if (input) setTimeout(function() { input.focus(); }, 50);
            }
        }
        function closeSearch() {
            var main = document.querySelector('.modal-search-block .modal-search-main');
            if (main) {
                main.classList.remove('open');
                unlockSearchBodyScroll();
            }
        }
        window.closeSearch = closeSearch;
        window.lockSearchBodyScroll = lockSearchBodyScroll;
        window.unlockSearchBodyScroll = unlockSearchBodyScroll;
        function openMobileMenuFromBottom() {
            var mm = document.getElementById('menu-mobile');
            if (mm) { mm.classList.add('open'); document.body.style.overflow='hidden'; document.body.classList.add('mobile-menu-open'); }
        }
        document.addEventListener('click', function(e) {
            if (e.target.closest('.cart-icon')) { e.preventDefault(); e.stopPropagation(); openCart(); }
            else if (e.target.closest('[data-open-cart-modal]')) { e.preventDefault(); e.stopPropagation(); openCart(); }
            else if (e.target.closest('.wishlist-icon')) { e.preventDefault(); e.stopPropagation(); openWishlist(); }
            else if (e.target.closest('.search-icon')) { e.preventDefault(); e.stopPropagation(); openSearch(); }
            else if (e.target.closest('[data-open-search-modal]')) { e.preventDefault(); e.stopPropagation(); openSearch(); }
            else if (e.target.closest('[data-open-mobile-menu]')) { e.preventDefault(); e.stopPropagation(); openMobileMenuFromBottom(); }
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

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.mobile-bottom-nav')
    
    <!-- Search Modal - Dynamic live search -->
    <div class="modal-search-block">
        <div class="modal-search-main md:p-10 p-6 rounded-[32px] relative">
            <div class="form-search search-modal-top">
                <form method="GET" action="{{{ route('search') }}}" id="searchModalForm">
                    <input type="text" name="q" id="searchModalInput" placeholder="What are you looking for?" class="text-button-lg h-14 rounded-2xl border border-line w-full pl-6" autocomplete="off" />
                    <button type="submit" class="search-modal-submit" aria-label="Search">
                        <i class="ph ph-magnifying-glass text-xl leading-none"></i>
                    </button>
                </form>
                <button type="button" class="search-modal-close" aria-label="Close search" onclick="closeSearch()">
                    <i class="ph ph-x text-lg leading-none"></i>
                </button>
            </div>
            @php
                $popularSearchSuggestions = popular_search_suggestions(6);
                $recentProducts = \App\Models\Product::where('is_active', true)
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();
            @endphp
            <div class="keyword mt-8 shrink-0">
                <div class="heading5">Popular searches</div>
                <div class="list-keyword flex items-center flex-wrap gap-3 mt-4">
                    @forelse($popularSearchSuggestions as $suggestion)
                        <a href="{{ $suggestion['url'] }}" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">{{ $suggestion['label'] }}</a>
                    @empty
                        <a href="{{ route('shop') }}" class="item px-4 py-1.5 border border-line rounded-full cursor-pointer duration-300 hover:bg-black hover:text-white">Browse shop</a>
                    @endforelse
                </div>
            </div>
            <div class="search-modal-body mt-8 min-h-0">
            <div class="search-results-dynamic flex flex-col min-h-0 flex-1" id="searchModalResults">
                <div class="heading6 shrink-0" id="searchResultsTitle">Latest products</div>
                <div class="search-modal-results-scroll mt-4">
                <div class="list-product pb-5 hide-product-sold grid xl:grid-cols-4 sm:grid-cols-3 grid-cols-2 md:gap-[30px] gap-4" id="searchModalProductList">
                    @forelse($recentProducts as $product)
                        <div class="product-item grid-type search-default-product">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="body1 text-secondary">No products yet. Start typing to search.</p>
                        </div>
                    @endforelse
                </div>
                </div>
                <div class="search-loading hidden text-center py-6 shrink-0" id="searchModalLoading">
                    <span class="body1 text-secondary">Searching...</span>
                </div>
                <a href="{{{ route('search') }}}" class="button-main w-full text-center mt-4 hidden shrink-0" id="searchModalViewAll">View all results</a>
            </div>
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
                <a href="{{ route('wishlist') }}" class="button-main w-full text-center uppercase block"> View All Wish List</a>
                <a href="{{ route('shop') }}" class="text-button-uppercase continue mt-2 text-center has-line-before cursor-pointer inline-block block">Continue shopping</a>
            </div>
        </div>
    </div>
    
    <!-- Quick View Modal -->
    <div class="modal-quickview-block">
        <div class="modal-quickview-main py-6">
            <div class="flex h-full max-md:flex-col-reverse gap-y-6">
                <div class="left lg:w-[388px] md:w-[300px] flex-shrink-0 px-6">
                    <div class="list-img max-md:flex items-center gap-4 flex flex-col">
                        <div class="qv-main-img bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                            <img src="{{ asset('assets/images/product/perch-bottal.webp') }}" alt="item" class="w-full h-full object-cover" />
                        </div>
                        <div class="qv-thumbs flex gap-2 mt-2 flex-wrap" style="display:none;"></div>
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
                        <div class="flex items-center gap-3 flex-wrap mt-5 pb-4 border-b border-line">
                            <div class="product-price heading5"></div>
                            <div class="product-origin-price font-normal text-secondary2" style="display:none"><del></del></div>
                            <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full" style="display:none"></div>
                            <div class="qv-stock caption2 text-secondary mt-1" style="display:none"></div>
                        </div>
                        <div class="qv-description-block mt-4 pb-4 border-b border-line" style="display:none">
                            <div class="text-button-uppercase text-secondary2 mb-1.5">Description</div>
                            <div class="qv-description text-secondary body2 line-clamp-4 max-h-24 overflow-y-auto"></div>
                        </div>
                        <div class="qv-specs-block mt-4 pb-4 border-b border-line" style="display:none">
                            <div class="text-button-uppercase text-secondary2 mb-1.5">Specifications</div>
                            <div class="qv-specs body2 text-secondary"></div>
                        </div>
                        <div class="list-action mt-6">
                            <div class="qv-size-block mt-3" style="display:none">
                                <div class="text-button-uppercase text-secondary2 mb-1.5">Size</div>
                                <div class="list-size flex items-center gap-2 flex-wrap"></div>
                            </div>
                            <div class="qv-color-block mt-3" style="display:none">
                                <div class="text-button-uppercase text-secondary2 mb-1.5">Color</div>
                                <div class="list-color flex items-center gap-2 flex-wrap"></div>
                            </div>
                            <div class="choose-quantity flex items-center gap-5 mt-3">
                                <div class="quantity-block md:p-3 flex items-center justify-between rounded-lg border border-line sm:w-[180px] w-[120px] flex-shrink-0">
                                    <i class="ph-bold ph-minus cursor-pointer body1 quantity-decrease-qv"></i>
                                    <input type="number" min="1" max="9999" step="1" value="1" inputmode="numeric" aria-label="Quantity" class="quantity body1 font-semibold w-12 min-w-[3rem] text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" />
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
                <!-- <div class="time countdown-cart px-6">
                    <div class="flex items-center gap-3 px-5 py-3 bg-green rounded-lg">
                        <p class="text-3xl">🔥</p>
                        <div class="caption1">
                            Your cart will expire in <span class="text-red caption1 font-semibold"><span class="minute">04</span>:<span class="second">59</span></span> minutes!<br />
                            Please checkout now before your items sell out!
                        </div>
                    </div>
                </div> -->
                <!-- <div class="heading banner mt-3 px-6">
                    <div class="text">
                        Buy <span class="text-button"> ₹<span class="more-price">150</span>.00 </span>
                        <span>more to get </span>
                        <span class="text-button">freeship</span>
                    </div>
                    <div class="tow-bar-block mt-3">
                        <div class="progress-line"></div>
                    </div>
                </div> -->
                <div class="list-cart px-6 overflow-y-auto max-h-[400px]">
                    <!-- Cart items will be loaded dynamically -->
                </div>
                <div class="footer-cart p-6 border-t border-line bg-white absolute bottom-0 left-0 w-full">
                    <div class="total flex items-center justify-between mb-4">
                        <div class="text-button-uppercase">Total:</div>
                        <div class="text-title">₹<span class="total-price">0.00</span></div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="button-main cart-checkout-btn w-full text-center uppercase">Checkout</a>
                    <a href="{{{ route('cart.index') }}}" class="button-main w-full text-center uppercase mt-3 bg-white border border-black text-black hover:bg-black hover:text-white">View Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.scripts')
    @yield('scripts')
    @stack('scripts')
    
    <script>
        // Header interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu: .open class handled in assets/js/main.js (avoid duplicate .active handlers)

            // Close search modal (backdrop click + ESC) + trap scroll inside results
            const searchModal = document.querySelector('.modal-search-block');
            const searchModalMain = document.querySelector('.modal-search-block .modal-search-main');
            if (searchModal && searchModalMain) {
                searchModal.addEventListener('click', function(e) {
                    if (e.target === searchModal) {
                        if (typeof window.closeSearch === 'function') window.closeSearch();
                        else {
                            searchModalMain.classList.remove('open');
                            if (typeof window.unlockSearchBodyScroll === 'function') window.unlockSearchBodyScroll();
                        }
                    }
                });
                searchModalMain.addEventListener('click', function(e) { e.stopPropagation(); });

                function trapSearchWheel(e) {
                    if (!searchModalMain.classList.contains('open')) return;
                    var scrollArea = e.target.closest('.search-modal-results-scroll');
                    if (scrollArea) {
                        var atTop = scrollArea.scrollTop <= 0;
                        var atBottom = scrollArea.scrollTop + scrollArea.clientHeight >= scrollArea.scrollHeight - 1;
                        if ((e.deltaY < 0 && atTop) || (e.deltaY > 0 && atBottom)) {
                            e.preventDefault();
                        }
                        return;
                    }
                    // Wheel outside results (header/popular/backdrop): keep page locked
                    e.preventDefault();
                }
                searchModal.addEventListener('wheel', trapSearchWheel, { passive: false });
                searchModal.addEventListener('touchmove', function(e) {
                    if (!searchModalMain.classList.contains('open')) return;
                    if (!e.target.closest('.search-modal-results-scroll')) {
                        e.preventDefault();
                    }
                }, { passive: false });
            }
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const sm = document.querySelector('.modal-search-block .modal-search-main');
                    if (sm && sm.classList.contains('open')) {
                        if (typeof window.closeSearch === 'function') window.closeSearch();
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
                                    var scrollArea = document.querySelector('.search-modal-results-scroll');
                                    if (scrollArea) scrollArea.scrollTop = 0;
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
            
            document.querySelectorAll('.share-product-btn, .share-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var url = btn.getAttribute('data-share-url') || window.location.href;
                    var title = btn.getAttribute('data-share-title') || document.title;
                    if (navigator.share) {
                        navigator.share({ title: title, url: url }).catch(function(){});
                    } else if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(url).then(function() { alert('Link copied to clipboard'); });
                    } else {
                        prompt('Copy this link:', url);
                    }
                });
            });

        });
    </script>
</body>
</html>
