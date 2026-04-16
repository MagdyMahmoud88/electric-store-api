{{-- ── NAVBAR ── --}}
<nav class="main-navbar" id="mainNav">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ route('welcome') }}" class="nav-logo">
            <div class="nav-logo-icon">⚡</div>
            <div class="nav-logo-text">متجر <span>الكهرباء</span></div>
        </a>

        {{-- Links --}}
        <div class="nav-links">
            <a href="{{ route('welcome') }}"
               class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                الرئيسية
            </a>
            <a href="{{ route('products.index') }}"
               class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                المنتجات
            </a>
        </div>

        {{-- Right side --}}
        <div class="nav-end">

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="nav-cart">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                @php $cartCount = count(session()->get('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

            {{-- Wishlist --}}
            @auth

                <a href="{{ route('wishlist.index') }}"
                   class="nav-cart {{ request()->routeIs('wishlist.*') ? 'active' : '' }}"
                   title="المفضلة">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    @php $wishlistCount = auth()->user()->wishlists()->count(); @endphp
                    @if($wishlistCount > 0)
                        <span class="cart-badge" id="wishlist-count">{{ $wishlistCount }}</span>
                    @else
                        <span class="cart-badge" id="wishlist-count" style="display:none;">0</span>
                    @endif
                </a>
            @endauth

            {{-- Theme Toggle --}}
            <button onclick="toggleTheme()" id="theme-btn" class="nav-icon-btn" title="تغيير الثيم">
                <svg id="sun-icon" style="display:none;" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg id="moon-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>

            {{-- Auth --}}
            @auth
                @can('admin')
                    <a href="{{ route('admin.dashboard') }}" class="admin-badge">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                        لوحة التحكم
                    </a>
                @endcan

                <div style="position:relative;">
                    <button class="nav-user-btn" onclick="toggleUserMenu()">
                        <div class="nav-user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden-mobile">{{ Str::limit(auth()->user()->name, 10) }}</span>
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="userMenu" class="user-dropdown">
                        <div class="user-dropdown-email">{{ auth()->user()->email }}</div>

                                <a href="{{ route('profile.index') }}" class="user-dropdown-item">
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zM19 21v-1a7 7 0 00-14 0v1"/>
    </svg>
    الملف الشخصي
</a>
                        <a href="{{ route('cart.index') }}" class="user-dropdown-item">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            سلة المشتريات
                        </a>

                        <a href="{{ route('wishlist.index') }}" class="user-dropdown-item">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            المفضلة
                        </a>

                        {{-- ── لينك التقييمات للأدمن فقط ── --}}
                        @can('admin')
                            <a href="{{ route('admin.reviews.index') }}"
                               class="user-dropdown-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                إدارة التقييمات
                                @php
                                    $pendingCount = \App\Models\Review::where('is_approved', false)->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span style="margin-right:auto;background:#E24B4A;color:#fff;font-size:10px;font-weight:900;min-width:18px;height:18px;border-radius:99px;display:inline-flex;align-items:center;justify-content:center;padding:0 4px;">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </a>
                        @endcan

                        <form action="{{ route('logout.destroy') }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="user-dropdown-logout">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login.index') }}"
                   class="btn-nav-ghost {{ Request::is('login*') ? 'active' : '' }}">
                    دخول
                </a>
                <a href="{{ route('register.index') }}" class="btn-nav-primary">إنشاء حساب</a>
            @endguest

            {{-- Mobile Toggle --}}
            <button class="mobile-toggle" onclick="toggleMobileMenu()">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile Menu --}}
<div id="mobileMenu" style="display:none;background:var(--surface);border-bottom:1px solid var(--border);padding:12px 16px;position:sticky;top:64px;z-index:99;">
    <a href="{{ route('welcome') }}" class="nav-link" style="display:flex;margin-bottom:4px;">الرئيسية</a>
    <a href="{{ route('products.index') }}" class="nav-link" style="display:flex;margin-bottom:4px;">المنتجات</a>
    @auth
    <a href="{{ route('profile.index') }}" class="nav-link" style="display:flex;margin-bottom:4px;">الملف الشخصي</a>
        <a href="{{ route('wishlist.index') }}" class="nav-link" style="display:flex;margin-bottom:4px;">
            المفضلة
            @php $wc = auth()->user()->wishlists()->count(); @endphp
            @if($wc > 0)
                <span class="cart-badge" style="margin-right:4px;">{{ $wc }}</span>
            @endif
        </a>

    @endauth
    @can('admin')

        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="display:flex;margin-bottom:4px;">لوحة التحكم</a>
        <a href="{{ route('admin.reviews.index') }}" class="nav-link" style="display:flex;margin-bottom:4px;">إدارة التقييمات</a>
    @endcan
</div>

{{-- Theme Script --}}
<script>
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
