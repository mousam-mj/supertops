<?php $__env->startSection('title', 'FAQ Items - ' . $faq->name); ?>
<?php $__env->startSection('page-title', 'FAQ Items - ' . $faq->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <a href="<?php echo e(route('admin.faqs.index')); ?>" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> Back to Categories</a>
            <h4 class="mb-1 fw-bold mt-2" style="color: #2d3748;"><?php echo e($faq->name); ?></h4>
            <p class="text-muted mb-0">Manage questions and answers for this category.</p>
        </div>
        <a href="<?php echo e(route('admin.faqs.create-item', $faq)); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Question
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e(Str::limit($item->question, 60)); ?></td>
                                    <td>
                                        <?php if($item->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->sort_order); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.faqs.edit-item', [$faq, $item])); ?>" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.faqs.destroy-item', [$faq, $item])); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No questions yet. <a href="<?php echo e(route('admin.faqs.create-item', $faq)); ?>">Add one</a></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/faqs/items.blade.php ENDPATH**/ ?>