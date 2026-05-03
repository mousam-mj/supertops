<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update - <?php echo e($order->order_number); ?></title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center;">
        <h1 style="color: #333; margin: 0;">Order Status Update</h1>
    </div>
    
    <div style="background-color: #fff; padding: 30px; margin-top: 20px;">
        <p>Hello <?php echo e($order->user->name); ?>,</p>
        
        <p>Your order status has been updated.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #333;">
            <p><strong>Order Number:</strong> <?php echo e($order->order_number); ?></p>
            <p><strong>Previous Status:</strong> <?php echo e(ucfirst($oldStatus)); ?></p>
            <p><strong>Current Status:</strong> <span style="font-weight: bold; color: #28a745;"><?php echo e(ucfirst($newStatus)); ?></span></p>
        </div>
        
        <?php if($newStatus === 'shipped' && $order->delhivery_waybill): ?>
        <div style="background-color: #e8f4f8; padding: 15px; margin: 20px 0; border-left: 4px solid #17a2b8;">
            <p style="margin: 0;"><strong>Tracking Information:</strong></p>
            <p style="margin: 5px 0;">Your order has been shipped!</p>
            <?php if($order->delhivery_waybill): ?>
                <p style="margin: 5px 0;"><strong>Waybill Number:</strong> <?php echo e($order->delhivery_waybill); ?></p>
            <?php endif; ?>
            <p style="margin: 10px 0 0 0;">You can track your order using the tracking number above.</p>
        </div>
        <?php endif; ?>
        
        <?php if($newStatus === 'delivered'): ?>
        <div style="background-color: #d4edda; padding: 15px; margin: 20px 0; border-left: 4px solid #28a745;">
            <p style="margin: 0;"><strong>Order Delivered!</strong></p>
            <p style="margin: 5px 0;">Your order has been successfully delivered. We hope you enjoy your purchase!</p>
        </div>
        <?php endif; ?>
        
        <p>If you have any questions, please don't hesitate to contact our support team.</p>
        
        <p>Thank you for shopping with us!</p>
        
        <p>Best regards,<br><?php echo e(config('app.name')); ?> Team</p>
    </div>
    
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html>




<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/emails/order-status-update.blade.php ENDPATH**/ ?>