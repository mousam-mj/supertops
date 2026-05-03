<div class="list-product hide-product-sold grid grid-cols-2 md:grid-cols-3 xl:grid-cols-3 md:gap-[30px] gap-4 mt-7">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-16">
            <p class="text-secondary body1">No products found.</p>
            <a href="<?php echo e(route('shop')); ?>" class="button-main mt-4 inline-block shop-filter-link">Browse Shop</a>
        </div>
    <?php endif; ?>
</div>

<?php if($products->hasPages()): ?>
<div class="list-pagination w-full flex items-center justify-center gap-4 mt-10">
    <?php echo e($products->links()); ?>

</div>
<?php endif; ?>
<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/shop-products-partial.blade.php ENDPATH**/ ?>