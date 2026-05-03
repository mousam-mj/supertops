<?php $__env->startSection('title', 'Alerts'); ?>
<?php $__env->startSection('page-title', 'Alerts & Notifications'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">System Alerts</h4>
            <p class="text-muted mb-0">Monitor important alerts and notifications</p>
        </div>
    </div>
</div>

<!-- Low Stock Alerts -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Low Stock Products (<?php echo e($lowStockCount); ?>)
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $lowStockProducts = \App\Models\Product::where('stock_quantity', '<', 10)
                        ->where('is_active', true)
                        ->orderBy('stock_quantity', 'asc')
                        ->get();
                ?>
                
                <?php if($lowStockProducts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>"><?php echo e($product->name); ?></a>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger"><?php echo e($product->stock_quantity ?? 0); ?></span>
                                        </td>
                                        <td><?php echo e(currency($product->sale_price ?? $product->price ?? 0)); ?></td>
                                        <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>All products have sufficient stock!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Pending Orders Alerts -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Pending Orders (<?php echo e($pendingOrdersCount); ?>)
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $pendingOrders = \App\Models\Order::where('status', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();
                ?>
                
                <?php if($pendingOrders->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>"><?php echo e($order->order_number ?? 'N/A'); ?></a>
                                        </td>
                                        <td><?php echo e($order->customer_name ?? 'Guest'); ?></td>
                                        <td><?php echo e(currency($order->total_amount ?? $order->total ?? 0)); ?></td>
                                        <td><?php echo e($order->created_at->format('M d, Y H:i')); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>No pending orders!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Out of Stock Products -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-x-circle me-2"></i>
                    Out of Stock Products
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $outOfStockProducts = \App\Models\Product::where('stock_quantity', '<=', 0)
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
                ?>
                
                <?php if($outOfStockProducts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $outOfStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.products.show', $product)); ?>"><?php echo e($product->name); ?></a>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        </td>
                                        <td><?php echo e(currency($product->sale_price ?? $product->price ?? 0)); ?></td>
                                        <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle me-2"></i>No out of stock products!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/alerts/index.blade.php ENDPATH**/ ?>