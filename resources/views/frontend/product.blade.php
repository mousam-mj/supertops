@extends('layouts.frontend')

@php
    $specs = $product->specifications;
    if (is_string($specs)) {
        $specs = json_decode($specs, true);
    }
    $specs = is_array($specs) ? $specs : [];

    $equivRows = [];
    foreach (['equiv_skf' => 'SKF', 'equiv_fag' => 'FAG', 'equiv_ntn' => 'NTN', 'equiv_timken' => 'Timken'] as $key => $brand) {
        $model = isset($specs[$key]) ? trim((string) $specs[$key]) : '';
        if ($model !== '') {
            $equivRows[] = ['model' => $model, 'brand' => $brand];
        }
    }

    $suffixRows = [];
    $hadAdminSuffixPairRows = false;
    if (! empty($specs['suffix_pairs']) && is_array($specs['suffix_pairs'])) {
        foreach ($specs['suffix_pairs'] as $row) {
            if (! is_array($row)) {
                continue;
            }
            $s = trim((string) ($row['suffix'] ?? ''));
            $d = trim((string) ($row['description'] ?? ''));
            if ($s === '' && $d === '') {
                continue;
            }
            $hadAdminSuffixPairRows = true;
            $suffixRows[] = ['suffix' => $s !== '' ? $s : '—', 'description' => $d];
        }
    }
    if (! $hadAdminSuffixPairRows) {
        $suffixName = isset($specs['suffix_name']) ? trim((string) $specs['suffix_name']) : '';
        $suffixDesc = isset($specs['suffix_desc']) ? trim((string) $specs['suffix_desc']) : '';
        $suffixCode = isset($specs['suffix']) ? trim((string) $specs['suffix']) : '';
        if ($suffixName !== '' && $suffixDesc !== '') {
            $suffixRows[] = ['suffix' => $suffixName, 'description' => $suffixDesc];
        } elseif ($suffixCode !== '' && $suffixDesc !== '') {
            $suffixRows[] = ['suffix' => $suffixCode, 'description' => $suffixDesc];
        } elseif ($suffixCode !== '' && $suffixName !== '') {
            $suffixRows[] = ['suffix' => $suffixCode, 'description' => $suffixName];
        } elseif ($suffixDesc !== '') {
            $suffixRows[] = ['suffix' => $suffixCode !== '' ? $suffixCode : '—', 'description' => $suffixDesc];
        }
    }
    if (! $hadAdminSuffixPairRows) {
    foreach ($specs as $k => $v) {
        if ($k === 'suffix_pairs') {
            continue;
        }
        if (! is_string($k) || ! is_scalar($v)) {
            continue;
        }
        $v = trim((string) $v);
        if ($v === '') {
            continue;
        }
        if (! str_starts_with(strtolower($k), 'suffix_')) {
            continue;
        }
        if (in_array($k, ['suffix_name', 'suffix_desc', 'suffix'], true)) {
            continue;
        }
        $label = (string) preg_replace('/^suffix_/i', '', $k);
        $label = $label !== '' ? str_replace('_', ' ', $label) : $k;
        $suffixRows[] = ['suffix' => ucwords($label), 'description' => $v];
    }
    }

    $suffixCount = count($suffixRows);
@endphp

@section('title', ($product->sku ?? $product->name) . ' - EDX Rulmenti Romania')

@section('styles')
<style>
.product-description-html p { margin-bottom: 0.5rem; }
.product-description-html p:last-child { margin-bottom: 0; }

/* Spec tables in tabs use global .spec-table (layouts/frontend) */
.product-detail .desc-tab .spec-table td.edx-empty-cell {
    text-align: left !important;
    color: #71717a !important;
    padding: 1.25rem 0 !important;
    font-size: 0.875rem;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td.edx-empty-cell {
    padding: 1.25rem 0 !important;
}

/* Product spec sheet (edx-product.html style): flat, label left / value right, hairline rules — no “card” chrome */
.product-detail .desc-tab .desc-block--spec {
    background: #fff;
    border: none;
    border-radius: 0;
    padding: 0;
    margin-top: 2rem;
}
.product-detail .desc-tab .edx-spec-block {
    min-width: 0;
    margin: 0;
}
.product-detail .desc-tab .edx-spec-block__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #18181b;
    line-height: 1.3;
    margin: 0 0 0.75rem 0;
    padding: 0;
    letter-spacing: -0.01em;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table {
    width: 100%;
    border-collapse: collapse;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr {
    border-bottom: 1px solid #e8e8ed;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr:last-child {
    border-bottom: none;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td {
    padding: 0.6rem 0;
    font-size: 0.875rem;
    line-height: 1.45;
    color: #3f3f46;
    vertical-align: top;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td:first-child {
    color: #52525b;
    font-weight: 500;
    padding-right: 1.25rem;
    max-width: 58%;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table td:last-child {
    text-align: right;
    color: #18181b;
    font-weight: 500;
    word-break: break-word;
}
/* Cross-ref / suffix: two-column data with a header row (no grey bar — hairline only) */
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th {
    border-bottom: 1px solid #d4d4d8;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th td {
    background: transparent;
    font-weight: 600;
    color: #18181b;
    font-size: 0.875rem;
    padding: 0 0 0.5rem 0;
    vertical-align: bottom;
    border: none;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th td:first-child {
    color: #18181b;
    font-weight: 600;
}
.product-detail .desc-tab .edx-spec-block__table .spec-table tr.edx-spec-th td:last-child {
    text-align: right;
}
/* edx.ltd style: rectangular tab buttons, uppercase, grey inactive / solid red selected */
.product-detail .desc-tab .menu-tab.edx-spec-tabs {
    position: relative;
    justify-content: flex-start;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab {
    -webkit-appearance: none;
    appearance: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 0;
    margin: 0;
    padding: 0.65rem 1.35rem;
    min-height: 2.75rem;
    font: inherit;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
    cursor: pointer;
    color: #18181b;
    background-color: #e4e4e7;
    transition: background-color 0.2s ease, color 0.2s ease;
    text-align: center;
    line-height: 1.2;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab:hover,
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab:focus-visible {
    background-color: #d4d4d8;
    color: #18181b;
    outline: none;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab:focus-visible {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #ec2127;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab.active,
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab.active:hover {
    background-color: #ec2127;
    color: #fff;
    box-shadow: none;
}
.product-detail .desc-tab .menu-tab .tab-item.edx-spec-tab.active:focus-visible {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #18181b;
}
.edx-red {
    --tw-bg-opacity: 1;
    background-color: rgb(236 33 39);
    color: #fff !important;
}
/* Scoped accent — never add bare `.ph` here (breaks all Phosphor icons) */
.product-detail .edx-text-accent {
    color: rgb(236 33 39);
}

/* Match theme .quantity-block .disabled for edx-quantity-block (main.js handleQuantity binds .quantity-block only) */
.featured-product.underwear .edx-quantity-block .disabled,
.featured-product.cosmetic .edx-quantity-block .disabled {
    color: var(--secondary2);
    opacity: 0.8;
    cursor: default;
}

/* Quantity: typeable number, hide spinners, match stepper row */
.edx-quantity-block input#qty-value {
    width: 2.75rem;
    min-width: 1.5rem;
    max-width: 4rem;
    text-align: center;
    font: inherit;
    font-weight: 600;
    color: inherit;
    background: transparent;
    border: 0;
    border-radius: 0;
    padding: 0;
    -moz-appearance: textfield;
    appearance: textfield;
}
.edx-quantity-block input#qty-value:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(236, 33, 39, 0.25);
    border-radius: 4px;
}
.edx-quantity-block input#qty-value::-webkit-outer-spin-button,
.edx-quantity-block input#qty-value::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@endsection

@section('content')
<!-- Breadcrumb (matches edx-product.html) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">{{ $product->category->name ?? 'Bearing' }}</div>
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
        <div class="container flex justify-between gap-y-6 flex-wrap md:items-start">
            <div class="list-img w-full md:w-5/12 md:pr-8 lg:pr-10 flex-shrink-0">
                <img class="object-contain object-center duration-700" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                <div class="product-description text-secondary mt-3">Image may differ from product. See technical specification for details.</div>
            </div>
            <div class="product-item product-infor w-full md:w-7/12 md:pl-6 lg:pl-8" data-item="{{ $product->id }}">
                <div class="flex justify-between">
                    <div>
                        <div class="product-name heading4 mt-1">{{ $product->sku ?? $product->name }}</div>
                    </div>
                    <div class="add-wishlist-btn w-10 h-10 flex-shrink-0 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white">
                        <i class="ph ph-heart text-xl"></i>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                    <div class="product-sale font-semibold edx-red px-3 py-0.5 inline-block rounded-full">{{ $product->category->name ?? 'Deep Groove Ball Bearing' }}</div>
                    <div class="product-description text-secondary mt-3 w-full product-description-html">
                        @php $descHtml = trim((string) ($product->description ?? '')); @endphp
                        @if($descHtml !== '')
                            {!! $descHtml !!}
                        @else
                            Keep your home organized, yet elegant with storage cabinets by Onita Patio Furniture. Traditionally designed, they are perfect to be used in the any place where you need to store.
                        @endif
                    </div>
                    <div class="product-price heading5 edx-text-accent">Price on request</div>
                            
                            <div class="w-px h-4 bg-line"></div>
                </div>

                <div class="list-action mt-6">
                    <div class="product-category text-secondary font-semibold edx-text-accent">Available in stock</div>
                    <div class="text-title mt-5">Quantity:</div>
                    <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                        {{-- edx-quantity-block: avoid .quantity-block or theme main.js increments qty twice per + click --}}
                        <div class="edx-quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-center gap-1 rounded-lg border border-line sm:w-[160px] w-[140px] flex-shrink-0">
                            <i class="ph-bold ph-minus cursor-pointer body1 disabled shrink-0" id="qty-minus" role="button" aria-label="Decrease quantity" tabindex="0"></i>
                            <input type="number" class="body1 quantity" id="qty-value" name="quantity" min="1" max="99999" value="1" inputmode="numeric" pattern="[0-9]*" aria-label="Quantity" autocomplete="off" />
                            <i class="ph-bold ph-plus cursor-pointer body1 shrink-0" id="qty-plus" role="button" aria-label="Increase quantity" tabindex="0"></i>
                        </div>
                        <button type="button" class="edx-btn-add-quote whitespace-nowrap edx-add-quota-btn" data-product-id="{{ $product->id }}">
                            <i class="ph ph-files shrink-0" aria-hidden="true"></i>
                            <span class="edx-quota-btn-label">Add to quote</span>
                        </button>
                    </div>

                    <div class="more-infor mt-6">
                                <div class="flex items-center gap-4 flex-wrap">
                                    <div class="flex items-center gap-1">
                                        <i class="ph ph-package body1"></i>
                                        <div class="text-title">This product is available from stock.</div>
                                    </div>
                                    
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <i class="ph ph-clock body1"></i>
                                    <div class="text-title">Orders placed before 6 p.m. CEST will be shipped today.</div>
                                    
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <i class="ph ph-scroll body1"></i>
                                    <div class="text-title">Payment by invoice possible.</div>
                                </div>
                                <div class="flex items-center gap-1 mt-3">
                                    <i class="ph ph-path body1"></i>
                                    <div class="text-title">Track your order.</div>
                                    
                                </div>
                                
                            </div>
                </div>

                <div class="button-block mt-5 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('frontend.product.pdf.download', $product->slug) }}" class="button-main flex-1 text-center"><i class="ph ph-download"></i> Download PDF</a>
                </div>
            </div>
        </div>
    </div>

    <div class="desc-tab md:pb-20 pb-10">
        <div class="container">
            <div class="w-full">
                <div class="menu-tab edx-spec-tabs flex flex-wrap items-stretch gap-2" role="tablist" aria-label="Product information">
                    <button type="button" class="tab-item edx-spec-tab active" data-item="Overview" role="tab" aria-selected="true" id="tab-overview">Overview</button>
                    <button type="button" class="tab-item edx-spec-tab" data-item="Equivalents" role="tab" aria-selected="false" id="tab-equivalents">Equivalents</button>
                    <button type="button" class="tab-item edx-spec-tab" data-item="Suffixdescription" role="tab" aria-selected="false" id="tab-suffix">Suffix description</button>
                </div>
            </div>
            <div class="desc-block desc-block--spec mt-6 relative">
                <div class="desc-item description open pb-10" data-item="Overview">
                    <div class="grid md:grid-cols-2 gap-8 md:gap-x-12 gap-y-8 mt-2">
                        <section class="edx-spec-block min-w-0" aria-labelledby="spec-dim">
                            <h2 id="spec-dim" class="edx-spec-block__title">Boundary dimensions</h2>
                            <div class="edx-spec-block__table">
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
                        </section>
                        <section class="edx-spec-block min-w-0" aria-labelledby="spec-perf">
                            <h2 id="spec-perf" class="edx-spec-block__title">Performance</h2>
                            <div class="edx-spec-block__table">
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
                        </section>
                        <section class="edx-spec-block min-w-0 md:col-span-2" aria-labelledby="spec-props">
                            <h2 id="spec-props" class="edx-spec-block__title">Properties</h2>
                            <div class="edx-spec-block__table max-w-4xl">
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
                        </section>
                    </div>
                </div>


                <div class="desc-item description pb-10" data-item="Equivalents">
                    <div class="mt-2 min-w-0 overflow-x-auto max-w-3xl">
                        <section class="edx-spec-block" aria-labelledby="spec-equiv">
                            <h2 id="spec-equiv" class="edx-spec-block__title">Manufacturer cross-reference</h2>
                            <div class="edx-spec-block__table">
                                <table class="spec-table w-full">
                                    <tr class="edx-spec-th">
                                        <td>Model</td>
                                        <td>Brand</td>
                                    </tr>
                                    @forelse($equivRows as $row)
                                    <tr>
                                        <td>{{ $row['model'] }}</td>
                                        <td>{{ $row['brand'] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="edx-empty-cell">No manufacturer cross-references are stored for this designation yet.</td>
                                    </tr>
                                    @endforelse
                                </table>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="desc-item description pb-10" data-item="Suffixdescription">
                    @if($suffixCount === 0)
                    <p class="text-secondary mt-2">No suffix codes or descriptions are stored for this product in the catalogue data.</p>
                    @else
                    <div class="mt-2 overflow-x-auto max-w-3xl">
                        <section class="edx-spec-block" aria-labelledby="spec-suf">
                            <h2 id="spec-suf" class="edx-spec-block__title">Suffix description</h2>
                            <div class="edx-spec-block__table">
                                <table class="spec-table w-full">
                                    <tr class="edx-spec-th">
                                        <td>Suffix / field</td>
                                        <td>Description</td>
                                    </tr>
                                    @foreach($suffixRows as $row)
                                    <tr>
                                        <td>{{ $row['suffix'] }}</td>
                                        <td>{{ $row['description'] }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </section>
                    </div>
                    @endif
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
            <div class="list-product grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-item edxpro bg-white rounded-2xl border border-line overflow-hidden flex flex-col h-full" data-product-id="{{ $relatedProduct->id }}">
                    <a href="{{ route('frontend.product', $relatedProduct->slug) }}" class="block p-4 pb-3 no-underline text-inherit flex-1 min-w-0">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl aspect-square">
                            <div class="product-img w-full h-full rounded-2xl overflow-hidden flex items-center justify-center bg-surface">
                                <img class="w-full h-full object-contain duration-700" src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}">
                            </div>
                        </div>
                        <div class="product-infor mt-4">
                            <div class="product-name heading6 block duration-300 line-clamp-2">{{ $relatedProduct->sku ?? $relatedProduct->name }}</div>
                            <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                <div class="product-price text-title edx-red px-3 py-0.5 inline-block rounded-full text-sm">{{ $relatedProduct->category->name ?? 'Bearing' }}</div>
                            </div>
                        </div>
                    </a>
                    <div class="action flex flex-col gap-2 p-4 pt-0 mt-auto">
                        <a href="{{ route('frontend.product', $relatedProduct->slug) }}" class="button-main w-full text-center py-2.5 px-4 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white no-underline text-sm">View details</a>
                        <button type="button" class="edx-btn-add-quote edx-btn-add-quote--compact w-full text-sm edx-add-quota-btn inline-flex items-center justify-center gap-2" data-product-id="{{ $relatedProduct->id }}">
                            <i class="ph ph-files shrink-0" aria-hidden="true"></i>
                            <span class="edx-quota-btn-label">Add to quote</span>
                        </button>
                    </div>
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

    function getQty() {
        var n = parseInt(String(qtyValue && qtyValue.value !== undefined ? qtyValue.value : '').trim(), 10);
        if (isNaN(n) || n < 1) {
            return 1;
        }
        return Math.min(99999, n);
    }
    function setQty(n) {
        var v = Math.max(1, Math.min(99999, parseInt(n, 10) || 1));
        if (qtyValue) {
            qtyValue.value = String(v);
        }
        if (qtyMinus) {
            qtyMinus.classList.toggle('disabled', v <= 1);
        }
    }
    if (qtyMinus && qtyPlus && qtyValue) {
        qtyMinus.addEventListener('click', function (e) {
            e.preventDefault();
            setQty(getQty() - 1);
        });
        qtyPlus.addEventListener('click', function (e) {
            e.preventDefault();
            setQty(getQty() + 1);
        });
        qtyValue.addEventListener('change', function () {
            setQty(getQty());
        });
        qtyValue.addEventListener('blur', function () {
            setQty(getQty());
        });
        qtyValue.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                setQty(getQty());
                qtyValue.blur();
            }
        });
        setQty(1);
    }

    const descTabItems = document.querySelectorAll('.product-detail .desc-tab .menu-tab .tab-item[data-item]');
    const descItems = document.querySelectorAll('.product-detail .desc-tab .desc-block .desc-item');

    function showDescTab(key) {
        descItems.forEach(function (item) {
            item.classList.toggle('open', item.getAttribute('data-item') === key);
        });
    }

    descTabItems.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var key = tab.getAttribute('data-item');
            if (!key) {
                return;
            }
            descTabItems.forEach(function (t) {
                var isActive = t === tab;
                t.classList.toggle('active', isActive);
                t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            showDescTab(key);
        });
    });

    var initial = document.querySelector('.product-detail .desc-tab .menu-tab .tab-item.active[data-item]');
    if (initial) {
        showDescTab(initial.getAttribute('data-item'));
    }
})();
</script>
@endsection
