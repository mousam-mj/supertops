<?php $__env->startSection('title', 'Quotation '.$quotaRequest->reference); ?>
<?php $__env->startSection('page-title', 'Quotation: '.$quotaRequest->reference); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-3">
    <div class="col-12 d-flex flex-wrap align-items-center gap-2 justify-content-between">
        <a href="<?php echo e(route('admin.quota-requests.index')); ?>" class="btn btn-outline-secondary btn-sm">&larr; Back to list</a>
        <form method="POST" action="<?php echo e(route('admin.quota-requests.destroy', $quotaRequest)); ?>" onsubmit="return confirm('Delete this quota request permanently?');" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete quotation</button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer</h5>
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr><th width="180">Reference</th><td><strong><?php echo e($quotaRequest->reference); ?></strong></td></tr>
                    <tr><th>Company</th><td><?php echo e($quotaRequest->company_name ?: '—'); ?></td></tr>
                    <tr><th>Contact</th><td><?php echo e($quotaRequest->contact_name); ?></td></tr>
                    <tr><th>Email</th><td><a href="mailto:<?php echo e($quotaRequest->email); ?>"><?php echo e($quotaRequest->email); ?></a></td></tr>
                    <tr><th>Phone</th><td><?php echo e($quotaRequest->phone ?: '—'); ?></td></tr>
                    <tr><th>Message</th><td><?php if($quotaRequest->message): ?><?php echo nl2br(e($quotaRequest->message)); ?><?php else: ?>—<?php endif; ?></td></tr>
                    <tr><th>Submitted</th><td><?php echo e($quotaRequest->created_at->format('F d, Y h:i A')); ?></td></tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Requested products</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $quotaRequest->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->product_sku ?? '—'); ?></td>
                                <td><?php echo e($item->product_name ?? '—'); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td>
                                    <?php if($item->product): ?>
                                        <a href="<?php echo e(route('frontend.product', $item->product->slug)); ?>" target="_blank" rel="noopener">View</a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Admin</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.quota-requests.update', $quotaRequest)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <?php $__currentLoopData = ['pending', 'in_review', 'quoted', 'closed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($st); ?>" <?php echo e(old('status', $quotaRequest->status) === $st ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_', ' ', $st))); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Internal notes</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="6" maxlength="10000"><?php echo e(old('admin_notes', $quotaRequest->admin_notes)); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/quota-requests/show.blade.php ENDPATH**/ ?>