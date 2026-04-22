<?php $__env->startSection('title', 'Orders'); ?>
<?php $__env->startSection('page-title', 'Order Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Orders</h4>
                <p class="text-muted mb-0">View and manage customer orders</p>
            </div>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download Reports
            </a>
        </div>
    </div>
</div>


<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-3">
                <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="filter-status" class="form-label small text-muted mb-1">Status</label>
                        <select name="status" id="filter-status" class="form-select form-select-sm">
                            <option value="all" <?php echo e(($status ?? '') === 'all' || ($status ?? '') === '' ? 'selected' : ''); ?>>All</option>
                            <option value="pending" <?php echo e(($status ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="processing" <?php echo e(($status ?? '') === 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="shipped" <?php echo e(($status ?? '') === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                            <option value="delivered" <?php echo e(($status ?? '') === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                            <option value="fulfilled" <?php echo e(($status ?? '') === 'fulfilled' ? 'selected' : ''); ?>>Fulfilled</option>
                            <option value="cancelled" <?php echo e(($status ?? '') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            <option value="returned" <?php echo e(($status ?? '') === 'returned' ? 'selected' : ''); ?>>Returned</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filter-payment" class="form-label small text-muted mb-1">Payment</label>
                        <select name="payment_status" id="filter-payment" class="form-select form-select-sm">
                            <option value="all" <?php echo e(($paymentStatus ?? '') === 'all' || ($paymentStatus ?? '') === '' ? 'selected' : ''); ?>>All</option>
                            <option value="pending" <?php echo e(($paymentStatus ?? '') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="paid" <?php echo e(($paymentStatus ?? '') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="failed" <?php echo e(($paymentStatus ?? '') === 'failed' ? 'selected' : ''); ?>>Failed</option>
                            <option value="refunded" <?php echo e(($paymentStatus ?? '') === 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter-search" class="form-label small text-muted mb-1">Search</label>
                        <input type="text" name="search" id="filter-search" class="form-control form-control-sm"
                               placeholder="Order #, customer, email..." value="<?php echo e($search ?? ''); ?>">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-funnel me-1"></i> Apply
                        </button>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Delivery Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $colors = $order->items->pluck('color')->filter()->unique()->values();
                                    $sizes = $order->items->pluck('size')->filter()->unique()->values();
                                ?>
                                <tr>
                                    <td><strong><?php echo e($order->order_number); ?></strong></td>
                                    <td><?php echo e($order->user ? $order->user->name : ($order->customer_name ?? 'Guest')); ?></td>
                                    <td><?php echo e($order->user ? $order->user->email : ($order->customer_email ?? 'N/A')); ?></td>
                                    <td><strong><?php echo e(currency($order->total_amount ?? $order->total ?? 0)); ?></strong></td>
                                    <td><?php echo e($colors->isNotEmpty() ? $colors->implode(', ') : '—'); ?></td>
                                    <td><?php echo e($sizes->isNotEmpty() ? $sizes->implode(', ') : '—'); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($order->status_badge_class); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($order->payment_status_badge_class); ?>">
                                            <?php echo e(ucfirst($order->payment_status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($order->shiprocket_awb): ?>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">AWB: <?php echo e($order->shiprocket_awb); ?></small>
                                                <button class="btn btn-xs btn-outline-info mt-1" onclick="trackOrder(<?php echo e($order->id); ?>, 'shiprocket')">
                                                    <i class="bi bi-geo-alt"></i> Track
                                                </button>
                                            </div>
                                        <?php elseif($order->delhivery_waybill): ?>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">Waybill: <?php echo e($order->delhivery_waybill); ?></small>
                                                <button class="btn btn-xs btn-outline-info mt-1" onclick="trackOrder(<?php echo e($order->id); ?>, 'delhivery')">
                                                    <i class="bi bi-geo-alt"></i> Track
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Not shipped</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                            <div class="btn-group mt-1" role="group">
                                                <?php if(!$order->shiprocket_awb && !$order->delhivery_waybill && $order->status !== 'cancelled'): ?>
                                                    <button class="btn btn-sm btn-outline-success" 
                                                            onclick="createShipment(<?php echo e($order->id); ?>)" 
                                                            title="Create Shipment">
                                                        <i class="bi bi-truck"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <?php if($order->status !== 'cancelled' && $order->status !== 'delivered'): ?>
                                                    <button class="btn btn-sm btn-outline-warning" 
                                                            onclick="cancelOrder(<?php echo e($order->id); ?>)" 
                                                            title="Cancel Order">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <p class="text-muted mb-0">No orders found.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($orders->hasPages()): ?>
                <div class="card-footer-pagination">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Track order function
function trackOrder(orderId, provider) {
    const url = `/api/admin/orders/${orderId}/${provider}/track`;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show tracking information in modal
            showTrackingModal(data.data);
        } else {
            alert('Failed to fetch tracking information: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error fetching tracking information');
    });
}

// Create shipment function
function createShipment(orderId) {
    if (!confirm('Create shipment for this order?')) return;
    
    const url = `/api/admin/orders/${orderId}/shiprocket/create-shipment`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Shipment created successfully!');
            location.reload();
        } else {
            alert('Failed to create shipment: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating shipment');
    });
}

// Cancel order function
function cancelOrder(orderId) {
    if (!confirm('Are you sure you want to cancel this order? This action cannot be undone.')) return;
    
    const url = `/api/admin/orders/${orderId}/cancel`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order cancelled successfully!');
            location.reload();
        } else {
            alert('Failed to cancel order: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error cancelling order');
    });
}

// Show tracking modal
function showTrackingModal(trackingData) {
    let modalHtml = `
        <div class="modal fade" id="trackingModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Tracking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>AWB/Waybill:</strong> ${trackingData.awb || trackingData.waybill || 'N/A'}
                            </div>
                            <div class="col-md-6">
                                <strong>Current Status:</strong> ${trackingData.current_status || 'Unknown'}
                            </div>
                        </div>
                        <hr>
                        <div class="tracking-timeline">
                            <h6>Tracking History:</h6>
    `;
    
    if (trackingData.tracking_data && trackingData.tracking_data.length > 0) {
        trackingData.tracking_data.forEach(track => {
            modalHtml += `
                <div class="timeline-item mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted">${track.date || track.timestamp || ''}</small>
                        </div>
                        <div class="col-md-9">
                            <strong>${track.status || track.activity || ''}</strong><br>
                            <small>${track.location || track.remarks || ''}</small>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        modalHtml += '<p class="text-muted">No tracking information available.</p>';
    }
    
    modalHtml += `
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('trackingModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('trackingModal'));
    modal.show();
}
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>