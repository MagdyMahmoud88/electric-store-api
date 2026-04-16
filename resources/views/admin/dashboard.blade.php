<x-layout>

{{-- ── Navbar Override: Admin bar ── --}}
<div class="sticky top-[64px] z-40 w-full"
     style="background:var(--surface);border-bottom:1px solid var(--border);">
    <div class="page-container">
        <div class="flex items-center justify-between gap-3 py-3 flex-wrap">

            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                     style="background:var(--electric-dim);color:var(--electric);">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <span class="font-black text-sm" style="color:var(--text);">لوحة التحكم</span>
            </div>

            {{-- Admin Nav Links --}}
            <div class="flex items-center gap-2 flex-wrap">

                <a href="{{ route('admin.brands.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                   style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);"
                   onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                   onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 014-4z"/>
                    </svg>
                    الماركات
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                   style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);"
                   onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                   onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    الأقسام
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 relative"
                   style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);"
                   onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                   onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    الطلبات
                    @if($pendingOrders > 0)
                    <span class="inline-flex items-center justify-center w-4 h-4 rounded-full text-[10px] font-black"
                          style="background:var(--electric);color:#070810;">
                        {{ $pendingOrders }}
                    </span>
                    @endif
                </a>

                <a href="{{ route('admin.reports.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                   style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);"
                   onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                   onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    التقارير
                </a>

                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg text-xs font-black transition-all duration-200"
                   style="background:var(--electric);color:#070810;border:1px solid var(--electric);"
                   onmouseover="this.style.opacity='.85'"
                   onmouseout="this.style.opacity='1'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة منتج
                </a>

            </div>
        </div>
    </div>
</div>

<div class="page-container py-8">

    {{-- Flash --}}
    @if(session('success'))
    <div role="alert" class="alert alert-success mb-6 text-sm font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div role="alert" class="alert alert-error mb-6 text-sm font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ══ Stats Grid ══ --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 mb-8">

        {{-- المنتجات --}}
        <div class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:var(--electric-dim);color:var(--electric);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $totalProducts }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">المنتجات</p>
            </div>
        </div>

        {{-- الماركات --}}
        <a href="{{ route('admin.brands.index') }}"
           class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1"
           style="background:var(--surface);border:1px solid var(--border);text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='var(--border)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(168,85,247,.1);color:#a855f7;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 014-4z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $totalBrands }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">الماركات</p>
            </div>
        </a>

        {{-- الأقسام --}}
        <div class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(59,130,246,.1);color:#3b82f6;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $totalCategories }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">الأقسام</p>
            </div>
        </div>

        {{-- مخزون منخفض --}}
        <div class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(234,179,8,.1);color:#eab308;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $lowStock }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">مخزون منخفض</p>
            </div>
        </div>

        {{-- نفذ --}}
        <div class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(239,68,68,.1);color:#ef4444;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $outOfStock }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">نفذ من المخزون</p>
            </div>
        </div>

        {{-- إجمالي الطلبات --}}
        <a href="{{ route('admin.orders.index') }}"
           class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1 cursor-pointer"
           style="background:var(--surface);border:1px solid var(--border);text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='var(--border)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(34,197,94,.1);color:#22c55e;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $totalOrders }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">إجمالي الطلبات</p>
            </div>
        </a>

        {{-- طلبات معلقة --}}
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
           class="rounded-2xl p-4 flex items-center gap-3 transition-all duration-200 hover:-translate-y-1 cursor-pointer"
           style="background:var(--surface);border:1px solid {{ $pendingOrders > 0 ? 'rgba(245,158,11,.3)' : 'var(--border)' }};text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='{{ $pendingOrders > 0 ? 'rgba(245,158,11,.3)' : 'var(--border)' }}'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(249,115,22,.1);color:#f97316;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black leading-none" style="color:var(--text);">{{ $pendingOrders }}</p>
                <p class="text-[11px] mt-1" style="color:var(--text-muted);">طلبات معلقة</p>
                @if($pendingOrders > 0)
                <span class="inline-flex items-center gap-1 text-[10px] font-black mt-1"
                      style="color:var(--electric);">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400" style="animation:pulse 1.5s infinite;"></span>
                    تحتاج مراجعة
                </span>
                @endif
            </div>
        </a>

    </div>

    {{-- ══ Quick Links ══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-8">

        <a href="{{ route('admin.brands.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-200 hover:-translate-y-1"
           style="background:var(--surface);border:1px solid var(--border);text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='var(--border)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(168,85,247,.1);color:#a855f7;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 014-4z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-black" style="color:var(--text);">إدارة الماركات</p>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">إضافة وتعديل الماركات</p>
            </div>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-200 hover:-translate-y-1"
           style="background:var(--surface);border:1px solid var(--border);text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='var(--border)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(34,197,94,.1);color:#22c55e;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-black" style="color:var(--text);">إدارة الطلبات</p>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">عرض وتحديث حالة الطلبات</p>
            </div>
        </a>

        <a href="{{ route('admin.reports.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-200 hover:-translate-y-1"
           style="background:var(--surface);border:1px solid var(--border);text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='var(--border)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(59,130,246,.1);color:#3b82f6;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-black" style="color:var(--text);">التقارير والإحصائيات</p>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">مبيعات وأكثر المنتجات طلباً</p>
            </div>
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-4 p-4 rounded-2xl transition-all duration-200 hover:-translate-y-1"
           style="background:var(--surface);border:1px solid var(--border);text-decoration:none;"
           onmouseover="this.style.borderColor='var(--electric)'"
           onmouseout="this.style.borderColor='var(--border)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:var(--electric-dim);color:var(--electric);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-black" style="color:var(--text);">إدارة الأقسام</p>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">إضافة وتعديل أقسام المتجر</p>
            </div>
        </a>

    </div>

    {{-- ══ Recent Orders ══ --}}
    @if($recentOrders->count() > 0)
    <div class="flex items-center gap-3 mb-5">
        <div class="flex-1 h-px" style="background:var(--border);"></div>
        <span class="text-[11px] font-black tracking-widest uppercase" style="color:var(--text-muted);">أحدث الطلبات</span>
        <div class="flex-1 h-px" style="background:var(--border);"></div>
    </div>

    <div class="rounded-2xl overflow-hidden mb-8" style="background:var(--surface);border:1px solid var(--border);">
        <div class="flex items-center justify-between px-5 py-4 flex-wrap gap-3"
             style="border-bottom:1px solid var(--border);">
            <div>
                <p class="font-black text-sm" style="color:var(--text);">آخر الطلبات</p>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">أحدث {{ $recentOrders->count() }} طلبات</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
               style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);"
               onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
               onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                عرض الكل
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>

        <div class="block md:hidden divide-y" style="border-color:var(--border);">
            @foreach($recentOrders as $order)
            @php
            $statusMap = [
                'pending'    => ['قيد الانتظار','warning'],
                'processing' => ['قيد التجهيز', 'info'],
                'shipped'    => ['تم الشحن',     'primary'],
                'delivered'  => ['تم التسليم',   'success'],
                'cancelled'  => ['ملغي',          'error'],
            ];
            [$statusLabel, $statusColor] = $statusMap[$order->status] ?? ['—','ghost'];
            @endphp
            <div class="p-4 flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-black flex-shrink-0"
                         style="background:var(--electric-dim);color:var(--electric);border:1px solid rgba(245,158,11,.25);">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold" style="color:var(--text);">{{ $order->user->name }}</p>
                        <p class="text-[11px]" style="color:var(--text-muted);">#{{ substr($order->id, 0, 8) }}</p>
                        <p class="text-[11px] mt-0.5" style="color:var(--text-muted);">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="badge badge-{{ $statusColor }} badge-sm font-bold">{{ $statusLabel }}</span>
                    <span class="text-sm font-black" style="color:var(--electric);">{{ number_format($order->total, 0) }} ج.م</span>
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                       class="text-[11px] font-bold" style="color:var(--text-muted);text-decoration:none;"
                       onmouseover="this.style.color='var(--electric)'"
                       onmouseout="this.style.color='var(--text-muted)'">عرض ←</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr style="background:var(--surface2);color:var(--text-soft);">
                        <th class="font-black text-right py-3 px-5">#</th>
                        <th class="font-black text-right py-3 px-5">العميل</th>
                        <th class="font-black text-right py-3 px-5">العناصر</th>
                        <th class="font-black text-right py-3 px-5">الإجمالي</th>
                        <th class="font-black text-right py-3 px-5">الحالة</th>
                        <th class="font-black text-right py-3 px-5">التاريخ</th>
                        <th class="font-black text-right py-3 px-5"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    @php
                    [$statusLabel, $statusColor] = $statusMap[$order->status] ?? ['—','ghost'];
                    @endphp
                    <tr style="border-bottom:1px solid var(--border);">
                        <td class="py-3 px-5"><span class="font-mono text-xs" style="color:var(--text-muted);">#{{ substr($order->id,0,8) }}</span></td>
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black flex-shrink-0"
                                     style="background:var(--electric-dim);color:var(--electric);border:1px solid rgba(245,158,11,.25);">
                                    {{ strtoupper(substr($order->user->name,0,1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold" style="color:var(--text);">{{ $order->user->name }}</p>
                                    <p class="text-[11px]" style="color:var(--text-muted);">{{ $order->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-5"><span class="text-xs" style="color:var(--text-soft);">{{ $order->orderItems->sum('quantity') }} عنصر</span></td>
                        <td class="py-3 px-5"><span class="text-sm font-black" style="color:var(--electric);">{{ number_format($order->total,2) }} ج.م</span></td>
                        <td class="py-3 px-5"><span class="badge badge-{{ $statusColor }} badge-sm font-bold">{{ $statusLabel }}</span></td>
                        <td class="py-3 px-5"><span class="text-xs" style="color:var(--text-muted);">{{ $order->created_at->diffForHumans() }}</span></td>
                        <td class="py-3 px-5">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                               style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);text-decoration:none;"
                               onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                               onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">عرض</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ══ Products Table ══ --}}
    <div class="flex items-center gap-3 mb-5">
        <div class="flex-1 h-px" style="background:var(--border);"></div>
        <span class="text-[11px] font-black tracking-widest uppercase" style="color:var(--text-muted);">المنتجات</span>
        <div class="flex-1 h-px" style="background:var(--border);"></div>
    </div>

    <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
        <div class="flex items-center justify-between px-5 py-4 flex-wrap gap-3"
             style="border-bottom:1px solid var(--border);">
            <div>
                <p class="font-black text-sm" style="color:var(--text);">المنتجات</p>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $products->total() }} منتج في المخزن</p>
            </div>
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <label class="input input-bordered input-sm flex items-center gap-2"
                       style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" name="search" placeholder="بحث عن منتج..."
                           value="{{ request('search') }}"
                           class="grow bg-transparent outline-none text-sm" style="color:var(--text);">
                </label>
            </form>
        </div>

        @if($products->count() > 0)
        <div class="block md:hidden divide-y" style="border-color:var(--border);">
            @foreach($products as $product)
            @php
                $disc  = $product->discount ?? 0;
                $final = number_format($product->price * (1 - $disc/100), 2);
            @endphp
            <div class="p-4 flex items-start gap-3">
                <img src="{{ $product->image_url ? asset('storage/'.$product->image_url) : asset('images/placeholder.png') }}"
                     alt="{{ $product->name }}"
                     class="w-14 h-14 object-cover rounded-xl flex-shrink-0"
                     style="border:1px solid var(--border);"
                     onerror="this.src='{{ asset('images/placeholder.png') }}'">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black truncate" style="color:var(--text);">{{ $product->name }}</p>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $product->category->name ?? '—' }}</p>
                    @if($product->brand)
                        <p class="text-xs mt-0.5" style="color:#a855f7;">{{ $product->brand->name }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-sm font-black" style="color:var(--electric);">{{ $final }} ج.م</span>
                        <span class="badge badge-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'error') }} badge-xs font-bold">
                            {{ $product->stock > 0 ? $product->stock.' وحدة' : 'نفذ' }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-2 flex-shrink-0">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="btn btn-xs font-bold"
                       style="background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.25);color:#93c5fd;">تعديل</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                          onsubmit="return confirm('حذف {{ addslashes($product->name) }}؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs w-full font-bold"
                                style="background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.25);color:#fca5a5;">حذف</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr style="background:var(--surface2);color:var(--text-soft);">
                        <th class="font-black text-right py-3 px-5">المنتج</th>
                        <th class="font-black text-right py-3 px-5">القسم / الماركة</th>
                        <th class="font-black text-right py-3 px-5">السعر</th>
                        <th class="font-black text-right py-3 px-5">المخزون</th>
                        <th class="font-black text-right py-3 px-5">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    @php
                        $disc  = $product->discount ?? 0;
                        $final = number_format($product->price * (1 - $disc/100), 2);
                    @endphp
                    <tr style="border-bottom:1px solid var(--border);">
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url ? asset('storage/'.$product->image_url) : asset('images/placeholder.png') }}"
                                     alt="{{ $product->name }}"
                                     class="w-12 h-12 object-cover rounded-xl flex-shrink-0"
                                     style="border:1px solid var(--border);"
                                     onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                <div>
                                    <p class="text-sm font-bold" style="color:var(--text);">{{ $product->name }}</p>
                                    <p class="text-[11px]" style="color:var(--text-muted);">#{{ $product->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                                  style="background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);">
                                {{ $product->category->name ?? '—' }}
                            </span>
                            @if($product->brand)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold mt-1"
                                  style="background:rgba(168,85,247,.1);border:1px solid rgba(168,85,247,.2);color:#a855f7;">
                                {{ $product->brand->name }}
                            </span>
                            @endif
                        </td>
                        <td class="py-3 px-5">
                            <span class="text-sm font-black" style="color:var(--electric);">{{ $final }} ج.م</span>
                            @if($disc > 0)
                            <p class="text-[11px] line-through" style="color:var(--text-muted);">{{ number_format($product->price, 2) }} ج.م</p>
                            @endif
                        </td>
                        <td class="py-3 px-5">
                            @if($product->stock > 10)
                                <span class="badge badge-success badge-sm font-bold">{{ $product->stock }} وحدة</span>
                            @elseif($product->stock > 0)
                                <span class="badge badge-warning badge-sm font-bold">{{ $product->stock }} وحدة</span>
                            @else
                                <span class="badge badge-error badge-sm font-bold">نفذ</span>
                            @endif
                        </td>
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-xs font-bold gap-1"
                                   style="background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.25);color:#93c5fd;">تعديل</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('حذف {{ addslashes($product->name) }}؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs font-bold"
                                            style="background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.25);color:#fca5a5;">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="flex justify-center py-5" style="border-top:1px solid var(--border);">
            {{ $products->withQueryString()->links() }}
        </div>
        @endif

        @else
        <div class="flex flex-col items-center justify-center py-16 gap-3">
            <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" style="color:var(--border-hover);">
                <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-sm font-bold" style="color:var(--text-muted);">لا توجد منتجات بعد</p>
            <a href="{{ route('admin.products.create') }}"
               class="btn btn-sm font-black"
               style="background:var(--electric);color:#070810;border:none;">إضافة منتج الآن</a>
        </div>
        @endif

    </div>

</div>

</x-layout>
