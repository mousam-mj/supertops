<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quota request <?php echo e($quotaRequest->reference); ?></title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #111; max-width: 640px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">New quota request</h1>
    <p><strong>Reference:</strong> <?php echo e($quotaRequest->reference); ?></p>
    <p><strong>Company:</strong> <?php echo e($quotaRequest->company_name ?: '—'); ?></p>
    <p><strong>Contact:</strong> <?php echo e($quotaRequest->contact_name); ?></p>
    <p><strong>Email:</strong> <a href="mailto:<?php echo e($quotaRequest->email); ?>"><?php echo e($quotaRequest->email); ?></a></p>
    <p><strong>Phone:</strong> <?php echo e($quotaRequest->phone ?: '—'); ?></p>
    <?php if($quotaRequest->message): ?>
    <p><strong>Message:</strong><br><?php echo e($quotaRequest->message); ?></p>
    <?php endif; ?>

    <h2 style="font-size: 16px; margin-top: 24px;">Products</h2>
    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; font-size: 14px;">
        <thead>
            <tr style="background: #f3f4f6;">
                <th align="left">SKU</th>
                <th align="left">Name</th>
                <th align="right">Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $quotaRequest->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->product_sku ?? '—'); ?></td>
                <td><?php echo e($item->product_name ?? '—'); ?></td>
                <td align="right"><?php echo e($item->quantity); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <p style="margin-top: 24px; font-size: 14px; color: #6b7280;">
        Open the admin panel to update status and add internal notes.
    </p>
</body>
</html>
<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/emails/quota-request-admin.blade.php ENDPATH**/ ?>