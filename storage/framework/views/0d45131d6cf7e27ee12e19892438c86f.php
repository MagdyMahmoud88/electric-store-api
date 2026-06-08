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

<section class="relative min-h-screen flex flex-col justify-center px-5 md:px-10 pt-28 pb-20 overflow-hidden">

    
    <div class="absolute inset-0 pointer-events-none opacity-40"
         style="background-image:linear-gradient(rgba(245,158,11,0.05) 1px,transparent 1px),linear-gradient(90deg,rgba(245,158,11,0.05) 1px,transparent 1px);background-size:64px 64px;"></div>
    <div class="absolute top-1/4 left-1/2 w-[700px] h-[700px] rounded-full pointer-events-none"
         style="background:radial-gradient(circle,rgba(245,158,11,0.06) 0%,transparent 65%);"></div>
    <div class="absolute bottom-10 right-2/3 w-[500px] h-[500px] rounded-full pointer-events-none"
         style="background:radial-gradient(circle,rgba(59,130,246,0.05) 0%,transparent 65%);"></div>

    <div class="max-w-[1300px] mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">

        
        <div>
            
            <div class="anim-1 inline-flex items-center gap-2 mb-5 px-4 py-1.5 rounded-full text-[11px] font-bold tracking-widest uppercase border border-amber-400/25 bg-amber-400/10 text-amber-400">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                متجرك الأول للأدوات الكهربائية
            </div>

            
            <h1 class="anim-2 font-tajawal font-black leading-tight mb-5 text-base-content" style="font-size:clamp(34px,4.5vw,62px);">
                كل ما تحتاجه من<br>
                <span class="text-amber-400 underline decoration-amber-400/30 underline-offset-4">أدوات كهربائية</span><br>
                في مكان واحد
            </h1>

            
            <p class="anim-3 text-[16px] leading-[1.85] mb-8 text-base-content/50">
                نوفر لك أفضل المنتجات الكهربائية بجودة عالية وأسعار منافسة، من كشافات وأسلاك ولوحات توزيع وكل ما يلزم للمشاريع.
            </p>

            
            <div class="anim-4 flex gap-3 flex-wrap">
                <a href="<?php echo e(route('products.index')); ?>"
                   class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl font-black text-[15px] transition-all duration-300 hover:-translate-y-1 bg-amber-400 text-neutral hover:shadow-[0_14px_36px_rgba(245,158,11,0.28)]">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    تسوق الآن
                </a>
                <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register.index')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-bold text-[15px] transition-all duration-300 border border-base-content/10 text-base-content/70 hover:border-amber-400 hover:text-amber-400">
                    إنشاء حساب مجاناً
                </a>
                <?php endif; ?>
            </div>

            
            <div class="anim-5 flex gap-7 mt-11 pt-7 border-t border-base-content/10">
                <div>
                    <div class="font-tajawal text-2xl font-black text-amber-400" data-target="500">0</div>
                    <div class="text-[11px] mt-0.5 text-base-content/40">منتج متوفر</div>
                </div>
                <div>
                    <div class="font-tajawal text-2xl font-black text-amber-400" data-target="1200">0</div>
                    <div class="text-[11px] mt-0.5 text-base-content/40">عميل راضي</div>
                </div>
                <div>
                    <div class="font-tajawal text-2xl font-black text-amber-400" data-target="15">0</div>
                    <div class="text-[11px] mt-0.5 text-base-content/40">قسم متخصص</div>
                </div>
            </div>
        </div>

        
        <div class="hidden lg:block relative">

            
            <div class="float-badge float-1 absolute -top-4 -right-4 z-10 flex items-center gap-2 px-3 py-2 rounded-xl text-[11px] font-bold bg-base-200 border border-base-content/10 shadow-lg text-base-content">
                <span class="text-green-400">●</span> شحن خلال 24 ساعة
            </div>
            <div class="float-badge float-2 absolute -bottom-2 -right-6 z-10 flex items-center gap-2 px-3 py-2 rounded-xl text-[11px] font-bold bg-base-200 border border-base-content/10 shadow-lg text-base-content">
                ⭐ تقييم 4.9 / 5
            </div>

            
            <div class="rounded-2xl p-7 relative overflow-hidden bg-base-200 border border-base-content/10">
                <div class="absolute -top-10 -left-10 w-52 h-52 rounded-full pointer-events-none"
                     style="background:radial-gradient(circle,rgba(245,158,11,0.08),transparent 70%);"></div>

                
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl mb-4 bg-amber-400/10 border border-amber-400/25">
                    ⚡
                </div>

                <h3 class="text-lg font-black mb-1 text-base-content">الأكثر مبيعاً</h3>
                <p class="text-xs mb-5 text-base-content/40">منتجات اختارها عملاؤنا</p>

                
                <?php $__currentLoopData = $latestProducts->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-3 rounded-xl px-3 py-2.5 mb-2 last:mb-0 transition-all duration-200 bg-base-300 border border-base-content/10 hover:border-amber-400/30">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center text-base flex-shrink-0 bg-base-100">
                        🔦
                    </div>
                    <div class="text-xs font-bold flex-1 text-base-content"><?php echo e(Str::limit($p->name, 22)); ?></div>
                    <div class="text-xs font-black text-amber-400"><?php echo e(number_format($p->price, 0)); ?> ج.م</div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
</section>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/welcome/hero.blade.php ENDPATH**/ ?>