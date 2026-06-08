
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

    
    <div class="admin-bar sticky top-[64px] z-40 w-full">
        <div class="page-container">
            <div class="admin-bar__inner">

                <div class="admin-bar__brand">
                    <div class="admin-bar__icon">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                    </div>
                    <span class="admin-bar__title">لوحة التحكم</span>
                </div>

                <nav class="admin-bar__nav">
                    <?php
                        $navItems = [
                            ['route' => 'admin.brands.index',    'label' => 'الماركات',  'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 014-4z'],
                            ['route' => 'admin.products.index',  'label' => 'المنتجات',  'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['route' => 'admin.categories.index','label' => 'الأقسام',   'icon' => 'M4 6h16M4 12h16M4 18h7'],
                            ['route' => 'admin.reports.index',   'label' => 'التقارير',  'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['route' => 'admin.reviews.index',   'label' => 'التقييمات', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                            ['route' => 'admin.coupons.index',   'label' => 'الكوبونات', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 014-4z'],
                            ['route' => 'admin.users.index',     'label' => 'المستخدمين','icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ];
                    ?>

                    <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                           class="admin-nav-link <?php echo e(request()->routeIs($item['route']) ? 'admin-nav-link--active' : ''); ?>">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="<?php echo e($item['icon']); ?>"/>
                            </svg>
                            <?php echo e($item['label']); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <a href="<?php echo e(route('admin.orders.index')); ?>"
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'admin-nav-link--active' : ''); ?>">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        الطلبات
                        <?php if($pendingOrders > 0): ?>
                            <span class="admin-nav-link__badge"><?php echo e($pendingOrders); ?></span>
                        <?php endif; ?>
                    </a>

                    
                    <?php $pendingReturnsCount = \App\Models\ReturnRequest::where('status','pending')->count(); ?>
                    <a href="<?php echo e(route('admin.returns.index')); ?>"
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.returns.*') ? 'admin-nav-link--active' : ''); ?>">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                        </svg>
                        الإرجاع
                        <?php if($pendingReturnsCount > 0): ?>
                            <span class="admin-nav-link__badge"><?php echo e($pendingReturnsCount); ?></span>
                        <?php endif; ?>
                    </a>

                    <a href="<?php echo e(route('admin.products.create')); ?>" class="admin-nav-link admin-nav-link--cta">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        إضافة منتج
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div class="page-container py-8">

        
        <?php if(session('success')): ?>
            <div role="alert" class="alert alert-success mb-5 text-sm font-bold">
                <svg class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div role="alert" class="alert alert-error mb-5 text-sm font-bold">
                <svg class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <?php if($pendingOrders > 0): ?>
            <a href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>" class="pending-alert">
                <span class="pending-alert__dot"></span>
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span><strong><?php echo e($pendingOrders); ?> <?php echo e($pendingOrders === 1 ? 'طلب معلق' : 'طلبات معلقة'); ?></strong> تحتاج مراجعة الآن</span>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="pending-alert__arrow">
                    <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        <?php endif; ?>

        <?php if($pendingReturnsCount > 0): ?>
            <a href="<?php echo e(route('admin.returns.index', ['status' => 'pending'])); ?>" class="pending-alert pending-alert--returns">
                <span class="pending-alert__dot pending-alert__dot--returns"></span>
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                </svg>
                <span><strong><?php echo e($pendingReturnsCount); ?> <?php echo e($pendingReturnsCount === 1 ? 'طلب إرجاع' : 'طلبات إرجاع'); ?></strong> تحتاج مراجعة</span>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="pending-alert__arrow">
                    <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        <?php endif; ?>

        
        <div class="stats-grid" style="margin-bottom:12px;">
            <div class="stat-card" style="border-color:rgba(245,158,11,.3);">
                <div class="stat-card__icon stat-card__icon--electric">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val" style="font-size:16px;"><?php echo e(number_format($revenueToday, 0)); ?> ج.م</p>
                    <p class="stat-card__label">إيرادات اليوم</p>
                </div>
            </div>

            <div class="stat-card" style="border-color:rgba(34,197,94,.3);">
                <div class="stat-card__icon stat-card__icon--green">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val" style="font-size:16px;"><?php echo e(number_format($revenueThisMonth, 0)); ?> ج.م</p>
                    <p class="stat-card__label">إيرادات الشهر</p>
                </div>
            </div>

            <div class="stat-card" style="border-color:rgba(59,130,246,.3);">
                <div class="stat-card__icon stat-card__icon--blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val" style="font-size:16px;"><?php echo e(number_format($revenueTotal, 0)); ?> ج.م</p>
                    <p class="stat-card__label">إجمالي الإيرادات</p>
                </div>
            </div>
        </div>

        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--electric">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($totalProducts); ?></p>
                    <p class="stat-card__label">المنتجات</p>
                </div>
            </div>

            <a href="<?php echo e(route('admin.orders.index')); ?>" class="stat-card stat-card--link">
                <div class="stat-card__icon stat-card__icon--green">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($totalOrders); ?></p>
                    <p class="stat-card__label">إجمالي الطلبات</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.users.index')); ?>" class="stat-card stat-card--link">
                <div class="stat-card__icon stat-card__icon--blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($totalUsers); ?></p>
                    <p class="stat-card__label">المستخدمين</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.users.index', ['sort' => 'latest'])); ?>" class="stat-card stat-card--link">
                <div class="stat-card__icon stat-card__icon--teal">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($newUsersToday); ?></p>
                    <p class="stat-card__label">مستخدمين اليوم</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.brands.index')); ?>" class="stat-card stat-card--link">
                <div class="stat-card__icon stat-card__icon--purple">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($totalBrands); ?></p>
                    <p class="stat-card__label">الماركات</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.categories.index')); ?>" class="stat-card stat-card--link">
                <div class="stat-card__icon stat-card__icon--blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($totalCategories); ?></p>
                    <p class="stat-card__label">الأقسام</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="stat-card stat-card--link">
                <div class="stat-card__icon stat-card__icon--teal">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M3 7l9-4 9 4v4a9 9 0 01-9 8 9 9 0 01-9-8V7z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($totalCoupons); ?></p>
                    <p class="stat-card__label">الكوبونات</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.reviews.index')); ?>" class="stat-card stat-card--link <?php echo e($pendingReviews > 0 ? 'stat-card--warn' : ''); ?>">
                <div class="stat-card__icon stat-card__icon--amber">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val <?php echo e($pendingReviews > 0 ? 'text-amber-500' : ''); ?>"><?php echo e($pendingReviews); ?></p>
                    <p class="stat-card__label">تقييمات انتظار</p>
                </div>
            </a>

            <a href="<?php echo e(route('admin.returns.index')); ?>" class="stat-card stat-card--link <?php echo e($pendingReturnsCount > 0 ? 'stat-card--warn' : ''); ?>">
                <div class="stat-card__icon stat-card__icon--orange">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val <?php echo e($pendingReturnsCount > 0 ? 'text-orange-400' : ''); ?>"><?php echo e($pendingReturnsCount); ?></p>
                    <p class="stat-card__label">طلبات إرجاع</p>
                </div>
            </a>

            <div class="stat-card <?php echo e($lowStock > 0 ? 'stat-card--warn' : ''); ?>">
                <div class="stat-card__icon stat-card__icon--amber">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val <?php echo e($lowStock > 0 ? 'text-amber-500' : ''); ?>"><?php echo e($lowStock); ?></p>
                    <p class="stat-card__label">مخزون منخفض</p>
                </div>
            </div>

            <div class="stat-card <?php echo e($outOfStock > 0 ? 'stat-card--danger' : ''); ?>">
                <div class="stat-card__icon stat-card__icon--red">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val <?php echo e($outOfStock > 0 ? 'text-red-500' : ''); ?>"><?php echo e($outOfStock); ?></p>
                    <p class="stat-card__label">نفذ من المخزون</p>
                </div>
            </div>
        </div>

        
        <div class="two-col-grid">

            <?php if($recentOrders->count() > 0): ?>
                <div class="dash-card">
                    <div class="dash-card__head">
                        <div>
                            <p class="dash-card__title">آخر الطلبات</p>
                            <p class="dash-card__sub">أحدث <?php echo e($recentOrders->count()); ?> طلبات</p>
                        </div>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="dash-link">
                            عرض الكل
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="order-list">
                        <?php
                            $statusMap = [
                                'pending'    => ['قيد الانتظار', 'pending'],
                                'processing' => ['قيد التجهيز',  'processing'],
                                'shipped'    => ['تم الشحن',     'shipped'],
                                'delivered'  => ['تم التسليم',   'delivered'],
                                'cancelled'  => ['ملغي',         'cancelled'],
                            ];
                        ?>
                        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php [$statusLabel, $statusKey] = $statusMap[$order->status] ?? ['—', 'default']; ?>
                            <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="order-row">
                                <div class="order-avatar">
                                    <?php echo e(strtoupper(mb_substr($order->user?->name ?? 'U', 0, 1))); ?>

                                </div>
                                <div class="order-info">
                                    <p class="order-name"><?php echo e($order->user?->name ?? 'مستخدم محذوف'); ?></p>
                                    <p class="order-meta">#<?php echo e($order->order_number); ?> · <?php echo e($order->created_at->diffForHumans()); ?></p>
                                </div>
                                <span class="order-amount"><?php echo e(number_format($order->total, 0)); ?> ج.م</span>
                                <span class="order-status order-status--<?php echo e($statusKey); ?>"><?php echo e($statusLabel); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($lowStockProducts->count() > 0): ?>
                <div class="dash-card">
                    <div class="dash-card__head">
                        <div>
                            <p class="dash-card__title">مخزون يحتاج انتباه</p>
                            <p class="dash-card__sub"><?php echo e($lowStockProducts->count()); ?> منتجات</p>
                        </div>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="dash-link">
                            إدارة المخزون
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="inventory-list">
                        <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="inventory-row">
                                <?php if (isset($component)) { $__componentOriginala58dde406db9207f2e2c58e1c4a3d690 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala58dde406db9207f2e2c58e1c4a3d690 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-image','data' => ['product' => $product,'class' => 'inventory-thumb','lazy' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'class' => 'inventory-thumb','lazy' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala58dde406db9207f2e2c58e1c4a3d690)): ?>
<?php $attributes = $__attributesOriginala58dde406db9207f2e2c58e1c4a3d690; ?>
<?php unset($__attributesOriginala58dde406db9207f2e2c58e1c4a3d690); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala58dde406db9207f2e2c58e1c4a3d690)): ?>
<?php $component = $__componentOriginala58dde406db9207f2e2c58e1c4a3d690; ?>
<?php unset($__componentOriginala58dde406db9207f2e2c58e1c4a3d690); ?>
<?php endif; ?>
                                <div class="inventory-info">
                                    <p class="inventory-name"><?php echo e($product->name); ?></p>
                                    <p class="inventory-cat"><?php echo e($product->category->name ?? '—'); ?><?php echo e($product->brand ? ' · '.$product->brand->name : ''); ?></p>
                                </div>
                                <div class="inventory-right">
                                    <span class="inventory-price"><?php echo e(number_format($product->discounted_price, 0)); ?> ج.م</span>
                                    <?php if($product->stock === 0): ?>
                                        <span class="stock-badge stock-badge--none">نفذ</span>
                                    <?php else: ?>
                                        <span class="stock-badge stock-badge--low"><?php echo e($product->stock); ?> وحدة</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        
        <div class="dash-card">
            <div class="dash-card__head">
                <div>
                    <p class="dash-card__title">جميع المنتجات</p>
                    <p class="dash-card__sub"><?php echo e($products->total()); ?> منتج في المخزن</p>
                </div>
                <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>">
                    <label class="search-field">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" placeholder="بحث عن منتج..." value="<?php echo e(request('search')); ?>">
                    </label>
                </form>
            </div>

            <?php if($products->count() > 0): ?>

                
                <div class="block md:hidden divide-y" style="border-color:var(--border);">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 flex items-start gap-3">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>"
                                 class="w-14 h-14 object-cover rounded-xl shrink-0"
                                 style="border:1px solid var(--border);"
                                 onerror="this.src='<?php echo e(asset('images/error.jpg')); ?>'">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black truncate" style="color:var(--text);"><?php echo e($product->name); ?></p>
                                <p class="text-xs mt-0.5" style="color:var(--text-muted);"><?php echo e($product->category->name ?? '—'); ?></p>
                                <?php if($product->brand): ?>
                                    <p class="text-xs mt-0.5" style="color:#a855f7;"><?php echo e($product->brand->name); ?></p>
                                <?php endif; ?>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-sm font-black" style="color:var(--electric);"><?php echo e(number_format($product->discounted_price, 2)); ?> ج.م</span>
                                    <span class="stock-badge <?php echo e($product->stock > 10 ? 'stock-badge--ok' : ($product->stock > 0 ? 'stock-badge--low' : 'stock-badge--none')); ?>">
                                <?php echo e($product->stock > 0 ? $product->stock.' وحدة' : 'نفذ'); ?>

                            </span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 shrink-0">
                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="action-btn action-btn--edit">تعديل</a>
                                <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                      onsubmit="return confirm('حذف <?php echo e(addslashes($product->name)); ?>؟')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="action-btn action-btn--delete w-full">حذف</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="hidden md:block overflow-x-auto">
                    <table class="products-table">
                        <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>القسم / الماركة</th>
                            <th>السعر</th>
                            <th>المخزون</th>
                            <th>إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="prod-cell">
                                        <img src="<?php echo e(asset($product->image_url ?? $product->image)); ?>"
                                             alt="<?php echo e($product->name); ?>" class="prod-thumb"
                                             onerror="this.src='<?php echo e(asset('images/placeholder.png')); ?>'">
                                        <div>
                                            <p class="prod-cell__name"><?php echo e($product->name); ?></p>
                                            <p class="prod-cell__id">#<?php echo e($product->id); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-start;">
                                        <span class="tag"><?php echo e($product->category->name ?? '—'); ?></span>
                                        <?php if($product->brand): ?>
                                            <span class="tag tag--purple"><?php echo e($product->brand->name); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="price-val"><?php echo e(number_format($product->discounted_price, 2)); ?> ج.م</span>
                                    <?php if($product->effective_discount > 0): ?>
                                        <p class="price-original"><?php echo e(number_format($product->price, 2)); ?> ج.م</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                <span class="stock-badge <?php echo e($product->stock > 10 ? 'stock-badge--ok' : ($product->stock > 0 ? 'stock-badge--low' : 'stock-badge--none')); ?>">
                                    <?php echo e($product->stock > 0 ? $product->stock.' وحدة' : 'نفذ'); ?>

                                </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="action-btn action-btn--edit">
                                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            تعديل
                                        </a>
                                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                              onsubmit="return confirm('حذف <?php echo e(addslashes($product->name)); ?>؟')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="action-btn action-btn--delete">
                                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($products->hasPages()): ?>
                    <div class="pagination-wrap">
                        <?php echo e($products->withQueryString()->links()); ?>

                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" style="color:var(--border-hover);">
                        <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="empty-state__text">لا توجد منتجات مطابقة</p>
                    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-add-product">إضافة منتج الآن</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script>
        document.addEventListener('error', function(e) {
            if (e.target.tagName === 'IMG' && e.target.hasAttribute('data-fallback')) {
                const fallbackSrc = e.target.getAttribute('data-fallback');
                if (e.target.src !== fallbackSrc) {
                    e.target.src = fallbackSrc;
                    e.target.removeAttribute('data-fallback');
                }
            }
        }, true);
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>