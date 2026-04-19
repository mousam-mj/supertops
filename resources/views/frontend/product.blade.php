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
    $suffixMid = $suffixCount > 0 ? (int) ceil($suffixCount / 2) : 0;
    $suffixLeft = $suffixMid > 0 ? array_slice($suffixRows, 0, $suffixMid) : [];
    $suffixRight = $suffixMid > 0 ? array_slice($suffixRows, $suffixMid) : [];
@endphp

@section('title', ($product->sku ?? $product->name) . ' - EDX Rulmenti Romania')

@section('styles')
<style>
.product-description-html p { margin-bottom: 0.5rem; }
.product-description-html p:last-child { margin-bottom: 0; }
</style>
@endsection

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
                    <div class="product-description text-secondary mt-3 w-full product-description-html">
                        @php $descHtml = trim((string) ($product->description ?? '')); @endphp
                        @if($descHtml !== '')
                            {!! $descHtml !!}
                        @else
                            Keep your home organized, yet elegant with storage cabinets by Onita Patio Furniture. Traditionally designed, they are perfect to be used in the any place where you need to store.
                        @endif
                    </div>
                </div>

                <div class="list-action mt-6">
                    <div class="text-title mt-5">Quantity:</div>
                    <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                        <div class="quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0">
                            <i class="ph-bold ph-minus cursor-pointer body1 disabled" id="qty-minus"></i>
                            <div class="quantity body1 font-semibold" id="qty-value">1</div>
                            <i class="ph-bold ph-plus cursor-pointer body1" id="qty-plus"></i>
                        </div>
                        <button type="button" class="button-main whitespace-nowrap w-full text-center bg-white text-black border border-black edx-add-quota-btn cursor-pointer" data-product-id="{{ $product->id }}">Add To Quota List</button>
                    </div>

                    <div class="more-infor mt-6">
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
                    <a href="{{ route('frontend.product.pdf.download', $product->slug) }}" class="button-main flex-1 text-center">Download PDF</a>
                </div>
            </div>
        </div>
    </div>

    <div class="desc-tab md:pb-20 pb-10">
        <div class="container">
            <div class="flex items-center justify-center w-full">
                <div class="menu-tab flex items-center md:gap-[60px] gap-8">
                    <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer active" data-item="Overview">Overview</div>
                    <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer" data-item="Equivalents">Equivalents</div>
                    <div class="tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer" data-item="Suffixdescription">Suffix description</div>
                </div>
            </div>
            <div class="desc-block mt-8 relative">
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


                <div class="desc-item description pb-10" data-item="Equivalents">
                    <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Equivalents</div>
                    <div class="grid md:grid-cols-2 gap-8 gap-y-8 mt-6">
                        <div class="left min-w-0">
                            <div class="heading6">Manufacturer cross-reference</div>
                            <table class="spec-table mt-3">
                                <tr>
                                    <td><b>Model</b></td>
                                    <td><b>Brand</b></td>
                                </tr>
                                @forelse($equivRows as $row)
                                <tr>
                                    <td>{{ $row['model'] }}</td>
                                    <td>{{ $row['brand'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-secondary" style="text-align: left;">No manufacturer cross-references are stored for this designation yet.</td>
                                </tr>
                                @endforelse
                            </table>
                        </div>
                        <div class="right min-w-0">
                            <div class="heading6">EDX catalogue designation</div>
                            <table class="spec-table mt-3">
                                <tr>
                                    <td>EDX model</td>
                                    <td>{{ $product->sku ?? '—' }}</td>
                                </tr>
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

                <div class="desc-item description pb-10" data-item="Suffixdescription">
                    <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Suffix description</div>
                    @if($suffixCount === 0)
                    <p class="text-secondary mt-6">No suffix codes or descriptions are stored for this product in the catalogue data.</p>
                    @else
                    <div class="grid md:grid-cols-2 gap-8 gap-y-8 mt-6">
                        <div class="left min-w-0">
                            <table class="spec-table">
                                <tr>
                                    <td><b>Suffix / field</b></td>
                                    <td><b>Description</b></td>
                                </tr>
                                @foreach($suffixLeft as $row)
                                <tr>
                                    <td>{{ $row['suffix'] }}</td>
                                    <td>{{ $row['description'] }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="right min-w-0">
                            @if(count($suffixRight) > 0)
                            <table class="spec-table">
                                <tr>
                                    <td><b>Suffix / field</b></td>
                                    <td><b>Description</b></td>
                                </tr>
                                @foreach($suffixRight as $row)
                                <tr>
                                    <td>{{ $row['suffix'] }}</td>
                                    <td>{{ $row['description'] }}</td>
                                </tr>
                                @endforeach
                            </table>
                            @endif
                        </div>
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
            <div class="list-product grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
                                <div class="product-price text-title bg-green px-3 py-0.5 inline-block rounded-full text-sm">{{ $relatedProduct->category->name ?? 'Bearing' }}</div>
                            </div>
                        </div>
                    </a>
                    <div class="action flex flex-col gap-2 p-4 pt-0 mt-auto">
                        <a href="{{ route('frontend.product', $relatedProduct->slug) }}" class="quick-shop-btn button-main w-full text-center py-2.5 px-4 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white no-underline text-sm">View details</a>
                        <button type="button" class="quick-shop-btn button-main w-full py-2.5 px-4 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white edx-add-quota-btn text-sm" data-product-id="{{ $relatedProduct->id }}">Add to quota list</button>
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
                t.classList.toggle('active', t === tab);
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
