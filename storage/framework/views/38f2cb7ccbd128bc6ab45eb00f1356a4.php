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
    <div dir="rtl" class="p-6 max-w-3xl">

        
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="<?php echo e(route('admin.returns.index')); ?>" class="flex items-center gap-1.5 text-sm text-base-content/50 hover:text-base-content mb-2 w-fit">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    طلبات الإرجاع
                </a>
                <h1 class="text-2xl font-black">طلب إرجاع #<?php echo e($return->id); ?></h1>
            </div>
            <div class="badge badge-<?php echo e($return->statusColor()); ?> badge-lg font-bold">
                <?php echo e($return->statusLabel()); ?>

            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success mb-4 text-sm"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

            
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 gap-2">
                    <p class="text-xs font-black tracking-widest uppercase text-base-content/30">العميل</p>
                    <p class="font-bold"><?php echo e($return->user->name); ?></p>
                    <p class="text-sm text-base-content/50"><?php echo e($return->user->email); ?></p>
                    <a href="<?php echo e(route('admin.orders.show', $return->order)); ?>" class="btn btn-ghost btn-xs w-fit mt-1">
                        عرض الطلب #<?php echo e($return->order_id); ?> ←
                    </a>
                </div>
            </div>

            
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 gap-2">
                    <p class="text-xs font-black tracking-widest uppercase text-base-content/30">المنتج</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <?php if($return->product->image_url): ?>
                                <img src="<?php echo e(asset('storage/' . $return->product->image_url)); ?>"
                                     alt="<?php echo e($return->product->name); ?>" class="w-full h-full object-contain p-1">
                            <?php endif; ?>
                        </div>
                        <div>
                            <p class="font-bold text-sm"><?php echo e($return->product->name); ?></p>
                            <p class="text-xs text-warning font-bold"><?php echo e(number_format($return->orderItem->price, 2)); ?> ج.م</p>
                            <p class="text-xs text-base-content/40">كمية: <?php echo e($return->orderItem->quantity); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
            <div class="card-body p-4 gap-3">
                <p class="text-xs font-black tracking-widest uppercase text-base-content/30">تفاصيل الطلب</p>

                <div class="flex justify-between text-sm py-2 border-b border-base-200">
                    <span class="text-base-content/50">سبب الإرجاع</span>
                    <span class="font-semibold"><?php echo e($return->reasonLabel()); ?></span>
                </div>

                <?php if($return->description): ?>
                    <div>
                        <p class="text-xs text-base-content/50 mb-1.5">تفاصيل العميل</p>
                        <p class="bg-base-200 rounded-lg p-3 text-sm"><?php echo e($return->description); ?></p>
                    </div>
                <?php endif; ?>

                <div class="flex justify-between text-sm">
                    <span class="text-base-content/50">تاريخ الطلب</span>
                    <span class="font-semibold"><?php echo e($return->created_at->format('d/m/Y - h:i A')); ?></span>
                </div>
            </div>
        </div>

        
        <?php if($return->images && count($return->images) > 0): ?>
            <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
                <div class="card-body p-4">
                    <p class="text-xs font-black tracking-widest uppercase text-base-content/30 mb-3">صور مرفقة من العميل</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <?php $__currentLoopData = $return->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(Storage::url($img)); ?>" target="_blank">
                                <img src="<?php echo e(Storage::url($img)); ?>" class="w-full h-28 object-cover rounded-xl border border-base-300 hover:opacity-80 transition-opacity">
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if($return->isPending()): ?>
            <div class="card bg-base-100 border border-warning/30 shadow-sm">
                <div class="card-body p-5">
                    <p class="text-xs font-black tracking-widest uppercase text-base-content/30 mb-3">اتخاذ القرار</p>
                    <form action="<?php echo e(route('admin.returns.updateStatus', $return)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <div class="form-control mb-4">
                            <label class="label pb-1">
                                <span class="label-text font-bold text-sm">ملاحظة للعميل (اختياري)</span>
                            </label>
                            <textarea name="admin_note" rows="3" placeholder="وضح للعميل سبب القبول أو الرفض..."
                                      class="textarea textarea-bordered resize-none text-sm"><?php echo e(old('admin_note')); ?></textarea>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button type="submit" name="status" value="approved"
                                    class="btn btn-success flex-1 font-black gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                قبول الطلب
                            </button>
                            <button type="submit" name="status" value="rejected"
                                    class="btn btn-error btn-outline flex-1 font-black gap-2"
                                    onclick="return confirm('هل أنت متأكد من رفض الطلب؟')">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                رفض الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if($return->isApproved()): ?>
            <div class="card bg-info/10 border border-info/30 shadow-sm">
                <div class="card-body p-5">
                    <p class="font-bold text-sm mb-1">تم قبول الطلب ✅</p>
                    <p class="text-xs text-base-content/60 mb-4">بعد ما تستلم المنتج من العميل، اضغط زرار التأكيد.</p>
                    <form action="<?php echo e(route('admin.returns.updateStatus', $return)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="completed">
                        <textarea name="admin_note" rows="2" placeholder="ملاحظة ختامية للعميل (اختياري)..."
                                  class="textarea textarea-bordered resize-none text-sm w-full mb-3"></textarea>
                        <button type="submit" class="btn btn-success font-black gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            تأكيد استلام المنتج المرتجع
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if($return->admin_note && !$return->isPending() && !$return->isApproved()): ?>
            <div class="alert text-sm mt-4
            <?php echo e($return->isRejected() ? 'alert-error' : 'alert-success'); ?>">
                <p><span class="font-bold">ردك السابق:</span> <?php echo e($return->admin_note); ?></p>
            </div>
        <?php endif; ?>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/returns/show.blade.php ENDPATH**/ ?>