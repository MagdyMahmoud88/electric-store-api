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
                <div class="flex items-center gap-3 mb-1">
                    <a href="<?php echo e(route('admin.orders.index')); ?>"
                       class="text-sm font-bold transition-colors"
                       style="color:var(--text-muted);"
                       onmouseover="this.style.color='var(--electric)'"
                       onmouseout="this.style.color='var(--text-muted)'">
                        الطلبات
                    </a>
                    <span style="color:var(--border-hover);">/</span>
                    <span class="text-sm font-bold" style="color:var(--text);">
                    #<?php echo e(substr($order->id, 0, 8)); ?>

                </span>
                </div>
                <h1 class="text-2xl font-black" style="color:var(--text);">تفاصيل الطلب</h1>
            </div>

            
            <div class="flex items-center gap-2 flex-wrap">

                <a href="<?php echo e(route('admin.orders.invoice.stream', $order->id)); ?>"
                   target="_blank"
                   class="btn btn-sm gap-2 font-bold"
                   style="background:var(--surface2); border-color:var(--border); color:var(--text-soft);"
                   onmouseover="this.style.borderColor='var(--electric)'; this.style.color='var(--electric)'"
                   onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-soft)'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    معاينة وطباعة
                </a>

                <a href="<?php echo e(route('admin.orders.invoice.download', $order->id)); ?>"
                   class="btn btn-sm gap-2 font-bold"
                   style="background:var(--electric); color:#070810; border:none;"
                   onmouseover="this.style.opacity='0.9'"
                   onmouseout="this.style.opacity='1'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    تحميل PDF
                </a>

                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-ghost btn-sm gap-2">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    رجوع
                </a>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:var(--electric-dim);color:var(--electric);">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h2 class="font-black text-sm" style="color:var(--text);">
                            المنتجات (<?php echo e($order->items->sum('quantity')); ?> عنصر)
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table w-full text-sm">
                            <thead>
                            <tr style="background:var(--surface2);color:var(--text-soft);">
                                <th class="font-black text-right py-3 px-5">المنتج</th>
                                <th class="font-black text-right py-3 px-5">السعر</th>
                                <th class="font-black text-right py-3 px-5">الكمية</th>
                                <th class="font-black text-right py-3 px-5">الإجمالي</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom:1px solid var(--border);">
                                    <td class="py-4 px-5">
                                        <div class="flex items-center gap-3">
                                            <?php if($item->product?->image_url): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->product->image_url)); ?>"
                                                     alt="<?php echo e($item->product->name); ?>"
                                                     class="w-12 h-12 object-cover rounded-xl flex-shrink-0"
                                                     style="border:1px solid var(--border);">
                                            <?php else: ?>
                                                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                                                     style="background:var(--surface2);border:1px solid var(--border);">
                                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--border-hover);">
                                                        <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-bold text-xs" style="color:var(--text);">
                                                    <?php echo e($item->product?->name ?? 'منتج محذوف'); ?>

                                                </p>
                                                <?php if($item->product?->category): ?>
                                                    <p class="text-[11px]" style="color:var(--text-muted);">
                                                        <?php echo e($item->product->category->name); ?>

                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-5">
                                    <span class="text-xs font-bold" style="color:var(--text-soft);">
                                        <?php echo e(number_format($item->price, 2)); ?> ج.م
                                    </span>
                                    </td>
                                    <td class="py-4 px-5">
                                        <span class="badge badge-ghost badge-sm font-bold"><?php echo e($item->quantity); ?></span>
                                    </td>
                                    <td class="py-4 px-5">
                                    <span class="font-black text-sm" style="color:var(--electric);">
                                        <?php echo e(number_format($item->price * $item->quantity, 2)); ?> ج.م
                                    </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid var(--border);background:var(--surface2);">
                        <span class="font-black text-sm" style="color:var(--text-soft);">إجمالي الطلب</span>
                        <span class="font-black text-xl" style="color:var(--electric);">
                        <?php echo e(number_format($order->total, 2)); ?> ج.م
                    </span>
                    </div>
                </div>

                
                <?php if($order->notes): ?>
                    <div class="rounded-2xl p-5" style="background:var(--surface);border:1px solid var(--border);">
                        <div class="flex items-center gap-2 mb-3">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--electric);">
                                <path stroke-linecap="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <h3 class="font-black text-sm" style="color:var(--text);">ملاحظات العميل</h3>
                        </div>
                        <p class="text-sm leading-relaxed" style="color:var(--text-soft);"><?php echo e($order->notes); ?></p>
                    </div>
                <?php endif; ?>

            </div>

            
            <div class="space-y-5">

                
                <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                    <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                        <h3 class="font-black text-sm" style="color:var(--text);">معلومات الطلب</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color:var(--text-muted);">رقم الطلب</span>
                            <span class="font-mono text-xs font-bold" style="color:var(--text);">
                            #<?php echo e(substr($order->id, 0, 8)); ?>

                        </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color:var(--text-muted);">تاريخ الطلب</span>
                            <span class="text-xs font-bold" style="color:var(--text);">
                            <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                        </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color:var(--text-muted);">آخر تحديث</span>
                            <span class="text-xs font-bold" style="color:var(--text);">
                            <?php echo e($order->updated_at->diffForHumans()); ?>

                        </span>
                        </div>
                        <div class="flex items-center justify-between pt-2" style="border-top:1px solid var(--border);">
                            <span class="text-xs" style="color:var(--text-muted);">الحالة الحالية</span>
                            <span class="badge badge-<?php echo e($order->status_color); ?> badge-sm font-bold">
                            <?php echo e($order->status_label); ?>

                        </span>
                        </div>
                    </div>
                </div>

                
                <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                    <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                        <h3 class="font-black text-sm" style="color:var(--text);">تغيير الحالة</h3>
                    </div>
                    <div class="p-5">
                        <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST" class="space-y-3">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>

                            <?php
                                $statuses = [
                                    'pending'    => 'قيد الانتظار',
                                    'processing' => 'قيد التجهيز',
                                    'shipped'    => 'تم الشحن',
                                    'delivered'  => 'تم التسليم',
                                    'cancelled'  => 'ملغي',
                                ];
                            ?>

                            <div class="space-y-2">
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-150"
                                           style="background:<?php echo e($order->status === $key ? 'var(--electric-dim)' : 'var(--surface2)'); ?>;
                                          border:1px solid <?php echo e($order->status === $key ? 'rgba(245,158,11,.3)' : 'var(--border)'); ?>;">
                                        <input type="radio" name="status" value="<?php echo e($key); ?>"
                                               class="radio radio-sm"
                                               style="--chkbg:var(--electric);"
                                            <?php echo e($order->status === $key ? 'checked' : ''); ?>>
                                        <span class="text-sm font-bold" style="color:<?php echo e($order->status === $key ? 'var(--electric)' : 'var(--text-soft)'); ?>;">
                                    <?php echo e($label); ?>

                                </span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <button type="submit"
                                    class="btn btn-sm w-full font-black mt-2"
                                    style="background:var(--electric);color:#070810;border:none;">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                حفظ الحالة
                            </button>
                        </form>
                    </div>
                </div>

                
                <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                    <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                        <h3 class="font-black text-sm" style="color:var(--text);">بيانات العميل</h3>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-3 mb-4">
                            
                            <div class="w-11 h-11 rounded-full flex items-center justify-center font-black text-base flex-shrink-0"
                                 style="background:var(--electric-dim);color:var(--electric);border:1px solid rgba(245,158,11,.25);">
                                <?php echo e(strtoupper(substr($order->user?->name ?? 'G', 0, 1))); ?>

                            </div>
                            <div>
                                
                                <p class="font-black text-sm" style="color:var(--text);">
                                    <?php echo e($order->user?->name ?? 'عميل محذوف/زائر'); ?>

                                </p>
                                
                                <p class="text-xs" style="color:var(--text-muted);">
                                    <?php echo e($order->user?->email ?? 'N/A'); ?>

                                </p>
                            </div>

                        </div>

                        <div class="space-y-2 pt-3" style="border-top:1px solid var(--border);">
                            <div class="flex items-center justify-between">
                                <span class="text-xs" style="color:var(--text-muted);">إجمالي طلباته</span>
                                <span class="text-xs font-black" style="color:var(--text);">
                                <?php echo e($order->user ? $order->user->orders()->count() : 0); ?> طلب
                            </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs" style="color:var(--text-muted);">عضو منذ</span>
                                <span class="text-xs font-bold" style="color:var(--text);">
<?php echo e($order->user ? $order->user->created_at->format('d/m/Y') : 'غير متوفر'); ?>                            </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <style>
        @media print {
            .main-navbar, .main-footer, .btn, form, a[href] { display: none !important; }
            body { background: white !important; color: black !important; }
            .page-container { padding: 0 !important; }
            * { border-color: #ddd !important; color: black !important; background: white !important; }
            .font-black { color: black !important; }
        }
    </style>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>