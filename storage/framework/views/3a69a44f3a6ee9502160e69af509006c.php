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

    <div class="page-container py-8" dir="rtl" style="font-family:'Cairo',sans-serif;">

        
        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1 text-xs" style="color:var(--text-muted);">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       style="color:var(--text-muted);text-decoration:none;"
                       onmouseover="this.style.color='var(--electric)'"
                       onmouseout="this.style.color='var(--text-muted)'">لوحة التحكم</a>
                    <span>/</span>
                    <span style="color:var(--text-soft);">الأقسام</span>
                </div>
                <h1 class="text-2xl font-black" style="color:var(--text);">إدارة الأقسام</h1>
            </div>
            <button onclick="openAdd()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-black text-sm transition-all duration-200 hover:-translate-y-0.5"
                    style="background:var(--electric);color:#070810;border:none;cursor:pointer;"
                    onmouseover="this.style.boxShadow='0 8px 24px var(--electric-glow)'"
                    onmouseout="this.style.boxShadow='none'">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة قسم
            </button>
        </div>

        
        <?php if(session('success')): ?>
            <div role="alert" class="alert alert-success mb-6 text-sm font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div role="alert" class="alert alert-error mb-6 text-sm font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <?php if($errors->any()): ?>
            <div role="alert" class="alert alert-error mb-6 text-sm font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
            <?php $__currentLoopData = [
                ['إجمالي الأقسام',  $stats['total'],    'var(--electric)', 'var(--electric-dim)',  'rgba(245,158,11,.25)'],
                ['أقسام نشطة',      $stats['active'],   '#22c55e',         'rgba(34,197,94,.1)',   'rgba(34,197,94,.25)'],
                ['أقسام معطلة',     $stats['inactive'], '#eab308',         'rgba(234,179,8,.1)',   'rgba(234,179,8,.25)'],
                ['إجمالي المنتجات', $stats['products'], '#3b82f6',         'rgba(59,130,246,.1)',  'rgba(59,130,246,.25)'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $val, $color, $bg, $border]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-2xl p-4 transition-all duration-200 hover:-translate-y-1"
                     style="background:var(--surface);border:1px solid var(--border);">
                    <p class="text-2xl font-black mb-1" style="color:<?php echo e($color); ?>;"><?php echo e($val); ?></p>
                    <p class="text-xs" style="color:var(--text-muted);"><?php echo e($label); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <form method="GET" action="<?php echo e(route('admin.categories.index')); ?>"
              class="flex gap-3 mb-6 flex-wrap">

            <label class="input input-bordered input-sm flex items-center gap-2 flex-1 min-w-48"
                   style="background:var(--surface);border-color:var(--border);color:var(--text);">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                     style="color:var(--text-muted);">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="ابحث عن قسم..."
                       class="grow bg-transparent outline-none text-sm" style="color:var(--text);">
            </label>

            <select name="status" onchange="this.form.submit()"
                    class="select select-bordered select-sm"
                    style="background:var(--surface);border-color:var(--border);color:var(--text);">
                <option value="">كل الحالات</option>
                <option value="active"   <?php echo e(request('status') == 'active'   ? 'selected' : ''); ?>>نشط</option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>معطل</option>
            </select>

            <button type="submit"
                    class="btn btn-sm font-black"
                    style="background:var(--electric);color:#070810;border:none;">
                بحث
            </button>

            <?php if(request()->hasAny(['search','status'])): ?>
                <a href="<?php echo e(route('admin.categories.index')); ?>"
                   class="btn btn-sm btn-ghost font-bold"
                   style="border:1px solid var(--border);color:var(--text-soft);">
                    مسح
                </a>
            <?php endif; ?>
        </form>

        
        <?php if($categories->isEmpty()): ?>
            <div class="flex flex-col items-center justify-center py-20 gap-4">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl"
                     style="background:var(--surface);border:1px solid var(--border);">📦</div>
                <p class="text-sm font-bold" style="color:var(--text-muted);">لا توجد أقسام حتى الآن</p>
                <button onclick="openAdd()"
                        class="btn btn-sm font-black"
                        style="background:var(--electric);color:#070810;border:none;">
                    إضافة أول قسم
                </button>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-1"
                         style="background:var(--surface);border:1px solid var(--border);"
                         onmouseover="this.style.borderColor='rgba(245,158,11,.3)'"
                         onmouseout="this.style.borderColor='var(--border)'">

                        
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl"
                                 style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.2);">
                                <?php echo e($cat->icon ?? '⚡'); ?>

                            </div>
                            <div class="flex items-center gap-1">
                                
                                <a href="<?php echo e(route('admin.categories.show', $cat)); ?>"
                                   class="btn btn-xs btn-ghost"
                                   style="color:var(--text-soft);"
                                   title="عرض التفاصيل">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>

                                
                                <button onclick="openEdit(
                                    <?php echo e($cat->id); ?>,
                                    '<?php echo e(addslashes($cat->name)); ?>',
                                    '<?php echo e(addslashes($cat->description ?? '')); ?>',
                                    '<?php echo e(addslashes($cat->icon ?? '')); ?>',
                                    '<?php echo e($cat->color ?? 'icon-amber'); ?>',
                                    '<?php echo e($cat->status); ?>'
                                )"
                                        class="btn btn-xs btn-ghost"
                                        style="color:var(--text-muted);"
                                        title="تعديل">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                
                                <button onclick="openDelete(<?php echo e($cat->id); ?>, '<?php echo e(addslashes($cat->name)); ?>')"
                                        class="btn btn-xs btn-ghost"
                                        style="color:#fca5a5;"
                                        title="حذف">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        
                        <div class="flex-1">
                            <h2 class="font-black text-sm mb-1">
                                <a href="<?php echo e(route('admin.categories.show', $cat)); ?>"
                                   class="hover:underline transition-all"
                                   style="color:var(--text);"
                                   onmouseover="this.style.color='var(--electric)'"
                                   onmouseout="this.style.color='var(--text)'">
                                    <?php echo e($cat->name); ?>

                                </a>
                            </h2>
                            <p class="text-xs leading-relaxed" style="color:var(--text-muted);">
                                <?php echo e($cat->description ?? 'لا يوجد وصف'); ?>

                            </p>
                        </div>

                        
                        <div class="flex items-center justify-between pt-3"
                             style="border-top:1px solid var(--border);">
                            <span class="text-xs font-bold" style="color:var(--text-muted);">
                                <span style="color:var(--text);"><?php echo e($cat->products_count); ?></span> منتج
                            </span>

                            
                            <form action="<?php echo e(route('admin.categories.toggle-status', $cat)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                        class="badge badge-sm font-bold cursor-pointer border-0 transition-all"
                                        style="background:<?php echo e($cat->status === 'active' ? 'rgba(34,197,94,.15)' : 'rgba(107,114,128,.15)'); ?>;
                                       color:<?php echo e($cat->status === 'active' ? '#86efac' : 'var(--text-muted)'); ?>;">
                                    <?php echo e($cat->status === 'active' ? 'نشط' : 'معطل'); ?>

                                </button>
                            </form>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="flex justify-center">
                <?php echo e($categories->links()); ?>

            </div>
        <?php endif; ?>

    </div>

    
    <dialog id="categoryModal" class="modal">
        <div class="modal-box max-w-lg rounded-2xl p-8"
             style="background:var(--surface);border:1px solid var(--border);">

            <h3 class="font-black text-lg mb-6" id="modalTitle" style="color:var(--text);">إضافة قسم جديد</h3>

            <form id="categoryForm" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                
                <input type="hidden" name="_method" id="formMethod" value="POST">

                
                <input type="hidden" name="category_id" id="fId" value="<?php echo e(old('category_id')); ?>">

                
                <div class="form-control gap-1.5">
                    <label class="label py-0">
                    <span class="label-text text-xs font-bold" style="color:var(--text-soft);">
                        اسم القسم <span style="color:var(--electric);">*</span>
                    </span>
                    </label>
                    <input type="text" name="name" id="fName"
                           value="<?php echo e(old('name')); ?>"
                           placeholder="مثال: أسلاك كهربائية"
                           class="input input-bordered w-full <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);"
                           required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs mt-1" style="color:#ef4444;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="form-control gap-1.5">
                    <label class="label py-0">
                        <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الوصف</span>
                    </label>
                    <textarea name="description" id="fDesc" rows="3"
                              placeholder="وصف مختصر..."
                              class="textarea textarea-bordered w-full leading-relaxed <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              style="background:var(--surface2);border-color:var(--border);color:var(--text);resize:vertical;"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs mt-1" style="color:#ef4444;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="grid grid-cols-2 gap-3">
                    <div class="form-control gap-1.5">
                        <label class="label py-0">
                            <span class="label-text text-xs font-bold" style="color:var(--text-soft);">اللون</span>
                        </label>
                        <select name="color" id="fColor"
                                class="select select-bordered w-full"
                                style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                            <?php $__currentLoopData = [
                                'icon-blue'   => 'أزرق',
                                'icon-amber'  => 'ذهبي',
                                'icon-teal'   => 'أخضر فاتح',
                                'icon-coral'  => 'برتقالي',
                                'icon-purple' => 'بنفسجي',
                                'icon-green'  => 'أخضر',
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('color') == $val ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-control gap-1.5">
                        <label class="label py-0">
                            <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الحالة</span>
                        </label>
                        <select name="status" id="fStatus"
                                class="select select-bordered w-full"
                                style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                            <option value="active"   <?php echo e(old('status', 'active') == 'active'   ? 'selected' : ''); ?>>نشط</option>
                            <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>معطل</option>
                        </select>
                    </div>
                </div>

                
                <div class="form-control gap-1.5">
                    <label class="label py-0">
                        <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الأيقونة (emoji)</span>
                    </label>
                    <input type="text" name="icon" id="fIcon"
                           value="<?php echo e(old('icon')); ?>"
                           placeholder="مثال: ⚡"
                           class="input input-bordered w-full <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);"
                           maxlength="4">
                    <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs mt-1" style="color:#ef4444;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button"
                            onclick="document.getElementById('categoryModal').close()"
                            class="btn btn-sm btn-ghost font-bold"
                            style="border:1px solid var(--border);color:var(--text-soft);">
                        إلغاء
                    </button>
                    <button type="submit"
                            class="btn btn-sm font-black"
                            style="background:var(--electric);color:#070810;border:none;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    
    <dialog id="deleteModal" class="modal">
        <div class="modal-box max-w-sm rounded-2xl p-8 text-center"
             style="background:var(--surface);border:1px solid rgba(239,68,68,.25);">

            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                     style="color:#ef4444;">
                    <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="font-black text-base mb-2" style="color:var(--text);">حذف القسم</h3>
            <p class="text-sm mb-6" style="color:var(--text-muted);">
                هتحذف <strong id="delName" style="color:var(--text);"></strong>؟
                <br>هذا الإجراء لا يمكن التراجع عنه.
            </p>

            <form id="deleteForm" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <div class="flex items-center justify-center gap-3">
                    <button type="button"
                            onclick="document.getElementById('deleteModal').close()"
                            class="btn btn-sm btn-ghost font-bold"
                            style="border:1px solid var(--border);color:var(--text-soft);">
                        إلغاء
                    </button>
                    <button type="submit" class="btn btn-sm btn-error font-black gap-1.5">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        حذف
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    
    <style>
        .input:focus, .select:focus, .textarea:focus {
            border-color: var(--electric) !important;
            box-shadow: 0 0 0 3px var(--electric-glow) !important;
            outline: none;
        }
        .modal-box { color: var(--text); }
    </style>

    
    <script>
        const STORE_URL = "<?php echo e(route('admin.categories.store')); ?>";

        // ── فتح Modal الإضافة ──
        function openAdd() {
            document.getElementById('modalTitle').textContent  = 'إضافة قسم جديد';
            document.getElementById('categoryForm').action     = STORE_URL;
            document.getElementById('formMethod').value        = 'POST';
            document.getElementById('fId').value               = '';
            document.getElementById('categoryForm').reset();
            // نرجّع الـ status لـ active بعد الـ reset
            document.getElementById('fStatus').value = 'active';
            document.getElementById('fColor').value  = 'icon-amber';
            document.getElementById('categoryModal').showModal();
        }

        // ── فتح Modal التعديل ──
        function openEdit(id, name, desc, icon, color, status) {
            document.getElementById('modalTitle').textContent  = 'تعديل القسم';
            document.getElementById('categoryForm').action     = '/admin/categories/' + id;
            document.getElementById('formMethod').value        = 'PUT';
            document.getElementById('fId').value               = id; // ملء الـ ID المخفي
            document.getElementById('fName').value             = name;
            document.getElementById('fDesc').value             = desc;
            document.getElementById('fIcon').value             = icon;
            document.getElementById('fColor').value            = color;
            document.getElementById('fStatus').value           = status;
            document.getElementById('categoryModal').showModal();
        }

        // ── فتح Modal الحذف ──
        function openDelete(id, name) {
            document.getElementById('delName').textContent = name;
            document.getElementById('deleteForm').action   = '/admin/categories/' + id;
            document.getElementById('deleteModal').showModal();
        }

        // ── إعادة فتح الـ modal تلقائياً لو فيه validation errors ──
        <?php if($errors->any()): ?>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if(old('_method') === 'PUT'): ?>
            const oldId = "<?php echo e(old('category_id')); ?>";
            if (oldId) {
                document.getElementById('modalTitle').textContent = 'تعديل القسم';
                document.getElementById('categoryForm').action     = '/admin/categories/' + oldId;
                document.getElementById('formMethod').value        = 'PUT';
            }
            <?php endif; ?>
            document.getElementById('categoryModal').showModal();
        });
        <?php endif; ?>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>