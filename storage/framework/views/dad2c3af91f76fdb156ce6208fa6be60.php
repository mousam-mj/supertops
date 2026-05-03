<?php $__env->startSection('title', 'Policy Pages'); ?>
<?php $__env->startSection('page-title', 'Policy Pages'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #2d3748;">Policy & Legal Pages</h4>
            <p class="text-muted mb-0">Edit About Us, Terms & Conditions, Privacy Policy, Return & Refund, and Cancellation Policy. Content is shown on the frontend.</p>
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
                                <th>Page</th>
                                <th>Slug / URL</th>
                                <th>Status</th>
                                <th>Last updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($page->title); ?></td>
                                    <td><code>/<?php echo e($page->slug); ?></code></td>
                                    <td>
                                        <?php if($page->is_active): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($page->updated_at->format('M d, Y H:i')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.policy-pages.edit', $page)); ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>
                                        <a href="<?php echo e(url('/' . $page->slug)); ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View on site">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php if($pages->isEmpty()): ?>
                    <p class="text-muted text-center py-4 mb-0">No policy pages found. Run <code>php artisan db:seed --class=PolicyPageSeeder</code> to create default pages.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/policy-pages/index.blade.php ENDPATH**/ ?>