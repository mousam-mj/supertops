<?php $__env->startSection('title', 'Payments History'); ?>
<?php $__env->startSection('page-title', 'Payments History'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Payment History</h4>
                <p class="text-muted mb-0">View all successful payments</p>
            </div>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-download me-1"></i> Download Reports
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h5 class="text-success">Total Revenue</h5>
                <h3 class="mb-0"><?php echo e(currency($payments->sum('total_amount') ?? $payments->sum('total') ?? 0)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h5 class="text-info">Total Payments</h5>
                <h3 class="mb-0"><?php echo e($payments->total()); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h5 class="text-primary">This Month</h5>
                <h3 class="mb-0"><?php echo e(currency(\App\Models\Order::where('payment_status', 'paid')->whereMonth('created_at', now()->month)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(total_amount, total, 0)')) ?? 0)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h5 class="text-warning">Today</h5>
                <h3 class="mb-0"><?php echo e(currency(\App\Models\Order::where('payment_status', 'paid')->whereDate('created_at', today())->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(total_amount, total, 0)')) ?? 0)); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if($payments->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Payment ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.orders.show', $payment)); ?>"><?php echo e($payment->order_number ?? 'N/A'); ?></a>
                                        </td>
                                        <td><?php echo e($payment->customer_name ?? 'Guest'); ?></td>
                                        <td>
                                            <?php if($payment->payment_method == 'razorpay'): ?>
                                                <span class="badge bg-primary">Razorpay</span>
                                            <?php elseif($payment->payment_method == 'cod'): ?>
                                                <span class="badge bg-warning">COD</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo e(ucfirst($payment->payment_method ?? 'N/A')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="fw-semibold"><?php echo e(currency($payment->total_amount ?? $payment->total ?? 0)); ?></td>
                                        <td>
                                            <?php if($payment->razorpay_payment_id): ?>
                                                <code class="small"><?php echo e(substr($payment->razorpay_payment_id, 0, 20)); ?>...</code>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($payment->created_at->format('M d, Y H:i')); ?></td>
                                        <td>
                                            <?php if($payment->payment_status == 'paid'): ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning"><?php echo e(ucfirst($payment->payment_status ?? 'Pending')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.orders.show', $payment)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if($payments->hasPages()): ?>
                        <div class="mt-4">
                            <?php echo e($payments->links()); ?>

                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No payment records found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/payments/index.blade.php ENDPATH**/ ?>