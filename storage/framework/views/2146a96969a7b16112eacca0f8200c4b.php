<?php $__env->startSection('title', 'Review Manage'); ?>
<?php $__env->startSection('page-title', 'Review Manage'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">Product Reviews</h4>
            <p class="text-muted mb-0">View and manage customer product reviews</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <?php if($reviews->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Reviewer</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($review->product): ?>
                                                <a href="<?php echo e(route('product.show', $review->product->slug)); ?>" target="_blank"><?php echo e($review->product->name); ?></a>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($review->reviewer_name); ?></td>
                                        <td>
                                            <?php for($s = 1; $s <= 5; $s++): ?>
                                                <i class="bi bi-star<?php echo e($s <= $review->rating ? '-fill text-warning' : ''); ?>"></i>
                                            <?php endfor; ?>
                                            (<?php echo e($review->rating); ?>)
                                        </td>
                                        <td class="text-break" style="max-width: 280px;"><?php echo e(Str::limit($review->comment, 80) ?: '—'); ?></td>
                                        <td><?php echo e($review->created_at->format('M d, Y H:i')); ?></td>
                                        <td>
                                            <?php if($review->product): ?>
                                                <a href="<?php echo e(route('product.show', $review->product->slug)); ?>#form-review" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View on product">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>?from=admin" method="post" class="d-inline" onsubmit="return confirm('Delete this review?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($reviews->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>No product reviews yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/reviews/index.blade.php ENDPATH**/ ?>