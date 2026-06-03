{{-- resources/views/admin/users/show.blade.php --}}
<x-layout>

    {{-- ══ Admin Top Bar ══ --}}
    <div class="admin-bar sticky top-[64px] z-40 w-full">
        <div class="page-container">
            <div class="admin-bar__inner">
                <div class="admin-bar__brand">
                    <a href="{{ route('admin.users.index') }}"
                       class="admin-nav-link">
                        ← إدارة المستخدمين
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-container" style="padding-top:32px;padding-bottom:32px;">

        {{-- ══ Header ══ --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-2xl font-bold" style="color:var(--text)">{{ $user->name }}</h1>
                <p class="text-sm" style="color:var(--text-muted)">{{ $user->email }}</p>
            </div>
            <div class="flex gap-2 flex-wrap">
                {{-- Toggle Status --}}
                @unless($user->isAdmin())
                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="action-btn {{ $user->is_active ? 'action-btn--delete' : 'action-btn--edit' }}">
                            {{ $user->is_active ? '🔒 تعطيل الحساب' : '✅ تفعيل الحساب' }}
                        </button>
                    </form>

                    {{-- Delete --}}
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الحساب؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn action-btn--delete">🗑 حذف</button>
                    </form>
                @else
                    <span class="tag tag--purple">Admin — محمي</span>
                @endunless
            </div>
        </div>

        {{-- ══ Stats Cards ══ --}}
        <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(120px,1fr));">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val">{{ $user->orders_count }}</p>
                    <p class="stat-card__label">الطلبات</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--green">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val" style="font-size:16px;">{{ number_format($user->orders_sum_total ?? 0, 0) }}</p>
                    <p class="stat-card__label">إجمالي الإنفاق</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--amber">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val">{{ $user->reviews_count }}</p>
                    <p class="stat-card__label">التقييمات</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card__icon" style="background:rgba(236,72,153,.1);color:#ec4899;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val">{{ $user->wishlists_count }}</p>
                    <p class="stat-card__label">المفضلة</p>
                </div>
            </div>
        </div>

        {{-- ══ Info + Recent Orders ══ --}}
        <div class="two-col-grid">

            {{-- بيانات الحساب --}}
            <div class="dash-card">
                <div class="dash-card__head">
                    <p class="dash-card__title">بيانات الحساب</p>
                </div>
                <div style="padding:16px 18px;font-size:13px;color:var(--text-soft);display:flex;flex-direction:column;gap:10px;">
                    <div class="flex items-center gap-2">
                        <span>📧</span>
                        <span style="color:var(--text)">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>👤 الدور:</span>
                        <span class="tag {{ $user->isAdmin() ? 'tag--purple' : '' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'User' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>🟢 الحالة:</span>
                        <span class="stock-badge {{ $user->is_active ? 'stock-badge--ok' : 'stock-badge--none' }}">
                            {{ $user->is_active ? 'مفعّل' : 'معطّل' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>✅ التحقق:</span>
                        <span class="stock-badge {{ $user->email_verified_at ? 'stock-badge--ok' : 'stock-badge--low' }}">
                            {{ $user->email_verified_at ? 'متحقق' : 'غير متحقق' }}
                        </span>
                    </div>
                    <div>📅 تاريخ التسجيل: <strong>{{ $user->created_at->format('d M Y') }}</strong></div>
                    <div>🕐 آخر تحديث: <strong>{{ $user->updated_at->diffForHumans() }}</strong></div>
                </div>
            </div>

            {{-- آخر الطلبات --}}
            <div class="dash-card">
                <div class="dash-card__head">
                    <p class="dash-card__title">آخر الطلبات</p>
                </div>
                <div class="order-list">
                    @forelse($recentOrders as $order)
                        <div class="order-row" style="text-decoration:none;">
                            <div class="order-info">
                                <p class="order-name">{{ $order->order_number }}</p>
                                <p class="order-meta">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="order-amount">{{ number_format($order->total, 0) }} ج.م</span>
                            <span class="order-status order-status--{{ $order->status }}">{{ $order->status }}</span>
                        </div>
                    @empty
                        <div style="padding:24px;text-align:center;font-size:13px;color:var(--text-muted);">
                            لا توجد طلبات
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ══ Activity Preview ══ --}}
        <div class="dash-card">
            <div class="dash-card__head">
                <div>
                    <p class="dash-card__title">آخر النشاطات</p>
                </div>
                <a href="{{ route('admin.users.activity', $user) }}" class="dash-link">
                    عرض الكل ←
                </a>
            </div>

            @forelse($activityLogs as $log)
                <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);">
                    <span style="font-size:20px;flex-shrink:0;">{{ $log->icon() }}</span>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;font-weight:600;color:var(--text);margin:0;">{{ $log->description }}</p>
                        <p style="font-size:11px;color:var(--text-muted);margin:3px 0 0;">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                    <span style="font-size:11px;padding:2px 8px;border-radius:99px;background:var(--surface2);color:var(--text-muted);white-space:nowrap;flex-shrink:0;">
                    {{ $log->ip_address }}
                </span>
                </div>
            @empty
                <div style="padding:40px;text-align:center;font-size:13px;color:var(--text-muted);">
                    لا توجد نشاطات مسجّلة
                </div>
            @endforelse
        </div>

    </div>

</x-layout>
