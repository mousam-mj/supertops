@extends('layouts.frontend')

@php
    $specs = $product->specifications;
    if (is_string($specs)) {
        $specs = json_decode($specs, true);
    }
    $specs = is_array($specs) ? $specs : [];
@endphp

@section('title', ($product->sku ?? $product->name) . ' - EDX Rulmenti Romania')

@section('content')
<!-- Breadcrumb (matches edx-product.html) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">DABB</div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div class="capitalize">Bearing</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-detail default">
    <div class="featured-product underwear filter-product-img md:py-20 py-14">
        <div class="container flex justify-between gap-y-6 flex-wrap">
            <div class="list-img md:w-1/2 md:pr-[45px] w-full flex-shrink-0">
                <img class="w-full duration-700" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                <div class="product-description text-secondary mt-3">Image may differ from product. See technical specification for details.</div>
            </div>
            <div class="product-item product-infor md:w-1/2 w-full lg:pl-[15px] md:pl-2" data-item="{{ $product->id }}">
                <div class="flex justify-between">
                    <div>
                        <div class="product-name heading4 mt-1">{{ $product->sku ?? $product->name }}</div>
                    </div>
                    <div class="add-wishlist-btn w-10 h-10 flex-shrink-0 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white">
                        <i class="ph ph-heart text-xl"></i>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                    <div class="product-sale caption2 font-semibold bg-green px-3 py-0.5 inline-block rounded-full">{{ $product->category->name ?? 'Deep Groove Ball Bearing' }}</div>
                    <div class="product-description text-secondary mt-3 w-full">{{ $product->description ?? 'Keep your home organized, yet elegant with storage cabinets by Onita Patio Furniture. Traditionally designed, they are perfect to be used in the any place where you need to store.' }}</div>
                    <div class="product-price heading5">Price on request</div>
                    <div class="w-px h-4 bg-line"></div>
                </div>

                <div class="list-action mt-6">
                    <div class="text-title mt-5">Quantity:</div>
                    <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                        <div class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0">
                            <i class="ph-bold ph-minus cursor-pointer body1 disabled" id="qty-minus"></i>
                            <div class="quantity body1 font-semibold" id="qty-value">1</div>
                            <i class="ph-bold ph-plus cursor-pointer body1" id="qty-plus"></i>
                        </div>
                        <div class="add-cart-btn button-main whitespace-nowrap w-full text-center bg-white text-black border border-black">Add To Quota List</div>
                        <div class="product-category caption2 text-secondary font-semibold uppercase">{{ $product->stock_quantity > 0 ? 'Available in stock' : 'Contact for availability' }}</div>
                    </div>

                    <div class="more-infor mt-6">
                        <div class="flex items-center gap-4 flex-wrap">
                            <div class="flex items-center gap-1">
                                <i class="ph ph-arrow-clockwise body1"></i>
                                <div class="text-title">This product is available from stock.</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mt-3">
                            <i class="ph ph-timer body1"></i>
                            <div class="text-title">Orders placed before 6 p.m. CEST will be shipped today.</div>
                        </div>
                        <div class="flex items-center gap-1 mt-3">
                            <i class="ph ph-eye body1"></i>
                            <div class="text-title">Payment by invoice possible.</div>
                        </div>
                        <div class="flex items-center gap-1 mt-3">
                            <i class="ph ph-eye body1"></i>
                            <div class="text-title">Track your order.</div>
                        </div>
                    </div>
                </div>

                <div class="button-block mt-5 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('frontend.product.pdf.preview', $product->slug) }}" target="_blank" rel="noopener noreferrer" class="button-main flex-1 text-center">Preview PDF</a>
                    <a href="{{ route('frontend.product.pdf.download', $product->slug) }}" class="button-main bg-black flex-1 text-center">Download PDF</a>
                </div>
            </div>
        </div>
    </div>

    <div class="desc-tab md:pb-20 pb-10">
        <div class="container">
            <div class="flex items-center justify-center w-full">
                <div class="menu-tab flex items-center md:gap-[60px] gap-8">
                    <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 active">Overview</div>
                    <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300">Equivalents</div>
                    <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300">Suffix description</div>
                </div>
            </div>
            <div class="desc-block mt-8">
                <div class="desc-item description open pb-10" data-item="Overview">
                    <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Overview</div>
                    <div class="grid md:grid-cols-2 gap-8 gap-y-5">
                        <div class="left">
                            <div class="container">
                                <div class="section">
                                    <div class="heading6">Boundary dimensions</div>
                                    <table class="spec-table">
                                        <tr>
                                            <td>Bore diameter</td>
                                            <td>{{ $specs['bore_diameter'] ?? '12 mm' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Outside diameter</td>
                                            <td>{{ $specs['outside_diameter'] ?? '28 mm' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Width</td>
                                            <td>{{ $specs['width'] ?? '7 mm' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="section">
                                <div class="heading6">Performance</div>
                                <table class="spec-table">
                                    <tr>
                                        <td>Basic dynamic load rating</td>
                                        <td>{{ $specs['dynamic_load_rating'] ?? '5.10 KN' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Basic static load rating</td>
                                        <td>{{ $specs['static_load_rating'] ?? '2.39 KN' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Limiting speed – Grease</td>
                                        <td>{{ $specs['limiting_speed_grease'] ?? '26000 r/min' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Limiting speed – Oil</td>
                                        <td>{{ $specs['limiting_speed_oil'] ?? '30000 r/min' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-8 gap-y-5">
                        <div class="left">
                            <div class="container">
                                <div class="properties-section">
                                    <div class="heading6">Properties</div>
                                    <table class="spec-table">
                                        <tr>
                                            <td>Number of rows</td>
                                            <td>{{ $specs['number_of_rows'] ?? '1' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bore type</td>
                                            <td>{{ $specs['bore_type'] ?? 'Cylindrical' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cage</td>
                                            <td>{{ $specs['cage'] ?? 'Sheet Steel' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Radial internal clearance</td>
                                            <td>{{ $specs['radial_clearance'] ?? 'CN' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tolerance class for dimensions</td>
                                            <td>{{ $specs['tolerance_class'] ?? 'P6' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                    </g>
                                    <defs>
                                        <clipPath id="clip0_edx_prod_care1">
                                            <rect width="16" height="16" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <g clip-path="url(#clip0_edx_prod_care2)">
                                        <path d="M18.4739 3.94612C18.364 3.12175 17.6536 2.5 16.8219 2.5H7.08324C6.85293 2.5 6.66656 2.68636 6.66656 2.91667C6.66656 3.14698 6.85293 3.33335 7.08324 3.33335H16.8219C17.2378 3.33335 17.5934 3.64421 17.6479 4.05639L18.2184 8.33329H15.0445L17.3362 6.58077C17.5193 6.4412 17.5535 6.17957 17.4143 5.99687C17.2736 5.81336 17.0123 5.78 16.83 5.91914L13.6731 8.33325H7.08324C6.84371 8.33325 6.60707 8.34587 6.3736 8.36923L3.16969 5.91914C2.98657 5.77996 2.72618 5.81336 2.5854 5.99687C2.44626 6.17957 2.48044 6.4412 2.66352 6.58077L5.2733 8.57645C2.24326 9.37937 0 12.1372 0 15.4165C0 15.6468 0.186365 15.8332 0.416675 15.8332H3.86558L2.66356 16.7523C2.48048 16.8919 2.4463 17.1535 2.58544 17.3362C2.66763 17.4437 2.79133 17.4998 2.91665 17.4998C3.00536 17.4998 3.09407 17.4717 3.16973 17.414L5.23693 15.8332H14.7629L16.8301 17.414C16.9058 17.4717 16.9945 17.4998 17.0832 17.4998C17.2085 17.4998 17.3322 17.4437 17.4144 17.3362C17.5535 17.1535 17.5194 16.8919 17.3362 16.7523L16.1342 15.8332H19.5831C19.7036 15.8332 19.8175 15.7815 19.8964 15.6912C19.9754 15.6004 20.012 15.4804 19.9966 15.3616L18.4739 3.94612ZM12.5834 9.16656L9.99988 11.1422L7.4164 9.16656H12.5834ZM0.847178 14.9999C1.04128 12.0611 3.27824 9.67804 6.14626 9.24398L9.31427 11.6665L4.95533 14.9998H0.847178V14.9999ZM6.32665 14.9999L9.99988 12.1909L13.6731 14.9999H6.32665ZM15.0445 14.9999L10.6855 11.6666L13.9548 9.1666H18.3299L19.107 14.9999H15.0445Z" fill="#1F1F1F"></path>
                                        <path d="M18.4739 3.94612C18.364 3.12175 17.6536 2.5 16.8219 2.5H7.08324C6.85293 2.5 6.66656 2.68636 6.66656 2.91667C6.66656 3.14698 6.85293 3.33335 7.08324 3.33335H16.8219C17.2378 3.33335 17.5934 3.64421 17.6479 4.05639L18.2184 8.33329H15.0445L17.3362 6.58077C17.5193 6.4412 17.5535 6.17957 17.4143 5.99687C17.2736 5.81336 17.0123 5.78 16.83 5.91914L13.6731 8.33325H7.08324C6.84371 8.33325 6.60707 8.34587 6.3736 8.36923L3.16969 5.91914C2.98657 5.77996 2.72618 5.81336 2.5854 5.99687C2.44626 6.17957 2.48044 6.4412 2.66352 6.58077L5.2733 8.57645C2.24326 9.37937 0 12.1372 0 15.4165C0 15.6468 0.186365 15.8332 0.416675 15.8332H3.86558L2.66356 16.7523C2.48048 16.8919 2.4463 17.1535 2.58544 17.3362C2.66763 17.4437 2.79133 17.4998 2.91665 17.4998C3.00536 17.4998 3.09407 17.4717 3.16973 17.414L5.23693 15.8332H14.7629L16.8301 17.414C16.9058 17.4717 16.9945 17.4998 17.0832 17.4998C17.2085 17.4998 17.3322 17.4437 17.4144 17.3362C17.5535 17.1535 17.5194 16.8919 17.3362 16.7523L16.1342 15.8332H19.5831C19.7036 15.8332 19.8175 15.7815 19.8964 15.6912C19.9754 15.6004 20.012 15.4804 19.9966 15.3616L18.4739 3.94612ZM12.5834 9.16656L9.99988 11.1422L7.4164 9.16656H12.5834ZM0.847178 14.9999C1.04128 12.0611 3.27824 9.67804 6.14626 9.24398L9.31427 11.6665L4.95533 14.9998H0.847178V14.9999ZM6.32665 14.9999L9.99988 12.1909L13.6731 14.9999H6.32665ZM15.0445 14.9999L10.6855 11.6666L13.9548 9.1666H18.3299L19.107 14.9999H15.0445Z" fill="#1F1F1F"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_edx_prod_care2">
                                            <rect width="20" height="20" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none" aria-hidden="true">
                                    <g clip-path="url(#clip0_edx_prod_care3)">
                                        <path d="M15.1309 14.3723H2.6163C2.55417 14.372 2.49399 14.3505 2.44573 14.3114C2.39747 14.2723 2.36404 14.2178 2.35096 14.1571L0.00581614 1.96527C-0.00150672 1.93088 -0.00191806 1.89536 0.00460146 1.86081C0.011121 1.82625 0.0244481 1.79335 0.0437997 1.76398C0.0631512 1.73462 0.0881419 1.7094 0.117326 1.68978C0.146511 1.67016 0.179306 1.65655 0.213801 1.64972C0.248701 1.64246 0.284706 1.64231 0.319664 1.64928C0.354622 1.65625 0.387814 1.67019 0.417266 1.69027C0.446718 1.71035 0.47182 1.73617 0.491077 1.76616C0.510335 1.79616 0.523358 1.82973 0.529356 1.86487L2.86732 13.8344H14.9372L17.2107 1.85052C17.2158 1.81568 17.228 1.78224 17.2465 1.75229C17.265 1.72233 17.2895 1.69647 17.3184 1.67632C17.3472 1.65617 17.38 1.64214 17.4145 1.6351C17.449 1.62805 17.4846 1.62815 17.519 1.63537C17.5542 1.64137 17.5877 1.65438 17.6177 1.67364C17.6477 1.6929 17.6735 1.71801 17.6936 1.74746C17.7137 1.77691 17.7276 1.8101 17.7346 1.84506C17.7416 1.88002 17.7415 1.91602 17.7342 1.95093L15.3891 14.1428C15.3774 14.2048 15.3446 14.2609 15.2962 14.3015C15.2478 14.342 15.1868 14.3645 15.1237 14.3651L15.1309 14.3723Z" fill="#1F1F1F"></path>
                                        <path d="M12.7509 5.15568C12.0105 5.17359 11.2807 4.97682 10.6496 4.58911C10.0944 4.25817 9.46004 4.08346 8.81367 4.08346C8.1673 4.08346 7.53295 4.25817 6.97772 4.58911C6.3409 4.96016 5.61705 5.15566 4.88001 5.15566C4.14297 5.15566 3.41913 4.96016 2.7823 4.58911C2.23372 4.24251 1.5951 4.0654 0.946355 4.07993C0.875303 4.07995 0.807049 4.05222 0.756142 4.00266C0.705235 3.95309 0.675698 3.88559 0.673828 3.81457C0.675644 3.74286 0.704941 3.6746 0.755661 3.62388C0.80638 3.57316 0.87465 3.54387 0.946355 3.54205C1.68751 3.52628 2.41735 3.72556 3.04765 4.11579C3.5948 4.4589 4.23079 4.63348 4.87643 4.6178C5.52666 4.63419 6.16744 4.45966 6.71954 4.11579C7.35353 3.74029 8.07682 3.54216 8.81367 3.54216C9.55052 3.54216 10.2738 3.74029 10.9078 4.11579C11.4639 4.4481 12.0995 4.62358 12.7473 4.62358C13.3951 4.62358 14.0308 4.4481 14.5869 4.11579C15.2139 3.72422 15.9419 3.52477 16.681 3.54205C16.7533 3.54205 16.8226 3.57076 16.8737 3.62187C16.9248 3.67298 16.9535 3.74229 16.9535 3.81457C16.9535 3.85002 16.9464 3.88513 16.9327 3.9178C16.9189 3.95047 16.8987 3.98005 16.8733 4.00479C16.8479 4.02953 16.8178 4.04892 16.7847 4.06183C16.7517 4.07473 16.7165 4.08088 16.681 4.07993C16.0323 4.0654 15.3936 4.24251 14.8451 4.58911C14.2162 4.97586 13.489 5.17261 12.7509 5.15568Z" fill="#1F1F1F"></path>
                                        <path d="M14.9251 16C14.8852 16 14.8457 15.991 14.8097 15.9736C14.7736 15.9562 14.742 15.9309 14.7172 15.8996L2.61139 0.430295C2.58973 0.402512 2.57375 0.370733 2.56437 0.336775C2.55499 0.302817 2.55239 0.26734 2.55672 0.232378C2.56105 0.197415 2.57223 0.163648 2.5896 0.133004C2.60698 0.102359 2.63023 0.0754368 2.65801 0.0537754C2.68579 0.0321141 2.71757 0.0161333 2.75153 0.00675291C2.78549 -0.00262746 2.82095 -0.005225 2.85592 -0.000896318C2.89088 0.00343237 2.92465 0.014609 2.95529 0.0319877C2.98593 0.0493664 3.01286 0.07261 3.03452 0.100393L15.1331 15.5697C15.1557 15.5966 15.1726 15.6278 15.1827 15.6615C15.1929 15.6951 15.196 15.7305 15.192 15.7654C15.188 15.8004 15.1769 15.8341 15.1593 15.8645C15.1418 15.895 15.1183 15.9216 15.0901 15.9426C15.0429 15.9793 14.9849 15.9995 14.9251 16Z" fill="#1F1F1F"></path>
                                        <path d="M2.82464 16.0001C2.76466 16.0008 2.70635 15.9805 2.6597 15.9428C2.63183 15.9216 2.60841 15.8952 2.5908 15.865C2.57319 15.8348 2.56173 15.8014 2.55706 15.7667C2.5524 15.7321 2.55462 15.6968 2.56362 15.663C2.57262 15.6293 2.58821 15.5976 2.60949 15.5698L14.7153 0.100544C14.7369 0.0732209 14.7637 0.0504354 14.7942 0.0334844C14.8247 0.0165334 14.8582 0.00574553 14.8928 0.00174941C14.9275 -0.00224671 14.9625 0.000618864 14.9961 0.0101865C15.0296 0.0197542 15.0609 0.0358419 15.0882 0.0575155C15.1164 0.0785597 15.1399 0.105126 15.1574 0.135595C15.175 0.166063 15.1861 0.199792 15.1901 0.234706C15.1941 0.269621 15.191 0.304986 15.1808 0.338644C15.1707 0.372301 15.1538 0.403543 15.1312 0.430445L3.03262 15.8997C3.00776 15.9311 2.97614 15.9564 2.94013 15.9737C2.90411 15.9911 2.86463 16.0002 2.82464 16.0001Z" fill="#1F1F1F"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_edx_prod_care3">
                                            <rect width="17.7499" height="16" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="desc-item description open pb-10" data-item="Equivalents">
                    <div class="grid gap-8 gap-y-5 mt-5">
                        <div class="left">
                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Equivalents</div>
                            <div class="container">
                                <div class="section">
                                    <table class="spec-table">
                                        <tr>
                                            <td><b>Model</b></td>
                                            <td><b>Brand</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{ $product->sku ?? '16001' }}</td>
                                            <td>SKF</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ($product->sku ?? '16001') . '-A' }}</td>
                                            <td>FAG</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="desc-item description open pb-10" data-item="Suffixdescription">
                    <div class="grid gap-8 gap-y-5 mt-5">
                        <div class="left">
                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Suffix description</div>
                            <div class="container">
                                <div class="section">
                                    <table class="spec-table">
                                        <tr>
                                            <td><b>Suffix</b></td>
                                            <td><b>Description</b></td>
                                        </tr>
                                        <tr>
                                            <td>2RS</td>
                                            <td>Rubber seals on both sides</td>
                                        </tr>
                                        <tr>
                                            <td>ZZ</td>
                                            <td>Metal shields on both sides</td>
                                        </tr>
                                        <tr>
                                            <td>C3</td>
                                            <td>Increased internal clearance</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="related-products lg:py-20 md:py-14 py-10 bg-surface">
        <div class="container">
            <div class="heading text-center mb-10">
                <div class="heading3">Related Products</div>
            </div>
            <div class="list-product flex flex-col gap-8">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-item list-type edxpro bg-white">
                    <a href="{{ route('frontend.product', $relatedProduct->slug) }}" class="product-main cursor-pointer flex lg:items-center sm:justify-between gap-7 max-lg:gap-5 p-4">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl block max-sm:w-1/2">
                            <div class="product-img w-full rounded-2xl overflow-hidden">
                                <img class="w-full duration-700" src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" style="width: 200px;">
                            </div>
                        </div>
                        <div class="flex sm:items-center gap-7 max-lg:gap-4 max-lg:flex-wrap lg:w-2/3 lg:flex-shrink-0 max-lg:w-full max-sm:flex-col max-sm:w-1/2">
                            <div class="product-infor max-sm:w-full">
                                <div class="product-name heading6 inline-block duration-300">{{ $relatedProduct->sku ?? $relatedProduct->name }}</div>
                                <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                    <div class="product-price text-title bg-green px-3 py-0.5 inline-block rounded-full">{{ $relatedProduct->category->name ?? 'Bearing' }}</div>
                                </div>
                            </div>
                            <div class="action w-fit flex flex-col items-center justify-center">
                                <span class="quick-shop-btn button-main whitespace-nowrap py-2 px-9 max-lg:px-5 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white">View Details</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
(function () {
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    const qtyValue = document.getElementById('qty-value');

    function setQty(n) {
        const v = Math.max(1, n);
        qtyValue.textContent = String(v);
        if (qtyMinus) {
            qtyMinus.classList.toggle('disabled', v <= 1);
        }
    }

    if (qtyMinus && qtyPlus && qtyValue) {
        qtyMinus.addEventListener('click', function () {
            setQty(parseInt(qtyValue.textContent, 10) - 1);
        });
        qtyPlus.addEventListener('click', function () {
            setQty(parseInt(qtyValue.textContent, 10) + 1);
        });
        setQty(1);
    }

    // Same tab logic as edx-bearing product-detail.js (innerHTML matches data-item)
    const descTabItems = document.querySelectorAll('.product-detail .desc-tab .menu-tab .tab-item');
    const descItems = document.querySelectorAll('.product-detail .desc-tab .desc-block .desc-item');

    function syncDescPanels() {
        descTabItems.forEach(function (tab) {
            if (!tab.classList.contains('active')) {
                return;
            }
            const key = tab.innerHTML.replace(/\s+/g, '');
            descItems.forEach(function (item) {
                if (item.getAttribute('data-item') === key) {
                    item.classList.add('open');
                } else {
                    item.classList.remove('open');
                }
            });
        });
    }

    descTabItems.forEach(function (tab) {
        tab.addEventListener('click', function () {
            syncDescPanels();
        });
    });

    syncDescPanels();
})();
</script>
@endsection
