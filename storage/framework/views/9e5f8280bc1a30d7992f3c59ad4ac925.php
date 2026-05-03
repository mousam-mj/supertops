<?php $__env->startSection('title', 'View Main Category'); ?>
<?php $__env->startSection('page-title', 'Main Category Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;"><?php echo e($category->name); ?></h4>
                <p class="text-muted mb-0">Main category details</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.main-categories.edit', $category)); ?>" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
                <a href="<?php echo e(route('admin.main-categories.index')); ?>" class="btn btn-secondary">
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
                <h5 class="mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Name:</th>
                        <td><?php echo e($category->name); ?></td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code><?php echo e($category->slug); ?></code></td>
                    </tr>
                    <tr>
                        <th>Sort Order:</th>
                        <td><?php echo e($category->sort_order ?? 0); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <?php if($category->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Sub Categories:</th>
                        <td><?php echo e($category->categories->count() ?? 0); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php if($category->image): ?>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Image</h5>
            </div>
            <div class="card-body text-center">
                <img src="<?php echo e(storage_asset($category->image)); ?>" alt="<?php echo e($category->name); ?>" class="img-fluid" style="max-height: 300px; border-radius: 8px;">
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if($category->categories->count() > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sub Categories (<?php echo e($category->categories->count()); ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $category->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($subCategory->name); ?></td>
                                    <td><code><?php echo e($subCategory->slug); ?></code></td>
                                    <td>
                                        <?php if($subCategory->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.categories.show', $subCategory)); ?>" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/main-categories/show.blade.php ENDPATH**/ ?>