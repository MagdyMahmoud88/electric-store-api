<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'تفاصيل الطلب']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'تفاصيل الطلب']); ?>

    <?php $__env->startPush('styles'); ?>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            :root { --accent: #c9a96e; }
            .status-badge {
                display: inline-flex; align-items: center; gap: 5px;
                padding: 4px 12px; border-radius: 99px;
                font-size: 12px; font-weight: 600; font-family: 'Cairo', sans-serif;
            }
            .status-pending   { background: rgba(245,158,11,.12); color: #f59e0b; }
            .status-paid      { background: rgba(16,185,129,.12);  color: #10b981; }
            .status-failed    { background: rgba(239,68,68,.12);   color: #ef4444; }
            .status-cancelled { background: rgba(156,163,175,.12); color: #9ca3af; }
            .status-processing{ background: rgba(99,102,241,.12);  color: #6366f1; }
            .status-shipped   { background: rgba(59,130,246,.12);  color: #3b82f6; }
            .status-delivered { background: rgba(16,185,129,.12);  color: #10b981; }
            .co-grid { grid-template-columns: 1fr; }
            @media (min-width: 768px) { .co-grid { grid-template-columns: 1fr 280px; } }
        </style>
    <?php $__env->stopPush(); ?>

    <div class="bg-base-200 min-h-screen py-8 px-4" dir="rtl" style="font-family:'Cairo',sans-serif;">
        <div class="max-w-4xl mx-auto">

            
            <div class="flex items-center gap-2 text-xs text-base-content/40 mb-6">
                <a href="<?php echo e(route('profile.index')); ?>" class="hover:text-base-content/70 transition-colors">الملف الشخصي</a>
                <span>/</span>
                <a href="<?php echo e(route('orders.index')); ?>" class="hover:text-base-content/70 transition-colors">طلباتي</a>
                <span>/</span>
                <span class="text-base-content/70"><?php echo e($order->order_number); ?></span>
            </div>

            
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl font-bold"><?php echo e($order->order_number); ?></h1>
                        <?php
                            $statusMap = [
                              'pending'    => ['label' => 'في الانتظار',  'class' => 'status-pending'],
                              'paid'       => ['label' => 'تم الدفع',     'class' => 'status-paid'],
                              'processing' => ['label' => 'قيد التجهيز',  'class' => 'status-processing'],
                              'shipped'    => ['label' => 'تم الشحن',     'class' => 'status-shipped'],
                              'delivered'  => ['label' => 'تم التوصيل',   'class' => 'status-delivered'],
                              'cancelled'  => ['label' => 'ملغي',         'class' => 'status-cancelled'],
                              'failed'     => ['label' => 'فشل',          'class' => 'status-failed'],
                            ];
                            $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'status-pending'];
                        ?>
                        <span class="status-badge <?php echo e($s['class']); ?>">
          <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
          <?php echo e($s['label']); ?>

        </span>
                    </div>
                    <p class="text-xs text-base-content/50 mt-1">
                        <?php echo e($order->created_at->format('d F Y — H:i')); ?>

                    </p>
                </div>
                <a href="<?php echo e(route('orders.index')); ?>"
                   class="btn btn-sm border border-base-300 bg-transparent gap-2 font-normal"
                   style="font-family:'Cairo',sans-serif;">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
                    </svg>
                    كل الطلبات
                </a>
            </div>

            <div class="grid co-grid gap-4 items-start">

                
                <div class="flex flex-col gap-4">

                    
                    <div class="card bg-base-100 border border-base-300 shadow-none">
                        <div class="p-4 border-b border-base-300">
                            <p class="font-bold text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                المنتجات (<?php echo e($order->items->count()); ?>)
                            </p>
                        </div>
                        <div class="divide-y divide-base-300">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-4 flex items-center gap-3">
                                    
                                    <div class="w-14 h-14 rounded-xl bg-base-200 border border-base-300 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        <?php if($item->product && $item->product->image_url): ?>
                                            <img src="<?php echo e(asset('storage/' . $item->product->image_url)); ?>"
                                                 alt="<?php echo e($item->name); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <svg class="w-6 h-6 opacity-30" fill="none" viewBox="0 0 24 24" stroke="#c9a96e" stroke-width="1.3">
                                                <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-sm truncate"><?php echo e($item->name); ?></p>
                                        <?php if(!empty($item->options) && $item->options !== '[]'): ?>
                                            <?php $opts = is_array($item->options) ? $item->options : json_decode($item->options, true); ?>
                                            <?php if(!empty($opts)): ?>
                                                <p class="text-xs text-base-content/50 mt-0.5"><?php echo e(implode(' · ', $opts)); ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <p class="text-xs text-base-content/50 mt-1">
                                            <?php echo e(number_format($item->price, 2)); ?> ج.م × <?php echo e($item->quantity); ?>

                                        </p>

                                        
                                        <?php if($order->status === 'delivered'): ?>
                                            <?php
                                                $hasReturn = \App\Models\ReturnRequest::where('order_item_id', $item->id)
                                                    ->whereIn('status', ['pending', 'approved'])
                                                    ->exists();
                                            ?>

                                            <?php if($hasReturn): ?>
                                                <span class="inline-flex items-center gap-1 mt-2 text-[11px] font-bold
                               bg-warning/10 text-warning border border-warning/20
                               px-2 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-warning"></span>
                    طلب إرجاع مقدّم
                  </span>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('returns.create', [$order, $item])); ?>"
                                                   class="inline-flex items-center gap-1.5 mt-2 text-[11px] font-bold
                            text-base-content/50 hover:text-warning border border-base-300
                            hover:border-warning/40 px-2.5 py-1 rounded-full transition-all duration-200">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                                                    </svg>
                                                    إرجاع / ضمان
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>

                                    
                                    <div class="text-right flex-shrink-0">
                                        <p class="font-bold text-sm" style="color:var(--accent)">
                                            <?php echo e(number_format($item->subtotal, 2)); ?> ج.م
                                        </p>
                                        <p class="text-xs text-base-content/40"><?php echo e($item->quantity); ?> قطعة</p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="card bg-base-100 border border-base-300 shadow-none">
                        <div class="p-4 border-b border-base-300">
                            <p class="font-bold text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                بيانات التوصيل
                            </p>
                        </div>

                        <?php if($order->shippingAddress): ?>
                            <?php $addr = $order->shippingAddress; ?>
                            <div class="p-4 grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-base-content/40 mb-1">الاسم</p>
                                    <p class="text-sm font-medium"><?php echo e($addr->first_name); ?> <?php echo e($addr->last_name); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-base-content/40 mb-1">الهاتف</p>
                                    <p class="text-sm font-medium"><?php echo e($addr->phone); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-base-content/40 mb-1">البريد</p>
                                    <p class="text-sm font-medium"><?php echo e($addr->email); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-base-content/40 mb-1">المحافظة</p>
                                    <p class="text-sm font-medium"><?php echo e($addr->governorate); ?></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs text-base-content/40 mb-1">العنوان</p>
                                    <p class="text-sm font-medium">
                                        <?php echo e($addr->street_address); ?>

                                        <?php if($addr->city): ?>، <?php echo e($addr->city); ?><?php endif; ?>
                                        <?php if($addr->area): ?>، <?php echo e($addr->area); ?><?php endif; ?>
                                        <?php if($addr->building_number): ?>، مبنى <?php echo e($addr->building_number); ?><?php endif; ?>
                                        <?php if($addr->floor): ?>، دور <?php echo e($addr->floor); ?><?php endif; ?>
                                        <?php if($addr->apartment): ?>، شقة <?php echo e($addr->apartment); ?><?php endif; ?>
                                    </p>
                                </div>
                                <?php if($addr->landmark): ?>
                                    <div class="col-span-2">
                                        <p class="text-xs text-base-content/40 mb-1">علامة مميزة</p>
                                        <p class="text-sm font-medium"><?php echo e($addr->landmark); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-4">
                                <p class="text-sm text-base-content/40">لا تتوفر بيانات توصيل</p>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

                
                <div class="lg:sticky lg:top-24">
                    <div class="card bg-base-100 border border-base-300 shadow-none overflow-hidden">

                        <div class="p-4 border-b border-base-300">
                            <p class="font-bold text-sm">ملخص الطلب</p>
                        </div>

                        <div class="p-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-base-content/50">المجموع الفرعي</span>
                                <span><?php echo e(number_format($order->subtotal, 2)); ?> ج.م</span>
                            </div>
                            <?php if($order->discount > 0): ?>
                                <div class="flex justify-between text-sm">
                                    <span class="text-base-content/50">الخصم</span>
                                    <span style="color:#4caf7d">— <?php echo e(number_format($order->discount, 2)); ?> ج.م</span>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between text-sm">
                                <span class="text-base-content/50">الشحن</span>
                                <span class="<?php echo e($order->shipping == 0 ? 'text-success' : ''); ?>">
              <?php echo e($order->shipping == 0 ? 'مجاني' : number_format($order->shipping, 2) . ' ج.م'); ?>

            </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-base-content/50">ضريبة 14%</span>
                                <span><?php echo e(number_format($order->tax, 2)); ?> ج.م</span>
                            </div>
                            <div class="divider my-1"></div>
                            <div class="flex justify-between items-baseline">
                                <span class="font-bold text-sm">الإجمالي</span>
                                <span class="text-xl font-bold" style="color:var(--accent)">
              <?php echo e(number_format($order->total, 2)); ?>

              <span class="text-xs font-normal text-base-content/40">ج.م</span>
            </span>
                            </div>
                        </div>

                        
                        <div class="p-4 border-t border-base-300">
                            <p class="text-xs text-base-content/40 mb-2">طريقة الدفع</p>
                            <div class="flex items-center gap-2">
                                <?php if($order->payment_method === 'card'): ?>
                                    <svg class="w-4 h-4 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 9h20"/></svg>
                                    <span class="text-sm">بطاقة بنكية</span>
                                <?php elseif($order->payment_method === 'vodafone'): ?>
                                    <span class="text-sm">فودافون كاش</span>
                                <?php elseif($order->payment_method === 'instapay'): ?>
                                    <span class="text-sm">إنستاباي</span>
                                <?php else: ?>
                                    <span class="text-sm"><?php echo e($order->payment_method); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="p-4 border-t border-base-300 space-y-2">
                            <?php if(in_array($order->status, ['pending', 'paid', 'processing'])): ?>
                                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-sm w-full gap-2"
                                   style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;font-family:'Cairo',sans-serif;">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    تسوق مجدداً
                                </a>
                            <?php endif; ?>
                            <?php if($order->status === 'delivered'): ?>
                                <a href="<?php echo e(route('products.show', $order->items->first()->product_id ?? 1)); ?>"
                                   class="btn btn-sm w-full btn-ghost border border-base-300 gap-2 font-normal"
                                   style="font-family:'Cairo',sans-serif;">
                                    تقييم المنتجات
                                </a>
                                
                                <a href="<?php echo e(route('returns.index')); ?>"
                                   class="btn btn-sm w-full btn-ghost border border-base-300 gap-2 font-normal"
                                   style="font-family:'Cairo',sans-serif;">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                                    </svg>
                                    طلبات الإرجاع
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/user/orders/show.blade.php ENDPATH**/ ?>