<?php $__env->startSection('title', 'User Details'); ?>
<?php $__env->startSection('page-title', 'User Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="200">ID</th>
                        <td><?php echo e($user->id); ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo e($user->name); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($user->email); ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <?php if($user->role === 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-primary">User</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td><?php echo e($user->created_at->format('F d, Y h:i A')); ?></td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td><?php echo e($user->updated_at->format('F d, Y h:i A')); ?></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit User
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/users/show.blade.php ENDPATH**/ ?>