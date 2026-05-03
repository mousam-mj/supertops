<?php $__env->startSection('title', 'Hero Banners'); ?>
<?php $__env->startSection('page-title', 'Home Hero Banners'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Hero Banners</h4>
                <p class="text-muted mb-0">Manage the top hero slider on the homepage. Order by priority (lower = first).</p>
            </div>
            <a href="<?php echo e(route('admin.hero-banners.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Banner
            </a>
        </div>
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
                                <th>#</th>
                                <th>Image</th>
                                <th>Title / Subtitle</th>
                                <th>Button</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($banner->id); ?></td>
                                    <td>
                                        <?php if($banner->banner_image): ?>
                                            <img src="<?php echo e(storage_asset($banner->banner_image)); ?>" alt="" class="rounded" style="width: 120px; height: 60px; object-fit: cover;" onerror="this.style.display='none';">
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?php echo e($banner->name); ?></div>
                                        <?php if($banner->subtitle): ?>
                                            <small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($banner->subtitle, 50)); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($banner->button_text): ?>
                                            <span class="badge bg-light text-dark"><?php echo e($banner->button_text); ?></span>
                                            <?php if($banner->deeplink): ?>
                                                <br><small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($banner->deeplink, 30)); ?></small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($banner->priority); ?></td>
                                    <td>
                                        <?php if($banner->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.hero-banners.edit', $banner)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="<?php echo e(route('admin.hero-banners.destroy', $banner)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No hero banners yet. Add one to show on the homepage.</td>
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

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/hero-banners/index.blade.php ENDPATH**/ ?>