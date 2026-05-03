<?php $__env->startSection('title', 'View Coupon'); ?>
<?php $__env->startSection('page-title', 'Coupon Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;"><?php echo e($coupon->name); ?></h4>
                <p class="text-muted mb-0">Coupon details and usage statistics</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.coupons.edit', $coupon)); ?>" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
                <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Coupon Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Name:</th>
                        <td><?php echo e($coupon->name); ?></td>
                    </tr>
                    <tr>
                        <th>Code:</th>
                        <td><code class="fw-bold"><?php echo e($coupon->code); ?></code></td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td><?php echo e($coupon->description ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Discount Type:</th>
                        <td>
                            <?php if($coupon->discount_type == 'percentage'): ?>
                                <span class="badge bg-info">Percentage</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Fixed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Discount Value:</th>
                        <td>
                            <?php if($coupon->discount_type == 'percentage'): ?>
                                <?php echo e($coupon->discount_value); ?>%
                            <?php else: ?>
                                <?php echo e(currency($coupon->discount_value)); ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Minimum Order:</th>
                        <td>
                            <?php if($coupon->minimum_order_amount): ?>
                                <?php echo e(currency($coupon->minimum_order_amount)); ?>

                            <?php else: ?>
                                <span class="text-muted">No minimum</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Usage Limit:</th>
                        <td>
                            <?php if($coupon->usage_limit): ?>
                                <?php echo e($coupon->usage_limit); ?>

                            <?php else: ?>
                                <span class="text-muted">Unlimited</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Valid From:</th>
                        <td><?php echo e($coupon->valid_from ? $coupon->valid_from->format('M d, Y') : 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Valid Until:</th>
                        <td><?php echo e($coupon->valid_until ? $coupon->valid_until->format('M d, Y') : 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
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
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Usage Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Total Usage</h6>
                    <h3 class="text-primary"><?php echo e($coupon->usages->count() ?? $coupon->used_count ?? 0); ?></h3>
                    <?php if($coupon->usage_limit): ?>
                        <p class="text-muted small">of <?php echo e($coupon->usage_limit); ?> limit</p>
                    <?php endif; ?>
                </div>

                <?php if($coupon->usages->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>User</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $coupon->usages->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($usage->order): ?>
                                                <a href="<?php echo e(route('admin.orders.show', $usage->order)); ?>"><?php echo e($usage->order->order_number ?? 'N/A'); ?></a>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($usage->user->name ?? 'Guest'); ?></td>
                                        <td><?php echo e($usage->created_at->format('M d, Y')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No usage recorded yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/coupons/show.blade.php ENDPATH**/ ?>