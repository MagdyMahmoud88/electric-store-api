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
    <div dir="rtl" class="p-6">

        
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-black">طلبات الإرجاع والضمان</h1>
                <p class="text-sm text-base-content/50 mt-1">راجع وقرر على طلبات العملاء</p>
            </div>
            
            <?php $pendingCount = $returns->where('status', 'pending')->count(); ?>
            <?php if($pendingCount > 0): ?>
                <div class="badge badge-warning badge-lg font-black gap-1">
                    <?php echo e($pendingCount); ?> في الانتظار
                </div>
            <?php endif; ?>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success mb-4 text-sm"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <select name="status" onchange="this.form.submit()" class="select select-bordered select-sm font-bold w-40">
                <option value="">كل الحالات</option>
                <?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(request('status') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <label class="input input-bordered input-sm flex items-center gap-2 flex-1 max-w-xs">
                <svg class="w-3.5 h-3.5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="اسم العميل أو رقم الطلب..." class="grow text-xs">
            </label>

            <?php if(request()->hasAny(['status', 'search'])): ?>
                <a href="<?php echo e(route('admin.returns.index')); ?>" class="btn btn-ghost btn-sm">مسح الفلاتر ✕</a>
            <?php endif; ?>
        </form>

        
        <div class="card bg-base-100 border border-base-300 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead class="bg-base-200 text-xs font-black uppercase tracking-wider">
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>المنتج</th>
                        <th>السبب</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-base-50 <?php echo e($return->isPending() ? 'bg-warning/5' : ''); ?>">
                            <td class="font-mono text-xs text-base-content/40"><?php echo e($return->id); ?></td>
                            <td>
                                <p class="font-bold text-sm"><?php echo e($return->user->name); ?></p>
                                <p class="text-xs text-base-content/40">طلب #<?php echo e($return->order_id); ?></p>
                            </td>
                            <td>
                                <p class="text-sm font-medium max-w-[150px] truncate"><?php echo e($return->product->name); ?></p>
                            </td>
                            <td class="text-xs"><?php echo e($return->reasonLabel()); ?></td>
                            <td>
                                <div class="badge badge-<?php echo e($return->statusColor()); ?> badge-sm font-bold">
                                    <?php echo e($return->statusLabel()); ?>

                                </div>
                            </td>
                            <td class="text-xs text-base-content/50"><?php echo e($return->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.returns.show', $return)); ?>" class="btn btn-ghost btn-xs font-bold">
                                    عرض ←
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-10 text-base-content/30 text-sm">
                                لا توجد طلبات إرجاع
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <?php if($returns->hasPages()): ?>
            <div class="flex justify-center mt-6">
                <?php echo e($returns->withQueryString()->links()); ?>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/returns/index.blade.php ENDPATH**/ ?>