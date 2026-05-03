<?php $__env->startSection('title', 'Order Details'); ?>
<?php $__env->startSection('page-title', 'Order Details: ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="200">Order Number</th>
                        <td><strong><?php echo e($order->order_number); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td><?php echo e($order->customer_name); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($order->customer_email); ?></td>
                    </tr>
                    <?php if($order->customer_phone): ?>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo e($order->customer_phone); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-<?php echo e($order->status_badge_class); ?>">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td>
                            <span class="badge bg-<?php echo e($order->payment_status_badge_class); ?>">
                                <?php echo e(ucfirst($order->payment_status)); ?>

                            </span>
                        </td>
                    </tr>
                    <?php if($order->payment_method): ?>
                    <tr>
                        <th>Payment Method</th>
                        <td><?php echo e($order->payment_method); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Subtotal</th>
                        <td>₹<?php echo e(number_format($order->subtotal, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Tax</th>
                        <td>₹<?php echo e(number_format($order->tax, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Shipping</th>
                        <td>₹<?php echo e(number_format($order->shipping, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td><strong>₹<?php echo e(number_format($order->total, 2)); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td><?php echo e($order->created_at->format('F d, Y h:i A')); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Billing Address</h5>
            </div>
            <div class="card-body">
                <?php
                    $billing = is_array($order->billing_address) ? $order->billing_address : (is_string($order->billing_address) ? json_decode($order->billing_address, true) : []);
                ?>
                <?php if(!empty($billing)): ?>
                    <p class="mb-0">
                        <?php echo e(($billing['first_name'] ?? '') . ' ' . ($billing['last_name'] ?? '')); ?><br>
                        <?php echo e($billing['address_line_1'] ?? ''); ?><br>
                        <?php if(!empty($billing['address_line_2'])): ?><?php echo e($billing['address_line_2']); ?><br><?php endif; ?>
                        <?php echo e($billing['city'] ?? ''); ?>, <?php echo e($billing['state'] ?? ''); ?> <?php echo e($billing['pincode'] ?? ''); ?><br>
                        <?php if(!empty($billing['email'])): ?>Email: <?php echo e($billing['email']); ?><br><?php endif; ?>
                        <?php if(!empty($billing['phone'])): ?>Phone: <?php echo e($billing['phone']); ?><?php endif; ?>
                    </p>
                <?php else: ?>
                    <p class="text-muted mb-0">—</p>
                <?php endif; ?>
            </div>
        </div>

        <?php if($order->shipping_address): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <?php
                    $shipping = is_array($order->shipping_address) ? $order->shipping_address : (is_string($order->shipping_address) ? json_decode($order->shipping_address, true) : []);
                ?>
                <?php if(!empty($shipping)): ?>
                    <p class="mb-0">
                        <?php echo e(($shipping['first_name'] ?? '') . ' ' . ($shipping['last_name'] ?? '')); ?><br>
                        <?php echo e($shipping['address_line_1'] ?? ''); ?><br>
                        <?php if(!empty($shipping['address_line_2'])): ?><?php echo e($shipping['address_line_2']); ?><br><?php endif; ?>
                        <?php echo e($shipping['city'] ?? ''); ?>, <?php echo e($shipping['state'] ?? ''); ?> <?php echo e($shipping['pincode'] ?? ''); ?><br>
                        <?php if(!empty($shipping['email'])): ?>Email: <?php echo e($shipping['email']); ?><br><?php endif; ?>
                        <?php if(!empty($shipping['phone'])): ?>Phone: <?php echo e($shipping['phone']); ?><?php endif; ?>
                    </p>
                <?php else: ?>
                    <p class="text-muted mb-0">—</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $colorLines = $item->adminCustomizationColorLines();
                                    $sizeLabel = $item->adminDisplaySize();
                                    $custArr = $item->customizationArray();
                                    $engrText = is_array($custArr) && !empty($custArr['engraving_text']) && is_string($custArr['engraving_text']) ? trim($custArr['engraving_text']) : '';
                                    $engrObj = is_array($custArr) && isset($custArr['engraving']) && is_array($custArr['engraving']) ? $custArr['engraving'] : null;
                                    $engrArtPath = $engrObj && !empty($engrObj['engraving_image']) && is_string($engrObj['engraving_image']) ? trim($engrObj['engraving_image']) : '';
                                    $engrTop = $engrObj && isset($engrObj['top']) && is_array($engrObj['top']) ? $engrObj['top'] : null;
                                    $engrBottom = $engrObj && isset($engrObj['bottom']) && is_array($engrObj['bottom']) ? $engrObj['bottom'] : null;
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?php echo e($item->adminDisplayProductTitle()); ?></div>
                                        <?php if($item->customization_json && $item->product_name && $item->adminDisplayProductTitle() !== $item->product_name): ?>
                                            <div class="small text-muted">Catalog: <?php echo e($item->product_name); ?></div>
                                        <?php endif; ?>
                                        <?php if($item->customization_image): ?>
                                            <div class="mt-2">
                                                <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($item->customization_image)); ?>" alt="Customizer preview" class="rounded border" style="max-width:140px;height:auto;">
                                            </div>
                                        <?php endif; ?>
                                        <?php if($engrObj): ?>
                                            <?php
                                                $isDouble = !empty($engrObj['mode']) && is_string($engrObj['mode']) && strtolower(trim($engrObj['mode'])) === 'double';
                                                $legacyName = $engrObj['category_name'] ?? $engrObj['category_slug'] ?? '—';
                                                $legacyText = !empty($engrObj['text']) && is_string($engrObj['text']) ? trim($engrObj['text']) : '';
                                                $renderSlot = function ($slot, string $label) {
                                                    if (!is_array($slot)) { return ''; }
                                                    $name = $slot['category_name'] ?? $slot['category_slug'] ?? '—';
                                                    $text = !empty($slot['text']) && is_string($slot['text']) ? trim($slot['text']) : '';
                                                    $img = !empty($slot['engraving_image']) && is_string($slot['engraving_image']) ? trim($slot['engraving_image']) : '';
                                                    $html = '<div class="small mt-2"><span class="text-muted fw-semibold">'.e($label).':</span> '.e($name);
                                                    if ($text !== '') { $html .= '<span class="text-muted"> — </span>'.e($text); }
                                                    $html .= '</div>';
                                                    if ($img !== '') {
                                                        $url = \Illuminate\Support\Facades\Storage::disk('public')->url($img);
                                                        $html .= '<div class="small mt-1"><a href="'.e($url).'" target="_blank" rel="noopener">Engraving artwork</a></div>';
                                                        $html .= '<div class="mt-1"><img src="'.e($url).'" alt="Engraving upload" class="rounded border" style="max-width:120px;height:auto;"></div>';
                                                    }
                                                    return $html;
                                                };
                                            ?>
                                            <?php if($engrTop || $engrBottom): ?>
                                                <?php echo $renderSlot($engrTop, 'Top'); ?>

                                                <?php if($isDouble): ?>
                                                    <?php echo $renderSlot($engrBottom, 'Bottom'); ?>

                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="small mt-2">
                                                    <span class="text-muted fw-semibold">Engraving:</span>
                                                    <?php echo e($legacyName); ?>

                                                    <?php if($legacyText !== ''): ?>
                                                        <span class="text-muted"> — </span><?php echo e($legacyText); ?>

                                                    <?php endif; ?>
                                                </div>
                                                <?php if($engrArtPath !== ''): ?>
                                                    <div class="small mt-1">
                                                        <a href="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($engrArtPath)); ?>" target="_blank" rel="noopener">Engraving artwork</a>
                                                    </div>
                                                    <div class="mt-1">
                                                        <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($engrArtPath)); ?>" alt="Engraving upload" class="rounded border" style="max-width:120px;height:auto;">
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php elseif($engrText !== ''): ?>
                                            <div class="small mt-2"><span class="text-muted fw-semibold">Engraving:</span> <?php echo e($engrText); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->product_sku ?? '—'); ?></td>
                                    <td>
                                        <?php if(count($colorLines) > 0): ?>
                                            <ul class="list-unstyled small mb-0">
                                                <?php $__currentLoopData = $colorLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="d-flex align-items-center gap-2 py-1">
                                                        <?php if(!empty($line['hex'])): ?>
                                                            <span class="d-inline-block rounded border flex-shrink-0" style="width:16px;height:16px;background-color:<?php echo e($line['hex']); ?>"></span>
                                                        <?php endif; ?>
                                                        <span><span class="text-muted"><?php echo e($line['label']); ?>:</span> <?php echo e($line['name'] !== '' ? $line['name'] : ($line['hex'] ?? '—')); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php else: ?>
                                            <?php echo e($item->color ?: '—'); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($sizeLabel !== '' ? $sizeLabel : '—'); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td><?php echo e(currency($item->price)); ?></td>
                                    <td><strong><?php echo e(currency($item->total)); ?></strong></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if($order->notes): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Notes</h5>
            </div>
            <div class="card-body">
                <p><?php echo e($order->notes); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between">
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
            <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Order
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>