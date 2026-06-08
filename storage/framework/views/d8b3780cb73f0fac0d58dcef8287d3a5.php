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
    <div class="admin-page max-w-5xl mx-auto py-10 px-4 pb-32">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('admin.brands.index')); ?>"
                   class="btn btn-square btn-outline border-base-content/20 hover:border-amber-500 hover:text-amber-500 transition-all duration-300">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-black tracking-tight">إضافة ماركة جديدة</h1>
                    <p class="text-xs text-base-content/50 font-bold uppercase mt-1">لوحة تحكم فولت الكهربائية</p>
                </div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('admin.brands.store')); ?>" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                
                <div class="lg:col-span-2 space-y-6">

                    
                    <div class="card bg-base-200 border border-base-content/10 shadow-xl">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-2 mb-4 text-amber-500">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <h2 class="card-title text-sm font-bold">البيانات الأساسية</h2>
                            </div>

                            <div class="form-control w-full">
                                <label class="label font-bold text-xs text-base-content/70">
                                    اسم الماركة التجارية <span class="text-error">*</span>
                                </label>
                                <input type="text" name="name" id="brand_name"
                                       placeholder="مثال: آبل، سامسونج، تويوتا..."
                                       class="input input-bordered focus:input-primary bg-base-300 w-full font-bold"
                                       value="<?php echo e(old('name')); ?>" required />
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <label class="label"><span class="label-text-alt text-error font-bold"><?php echo e($message); ?></span></label>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-control w-full mt-4">
                                <label class="label font-bold text-xs text-base-content/70">الوصف التفصيلي</label>
                                <textarea name="description" rows="4"
                                          placeholder="نبذة مختصرة عن تخصص الماركة..."
                                          class="textarea textarea-bordered focus:textarea-primary bg-base-300 font-bold leading-relaxed"><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <label class="label"><span class="label-text-alt text-error font-bold"><?php echo e($message); ?></span></label>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card bg-base-200 border border-base-content/10 shadow-xl">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-2 mb-4 text-amber-500">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <h2 class="card-title text-sm font-bold">الهوية البصرية (اللوجو)</h2>
                            </div>

                            <div class="flex flex-col md:flex-row gap-6 items-start">
                                <div id="logo-preview"
                                     class="w-32 h-32 rounded-2xl bg-base-300 border border-dashed border-base-content/20 flex items-center justify-center overflow-hidden flex-shrink-0 shadow-inner">
                                    <span class="text-4xl opacity-20">🖼️</span>
                                </div>

                                <div class="flex-grow w-full">
                                    <label class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-base-content/20 rounded-2xl cursor-pointer hover:bg-base-300 transition-all group overflow-hidden">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <span class="text-2xl group-hover:scale-125 transition-transform duration-300">📤</span>
                                            <p class="mt-2 text-sm font-bold">اسحب اللوجو هنا أو اضغط للرفع</p>
                                            <p class="text-xs opacity-50 font-bold mt-1 uppercase">PNG, SVG, WEBP (Max 2MB)</p>
                                        </div>
                                        <input type="file" name="logo" id="logo-input" accept="image/*"
                                               class="absolute inset-0 opacity-0 cursor-pointer" />
                                    </label>
                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-error text-xs font-bold mt-2"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card bg-base-200 border border-base-content/10 shadow-xl">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-2 mb-4 text-amber-500">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <h2 class="card-title text-sm font-bold">خصم الماركة</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="form-control w-full">
                                    <label class="label font-bold text-xs text-base-content/70">
                                        نسبة الخصم % على جميع المنتجات
                                    </label>
                                    <input type="number" name="discount_percentage" min="0" max="100" step="0.01"
                                           class="input input-bordered focus:input-warning bg-base-300 w-full font-bold"
                                           value="<?php echo e(old('discount_percentage', 0)); ?>"
                                           placeholder="0 = بدون خصم" />
                                    <?php $__errorArgs = ['discount_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <label class="label"><span class="label-text-alt text-error font-bold"><?php echo e($message); ?></span></label>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-control w-full">
                                    <label class="label font-bold text-xs text-base-content/70">
                                        تاريخ انتهاء الخصم (اختياري)
                                    </label>
                                    <input type="datetime-local" name="discount_expires_at"
                                           class="input input-bordered focus:input-warning bg-base-300 w-full font-bold"
                                           value="<?php echo e(old('discount_expires_at')); ?>" />
                                    <?php $__errorArgs = ['discount_expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <label class="label"><span class="label-text-alt text-error font-bold"><?php echo e($message); ?></span></label>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                
                <div class="space-y-6">

                    <div class="card bg-base-200 border border-base-content/10 shadow-xl">
                        <div class="card-body p-6">
                            <h2 class="font-bold text-xs uppercase opacity-50 mb-4 tracking-widest text-center">الإعدادات الفنية</h2>

                            <div class="form-control w-full">
                                <label class="label font-bold text-xs">رابط الـ Slug</label>
                                <input type="text" name="slug" id="brand_slug" dir="ltr"
                                       class="input input-bordered input-sm bg-base-300 font-mono text-xs focus:input-primary"
                                       value="<?php echo e(old('slug')); ?>" />
                                <label class="label">
                                    <span class="label-text-alt opacity-50 font-bold">يتولد تلقائياً من الاسم</span>
                                </label>
                            </div>

                            <div class="form-control w-full mt-2">
                                <label class="label font-bold text-xs">ترتيب الظهور</label>
                                <input type="number" name="sort_order"
                                       class="input input-bordered input-sm bg-base-300 font-bold focus:input-primary"
                                       value="<?php echo e(old('sort_order', 0)); ?>" />
                            </div>

                            <div class="divider opacity-5"></div>

                            <div class="flex items-center justify-between p-3 bg-base-300 rounded-xl">
                                <div>
                                    <span class="block font-bold text-sm">تفعيل الماركة</span>
                                    <span class="text-[10px] opacity-50 uppercase font-black">Active Status</span>
                                </div>
                                <input type="checkbox" name="is_active" value="1"
                                       class="toggle toggle-primary"
                                    <?php echo e(old('is_active', true) ? 'checked' : ''); ?> />
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            
            <div class="fixed bottom-0 left-0 right-0 z-50">
                <div class="bg-base-200/90 backdrop-blur-md border-t border-base-content/10 px-4 py-4 md:px-8">
                    <div class="max-w-5xl mx-auto flex flex-col-reverse md:flex-row gap-3 items-center justify-end">

                        <a href="<?php echo e(route('admin.brands.index')); ?>"
                           class="btn btn-ghost btn-sm md:btn-md font-bold w-full md:w-auto hover:bg-error/10 hover:text-error transition-all">
                            إلغاء العملية
                        </a>

                        <button type="submit"
                                class="btn btn-primary md:px-12 gap-3 shadow-lg shadow-primary/20 w-full md:w-auto group transform transition hover:scale-[1.02] active:scale-95">
                            <span class="font-black text-base">إتمام إضافة الماركة</span>
                            <div class="bg-primary-content/20 p-1 rounded-md group-hover:bg-primary-content/30 transition-colors">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </button>

                    </div>
                </div>
            </div>

        </form>
    </div>

    <script>
        // معاينة الصورة قبل الرفع
        document.getElementById('logo-input').addEventListener('change', function (e) {
            const preview = document.getElementById('logo-preview');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-contain p-4 animate-in fade-in zoom-in duration-300">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // توليد الـ Slug تلقائياً من الاسم
        document.getElementById('brand_name').addEventListener('input', function () {
            const slugInput = document.getElementById('brand_slug');
            if (slugInput.value === '' || slugInput.dataset.auto === 'true') {
                slugInput.value = this.value.toLowerCase().trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.dataset.auto = 'true';
            }
        });

        // لو المستخدم عدّل الـ slug يدوياً، وقف التوليد التلقائي
        document.getElementById('brand_slug').addEventListener('input', function () {
            this.dataset.auto = 'false';
        });
    </script>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/brands/create.blade.php ENDPATH**/ ?>