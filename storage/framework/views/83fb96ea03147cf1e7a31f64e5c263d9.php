<?php $__env->startSection('title', 'Order Details - ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<?php
    $getImageUrl = function($path) {
        if (!$path) return asset('assets/images/product/perch-bottal.webp');
        if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) {
            return asset($path);
        }
        return storage_asset($path);
    };
    $totalAmount = $order->total_amount ?? $order->total ?? 0;
    $subtotal = $order->subtotal ?? ($order->items->sum('total') ?: $totalAmount);
    $shippingCharge = $order->shipping_charge ?? $order->shipping ?? 0;
    $statusColors = [
        'pending' => 'bg-yellow text-yellow',
        'processing' => 'bg-purple text-purple',
        'shipped' => 'bg-purple text-purple',
        'delivered' => 'bg-success text-success',
        'completed' => 'bg-success text-success',
        'cancelled' => 'bg-red text-red',
        'canceled' => 'bg-red text-red',
    ];
    $statusColor = $statusColors[strtolower($order->status)] ?? 'bg-secondary text-secondary';
?>
<div class="order-details-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="<?php echo e(route('my-account')); ?>?tab=orders" class="inline-flex items-center gap-2 text-secondary hover:text-black body2">
                    <i class="ph ph-arrow-left"></i> Back to My Account
                </a>
            </div>
            <div class="bg-white border border-line rounded-2xl p-8 md:p-12">
                <h1 class="heading2 md:heading1 mb-2">Order Details</h1>
                <p class="body2 text-secondary mb-6">Order <?php echo e($order->order_number); ?></p>
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <div class="caption1 text-secondary mb-1">Order Number</div>
                        <div class="body1 font-semibold"><?php echo e($order->order_number); ?></div>
                    </div>
                    <div>
                        <div class="caption1 text-secondary mb-1">Order Date</div>
                        <div class="body1 font-semibold"><?php echo e($order->created_at->format('M d, Y h:i A')); ?></div>
                    </div>
                    <div>
                        <div class="caption1 text-secondary mb-1">Status</div>
                        <span class="tag px-4 py-1.5 rounded-full bg-opacity-10 <?php echo e($statusColor); ?> caption1 font-semibold"><?php echo e(ucfirst($order->status)); ?></span>
                    </div>
                    <div>
                        <div class="caption1 text-secondary mb-1">Payment</div>
                        <div class="body1 font-semibold capitalize"><?php echo e($order->payment_method ?? '—'); ?></div>
                    </div>
                    <?php if($order->shiprocket_awb || $order->delhivery_waybill): ?>
                        <div>
                            <div class="caption1 text-secondary mb-1">Tracking Number</div>
                            <div class="body1 font-semibold"><?php echo e($order->shiprocket_awb ?? $order->delhivery_waybill); ?></div>
                        </div>
                        <div>
                            <div class="caption1 text-secondary mb-1">Courier</div>
                            <div class="body1 font-semibold"><?php echo e($order->shiprocket_awb ? 'Shiprocket' : 'Delhivery'); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if($order->shiprocket_awb || $order->delhivery_waybill): ?>
                    <div class="border-t border-line pt-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="heading6">Delivery Tracking</h2>
                            <button class="button-main py-2 px-4" onclick="trackUserOrder()">
                                <i class="ph ph-map-pin mr-2"></i>Track Order
                            </button>
                        </div>
                        <div id="tracking-info" class="hidden">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="text-center">
                                    <div class="loading-spinner mb-2">Loading tracking information...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="border-t border-line pt-6">
                    <h2 class="heading6 mb-4">Items</h2>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $product = $item->product;
                                $productImage = $product ? $getImageUrl($product->image ?? null) : asset('assets/images/product/perch-bottal.webp');
                                $productName = $item->product_name ?? ($product ? $product->name : 'Product');
                                $productSlug = $product ? $product->slug : '#';
                                $itemPrice = $item->price ?? 0;
                                $itemTotal = $item->total ?? ($itemPrice * $item->quantity);
                            ?>
                            <div class="flex flex-wrap items-center justify-between gap-4 py-4 <?php echo e(!$loop->last ? 'border-b border-line' : ''); ?>">
                                <a href="<?php echo e(route('product.show', $productSlug)); ?>" class="flex items-center gap-4">
                                    <div class="bg-img w-20 h-20 md:w-24 md:h-24 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="<?php echo e($productImage); ?>" alt="<?php echo e($productName); ?>" class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <div class="body1 font-semibold text-title"><?php echo e($productName); ?></div>
                                        <?php if($item->size || $item->color): ?>
                                            <div class="caption1 text-secondary mt-1">
                                                <?php if($item->size): ?><span class="uppercase"><?php echo e($item->size); ?></span><?php endif; ?>
                                                <?php if($item->size && $item->color): ?><span> / </span><?php endif; ?>
                                                <?php if($item->color): ?><span class="capitalize"><?php echo e($item->color); ?></span><?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="caption1 text-secondary mt-1">Qty: <?php echo e($item->quantity); ?> × ₹<?php echo e(number_format((float) $itemPrice, 2)); ?></div>
                                    </div>
                                </a>
                                <div class="body1 font-semibold">₹<?php echo e(number_format((float) $itemTotal, 2)); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="border-t border-line pt-6 mt-6">
                    <div class="caption1 text-secondary mb-2">Amount breakdown</div>
                    <div class="space-y-2 body2">
                        <div class="flex justify-between"><span>Subtotal</span><span>₹<?php echo e(number_format((float) $subtotal, 2)); ?></span></div>
                        <?php if($shippingCharge > 0): ?>
                            <div class="flex justify-between"><span>Shipping</span><span>₹<?php echo e(number_format((float) $shippingCharge, 2)); ?></span></div>
                        <?php endif; ?>
                        <div class="flex justify-between font-semibold pt-2 border-t border-line mt-2"><span>Total</span><span>₹<?php echo e(number_format((float) $totalAmount, 2)); ?></span></div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="<?php echo e(route('my-account')); ?>?tab=orders" class="button-secondary">
                        Back to My Orders
                    </a>
                    <a href="<?php echo e(route('home')); ?>" class="button-main">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function trackUserOrder() {
    const orderId = <?php echo e($order->id); ?>;
    const provider = '<?php echo e($order->shiprocket_awb ? "shiprocket" : "delhivery"); ?>';
    const trackingInfo = document.getElementById('tracking-info');
    
    // Show loading
    trackingInfo.classList.remove('hidden');
    trackingInfo.innerHTML = `
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="text-center">
                <div class="loading-spinner mb-2">Loading tracking information...</div>
            </div>
        </div>
    `;
    
    fetch(`/api/admin/orders/${orderId}/${provider}/track`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            displayTrackingInfo(data.data);
        } else {
            trackingInfo.innerHTML = `
                <div class="bg-red-50 rounded-xl p-4">
                    <div class="text-center text-red-600">
                        Failed to load tracking information. Please try again later.
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        trackingInfo.innerHTML = `
            <div class="bg-red-50 rounded-xl p-4">
                <div class="text-center text-red-600">
                    Error loading tracking information. Please try again later.
                </div>
            </div>
        `;
    });
}

function displayTrackingInfo(trackingData) {
    const trackingInfo = document.getElementById('tracking-info');
    let html = `
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <div class="caption1 text-secondary mb-1">Tracking Number</div>
                    <div class="body1 font-semibold">${trackingData.awb || trackingData.waybill || 'N/A'}</div>
                </div>
                <div>
                    <div class="caption1 text-secondary mb-1">Current Status</div>
                    <div class="body1 font-semibold">${trackingData.current_status || 'In Transit'}</div>
                </div>
            </div>
            <div class="border-t border-line pt-4">
                <h3 class="body1 font-semibold mb-3">Tracking History</h3>
                <div class="space-y-3">
    `;
    
    if (trackingData.tracking_data && trackingData.tracking_data.length > 0) {
        trackingData.tracking_data.forEach((track, index) => {
            html += `
                <div class="flex gap-4 ${index === 0 ? 'text-black' : 'text-secondary'}">
                    <div class="flex-shrink-0 w-3 h-3 rounded-full ${index === 0 ? 'bg-green-500' : 'bg-gray-300'} mt-1"></div>
                    <div class="flex-1">
                        <div class="body2 font-semibold">${track.status || track.activity || 'Status Update'}</div>
                        <div class="caption1 text-secondary">${track.location || track.remarks || ''}</div>
                        <div class="caption1 text-secondary">${track.date || track.timestamp || ''}</div>
                    </div>
                </div>
            `;
        });
    } else {
        html += '<div class="text-secondary caption1">No detailed tracking information available.</div>';
    }
    
    html += `
                </div>
            </div>
        </div>
    `;
    
    trackingInfo.innerHTML = html;
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/order/show.blade.php ENDPATH**/ ?>