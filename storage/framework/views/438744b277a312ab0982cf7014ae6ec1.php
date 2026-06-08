<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['discountedProducts']));

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

foreach (array_filter((['discountedProducts']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="py-16 px-5 md:px-10 bg-base-100">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">عروض حصرية</p>
        <h2 class="font-tajawal font-black mb-3 text-base-content" style="font-size:clamp(22px,3vw,34px);">خصومات لفترة محدودة</h2>
        <p class="text-sm text-base-content/40">استغل العروض قبل انتهائها</p>
    </div>

    <div class="max-w-[1300px] mx-auto reveal">
        <div class="slider-track flex gap-5 overflow-x-auto scroll-smooth pb-1" id="offerSlider" style="scroll-snap-type:x mandatory;">
            <?php $__currentLoopData = $discountedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $disc = $p->discount ?? 0; $final = $p->price * (1 - $disc/100); ?>
            <div class="flex-shrink-0 w-72 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 bg-base-200 border border-base-content/10 hover:border-amber-400/30"
                 style="scroll-snap-align:start;">
                
                <div class="h-48 flex items-center justify-center relative overflow-hidden bg-base-300">
                    <img src="<?php echo e($p->getImageSrc()); ?>"
                         alt="<?php echo e($p->name); ?>" loading="lazy"
                         class="w-4/5 h-11/12 object-cover"
                         onerror="this.onerror=null;this.src='<?php echo e($p->getPlaceholder()); ?>';">
                    <?php if($disc > 0): ?>
                    <span class="absolute top-2.5 right-2.5 badge badge-error text-white text-[11px] font-black px-2">
                        خصم <?php echo e($disc); ?>%
                    </span>
                    <?php endif; ?>
                    <?php if($p->stock <= 0): ?>
                    <span class="absolute top-2.5 left-2.5 badge badge-neutral text-[11px] font-black px-2">
                        محدود
                    </span>
                    <?php endif; ?>
                </div>

                
                <div class="p-4">
                    <p class="text-sm font-black mb-2 truncate text-base-content"><?php echo e($p->name); ?></p>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-lg font-black text-amber-400"><?php echo e(number_format($final, 0)); ?> ج.م</span>
                        <?php if($disc > 0): ?>
                        <span class="text-xs line-through text-base-content/30"><?php echo e(number_format($p->price, 0)); ?> ج.م</span>
                        <?php endif; ?>
                    </div>
                    <form action="<?php echo e(route('cart.add', $p->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="name"     value="<?php echo e($p->name); ?>">
                        <input type="hidden" name="price"    value="<?php echo e($final); ?>">
                        <input type="hidden" name="image"    value="<?php echo e(asset('storage/' . $p->image_url)); ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                class="btn w-full font-black text-[13px] border-0 bg-amber-400 text-neutral hover:bg-amber-300"
                                <?php echo e($p->stock <= 0 ? 'disabled' : ''); ?>>
                            <?php echo e($p->stock <= 0 ? 'نفذ' : 'أضف للسلة'); ?>

                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="flex gap-3 justify-center mt-5">
            <button onclick="document.getElementById('offerSlider').scrollBy({left:300,behavior:'smooth'})"
                    class="btn btn-sm btn-ghost border border-base-content/10 text-base-content/50 hover:border-amber-400/40 hover:text-amber-400">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <button onclick="document.getElementById('offerSlider').scrollBy({left:-300,behavior:'smooth'})"
                    class="btn btn-sm btn-ghost border border-base-content/10 text-base-content/50 hover:border-amber-400/40 hover:text-amber-400">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/welcome/offers.blade.php ENDPATH**/ ?>