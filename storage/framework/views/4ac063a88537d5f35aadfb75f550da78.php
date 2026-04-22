<?php $__env->startSection('title', 'View Category'); ?>
<?php $__env->startSection('page-title', 'Category: ' . $category->name); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Category Details</h5>
            </div>
            <div class="card-body">
                <?php if($category->image): ?>
                    <div class="mb-4 text-center">
                        <img src="<?php echo e(storage_asset($category->image)); ?>" 
                             alt="<?php echo e($category->name); ?>" 
                             class="img-fluid" 
                             style="max-width: 300px; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>
                <?php endif; ?>
                <table class="table table-borderless">
                    <tr>
                        <th width="200">ID:</th>
                        <td><?php echo e($category->id); ?></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><strong><?php echo e($category->name); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code><?php echo e($category->slug); ?></code></td>
                    </tr>
                    <tr>
                        <th>Parent Category:</th>
                        <td>
                            <?php if($category->parent): ?>
                                <a href="<?php echo e(route('admin.categories.show', $category->parent)); ?>" class="badge bg-info text-decoration-none">
                                    <?php echo e($category->parent->name); ?>

                                </a>
                            <?php else: ?>
                                <span class="text-muted">Main Category</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td><?php echo e($category->description ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Sort Order:</th>
                        <td><?php echo e($category->sort_order); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <?php if($category->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td><?php echo e($category->created_at->format('M d, Y H:i')); ?></td>
                    </tr>
                    <tr>
                        <th>Updated:</th>
                        <td><?php echo e($category->updated_at->format('M d, Y H:i')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Category
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this category?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php if($category->children->count() > 0): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Sub-categories (<?php echo e($category->children->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="<?php echo e(route('admin.categories.show', $child)); ?>" class="text-decoration-none">
                                    <?php echo e($child->name); ?>

                                </a>
                                <?php if($child->children->count() > 0): ?>
                                    <span class="badge bg-secondary"><?php echo e($child->children->count()); ?> items</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/categories/show.blade.php ENDPATH**/ ?>