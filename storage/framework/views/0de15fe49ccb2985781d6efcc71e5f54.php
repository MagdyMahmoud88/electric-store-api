<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['latestProducts']));

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

foreach (array_filter((['latestProducts']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="py-16 px-5 md:px-10 bg-base-100">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">أحدث المنتجات</p>
        <h2 class="font-tajawal font-black mb-3 text-base-content" style="font-size:clamp(22px,3vw,34px);">وصل حديثاً</h2>
        <p class="text-sm text-base-content/40">تشكيلة جديدة من أفضل المنتجات الكهربائية</p>
    </div>

    <div class="max-w-[1300px] mx-auto grid gap-4" style="grid-template-columns:repeat(auto-fill,minmax(230px,1fr));">
        <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $stock = $p->stock;
            $fp = $p->price * (1 - ($p->discount ?? 0)/100);
            $stockClass = $stock > 10 ? 'text-green-600 bg-green-400/10 border-green-400/30'
                        : ($stock > 0  ? 'text-amber-500 bg-amber-400/10 border-amber-400/30' : '');
            $stockLabel = $stock > 10 ? 'متوفر' : ($stock > 0 ? 'محدود' : 'نفذ');
        ?>
        <div class="reveal delay-<?php echo e(($loop->index % 4) + 1); ?> flex flex-col rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 bg-base-200 border border-base-content/10 hover:border-amber-400/30">
            <div class="h-44 relative overflow-hidden bg-base-300">
                <img src="<?php echo e($p->getImageSrc()); ?>" alt="<?php echo e($p->name); ?>" loading="lazy"
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                     onerror="this.onerror=null;this.src='<?php echo e($p->getPlaceholder()); ?>';">
                <?php if($stock > 0): ?>
                <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border <?php echo e($stockClass); ?>">
                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($stock > 10 ? 'bg-green-400' : 'bg-amber-400'); ?>"></span>
                    <?php echo e($stockLabel); ?>

                </span>
                <?php endif; ?>
            </div>

            <div class="p-4 flex flex-col flex-1">
                <p class="text-sm font-black mb-1 truncate text-base-content"><?php echo e($p->name); ?></p>
                <p class="text-xs leading-relaxed mb-3 flex-1 line-clamp-2 text-base-content/40"><?php echo e($p->description); ?></p>

                <div class="flex items-center justify-between pt-3 mb-3 border-t border-base-content/10">
                    <span class="text-lg font-black text-amber-400">
                        <?php echo e(number_format($fp, 0)); ?>

                        <span class="text-[11px] font-normal text-base-content/40">ج.م</span>
                    </span>
                    <span class="text-[11px] text-base-content/40"><?php echo e($stock); ?> وحدة</span>
                </div>

                <div class="flex gap-2">
                    <form action="<?php echo e(route('cart.add', $p->id)); ?>" method="POST" class="flex-1 flex">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="name"     value="<?php echo e($p->name); ?>">
                        <input type="hidden" name="price"    value="<?php echo e($fp); ?>">
                        <input type="hidden" name="image"    value="<?php echo e(asset('storage/' . $p->image_url)); ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                class="btn btn-sm flex-1 font-black text-[13px] border-0 bg-amber-400 text-neutral hover:bg-amber-300"
                                <?php echo e($stock <= 0 ? 'disabled' : ''); ?>>
                            <?php echo e($stock <= 0 ? 'نفذ' : 'أضف للسلة'); ?>

                        </button>
                    </form>
                    <a href="<?php echo e(route('products.show', $p->id)); ?>"
                       class="btn btn-sm btn-square bg-base-300 border border-base-content/10 text-base-content/50 hover:border-amber-400/40 hover:text-amber-400">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="text-center mt-10 reveal">
        <a href="<?php echo e(route('products.index')); ?>"
           class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl font-bold text-[15px] transition-all duration-300 border border-base-content/10 text-base-content/70 hover:border-amber-400 hover:text-amber-400">
            عرض جميع المنتجات
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    </div>
</section>
<?php /**PATH C:\Users\USER\Herd\electric-store-staging\resources\views/components/welcome/latest-products.blade.php ENDPATH**/ ?>