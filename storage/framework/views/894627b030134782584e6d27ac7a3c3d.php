<?php $__env->startSection('title', 'Instagram Reels'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-instagram me-2"></i>Instagram Reels</h1>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">Add Reel or post link</div>
        <div class="card-body">
            <p class="text-muted small mb-3">
                Full URL from Instagram, e.g. <code>https://www.instagram.com/reel/ABC123xyz/</code> or <code>.../p/ABC123xyz/</code>
            </p>
            <form action="<?php echo e(route('admin.instagram-reels.store')); ?>" method="POST" class="row g-2 align-items-end">
                <?php echo csrf_field(); ?>
                <div class="col-md-10">
                    <label class="form-label">Instagram URL</label>
                    <input type="url" name="url" class="form-control <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           value="<?php echo e(old('url')); ?>" placeholder="https://www.instagram.com/reel/..." required>
                    <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Slider order (shown on home &amp; category pages)</div>
        <div class="card-body p-0">
            <?php if($reels->isEmpty()): ?>
                <p class="text-muted p-4 mb-0">No links yet — the storefront uses the default image gallery.</p>
            <?php else: ?>
                <form id="instagram-reels-sort-form" action="<?php echo e(route('admin.instagram-reels.sort')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:110px">Order</th>
                                <th>URL</th>
                                <th style="width:100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="number" form="instagram-reels-sort-form" name="sort[<?php echo e($reel->id); ?>]" class="form-control form-control-sm"
                                               value="<?php echo e($reel->sort_order); ?>" min="0" max="99999" required>
                                    </td>
                                    <td>
                                        <a href="<?php echo e($reel->url); ?>" target="_blank" rel="noopener" class="small text-break"><?php echo e($reel->url); ?></a>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(route('admin.instagram-reels.destroy', $reel)); ?>" method="POST" class="d-inline"
                                              onsubmit="return confirm('Remove this reel?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top bg-light">
                    <button type="submit" form="instagram-reels-sort-form" class="btn btn-secondary btn-sm">Save order</button>
                    <span class="text-muted small ms-2">Lower numbers appear first in the slider.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/instagram-reels/index.blade.php ENDPATH**/ ?>