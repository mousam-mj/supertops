<?php
    $facets = $facets ?? ['cages' => [], 'rows' => []];
    $cageList = $facets['cages'] ?? [];
    $rowList = $facets['rows'] ?? [];
?>
<!-- Category filter (catalog categories + counts) -->
<div class="filter-type-block pb-8 border-b border-line">
    <div class="heading6">Products type</div>
    <div class="list-type filter-type menu-tab mt-4">
        <a href="<?php echo e(route('frontend.range', request()->except(['category', 'page']))); ?>"
           class="item tab-item flex items-center justify-between cursor-pointer <?php echo e(! request()->filled('category') ? 'active' : ''); ?>">
            <div class="type-name text-secondary has-line-before hover:text-black capitalize">All types</div>
            <div class="text-secondary2 number"><?php echo e($categories->sum('catalog_product_count')); ?></div>
        </a>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['category', 'page']), ['category' => $category->slug]))); ?>"
               class="item tab-item flex items-center justify-between cursor-pointer <?php echo e(request('category') === $category->slug ? 'active' : ''); ?>"
               data-item="<?php echo e($category->slug); ?>">
                <div class="type-name text-secondary has-line-before hover:text-black capitalize"><?php echo e($category->name); ?></div>
                <div class="text-secondary2 number"><?php echo e($category->catalog_product_count ?? 0); ?></div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Search -->
<div class="filter-search pb-8 border-b border-line mt-8">
    <div class="heading6">Search</div>
    <form action="<?php echo e(route('frontend.range')); ?>" method="GET" class="mt-4">
        <?php $__currentLoopData = ['bore', 'cage', 'rows', 'sort', 'category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preserveKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(request()->filled($preserveKey)): ?>
                <input type="hidden" name="<?php echo e($preserveKey); ?>" value="<?php echo e(request($preserveKey)); ?>">
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="relative">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   placeholder="Search by name or SKU…"
                   class="w-full py-3 pl-4 pr-10 rounded-lg border border-line">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2" aria-label="Search">
                <i class="ph ph-magnifying-glass text-xl"></i>
            </button>
        </div>
    </form>
</div>

<!-- Bore (overview boundary dimension) -->
<div class="filter-size pb-8 border-b border-line mt-8">
    <div class="heading6">Bore diameter (mm)</div>
    <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
        <a href="<?php echo e(route('frontend.range', request()->except(['bore', 'page']))); ?>"
           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(! request()->filled('bore') ? 'bg-black text-white' : ''); ?>">All</a>
        <?php $__currentLoopData = ['0-20' => '0–20', '20-50' => '20–50', '50-100' => '50–100', '100+' => '100+']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bKey => $bLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['bore', 'page']), ['bore' => $bKey]))); ?>"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(request('bore') === $bKey ? 'bg-black text-white' : ''); ?>"><?php echo e($bLabel); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php if(count($cageList) > 0): ?>
    <div class="filter-size pb-8 border-b border-line mt-8">
        <div class="heading6">Cage (overview)</div>
        <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
            <a href="<?php echo e(route('frontend.range', request()->except(['cage', 'page']))); ?>"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(! request()->filled('cage') ? 'bg-black text-white' : ''); ?>">All</a>
            <?php $__currentLoopData = $cageList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['cage', 'page']), ['cage' => $cage]))); ?>"
                   class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(request('cage') === $cage ? 'bg-black text-white' : ''); ?>"><?php echo e($cage); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>

<?php if(count($rowList) > 0): ?>
    <div class="filter-size pb-8 border-b border-line mt-8">
        <div class="heading6">Number of rows</div>
        <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
            <a href="<?php echo e(route('frontend.range', request()->except(['rows', 'page']))); ?>"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(! request()->filled('rows') ? 'bg-black text-white' : ''); ?>">All</a>
            <?php $__currentLoopData = $rowList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('frontend.range', array_merge(request()->except(['rows', 'page']), ['rows' => $row]))); ?>"
                   class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line <?php echo e(request('rows') === $row ? 'bg-black text-white' : ''); ?>"><?php echo e($row); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/supertops.in/public_html/resources/views/frontend/partials/catalog-sidebar.blade.php ENDPATH**/ ?>