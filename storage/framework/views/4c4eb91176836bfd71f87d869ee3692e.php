<div class="overflow-hidden bg-base-200 border-t border-b border-base-content/10" style="padding:14px 0;">
    <div class="ticker-track flex gap-0 whitespace-nowrap">
        <?php $items = [
            ['num'=>'+500','text'=>'منتج متوفر'],
            ['num'=>'🚚','text'=>'شحن سريع لجميع المحافظات'],
            ['num'=>'ضمان','text'=>'على جميع المنتجات'],
            ['num'=>'⚡','text'=>'عروض وخصومات يومية'],
            ['num'=>'24/7','text'=>'دعم فني متخصص'],
            ['num'=>'💳','text'=>'دفع آمن ومضمون'],
        ]; ?>
        <?php $__currentLoopData = array_merge($items,$items); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="inline-flex items-center gap-2 px-8 text-[13px] font-bold text-base-content/50">
            <span class="text-amber-400 text-[15px] font-black"><?php echo e($item['num']); ?></span>
            <?php echo e($item['text']); ?>

            <span class="text-base-content/10 text-[18px]">|</span>
        </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/welcome/ticker.blade.php ENDPATH**/ ?>