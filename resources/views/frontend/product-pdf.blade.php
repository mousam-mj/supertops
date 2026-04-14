@extends('layouts.frontend')

@php
    $specs = $product->specifications;
    if (is_string($specs)) {
        $specs = json_decode($specs, true);
    }
    $specs = is_array($specs) ? $specs : [];
@endphp

@section('title', ($product->sku ?? $product->name) . ' - PDF - EDX Rulmenti Romania')

@section('styles')
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
    </style>
@endsection

@section('content')
    <div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
        <div class="breadcrumb-main overflow-hidden">
            <div class="container pt-1 pb-1 relative"></div>
        </div>
    </div>

        <div class="product-detail default">
            <div class="featured-product underwear filter-product-img py-14 bg-surface">
                <div class="container flex justify-between gap-y-6 flex-wrap">
                    <div class="list-img md:w-1/2 md:pr-[45px] w-full flex-shrink-0">
                        <img class="duration-700" src="{{ $product->image_url }}" alt="{{ $product->name }}" />
                    </div>
                    <div class="product-item product-infor md:w-1/2 w-full lg:pl-[15px] md:pl-2" data-item="{{ $product->id }}">
                        <div class="flex justify-between">
                            <div>
                                <div class="product-name heading4 mt-1">{{ $product->sku ?? $product->name }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                            <div class="product-sale font-semibold bg-green px-3 py-0.5 inline-block rounded-full">{{ $product->category->name ?? 'Deep Groove Ball Bearing' }}</div>
                            <div class="product-description text-secondary mt-3">{{ $product->description ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="desc-tab md:pb-20 pb-10">
                <div class="container">
                    <div class="desc-block mt-8">
                        <div class="desc-item description open pb-10">
                            <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Overview</div>
                            <div class="grid md:grid-cols-2 gap-8 gap-y-5 mt-5">
                                <div class="left">
                                    <div class="container">
                                        <div class="section">
                                            <div class="heading6">Boundary dimensions</div>
                                            <table class="spec-table">
                                                <tr>
                                                    <td>Bore diameter</td>
                                                    <td>{{ $specs['bore_diameter'] ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Outside diameter</td>
                                                    <td>{{ $specs['outside_diameter'] ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Width</td>
                                                    <td>{{ $specs['width'] ?? '—' }}</td>
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
                                                <td>{{ $specs['dynamic_load_rating'] ?? '—' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Basic static load rating</td>
                                                <td>{{ $specs['static_load_rating'] ?? '—' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Limiting speed – Grease</td>
                                                <td>{{ $specs['limiting_speed_grease'] ?? '—' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Limiting speed – Oil</td>
                                                <td>{{ $specs['limiting_speed_oil'] ?? '—' }}</td>
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
                                                    <td>{{ $specs['number_of_rows'] ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bore type</td>
                                                    <td>{{ $specs['bore_type'] ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cage</td>
                                                    <td>{{ $specs['cage'] ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Radial internal clearance</td>
                                                    <td>{{ $specs['radial_clearance'] ?? '—' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tolerance class for dimensions</td>
                                                    <td>{{ $specs['tolerance_class'] ?? '—' }}</td>
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
        </div>
@endsection

