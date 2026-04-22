<?php $__env->startSection('title', 'Main Categories'); ?>
<?php $__env->startSection('page-title', 'Main Categories Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Main Categories</h4>
                <p class="text-muted mb-0">Manage main product categories</p>
                <div class="small mt-1">
                    <?php if(empty($showAll)): ?>
                        <span class="text-muted">Showing mains linked to the bearing catalog.</span>
                        <a href="<?php echo e(route('admin.main-categories.index', ['show_all' => 1])); ?>" class="text-primary ms-2">Show all</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.main-categories.index')); ?>" class="text-primary">Only mains used in catalog</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?php echo e(route('admin.main-categories.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Main Category
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if($mainCategories->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Sub Categories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($category->id); ?></td>
                                        <td><?php echo e($category->name); ?></td>
                                        <td><code><?php echo e($category->slug); ?></code></td>
                                        <td><?php echo e($category->sort_order ?? 0); ?></td>
                                        <td>
                                            <?php if($category->is_active): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($category->categories->count() ?? 0); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('admin.main-categories.show', $category)); ?>" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.main-categories.edit', $category)); ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.main-categories.destroy', $category)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                        <i class="bi bi-info-circle me-2"></i>No main categories found. 
                        <a href="<?php echo e(route('admin.main-categories.create')); ?>">Create your first main category</a>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/main-categories/index.blade.php ENDPATH**/ ?>