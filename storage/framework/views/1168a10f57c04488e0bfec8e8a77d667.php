<?php $__env->startSection('title', 'Coupons'); ?>
<?php $__env->startSection('page-title', 'Coupon Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Coupons</h4>
                <p class="text-muted mb-0">Manage discount coupons and promotional codes</p>
            </div>
            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Create New Coupon
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if($coupons->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Discount</th>
                                    <th>Min Order</th>
                                    <th>Usage Limit</th>
                                    <th>Used</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <code class="fw-bold"><?php echo e($coupon->code); ?></code>
                                        </td>
                                        <td>
                                            <?php if($coupon->discount_type == 'percentage'): ?>
                                                <span class="badge bg-info">Percentage</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">Fixed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($coupon->discount_type == 'percentage'): ?>
                                                <?php echo e($coupon->discount_value); ?>%
                                            <?php else: ?>
                                                <?php echo e(currency($coupon->discount_value)); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($coupon->minimum_order_amount): ?>
                                                <?php echo e(currency($coupon->minimum_order_amount)); ?>

                                            <?php else: ?>
                                                <span class="text-muted">No minimum</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($coupon->usage_limit): ?>
                                                <?php echo e($coupon->usage_limit); ?>

                                            <?php else: ?>
                                                <span class="text-muted">Unlimited</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($coupon->usages->count() ?? $coupon->used_count ?? 0); ?></td>
                                        <td><?php echo e($coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from)->format('M d, Y') : 'N/A'); ?></td>
                                        <td><?php echo e($coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until)->format('M d, Y') : 'N/A'); ?></td>
                                        <td>
                                            <?php
                                                $now = now();
                                                $validFrom = $coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from) : null;
                                                $validTo = $coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until) : null;
                                                
                                                $isActive = $coupon->is_active ?? true;
                                                if ($validFrom && $now->lt($validFrom)) {
                                                    $isActive = false;
                                                }
                                                if ($validTo && $now->gt($validTo)) {
                                                    $isActive = false;
                                                }
                                                $usedCount = $coupon->usages->count() ?? $coupon->used_count ?? 0;
                                                if ($coupon->usage_limit && $usedCount >= $coupon->usage_limit) {
                                                    $isActive = false;
                                                }
                                            ?>
                                            
                                            <?php if($isActive): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('admin.coupons.show', $coupon)); ?>" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.coupons.destroy', $coupon)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No coupons found. 
                        <a href="<?php echo e(route('admin.coupons.create')); ?>">Create your first coupon</a>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/coupons/index.blade.php ENDPATH**/ ?>