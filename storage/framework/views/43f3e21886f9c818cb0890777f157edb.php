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

<div class="page-container py-10" dir="rtl" style="font-family:'Cairo',sans-serif;">

    
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-black" style="color:var(--text);">إدارة الطلبات</h1>
            <p class="text-sm mt-1" style="color:var(--text-muted);"><?php echo e($orders->total()); ?> طلب إجمالاً</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-ghost btn-sm gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            لوحة التحكم
        </a>
    </div>

    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-8">
        <?php
        $statuses = [
            'pending'    => ['قيد الانتظار', 'warning',  '⏳'],
            'processing' => ['قيد التجهيز',  'info',     '⚙️'],
            'shipped'    => ['تم الشحن',      'primary',  '🚚'],
            'delivered'  => ['تم التسليم',    'success',  '✅'],
            'cancelled'  => ['ملغي',           'error',    '✕'],
        ];
        ?>
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label, $color, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(request()->fullUrlWithQuery(['status' => $key, 'page' => 1])); ?>"
           class="rounded-2xl p-4 flex flex-col gap-2 transition-all duration-200 hover:-translate-y-1 cursor-pointer"
           style="background:var(--surface);border:1px solid <?php echo e(request('status') === $key ? 'rgba(245,158,11,.4)' : 'var(--border)'); ?>;">
            <div class="flex items-center justify-between">
                <span class="text-xl"><?php echo e($icon); ?></span>
                <span class="badge badge-<?php echo e($color); ?> badge-sm font-bold"><?php echo e($statusCounts[$key] ?? 0); ?></span>
            </div>
            <p class="text-xs font-bold" style="color:var(--text-soft);"><?php echo e($label); ?></p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="rounded-2xl p-5 mb-6" style="background:var(--surface);border:1px solid var(--border);">
        <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="flex flex-wrap gap-3 items-end">

            
            <div class="form-control gap-1 flex-1 min-w-48">
                <label class="label py-0">
                    <span class="label-text text-xs font-bold" style="color:var(--text-soft);">بحث بالاسم أو الإيميل</span>
                </label>
                <label class="input input-bordered input-sm flex items-center gap-2"
                       style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                        <path stroke-linecap="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           class="grow bg-transparent outline-none text-sm" style="color:var(--text);"
                           placeholder="ابحث...">
                </label>
            </div>

            
            <div class="form-control gap-1">
                <label class="label py-0">
                    <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الحالة</span>
                </label>
                <select name="status" class="select select-bordered select-sm"
                        style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                    <option value="">كل الحالات</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(request('status') === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <button type="submit" class="btn btn-sm font-black"
                    style="background:var(--electric);color:#070810;border:none;">
                فلتر
            </button>

            <?php if(request('search') || request('status')): ?>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-ghost"
               style="border:1px solid var(--border);color:var(--text-soft);">
                مسح
            </a>
            <?php endif; ?>

        </form>
    </div>

    
    <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">

        
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border);">
            <h2 class="font-black text-sm" style="color:var(--text);">قائمة الطلبات</h2>
            <span class="text-xs" style="color:var(--text-muted);">
                عرض <?php echo e($orders->firstItem()); ?>–<?php echo e($orders->lastItem()); ?> من <?php echo e($orders->total()); ?>

            </span>
        </div>

        <?php if($orders->isEmpty()): ?>
            <div class="flex flex-col items-center justify-center py-20 gap-3">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"
                     style="color:var(--border-hover);">
                    <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm font-bold" style="color:var(--text-muted);">لا توجد طلبات</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-sm" style="--tw-bg-opacity:0;">

                    <thead>
                        <tr style="background:var(--surface2);color:var(--text-soft);">
                            <th class="font-black text-right py-3 px-5">#</th>
                            <th class="font-black text-right py-3 px-5">العميل</th>
                            <th class="font-black text-right py-3 px-5">المنتجات</th>
                            <th class="font-black text-right py-3 px-5">الإجمالي</th>
                            <th class="font-black text-right py-3 px-5">الحالة</th>
                            <th class="font-black text-right py-3 px-5">التاريخ</th>
                            <th class="font-black text-right py-3 px-5">إجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="transition-colors duration-150"
                            style="border-bottom:1px solid var(--border);"
                            onmouseover="this.style.background='var(--surface2)'"
                            onmouseout="this.style.background='transparent'">

                            
                            <td class="py-4 px-5">
                                <span class="font-mono text-xs font-bold" style="color:var(--text-muted);">
                                    #<?php echo e(substr($order->id, 0, 8)); ?>

                                </span>
                            </td>

                            
                            <td class="py-4 px-5">

                                
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black flex-shrink-0"
                                     style="background:var(--electric-dim);color:var(--electric);border:1px solid rgba(245,158,11,.25);">
                                    <?php echo e(strtoupper(substr($order->user?->name ?? 'G', 0, 1))); ?>

                                </div>

            <div>
                
                <p class="font-bold text-xs" style="color:var(--text);">
                    <?php echo e($order->user?->name ?? 'عميل محذوف/زائر'); ?>

                </p>
                
                <p class="text-[11px]" style="color:var(--text-muted);">
                    <?php echo e($order->user?->email ?? 'N/A'); ?>

                </p>
            </div>

                            </td>

                            
                            <td class="py-4 px-5">
                                <span class="text-xs font-bold" style="color:var(--text-soft);">
                                    <?php echo e($order->items->sum('quantity')); ?> منتج
                                </span>
                            </td>

                            
                            <td class="py-4 px-5">
                                <span class="font-black text-sm" style="color:var(--electric);">
                                    <?php echo e(number_format($order->total, 2)); ?>

                                    <span class="text-[11px] font-normal" style="color:var(--text-muted);">ج.م</span>
                                </span>
                            </td>

                            
                            <td class="py-4 px-5">
                                <span class="badge badge-<?php echo e($order->status_color); ?> badge-sm font-bold">
                                    <?php echo e($order->status_label); ?>

                                </span>
                            </td>

                            
                            <td class="py-4 px-5">
                                <span class="text-xs" style="color:var(--text-muted);">
                                    <?php echo e($order->created_at->format('d/m/Y')); ?>

                                </span>
                                <p class="text-[11px]" style="color:var(--text-muted);">
                                    <?php echo e($order->created_at->diffForHumans()); ?>

                                </p>
                            </td>

                            
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">

                                    
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                       class="btn btn-xs gap-1 font-bold"
                                       style="background:var(--surface2);border-color:var(--border);color:var(--text-soft);"
                                       onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                                       onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        عرض
                                    </a>

                                    
                                    <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <select name="status" onchange="this.form.submit()"
                                                class="select select-xs font-bold"
                                                style="background:var(--surface2);border-color:var(--border);color:var(--text-soft);min-width:110px;">
                                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php echo e($order->status === $key ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($orders->hasPages()): ?>
            <div class="flex justify-center py-5" style="border-top:1px solid var(--border);">
                <?php echo e($orders->withQueryString()->links()); ?>

            </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

</div>


<?php if(session('success')): ?>
<div id="toast" class="toast toast-top toast-center z-50">
    <div class="alert alert-success shadow-lg">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="font-bold text-sm"><?php echo e(session('success')); ?></span>
    </div>
</div>
<script>setTimeout(() => document.getElementById('toast')?.remove(), 3000);</script>
<?php endif; ?>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>