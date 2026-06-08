<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'تم تأكيد الطلب']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'تم تأكيد الطلب']); ?>

    <style>
        .success-page {
            max-width: 620px;
            margin: 4rem auto;
            padding: 0 1rem;
            text-align: center;
            font-family: 'Cairo', sans-serif;
        }

        .success-ring {
            width: 80px; height: 80px;
            border-radius: 50%;
            border: 2px solid #4caf7d;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
        }

        /* ✅ h1 — واضح على dark وlight */
        .success-page h1 {
            font-size: 26px; font-weight: 700;
            color: var(--text, var(--text-color, #f0ede8));
            margin-bottom: 10px;
        }
        [data-theme="light"] .success-page h1 { color: #111; }

        .success-page .sub {
            font-size: 14px;
            color: var(--text-soft, var(--text-muted, #888));
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .success-order-num {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface, var(--card-bg, #1a1a1a));
            border: 1px solid var(--border, var(--border-color, #2e2e2e));
            border-radius: 8px;
            padding: 8px 22px;
            font-size: 14px; font-weight: 700;
            color: var(--electric, var(--accent-color, #c9a96e));
            margin-bottom: 2rem;
            letter-spacing: .05em;
            font-family: 'Inter', monospace;
        }

        /* ── Summary Card ── */
        .success-summary {
            background: var(--surface, var(--card-bg, #1a1a1a));
            border: 1px solid var(--border, var(--border-color, #2e2e2e));
            border-radius: 12px;
            padding: 1.5rem;
            text-align: right;
            margin-bottom: 1.5rem;
        }
        .success-summary h2 {
            font-size: 13px; font-weight: 600;
            color: var(--text-soft, var(--text-muted, #888));
            margin-bottom: 1rem;
            padding-bottom: .75rem;
            border-bottom: 1px solid var(--border, var(--border-color, #2e2e2e));
            text-align: right;
        }

        /* ── Items ── */
        .s-items { margin-bottom: 1rem; }
        .s-item {
            display: flex; justify-content: space-between;
            align-items: flex-start;
            font-size: 13px; padding: 8px 0;
            border-bottom: 1px solid var(--border, var(--border-color, #2e2e2e));
        }
        .s-item:last-child { border-bottom: none; }

        /* ✅ item name واضح */
        .s-item-name {
            color: var(--text, var(--text-color, #f0ede8));
            font-weight: 600;
        }
        [data-theme="light"] .s-item-name { color: #1a1a1a; }

        .s-item-qty  { font-size: 11px; color: var(--text-soft, var(--text-muted, #888)); margin-top: 2px; }
        .s-item-price {
            color: var(--electric, var(--accent-color, #c9a96e));
            font-weight: 700; white-space: nowrap; margin-right: 8px;
            font-family: 'Inter', sans-serif;
        }

        /* ── Total rows ── */
        .s-trow {
            display: flex; justify-content: space-between;
            font-size: 13px; padding: 4px 0;
            color: var(--text-soft, var(--text-muted, #888));
        }
        /* ✅ القيم واضحة */
        .s-trow span:last-child {
            color: var(--text, var(--text-color, #f0ede8));
            font-family: 'Inter', sans-serif;
        }
        [data-theme="light"] .s-trow span:last-child { color: #1a1a1a; }
        .s-trow .green { color: #4caf7d !important; }

        .s-trow.final {
            font-size: 15px; font-weight: 700;
            color: var(--text, var(--text-color, #f0ede8));
            padding-top: 10px; margin-top: 6px;
            border-top: 1px solid var(--border, var(--border-color, #2e2e2e));
        }
        .s-trow.final span:last-child {
            color: var(--electric, var(--accent-color, #c9a96e)) !important;
        }

        /* ── Meta rows (address / payment) ── */
        .s-meta {
            margin-top: 1rem; padding-top: 1rem;
            border-top: 1px solid var(--border, var(--border-color, #2e2e2e));
        }
        .s-meta-row {
            display: flex; justify-content: space-between;
            align-items: center;
            font-size: 12px; padding: 6px 0;
            color: var(--text-soft, var(--text-muted, #888));
        }
        /* ✅ قيم الـ meta واضحة */
        .s-meta-row span:last-child {
            color: var(--text, var(--text-color, #f0ede8));
            text-align: left;
            max-width: 65%;
        }
        [data-theme="light"] .s-meta-row span:last-child { color: #222; }

        /* ── Action Buttons ── */
        .success-actions {
            display: flex; gap: 10px;
            justify-content: center; flex-wrap: wrap;
        }
        .s-btn-primary {
            padding: 12px 28px;
            background: var(--electric, var(--accent-color, #c9a96e));
            border: none; border-radius: 8px;
            font-size: 14px; font-weight: 700; color: #0f0f0f;
            cursor: pointer; font-family: 'Cairo', sans-serif;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 6px;
            transition: opacity .2s;
        }
        .s-btn-primary:hover { opacity: .88; }

        .s-btn-outline {
            padding: 12px 28px;
            background: transparent;
            border: 1px solid var(--border, var(--border-color, #2e2e2e));
            border-radius: 8px; font-size: 14px;
            color: var(--text-soft, var(--text-muted, #888));
            cursor: pointer; font-family: 'Cairo', sans-serif;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 6px;
            transition: all .2s;
        }
        .s-btn-outline:hover {
            border-color: var(--text-soft, #888);
            color: var(--text, var(--text-color, #f0ede8));
        }
    </style>

    <div class="success-page">

        
        <div class="success-ring">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                <path d="M6 18l8 8 16-16" stroke="#4caf7d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1>تم تأكيد طلبك!</h1>
        <p class="sub">
            شكراً يا <?php echo e(optional($order->address)->first_name ?? 'عميلنا العزيز'); ?> على ثقتك في متجرنا<br/>
            هيوصلك طلبك في أقرب وقت ممكن على عنوانك المحدد
        </p>

        <div class="success-order-num">
            <i class="fa fa-hashtag" style="margin-left:4px; font-size:12px;"></i>
            <?php echo e($order->order_number); ?>

        </div>

        
        <div class="success-summary">
            <h2>
                <i class="fa fa-receipt" style="margin-left:6px;"></i>
                تفاصيل الطلب
            </h2>

            <div class="s-items">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="s-item">
                        <div>
                            <div class="s-item-name"><?php echo e($item->name); ?></div>
                            <div class="s-item-qty">الكمية: <?php echo e($item->quantity); ?></div>
                        </div>
                        <div class="s-item-price">
                            <?php echo e(number_format($item->price * $item->quantity, 0)); ?> ج.م
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="s-trow">
                <span>المجموع الفرعي</span>
                <span><?php echo e(number_format($order->subtotal, 0)); ?> ج.م</span>
            </div>
            <div class="s-trow">
                <span>الشحن</span>
                <span class="<?php echo e($order->shipping == 0 ? 'green' : ''); ?>">
                    <?php echo e($order->shipping == 0 ? 'مجاني' : number_format($order->shipping, 0) . ' ج.م'); ?>

                </span>
            </div>
            <div class="s-trow">
                <span>ضريبة القيمة المضافة <?php echo e(number_format(($order->subtotal > 0 ? ($order->tax / $order->subtotal) * 100 : 0), 0)); ?>%</span>
                <span><?php echo e(number_format($order->tax, 0)); ?> ج.م</span>
            </div>
            <div class="s-trow final">
                <span>الإجمالي</span>
                <span><?php echo e(number_format($order->total, 0)); ?> ج.م</span>
            </div>

            <div class="s-meta">
                <div class="s-meta-row" style="align-items: flex-start;">
                    <span><i class="fa fa-location-dot" style="margin-left:5px;"></i>عنوان التوصيل</span>
                    <span>
                        <?php if($order->address): ?>
                            <?php echo e($order->address->street_address); ?><?php if($order->address->building_number): ?>، مبنى <?php echo e($order->address->building_number); ?><?php endif; ?>
                            ، <?php echo e($order->address->city); ?>، <?php echo e($order->address->governorate); ?>

                        <?php else: ?>
                            تفاصيل العنوان غير متوفرة
                        <?php endif; ?>
                    </span>
                </div>
                <div class="s-meta-row">
                    <span><i class="fa fa-credit-card" style="margin-left:5px;"></i>طريقة الدفع</span>
                    <span>
                        <?php echo e(match($order->payment_method) {
                            'card'     => 'بطاقة بنكية',
                            'vodafone' => 'فودافون كاش',
                            'instapay' => 'إنستاباي',
                            'cod'      => 'الدفع عند الاستلام',
                            default    => $order->payment_method
                        }); ?>

                    </span>
                </div>
            </div>
        </div>

        
        <div class="success-actions">
            <a href="<?php echo e(route('products.index')); ?>" class="s-btn-primary">
                <i class="fa fa-store"></i>
                متابعة التسوق
            </a>
            <a href="<?php echo e(route('profile.index')); ?>" class="s-btn-outline">
                <i class="fa fa-box"></i>
                طلباتي
            </a>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/checkout/success.blade.php ENDPATH**/ ?>