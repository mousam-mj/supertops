<?php
    $reviewStats = $reviewStats ?? ['avg' => 0, 'count' => 0, 'distribution' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]];
    $reviews = $reviews ?? collect();
    $distribution = $reviewStats['distribution'] ?? [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    $total = $reviewStats['count'] ?? 0;
?>
<div class="top-overview flex max-sm:flex-col items-center justify-between gap-12 gap-y-4">
    <div class="left flex max-sm:flex-col gap-y-4 items-center justify-between lg:w-1/2 sm:w-2/3 w-full sm:pr-5">
        <div class="rating flex flex-col items-center">
            <div class="text-display"><?php echo e($total > 0 ? number_format($reviewStats['avg'], 1) : '0'); ?></div>
            <div class="flex flex-col items-center">
                <div class="rate flex">
                    <?php for($s = 1; $s <= 5; $s++): ?>
                        <i class="ph <?php echo e($s <= round($reviewStats['avg']) ? 'ph-fill' : 'ph'); ?> ph-star text-lg <?php echo e($s <= round($reviewStats['avg']) ? 'text-yellow' : 'text-line'); ?>"></i>
                    <?php endfor; ?>
                </div>
                <div class="text-secondary text-center mt-1">(<?php echo e(number_format($total)); ?> <?php echo e($total === 1 ? 'Rating' : 'Ratings'); ?>)</div>
            </div>
        </div>
        <?php if($total > 0): ?>
        <div class="list-rating w-2/3">
            <?php $__currentLoopData = [5, 4, 3, 2, 1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $pct = $total > 0 ? round(($distribution[$star] ?? 0) / $total * 100) : 0; ?>
                <div class="item flex items-center justify-between gap-1.5 <?php echo e($loop->first ? '' : 'mt-1'); ?>">
                    <div class="flex items-center gap-1">
                        <div class="caption1"><?php echo e($star); ?></div>
                        <i class="ph-fill ph-star text-sm"></i>
                    </div>
                    <div class="progress bg-line relative w-3/4 h-2">
                        <div class="progress-percent absolute bg-yellow h-full left-0 top-0" style="width: <?php echo e($pct); ?>%;"></div>
                    </div>
                    <div class="caption1"><?php echo e($pct); ?>%</div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="right">
        <a href="#form-review" class="button-main bg-white text-black border border-black whitespace-nowrap">Write Reviews</a>
    </div>
</div>
<div class="list-review mt-8">
    <div class="heading flex items-center justify-between flex-wrap gap-4">
        <div class="heading4"><?php echo e($reviews->count()); ?> <?php echo e($reviews->count() === 1 ? 'Comment' : 'Comments'); ?></div>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="item mt-6 pb-6 border-b border-line review-item" data-review-id="<?php echo e($review->id); ?>">
        <div class="heading flex items-center justify-between">
            <div class="user-infor flex gap-4">
                <div class="avatar">
                    <div class="w-[52px] h-[52px] rounded-full bg-line flex items-center justify-center text-title"><?php echo e(strtoupper(substr($review->reviewer_name, 0, 1))); ?></div>
                </div>
                <div class="user">
                    <div class="flex items-center gap-2">
                        <div class="text-title"><?php echo e($review->reviewer_name); ?></div>
                        <div class="span text-line">-</div>
                        <div class="rate flex">
                            <?php for($s = 1; $s <= 5; $s++): ?>
                                <i class="ph <?php echo e($s <= $review->rating ? 'ph-fill' : 'ph'); ?> ph-star text-xs <?php echo e($s <= $review->rating ? 'text-yellow' : 'text-line'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="text-secondary2"><?php echo e($review->created_at->diffForHumans()); ?></div>
                    </div>
                </div>
            </div>
            <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isAdmin()): ?>
            <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="post" class="inline-block delete-review-form" onsubmit="return confirm('Delete this review?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-secondary2 hover:text-red-600 text-sm cursor-pointer" title="Delete review"><i class="ph ph-trash"></i></button>
            </form>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="mt-3"><?php echo e($review->comment ? e($review->comment) : '—'); ?></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="py-6 text-secondary2">No reviews yet. Be the first to leave a comment!</div>
    <?php endif; ?>
</div>
<div id="form-review" class="form-review pt-8">
    <div class="heading4">Leave A comment</div>
    <?php if(session('success')): ?>
        <p class="mt-3 text-green font-medium"><?php echo e(session('success')); ?></p>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <p class="mt-3 text-red-600 font-medium"><?php echo e(session('error')); ?></p>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <ul class="mt-3 text-red-600 list-disc list-inside">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($err); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
    <?php if(auth()->guard()->check()): ?>
    <form action="<?php echo e(route('product.review.store', $product)); ?>" method="post" class="grid sm:grid-cols-2 gap-4 gap-y-5 mt-6">
        <?php echo csrf_field(); ?>
        <div class="col-span-full">
            <label class="block caption1 mb-1">Rating *</label>
            <select name="rating" class="border border-line px-4 py-3 rounded-lg w-full max-w-[120px]" required>
                <?php for($r = 5; $r >= 1; $r--): ?>
                    <option value="<?php echo e($r); ?>" <?php echo e((int) old('rating', 5) === $r ? 'selected' : ''); ?>><?php echo e($r); ?> <?php echo e($r === 1 ? 'star' : 'stars'); ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-span-full message">
            <textarea class="border border-line px-4 py-3 w-full rounded-lg" name="comment" rows="4" placeholder="Your review (optional)"><?php echo e(old('comment')); ?></textarea>
        </div>
        <div class="col-span-full sm:pt-3">
            <button type="submit" class="button-main bg-white text-black border border-black">Submit Review</button>
        </div>
    </form>
    <?php else: ?>
    <p class="mt-4 text-secondary2">You must be logged in to leave a review. <a href="<?php echo e(route('login')); ?>" class="text-black font-semibold hover:underline">Log in</a></p>
    <?php endif; ?>
</div>
<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/partials/product-reviews.blade.php ENDPATH**/ ?>