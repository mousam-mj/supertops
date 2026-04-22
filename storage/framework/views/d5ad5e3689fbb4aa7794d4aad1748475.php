<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="product-item grid-type">
        <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full text-center py-8">
        <p class="body1 text-secondary">No products found for "<?php echo e(e($query ?? '')); ?>"</p>
    </div>
<?php endif; ?>
<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/partials/search-results.blade.php ENDPATH**/ ?>