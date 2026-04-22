<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation request received</title>
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #111; max-width: 640px; margin: 0 auto; padding: 24px;">
    <h1 style="font-size: 20px;">Thank you, <?php echo e($quotaRequest->contact_name); ?></h1>
    <p>We received your quotation request <strong><?php echo e($quotaRequest->reference); ?></strong> and will get back to you shortly.</p>
    <?php if($quotaRequest->items->isNotEmpty()): ?>
    <h2 style="font-size: 16px; margin-top: 20px;">Your requested lines</h2>
    <ul style="padding-left: 20px;">
        <?php $__currentLoopData = $quotaRequest->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($item->product_sku ?? 'Item'); ?> × <?php echo e($item->quantity); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>
    <p style="font-size: 14px; color: #6b7280;">If you did not submit this request, you can ignore this email.</p>
</body>
</html>
<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/emails/quota-request-customer.blade.php ENDPATH**/ ?>