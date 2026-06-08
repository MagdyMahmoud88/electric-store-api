<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'طلباتي']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'طلباتي']); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root { --accent: #c9a96e; }
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 99px;
    font-size: 11px; font-weight: 600; font-family: 'Cairo', sans-serif;
}
.status-pending   { background: rgba(245,158,11,.12); color: #f59e0b; }
.status-paid      { background: rgba(16,185,129,.12);  color: #10b981; }
.status-failed    { background: rgba(239,68,68,.12);   color: #ef4444; }
.status-cancelled { background: rgba(156,163,175,.12); color: #9ca3af; }
.status-processing{ background: rgba(99,102,241,.12);  color: #6366f1; }
.status-shipped   { background: rgba(59,130,246,.12);  color: #3b82f6; }
.status-delivered { background: rgba(16,185,129,.12);  color: #10b981; }
</style>
<?php $__env->stopPush(); ?>

<div class="bg-base-200 min-h-screen py-8 px-4" dir="rtl" style="font-family:'Cairo',sans-serif;">
<div class="max-w-4xl mx-auto">

  
  <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
      <h1 class="text-2xl font-bold">طلباتي</h1>
      <p class="text-sm text-base-content/50 mt-1">جميع طلباتك السابقة</p>
    </div>
    <a href="<?php echo e(route('products.index')); ?>"
      class="btn btn-sm border border-base-300 bg-transparent gap-2 font-normal"
      style="font-family:'Cairo',sans-serif;">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
      </svg>
      تسوق الآن
    </a>
  </div>

  <?php if($orders->isEmpty()): ?>
    
    <div class="card bg-base-100 border border-base-300 shadow-none">
      <div class="card-body items-center text-center py-16">
        <div class="opacity-10 mb-4">
          <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
            <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        </div>
        <p class="text-sm font-bold tracking-widest text-base-content/40 uppercase mb-4">لا توجد طلبات بعد</p>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-sm gap-2"
          style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;font-family:'Cairo',sans-serif;">
          ابدأ التسوق
        </a>
      </div>
    </div>

  <?php else: ?>

    
    <div class="flex flex-col gap-3">
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card bg-base-100 border border-base-300 shadow-none hover:border-base-content/20 transition-colors">
        <div class="card-body p-4">
          <div class="flex items-start justify-between gap-3 flex-wrap">

            
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2 flex-wrap">
                <span class="font-bold text-sm"><?php echo e($order->order_number); ?></span>
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

              <div class="flex items-center gap-4 text-xs text-base-content/50 flex-wrap">
                <span class="flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <?php echo e($order->created_at->format('d M Y')); ?>

                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                  </svg>
                  <?php echo e($order->items->count() ?? $order->items()->count()); ?> منتجات
                </span>
                <span class="flex items-center gap-1">
                  <?php if($order->payment_method === 'card'): ?>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 9h20"/></svg>
                    بطاقة بنكية
                  <?php elseif($order->payment_method === 'vodafone'): ?>
                    فودافون كاش
                  <?php else: ?>
                    <?php echo e($order->payment_method); ?>

                  <?php endif; ?>
                </span>
              </div>
            </div>

            
            <div class="flex flex-col items-end gap-2">
              <span class="text-lg font-bold" style="color:var(--accent)">
                <?php echo e(number_format($order->total, 2)); ?>

                <span class="text-xs font-normal text-base-content/40">ج.م</span>
              </span>
              <a href="<?php echo e(route('orders.show', $order)); ?>"
                class="btn btn-xs border border-base-300 bg-transparent gap-1 font-normal"
                style="font-family:'Cairo',sans-serif;">
                تفاصيل الطلب
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                </svg>
              </a>
            </div>

          </div>

          
          <?php if($order->relationLoaded('items') && $order->items->count() > 0): ?>
          <div class="flex gap-2 mt-3 pt-3 border-t border-base-300 overflow-x-auto">
            <?php $__currentLoopData = $order->items->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex-shrink-0 flex items-center gap-2">
              <div class="w-8 h-8 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center overflow-hidden">
                <?php if($item->product && $item->product->image_url): ?>
                  <img src="<?php echo e(asset('storage/' . $item->product->image_url)); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                  <svg class="w-4 h-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="#c9a96e" stroke-width="1.3">
                    <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($order->items->count() > 4): ?>
              <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center text-xs text-base-content/50 font-bold">
                +<?php echo e($order->items->count() - 4); ?>

              </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php if($orders->hasPages()): ?>
    <div class="mt-6 flex justify-center">
      <?php echo e($orders->links()); ?>

    </div>
    <?php endif; ?>

  <?php endif; ?>

  <div class="text-center mt-6">
    <a href="<?php echo e(route('profile.index')); ?>" class="text-xs text-base-content/40 hover:text-base-content/70 transition-colors">
      ← العودة للملف الشخصي
    </a>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/user/orders/index.blade.php ENDPATH**/ ?>