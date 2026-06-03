<section class="py-16 px-5 md:px-10 bg-base-100">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">آراء العملاء</p>
        <h2 class="font-tajawal font-black mb-3 text-base-content" style="font-size:clamp(22px,3vw,34px);">ماذا يقول عملاؤنا</h2>
        <p class="text-sm text-base-content/40">تقييمات حقيقية من عملاء راضين</p>
    </div>
    <div class="max-w-[1300px] mx-auto grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
        <?php $__currentLoopData = [
            ['★★★★★','"منتجات ممتازة وأسعار مناسبة جداً، الشحن وصل بسرعة والتغليف كان محترم."','أحمد محمد','مقاول كهرباء'],
            ['★★★★★','"تعاملت معهم في مشروع كبير، الجودة عالية والأسعار تنافسية."','محمود علي','مهندس كهرباء'],
            ['★★★★☆','"متجر ممتاز، التشكيلة واسعة وفيها كل اللي محتاجه."','خالد إبراهيم','صاحب محل'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="reveal delay-<?php echo e($i+1); ?> rounded-2xl p-6 transition-all duration-300 bg-base-200 border border-base-content/10 hover:border-amber-400/20">
            <div class="text-amber-400 text-base tracking-widest mb-4"><?php echo e($r[0]); ?></div>
            <p class="text-sm italic leading-[1.8] mb-5 text-base-content/50"><?php echo e($r[1]); ?></p>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-base bg-amber-400/10 border border-amber-400/25">
                    👤
                </div>
                <div>
                    <p class="text-sm font-black text-base-content"><?php echo e($r[2]); ?></p>
                    <p class="text-[11px] text-base-content/40"><?php echo e($r[3]); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php /**PATH C:\Users\USER\Herd\electric-store-staging\resources\views/components/welcome/reviews.blade.php ENDPATH**/ ?>