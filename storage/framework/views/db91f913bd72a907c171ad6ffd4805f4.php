<?php $__env->startSection('title', 'FAQs'); ?>
<?php $__env->startSection('page-title', 'FAQs'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">FAQ Categories</h4>
            <p class="text-muted mb-0">Manage FAQ categories and questions. Content is shown on the FAQs page.</p>
        </div>
        <a href="<?php echo e(route('admin.faqs.create-category')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Category
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
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Questions</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($cat->name); ?></td>
                                    <td><code><?php echo e($cat->slug); ?></code></td>
                                    <td><?php echo e($cat->items_count); ?></td>
                                    <td>
                                        <?php if($cat->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($cat->sort_order); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.faqs.items', $cat)); ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-list-ul"></i> Questions
                                        </a>
                                        <a href="<?php echo e(route('admin.faqs.edit-category', $cat)); ?>" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.faqs.destroy-category', $cat)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this category and all its questions?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No FAQ categories. <a href="<?php echo e(route('admin.faqs.create-category')); ?>">Add one</a> or run <code>php artisan db:seed --class=FaqSeeder</code></td>
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

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/faqs/index.blade.php ENDPATH**/ ?>