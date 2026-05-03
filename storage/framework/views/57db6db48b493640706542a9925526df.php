<?php $__env->startSection('title', 'Inventory'); ?>
<?php $__env->startSection('page-title', 'Inventory Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Product Inventory</h4>
                <p class="text-muted mb-0">Manage stock levels for all products (latest first)</p>
            </div>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download Reports
            </a>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <form action="<?php echo e(route('admin.inventory.index')); ?>" method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <div class="input-group" style="max-width: 320px;">
                <input type="text" name="q" class="form-control" placeholder="Search by product name or SKU..." value="<?php echo e(request('q')); ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
            <?php if(request('q')): ?>
                <a href="<?php echo e(route('admin.inventory.index')); ?>" class="btn btn-outline-secondary btn-sm">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if($products->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $placeholderImg = asset('assets/images/product/perch-bottal.webp');
                                    $getProductImageUrl = function($product) {
                                        if ($product->image) {
                                            $path = $product->image;
                                            if (str_starts_with($path, 'http') || str_starts_with($path, '//')) return $path;
                                            if (str_starts_with($path, 'assets/') || str_starts_with($path, '/assets/')) return asset($path);
                                            return storage_asset($path);
                                        }
                                        if (is_array($product->images) && count($product->images) > 0) {
                                            $first = $product->images[0];
                                            if (is_string($first)) {
                                                if (str_starts_with($first, 'assets/') || str_starts_with($first, '/assets/')) return asset($first);
                                                return storage_asset($first);
                                            }
                                        }
                                        return null;
                                    };
                                ?>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $imgUrl = $getProductImageUrl($product) ?? $placeholderImg; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo e($imgUrl); ?>" 
                                                     alt="<?php echo e($product->name); ?>" 
                                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px; background: #f0f0f0;"
                                                     onerror="this.onerror=null; this.src='<?php echo e($placeholderImg); ?>';">
                                                <div>
                                                    <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="fw-semibold"><?php echo e($product->name); ?></a>
                                                    <?php if($product->sku): ?>
                                                        <div class="text-muted small"><?php echo e($product->sku); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                        <td>
                                            <?php
                                                $stock = $product->stock_quantity ?? 0;
                                            ?>
                                            <?php if($stock <= 0): ?>
                                                <span class="badge bg-danger">Out of Stock</span>
                                            <?php elseif($stock < 10): ?>
                                                <span class="badge bg-warning"><?php echo e($stock); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?php echo e($stock); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(currency($product->sale_price ?? $product->price ?? 0)); ?></td>
                                        <td>
                                            <?php if($product->is_active): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.inventory.product', $product->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-box-seam"></i> Manage Inventory
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No products found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/inventory/index.blade.php ENDPATH**/ ?>