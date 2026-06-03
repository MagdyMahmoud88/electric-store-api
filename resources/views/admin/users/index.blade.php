{{-- resources/views/admin/users/index.blade.php --}}
<x-layout>

    {{-- ══ Admin Bar ══ --}}
    <div class="admin-bar sticky top-[64px] z-40 w-full">
        <div class="page-container">
            <div class="admin-bar__inner">
                <div class="admin-bar__brand">
                    <div class="admin-bar__icon">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="admin-bar__title">إدارة المستخدمين</span>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link">← لوحة التحكم</a>
            </div>
        </div>
    </div>

    <div class="page-container" style="padding-top:32px;padding-bottom:32px;">

        {{-- ══ Stats ══ --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val">{{ $stats['total'] }}</p>
                    <p class="stat-card__label">إجمالي المستخدمين</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--green">
                </div>
                <div>
                    <p class="stat-card__val">{{ $stats['active'] }}</p>
                    <p class="stat-card__label">مفعّلين</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--red">
                </div>
                <div>
                    <p class="stat-card__val {{ $stats['inactive'] > 0 ? 'text-red-400' : '' }}">{{ $stats['inactive'] }}</p>
                    <p class="stat-card__label">معطّلين</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--amber">
                </div>
                <div>
                    <p class="stat-card__val {{ $stats['unverified'] > 0 ? 'text-amber-400' : '' }}">{{ $stats['unverified'] }}</p>
                    <p class="stat-card__label">غير متحققين</p>
                </div>
            </div>
        </div>

        {{-- ══ Filters ══ --}}
        <form method="GET" class="dash-card" style="padding:16px 18px;">
            <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">

                <div style="flex:1;min-width:180px;">
                    <label style="font-size:11px;color:var(--text-muted);display:block;margin-bottom:4px;">بحث</label>
                    <div class="search-field">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="الاسم أو الإيميل...">
                    </div>
                </div>

                @foreach([
                    ['name' => 'status',   'label' => 'الحالة',  'options' => ['' => 'الكل', 'active' => 'مفعّل', 'inactive' => 'معطّل']],
                    ['name' => 'verified', 'label' => 'التحقق',  'options' => ['' => 'الكل', 'yes' => 'متحقق', 'no' => 'غير متحقق']],
                    ['name' => 'role',     'label' => 'الدور',   'options' => ['' => 'الكل', 'user' => 'User', 'admin' => 'Admin']],
                    ['name' => 'sort',     'label' => 'ترتيب',   'options' => ['latest' => 'الأحدث', 'oldest' => 'الأقدم', 'name' => 'الاسم', 'orders' => 'الطلبات', 'spent' => 'الإنفاق']],
                ] as $filter)
                    <div>
                        <label style="font-size:11px;color:var(--text-muted);display:block;margin-bottom:4px;">{{ $filter['label'] }}</label>
                        <select name="{{ $filter['name'] }}"
                                style="font-size:13px;padding:7px 12px;border-radius:8px;background:var(--surface2);border:1px solid var(--border);color:var(--text);outline:none;">
                            @foreach($filter['options'] as $val => $label)
                                <option value="{{ $val }}" {{ request($filter['name']) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <div style="display:flex;gap:8px;">
                    <button type="submit" class="action-btn action-btn--edit">🔍 بحث</button>
                    <a href="{{ route('admin.users.index') }}" class="action-btn" style="background:var(--surface2);color:var(--text-muted);border:1px solid var(--border);">✖ مسح</a>
                </div>
            </div>
        </form>

        {{-- ══ Table ══ --}}
        <div class="dash-card">
            <div class="dash-card__head">
                <div>
                    <p class="dash-card__title">المستخدمين</p>
                    <p class="dash-card__sub">{{ $users->total() }} مستخدم</p>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="products-table">
                    <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>الحالة</th>
                        <th>الطلبات</th>
                        <th>الإنفاق</th>
                        <th>التسجيل</th>
                        <th>إجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            {{-- المستخدم --}}
                            <td>
                                <div class="prod-cell">
                                    <div style="width:36px;height:36px;border-radius:50%;background:var(--electric-dim);color:var(--electric);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="prod-cell__name">{{ $user->name }}</p>
                                        <p class="prod-cell__id">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- الحالة --}}
                            <td>
                                <div style="display:flex;flex-direction:column;gap:4px;">
                                    <span class="stock-badge {{ $user->is_active ? 'stock-badge--ok' : 'stock-badge--none' }}">
                                        {{ $user->is_active ? 'مفعّل' : 'معطّل' }}
                                    </span>
                                    <span class="stock-badge {{ $user->email_verified_at ? 'stock-badge--ok' : 'stock-badge--low' }}">
                                        {{ $user->email_verified_at ? '✅ متحقق' : '⚠️ غير متحقق' }}
                                    </span>
                                </div>
                            </td>

                            {{-- الطلبات --}}
                            <td style="text-align:center;font-weight:700;color:var(--text);">
                                {{ $user->orders_count }}
                            </td>

                            {{-- الإنفاق --}}
                            <td>
                                <span class="price-val">{{ number_format($user->orders_sum_total ?? 0, 0) }} ج.م</span>
                            </td>

                            {{-- التسجيل --}}
                            <td style="font-size:12px;color:var(--text-muted);">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            {{-- إجراءات --}}
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.show', $user) }}" class="action-btn action-btn--edit">
                                        👁 عرض
                                    </a>
                                    @unless($user->isAdmin())
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="action-btn {{ $user->is_active ? 'action-btn--delete' : 'action-btn--edit' }}">
                                                {{ $user->is_active ? '🔒' : '✅' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('حذف {{ addslashes($user->name) }}؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn action-btn--delete">🗑</button>
                                        </form>
                                    @else
                                        <span class="tag tag--purple">Admin</span>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:48px;color:var(--text-muted);">
                                <p style="font-size:32px;margin-bottom:8px;">👥</p>
                                <p style="font-size:13px;">لا توجد نتائج</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="pagination-wrap">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>

</x-layout>
