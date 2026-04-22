<?php
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
?>

<?php $__env->startSection('title', ($product->sku ?? $product->name) . ' - EDX Rulmenti Romania'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.product-description-html p { margin-bottom: 0.5rem; }
.product-description-html p:last-child { margin-bottom: 0; }

/* Product tab — technical tables (card layout, readable columns) */
.product-detail .desc-tab .edx-spec-card {
    border: 1px solid #e5e5e5;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
}
.product-detail .desc-tab .edx-spec-card .edx-spec-card-title {
    margin: 0;
    padding: 14px 18px;
    font-size: 0.9375rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    color: #27272a;
    background: linear-gradient(180deg, #fafafa 0%, #f4f4f5 100%);
    border-bottom: 1px solid #e8e8e8;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table {
    width: 100%;
    border-collapse: collapse;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table tr {
    border-bottom: 1px solid #efefef;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table tr:last-child {
    border-bottom: none;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table td,
.product-detail .desc-tab .edx-spec-card .edx-spec-table th {
    padding: 13px 18px;
    font-size: 0.875rem;
    line-height: 1.45;
    vertical-align: top;
    text-align: left !important;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table thead th {
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #52525b;
    background: #f4f4f5;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table thead th:first-child {
    width: 40%;
    max-width: 14rem;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table tbody td:first-child {
    width: 40%;
    max-width: 14rem;
    color: #71717a;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table tbody td:last-child {
    font-weight: 500;
    color: #18181b;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table tbody tr:hover td {
    background-color: #fafafa;
}
.product-detail .desc-tab .edx-spec-card .edx-spec-table td.edx-empty-cell {
    width: auto !important;
    max-width: none !important;
    text-align: center !important;
    color: #71717a !important;
    font-weight: 400 !important;
    padding: 2.25rem 1.25rem !important;
}
.product-detail .desc-tab .edx-overview-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    margin-top: 1.5rem;
}
@media (min-width: 768px) {
    .product-detail .desc-tab .edx-overview-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem;
    }
}
@media (min-width: 1024px) {
    .product-detail .desc-tab .edx-overview-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.5rem;
    }
}
.tab-edx {
    padding: 10px 14px;
    border-radius: 8px;
    background-color: #e8e8e8;
    color: #656363;
    transition: background-color 0.2s ease, color 0.2s ease;
}
.product-detail .desc-tab .menu-tab .tab-item.tab-edx.active {
    background-color: #fff;
    color: #18181b;
    box-shadow: 0 0 0 1px #e5e5e5;
}
.product-detail .desc-tab .menu-tab .tab-item.tab-edx:hover:not(.active) {
    background-color: #dedede;
    color: #18181b;
}
.has-line-before::before {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0px;
    width: 0;
    height: 5px;
    background-color: #ec2127;
    transition: all ease 0.3s;
}
.edx-red {
    --tw-bg-opacity: 1;
    background-color: rgb(236 33 39);
    color: #fff !important;
}
/* Scoped accent — do not use global .ph (breaks every Phosphor icon on the page) */
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
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb (matches edx-product.html) -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2"><?php echo e($product->category->name ?? 'Bearing'); ?></div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="<?php echo e(route('home')); ?>">Home</a>
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
                <img class="w-full object-contain object-center duration-700" src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>">
                <div class="product-description text-secondary mt-3">Image may differ from product. See technical specification for details.</div>
            </div>
            <div class="product-item product-infor w-full md:w-7/12 md:pl-6 lg:pl-8" data-item="<?php echo e($product->id); ?>">
                <div class="flex justify-between">
                    <div>
                        <div class="product-name heading4 mt-1"><?php echo e($product->sku ?? $product->name); ?></div>
                    </div>
                    <div class="add-wishlist-btn w-10 h-10 flex-shrink-0 flex items-center justify-center border border-line cursor-pointer rounded-lg duration-300 hover:bg-black hover:text-white">
                        <i class="ph ph-heart text-xl"></i>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap mt-5 pb-6 border-b border-line">
                    <div class="product-sale font-semibold edx-red px-3 py-0.5 inline-block rounded-full"><?php echo e($product->category->name ?? 'Deep Groove Ball Bearing'); ?></div>
                    <div class="product-description text-secondary mt-3 w-full product-description-html">
                        <?php $descHtml = trim((string) ($product->description ?? '')); ?>
                        <?php if($descHtml !== ''): ?>
                            <?php echo $descHtml; ?>

                        <?php else: ?>
                            Keep your home organized, yet elegant with storage cabinets by Onita Patio Furniture. Traditionally designed, they are perfect to be used in the any place where you need to store.
                        <?php endif; ?>
                    </div>
                    <div class="product-price heading5 edx-text-accent">Price on request</div>
                            
                            <div class="w-px h-4 bg-line"></div>
                </div>

                <div class="list-action mt-6">
                    <div class="product-category text-secondary font-semibold edx-text-accent">Available in stock</div>
                    <div class="text-title mt-5">Quantity:</div>
                    <div class="choose-quantity flex items-center max-xl:flex-wrap lg:justify-between gap-5 mt-3">
                        
                        <div class="edx-quantity-block md:p-3 max-md:py-1.5 max-md:px-3 flex items-center justify-between rounded-lg border border-line sm:w-[140px] w-[120px] flex-shrink-0">
                            <i class="ph-bold ph-minus cursor-pointer body1 disabled" id="qty-minus"></i>
                            <div class="quantity body1 font-semibold" id="qty-value">1</div>
                            <i class="ph-bold ph-plus cursor-pointer body1" id="qty-plus"></i>
                        </div>
                        <button type="button" class="button-main whitespace-nowrap w-full text-center bg-black text-white border border-black hover:bg-white hover:text-black edx-add-quota-btn cursor-pointer inline-flex items-center justify-center gap-2" data-product-id="<?php echo e($product->id); ?>">
                            <i class="ph ph-files text-lg shrink-0" aria-hidden="true"></i>
                            <span class="edx-quota-btn-label">Add To Quota List</span>
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
                    <a href="<?php echo e(route('frontend.product.pdf.download', $product->slug)); ?>" class="button-main flex-1 text-center"><i class="ph ph-download"></i> Download PDF</a>
                </div>
            </div>
        </div>
    </div>

    <div class="desc-tab md:pb-20 pb-10">
        <div class="container">
            <div class="flex items-center justify-center w-full">
                <div class="menu-tab flex items-center md:gap-[60px] gap-8">
                    <div class="tab-edx tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer active" data-item="Overview">Overview</div>
                    <div class="tab-edx tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer" data-item="Equivalents">Equivalents</div>
                    <div class="tab-edx tab-item heading5 has-line-before text-secondary2 hover:text-black duration-300 cursor-pointer" data-item="Suffixdescription">Suffix description</div>
                </div>
            </div>
            <div class="desc-block mt-8 relative">
                <div class="desc-item description open pb-10" data-item="Overview">
                    <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Overview</div>
                    <div class="edx-overview-grid">
                        <div class="edx-spec-card">
                            <h3 class="heading6 edx-spec-card-title">Boundary dimensions</h3>
                            <table class="spec-table edx-spec-table">
                                <tbody>
                                    <tr>
                                        <td>Bore diameter</td>
                                        <td><?php echo e($specs['bore_diameter'] ?? '12 mm'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Outside diameter</td>
                                        <td><?php echo e($specs['outside_diameter'] ?? '28 mm'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Width</td>
                                        <td><?php echo e($specs['width'] ?? '7 mm'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="edx-spec-card">
                            <h3 class="heading6 edx-spec-card-title">Performance</h3>
                            <table class="spec-table edx-spec-table">
                                <tbody>
                                    <tr>
                                        <td>Basic dynamic load rating</td>
                                        <td><?php echo e($specs['dynamic_load_rating'] ?? '5.10 KN'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Basic static load rating</td>
                                        <td><?php echo e($specs['static_load_rating'] ?? '2.39 KN'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Limiting speed – Grease</td>
                                        <td><?php echo e($specs['limiting_speed_grease'] ?? '26000 r/min'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Limiting speed – Oil</td>
                                        <td><?php echo e($specs['limiting_speed_oil'] ?? '30000 r/min'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="edx-spec-card md:col-span-2 lg:col-span-1">
                            <h3 class="heading6 edx-spec-card-title">Properties</h3>
                            <table class="spec-table edx-spec-table">
                                <tbody>
                                    <tr>
                                        <td>Number of rows</td>
                                        <td><?php echo e($specs['number_of_rows'] ?? '1'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bore type</td>
                                        <td><?php echo e($specs['bore_type'] ?? 'Cylindrical'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Cage</td>
                                        <td><?php echo e($specs['cage'] ?? 'Sheet Steel'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Radial internal clearance</td>
                                        <td><?php echo e($specs['radial_clearance'] ?? 'CN'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tolerance class for dimensions</td>
                                        <td><?php echo e($specs['tolerance_class'] ?? 'P6'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="desc-item description pb-10" data-item="Equivalents">
                    <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Equivalents</div>
                    <div class="mt-6 min-w-0 overflow-x-auto">
                        <div class="edx-spec-card max-w-3xl">
                            <h3 class="heading6 edx-spec-card-title">Manufacturer cross-reference</h3>
                            <table class="spec-table edx-spec-table w-full">
                                <thead>
                                    <tr>
                                        <th scope="col">Model</th>
                                        <th scope="col">Brand</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $equivRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($row['model']); ?></td>
                                        <td><?php echo e($row['brand']); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="edx-empty-cell">No manufacturer cross-references are stored for this designation yet.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="desc-item description pb-10" data-item="Suffixdescription">
                    <div class="text-button-uppercase text-white bg-red px-2 py-0.5 inline-block rounded-sm border-b border-line">Suffix description</div>
                    <?php if($suffixCount === 0): ?>
                    <p class="text-secondary mt-6">No suffix codes or descriptions are stored for this product in the catalogue data.</p>
                    <?php else: ?>
                    <div class="mt-6 overflow-x-auto">
                        <div class="edx-spec-card max-w-3xl">
                            <h3 class="heading6 edx-spec-card-title">Suffix description</h3>
                            <table class="spec-table edx-spec-table w-full">
                                <thead>
                                    <tr>
                                        <th scope="col">Suffix / field</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $suffixRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($row['suffix']); ?></td>
                                        <td><?php echo e($row['description']); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if($relatedProducts->count() > 0): ?>
    <div class="related-products lg:py-20 md:py-14 py-10 bg-surface">
        <div class="container">
            <div class="heading text-center mb-10">
                <div class="heading3">Related Products</div>
            </div>
            <div class="list-product grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-item edxpro bg-white rounded-2xl border border-line overflow-hidden flex flex-col h-full" data-product-id="<?php echo e($relatedProduct->id); ?>">
                    <a href="<?php echo e(route('frontend.product', $relatedProduct->slug)); ?>" class="block p-4 pb-3 no-underline text-inherit flex-1 min-w-0">
                        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl aspect-square">
                            <div class="product-img w-full h-full rounded-2xl overflow-hidden flex items-center justify-center bg-surface">
                                <img class="w-full h-full object-contain duration-700" src="<?php echo e($relatedProduct->image_url); ?>" alt="<?php echo e($relatedProduct->name); ?>">
                            </div>
                        </div>
                        <div class="product-infor mt-4">
                            <div class="product-name heading6 block duration-300 line-clamp-2"><?php echo e($relatedProduct->sku ?? $relatedProduct->name); ?></div>
                            <div class="product-price-block flex items-center gap-2 flex-wrap mt-2 duration-300 relative z-[1]">
                                <div class="product-price text-title edx-red px-3 py-0.5 inline-block rounded-full text-sm"><?php echo e($relatedProduct->category->name ?? 'Bearing'); ?></div>
                            </div>
                        </div>
                    </a>
                    <div class="action flex flex-col gap-2 p-4 pt-0 mt-auto">
                        <a href="<?php echo e(route('frontend.product', $relatedProduct->slug)); ?>" class="button-main w-full text-center py-2.5 px-4 rounded-full bg-white text-black border border-black hover:bg-black hover:text-white no-underline text-sm">View details</a>
                        <button type="button" class="button-main w-full py-2.5 px-4 rounded-full bg-black text-white border border-black hover:bg-white hover:text-black edx-add-quota-btn text-sm inline-flex items-center justify-center gap-2" data-product-id="<?php echo e($relatedProduct->id); ?>">
                            <i class="ph ph-files text-base shrink-0" aria-hidden="true"></i>
                            <span class="edx-quota-btn-label">Add to quota list</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/supertops.in/public_html/resources/views/frontend/product.blade.php ENDPATH**/ ?>