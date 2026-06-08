<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['categories']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['categories']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="py-16 px-5 md:px-10 bg-base-200">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">تصفح الأقسام</p>
        <h2 class="font-tajawal font-black text-base-content" style="font-size:clamp(22px,3vw,34px);">كل ما تحتاجه هنا</h2>
    </div>
    <div class="max-w-[1300px] mx-auto grid gap-3" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('products.index', ['category' => $cat->id])); ?>"
           class="reveal flex flex-col items-center gap-3 rounded-2xl p-6 text-center no-underline transition-all duration-300 hover:-translate-y-1 bg-base-100 border border-base-content/10 hover:border-amber-400/30 hover:bg-base-300">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl bg-amber-400/10 border border-amber-400/20">
                <?php echo e($cat->icon ?? '⚡'); ?>

            </div>
            <p class="text-sm font-bold text-base-content"><?php echo e($cat->name); ?></p>
            <p class="text-[11px] text-base-content/40"><?php echo e($cat->products_count); ?> منتج</p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/welcome/categories.blade.php ENDPATH**/ ?>