<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div dir="rtl" class="min-h-screen bg-base-200 py-8">
        <div class="container mx-auto px-4 max-w-4xl">

            
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-black">طلبات الإرجاع والضمان</h1>
                    <p class="text-sm text-base-content/50 mt-1">تابع حالة طلبات الإرجاع بتاعتك</p>
                </div>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    طلباتي
                </a>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($returns->isEmpty()): ?>
                
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body items-center text-center py-16">
                        <div class="w-16 h-16 rounded-2xl bg-base-200 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                            </svg>
                        </div>
                        <p class="font-black text-lg">مفيش طلبات إرجاع</p>
                        <p class="text-sm text-base-content/50">لو محتاج ترجع منتج، افتح الطلب وهتلاقي زرار الإرجاع</p>
                        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-warning btn-sm mt-4 font-bold">عرض طلباتي</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex flex-col gap-4">
                    <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card bg-base-100 border border-base-300 shadow-sm hover:border-warning/30 transition-colors">
                            <div class="card-body p-4 sm:p-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">

                                    
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-white border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                                            <?php if($return->product->image_url): ?>
                                                <img src="<?php echo e($return->product->image_url); ?>" alt="<?php echo e($return->product->name); ?>" class="w-full h-full object-contain p-1">
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm"><?php echo e($return->product->name); ?></p>
                                            <p class="text-xs text-base-content/50">طلب #<?php echo e($return->order_id); ?></p>
                                            <p class="text-xs text-base-content/40 mt-0.5"><?php echo e($return->created_at->diffForHumans()); ?></p>
                                        </div>
                                    </div>

                                    
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="badge badge-<?php echo e($return->statusColor()); ?> badge-sm font-bold">
                                            <?php echo e($return->statusLabel()); ?>

                                        </div>
                                        <a href="<?php echo e(route('returns.show', $return)); ?>" class="btn btn-ghost btn-xs">التفاصيل ←</a>
                                    </div>
                                </div>

                                
                                <div class="mt-3 pt-3 border-t border-base-200 flex items-center gap-2">
                                    <span class="text-xs text-base-content/40">السبب:</span>
                                    <span class="text-xs font-semibold"><?php echo e($return->reasonLabel()); ?></span>
                                </div>

                                
                                <?php if($return->admin_note): ?>
                                    <div class="mt-2 p-2.5 rounded-lg bg-base-200 text-xs text-base-content/70">
                                        <span class="font-bold">رد المتجر:</span> <?php echo e($return->admin_note); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <?php if($returns->hasPages()): ?>
                    <div class="flex justify-center mt-6">
                        <?php echo e($returns->links()); ?>

                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/user/returns/index.blade.php ENDPATH**/ ?>