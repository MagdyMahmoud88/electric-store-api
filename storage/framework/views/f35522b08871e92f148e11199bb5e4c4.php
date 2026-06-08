
<nav class="main-navbar" id="mainNav">
    <div class="nav-inner">

        
        <a href="<?php echo e(route('welcome')); ?>" class="nav-logo">
            <div class="nav-logo-icon">⚡</div>
            <div class="nav-logo-text">متجر <span>الكهرباء</span></div>
        </a>

        
        <div class="nav-links">
            <a href="<?php echo e(route('welcome')); ?>"
               class="nav-link <?php echo e(request()->routeIs('welcome') ? 'active' : ''); ?>">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                الرئيسية
            </a>
            <a href="<?php echo e(route('products.index')); ?>"
               class="nav-link <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                المنتجات
            </a>
        </div>

        
        <div class="nav-end">

            
            <a href="<?php echo e(route('cart.index')); ?>" class="nav-cart">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <?php
                    $cartCount = auth()->check()
                        ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
                        : collect(session()->get('cart', []))->sum('quantity');
                ?>                <?php if($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo e($cartCount); ?></span>
                <?php endif; ?>
            </a>

            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('wishlist.index')); ?>"
                   class="nav-cart <?php echo e(request()->routeIs('wishlist.*') ? 'active' : ''); ?>"
                   title="المفضلة">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <?php $wishlistCount = auth()->user()->wishlists()->count(); ?>
                    <?php if($wishlistCount > 0): ?>
                        <span class="cart-badge" id="wishlist-count"><?php echo e($wishlistCount); ?></span>
                    <?php else: ?>
                        <span class="cart-badge" id="wishlist-count" style="display:none;">0</span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                <?php
                    $bellNotifications = auth()->user()->unreadNotifications()->latest()->take(10)->get();
                    $bellCount         = auth()->user()->unreadNotifications()->count();
                ?>

                <div style="position:relative;">
                    <button id="bellBtn" onclick="toggleBellMenu()" class="nav-icon-btn" title="الإشعارات" style="position:relative;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <?php if($bellCount > 0): ?>
                            <span id="bellBadge" class="cart-badge"><?php echo e($bellCount); ?></span>
                        <?php else: ?>
                            <span id="bellBadge" class="cart-badge" style="display:none;">0</span>
                        <?php endif; ?>
                    </button>

                    <div id="bellMenu" style="display:none;position:absolute;left:0;top:calc(100% + 8px);width:300px;background:var(--surface);border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:9999;overflow:hidden;">

                        
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid var(--border);">
                            <span style="font-size:13px;font-weight:700;">الإشعارات</span>
                            <?php if($bellCount > 0): ?>
                                <form action="<?php echo e(route('admin.notifications.readAll')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" style="background:none;border:none;font-size:12px;color:var(--primary);cursor:pointer;padding:0;">
                                        تعليم الكل كمقروء
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        
                        <div id="bellList" style="max-height:300px;overflow-y:auto;">
                            <?php $__empty_1 = true; $__currentLoopData = $bellNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e(route('admin.notifications.read', $notification->id)); ?>"
                                   style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid var(--border);text-decoration:none;color:inherit;background:<?php echo e($notification->read_at ? 'transparent' : 'rgba(226,75,74,0.05)'); ?>;">
                                    <?php if (! ($notification->read_at)): ?>
                                        <span style="width:8px;height:8px;border-radius:50%;background:#E24B4A;flex-shrink:0;margin-top:4px;"></span>
                                    <?php endif; ?>
                                    <div>
                                        <p style="margin:0;font-size:13px;font-weight:<?php echo e($notification->read_at ? '400' : '600'); ?>;">
                                            <?php echo e($notification->data['message']); ?>

                                        </p>
                                        <p style="margin:4px 0 0;font-size:11px;opacity:.6;">
                                            <?php echo e($notification->created_at->diffForHumans()); ?>

                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div style="padding:20px;text-align:center;font-size:13px;opacity:.5;">
                                    لا توجد إشعارات جديدة
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

            
            <button onclick="toggleTheme()" id="theme-btn" class="nav-icon-btn" title="تغيير الثيم">
                <svg id="sun-icon" style="display:none;" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg id="moon-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            
            <?php if(auth()->guard()->check()): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-badge">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                        لوحة التحكم
                    </a>
                <?php endif; ?>

                <div style="position:relative;">
                    <button class="nav-user-btn" onclick="toggleUserMenu()">
                        <div class="nav-user-avatar">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                        <span class="hidden-mobile"><?php echo e(Str::limit(auth()->user()->name, 10)); ?></span>
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="userMenu" class="user-dropdown">
                        <div class="user-dropdown-email"><?php echo e(auth()->user()->email); ?></div>

                        <a href="<?php echo e(route('profile.index')); ?>" class="user-dropdown-item">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zM19 21v-1a7 7 0 00-14 0v1"/>
                            </svg>
                            الملف الشخصي
                        </a>

                        <a href="<?php echo e(route('cart.index')); ?>" class="user-dropdown-item">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            سلة المشتريات
                        </a>

                        <a href="<?php echo e(route('wishlist.index')); ?>" class="user-dropdown-item">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            المفضلة
                        </a>

                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('admin')): ?>
                            <a href="<?php echo e(route('returns.index')); ?>"
                               class="user-dropdown-item <?php echo e(request()->routeIs('returns.*') ? 'active' : ''); ?>">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                                </svg>
                                طلبات الإرجاع
                                <?php
                                    $pendingReturns = \App\Models\ReturnRequest::where('user_id', auth()->id())
                                        ->where('status', 'pending')->count();
                                ?>
                                <?php if($pendingReturns > 0): ?>
                                    <span style="margin-right:auto;background:#f59e0b;color:#000;font-size:10px;font-weight:900;min-width:18px;height:18px;border-radius:99px;display:inline-flex;align-items:center;justify-content:center;padding:0 4px;">
                                        <?php echo e($pendingReturns); ?>

                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                            <a href="<?php echo e(route('admin.reviews.index')); ?>"
                               class="user-dropdown-item <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                إدارة التقييمات
                                <?php
                                    $pendingCount = \App\Models\Review::where('is_approved', false)->count();
                                ?>
                                <?php if($pendingCount > 0): ?>
                                    <span style="margin-right:auto;background:#E24B4A;color:#fff;font-size:10px;font-weight:900;min-width:18px;height:18px;border-radius:99px;display:inline-flex;align-items:center;justify-content:center;padding:0 4px;">
                                        <?php echo e($pendingCount); ?>

                                    </span>
                                <?php endif; ?>
                            </a>
                            <a href="<?php echo e(route('admin.users.index')); ?>"
                               class="user-dropdown-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                إدارة المستخدمين
                            </a>
                        <?php endif; ?>

                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="user-dropdown-logout">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="btn-nav-ghost <?php echo e(Request::is('login*') ? 'active' : ''); ?>">
                    دخول
                </a>
                <a href="<?php echo e(route('register.index')); ?>" class="btn-nav-primary">إنشاء حساب</a>
            <?php endif; ?>

            
            <button class="mobile-toggle" onclick="toggleMobileMenu()">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</nav>


<div id="mobileMenu" style="display:none;background:var(--surface);border-bottom:1px solid var(--border);padding:12px 16px;position:sticky;top:64px;z-index:99;">
    <a href="<?php echo e(route('welcome')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">الرئيسية</a>
    <a href="<?php echo e(route('products.index')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">المنتجات</a>
    <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('profile.index')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">الملف الشخصي</a>
        <a href="<?php echo e(route('wishlist.index')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">
            المفضلة
            <?php $wc = auth()->user()->wishlists()->count(); ?>
            <?php if($wc > 0): ?>
                <span class="cart-badge" style="margin-right:4px;"><?php echo e($wc); ?></span>
            <?php endif; ?>
        </a>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('admin')): ?>
            <a href="<?php echo e(route('returns.index')); ?>"
               class="nav-link <?php echo e(request()->routeIs('returns.*') ? 'active' : ''); ?>"
               style="display:flex;margin-bottom:4px;">
                طلبات الإرجاع
                <?php if(isset($pendingReturns) && $pendingReturns > 0): ?>
                    <span class="cart-badge" style="margin-right:4px;"><?php echo e($pendingReturns); ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">لوحة التحكم</a>
        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">إدارة التقييمات</a>
        <a href="<?php echo e(route('admin.returns.index')); ?>" class="nav-link" style="display:flex;margin-bottom:4px;">طلبات الإرجاع</a>
        <a href="<?php echo e(route('admin.users.index')); ?>"
           class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"
           style="display:flex;margin-bottom:4px;">
            إدارة المستخدمين
        </a>
    <?php endif; ?>
</div>


<script>
    <?php if(auth()->guard()->check()): ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
    const BELL_FETCH_URL  = '<?php echo e(route("admin.notifications.fetch")); ?>';
    const BELL_COUNT_URL  = '<?php echo e(route("admin.notifications.count")); ?>';
    const CSRF_TOKEN      = '<?php echo e(csrf_token()); ?>';

    function toggleBellMenu() {
        const menu = document.getElementById('bellMenu');
        if (!menu) return;
        if (menu.style.display === 'none') {
            loadNotifications();
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }

    function loadNotifications() {
        fetch(BELL_FETCH_URL, {
            headers: { 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(data => {
                const badge = document.getElementById('bellBadge');
                const list  = document.getElementById('bellList');

                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }

                if (!list) return;

                if (!data.notifications || data.notifications.length === 0) {
                    list.innerHTML = '<div style="padding:20px;text-align:center;font-size:13px;opacity:.5;">لا توجد إشعارات جديدة</div>';
                    return;
                }

                list.innerHTML = data.notifications.map(n => `
                <div onclick="readNotification('${n.id}')"
                     style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid var(--border);cursor:pointer;background:rgba(226,75,74,0.05);">
                    <span style="width:8px;height:8px;border-radius:50%;background:#E24B4A;flex-shrink:0;margin-top:4px;"></span>
                    <div>
                        <p style="margin:0;font-size:13px;font-weight:600;color:var(--text);">${n.message}</p>
                        <p style="margin:4px 0 0;font-size:11px;opacity:.6;color:var(--text);">${n.time}</p>
                    </div>
                </div>
            `).join('');
            })
            .catch(err => console.error('Bell error:', err));
    }

    function readNotification(id) {
        fetch(`/admin/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            }
        }).then(() => loadNotifications())
            .catch(err => console.error(err));
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#bellBtn') && !e.target.closest('#bellMenu')) {
            const menu = document.getElementById('bellMenu');
            if (menu) menu.style.display = 'none';
        }
    });

    setInterval(function() {
        fetch(BELL_COUNT_URL, {
            headers: { 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(data => {
                const badge = document.getElementById('bellBadge');
                if (!badge) return;
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(() => {});
    }, 30000);

    <?php endif; ?>
    <?php endif; ?>

    
    function updateThemeIcons(theme) {
        const sunIcon  = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        if (!sunIcon || !moonIcon) return;
        sunIcon.style.display  = theme === 'light' ? 'block' : 'none';
        moonIcon.style.display = theme === 'dark'  ? 'block' : 'none';
    }

    function toggleTheme() {
        const current  = document.documentElement.getAttribute('data-theme');
        const newTheme = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcons(newTheme);
    }

    updateThemeIcons(document.documentElement.getAttribute('data-theme'));
</script>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/nav-bar.blade.php ENDPATH**/ ?>