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
        <div class="container mx-auto px-4 max-w-2xl">

            
            <div class="mb-6">
                <a href="<?php echo e(route('orders.show', $order)); ?>" class="flex items-center gap-1.5 text-sm text-base-content/50 hover:text-base-content mb-3 w-fit">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    رجوع للطلب
                </a>
                <h1 class="text-2xl font-black">طلب إرجاع / ضمان</h1>
                <p class="text-sm text-base-content/50 mt-1">أكمل البيانات وهنتواصل معاك في أقرب وقت</p>
            </div>

            
            <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
                <div class="card-body p-4 flex flex-row items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-white border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                        <?php if($item->product->image_url): ?>
                            <img src="<?php echo e(asset('storage/' . $item->product->image_url)); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-contain p-1">
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="font-bold"><?php echo e($item->product_name); ?></p>
                        <p class="text-xs text-base-content/50">طلب #<?php echo e($order->id); ?> • <?php echo e($order->created_at->format('d/m/Y')); ?></p>
                        <p class="text-xs text-warning font-bold mt-0.5"><?php echo e(number_format($item->price, 2)); ?> ج.م</p>
                    </div>
                </div>
            </div>

            
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-5 sm:p-6">
                    <form action="<?php echo e(route('returns.store', [$order, $item])); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        
                        <div class="form-control mb-5">
                            <label class="label pb-1.5">
                                <span class="label-text font-bold">سبب الإرجاع <span class="text-error">*</span></span>
                            </label>
                            <div class="flex flex-col gap-2">
                                <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-base-300 cursor-pointer hover:border-warning transition-colors has-[:checked]:border-warning has-[:checked]:bg-warning/5">
                                        <input type="radio" name="reason" value="<?php echo e($value); ?>" class="radio radio-warning radio-sm"
                                            <?php echo e(old('reason') === $value ? 'checked' : ''); ?>>
                                        <span class="text-sm font-medium"><?php echo e($label); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-error text-xs mt-1.5"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-control mb-5">
                            <label class="label pb-1.5">
                                <span class="label-text font-bold">تفاصيل إضافية (اختياري)</span>
                            </label>
                            <textarea name="description" rows="3"
                                      placeholder="وصف المشكلة بالتفصيل..."
                                      class="textarea textarea-bordered resize-none text-sm <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> textarea-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-error text-xs mt-1.5"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-control mb-6">
                            <label class="label pb-1.5">
                                <span class="label-text font-bold">صور توضيحية (اختياري، حتى 4 صور)</span>
                            </label>
                            <input type="file" name="images[]" multiple accept="image/*"
                                   class="file-input file-input-bordered file-input-sm w-full <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> file-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="text-xs text-base-content/40 mt-1.5">صور المنتج أو المشكلة — تساعدنا نحل الموضوع أسرع</p>
                            <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-error text-xs mt-1.5"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="alert alert-warning mb-5 text-sm">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-bold">قبل ما تبعت الطلب</p>
                                <p class="text-xs mt-0.5">هنراجع الطلب ونتواصل معاك خلال 24-48 ساعة لتحديد خطوات الإرجاع.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-full font-black">
                            إرسال طلب الإرجاع
                        </button>
                    </form>
                </div>
            </div>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/user/returns/create.blade.php ENDPATH**/ ?>