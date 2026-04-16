<x-layout>

<div class="page-container py-10" dir="rtl" style="font-family:'Cairo',sans-serif;">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-black" style="color:var(--text);">التقارير والإحصائيات</h1>
            <p class="text-sm mt-1" style="color:var(--text-muted);">آخر تحديث: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            لوحة التحكم
        </a>
    </div>

    {{-- ══ Metric Cards ══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        <div class="rounded-2xl p-5 flex items-center gap-4 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.25);">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--electric);">
                    <path stroke-linecap="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold mb-1" style="color:var(--text-muted);">إجمالي المبيعات</p>
                <p class="text-2xl font-black" style="color:var(--electric);">
                    {{ number_format($totalRevenue, 0) }}
                    <span class="text-sm font-normal" style="color:var(--text-muted);">ج.م</span>
                </p>
            </div>
        </div>

        <div class="rounded-2xl p-5 flex items-center gap-4 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#22c55e;">
                    <path stroke-linecap="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold mb-1" style="color:var(--text-muted);">إجمالي الطلبات</p>
                <p class="text-2xl font-black" style="color:#22c55e;">
                    {{ number_format($totalOrders) }}
                    <span class="text-sm font-normal" style="color:var(--text-muted);">طلب</span>
                </p>
            </div>
        </div>

        <div class="rounded-2xl p-5 flex items-center gap-4 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.25);">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#3b82f6;">
                    <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold mb-1" style="color:var(--text-muted);">إجمالي العملاء</p>
                <p class="text-2xl font-black" style="color:#3b82f6;">
                    {{ number_format($totalUsers) }}
                    <span class="text-sm font-normal" style="color:var(--text-muted);">عميل</span>
                </p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- ══ Weekly Sales Chart ══ --}}
        <div class="lg:col-span-2 rounded-2xl overflow-hidden"
             style="background:var(--surface);border:1px solid var(--border);">

            <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                     style="background:var(--electric-dim);color:var(--electric);">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-sm" style="color:var(--text);">مبيعات آخر 7 أيام</h2>
                    <p class="text-xs" style="color:var(--text-muted);">إجمالي المبيعات اليومية</p>
                </div>
            </div>

            <div class="p-6">
                @if($weeklySales->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 gap-2">
                        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" style="color:var(--border-hover);">
                            <path stroke-linecap="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-sm" style="color:var(--text-muted);">لا توجد مبيعات في آخر 7 أيام</p>
                    </div>
                @else
                    {{-- Bar Chart --}}
                    @php $maxTotal = $weeklySales->max('total') ?: 1; @endphp
                    <div class="flex items-end gap-3 h-48 mb-3">
                        @foreach($weeklySales as $day)
                        @php $height = max(4, ($day->total / $maxTotal) * 100); @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="relative w-full flex justify-center">
                                {{-- Tooltip --}}
                                <div class="absolute -top-10 hidden group-hover:flex flex-col items-center z-10">
                                    <div class="px-2 py-1 rounded-lg text-[10px] font-black whitespace-nowrap"
                                         style="background:var(--electric);color:#070810;">
                                        {{ number_format($day->total, 0) }} ج.م
                                    </div>
                                    <div class="w-0 h-0" style="border-left:4px solid transparent;border-right:4px solid transparent;border-top:4px solid var(--electric);"></div>
                                </div>
                                {{-- Bar --}}
                                <div class="w-full rounded-t-lg transition-all duration-500 cursor-pointer"
                                     style="height:{{ $height }}%;min-height:4px;background:linear-gradient(to top,var(--electric),rgba(245,158,11,0.5));opacity:.85;"
                                     onmouseover="this.style.opacity='1'"
                                     onmouseout="this.style.opacity='.85'">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{-- X Labels --}}
                    <div class="flex gap-3">
                        @foreach($weeklySales as $day)
                        <div class="flex-1 text-center text-[10px] font-bold" style="color:var(--text-muted);">
                            {{ \Carbon\Carbon::parse($day->date)->format('d/m') }}
                        </div>
                        @endforeach
                    </div>

                    {{-- Summary row --}}
                    <div class="flex gap-4 mt-5 pt-4" style="border-top:1px solid var(--border);">
                        <div>
                            <p class="text-[11px]" style="color:var(--text-muted);">إجمالي الأسبوع</p>
                            <p class="text-sm font-black" style="color:var(--electric);">
                                {{ number_format($weeklySales->sum('total'), 0) }} ج.م
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px]" style="color:var(--text-muted);">عدد الطلبات</p>
                            <p class="text-sm font-black" style="color:var(--text);">
                                {{ $weeklySales->sum('count') }} طلب
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px]" style="color:var(--text-muted);">متوسط الطلب</p>
                            <p class="text-sm font-black" style="color:var(--text);">
                                {{ $weeklySales->sum('count') > 0 ? number_format($weeklySales->sum('total') / $weeklySales->sum('count'), 0) : 0 }} ج.م
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ Orders by Status ══ --}}
        <div class="rounded-2xl overflow-hidden"
             style="background:var(--surface);border:1px solid var(--border);">

            <div class="px-5 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                     style="background:rgba(59,130,246,.1);color:#3b82f6;">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h2 class="font-black text-sm" style="color:var(--text);">توزيع الطلبات</h2>
            </div>

            <div class="p-5 space-y-3">
                @php
                $statusConfig = [
                    'pending'    => ['قيد الانتظار', '#f59e0b'],
                    'processing' => ['قيد التجهيز',  '#3b82f6'],
                    'shipped'    => ['تم الشحن',      '#8b5cf6'],
                    'delivered'  => ['تم التسليم',    '#22c55e'],
                    'cancelled'  => ['ملغي',           '#ef4444'],
                ];
                $totalOrdersCount = $ordersByStatus->sum() ?: 1;
                @endphp

                @foreach($statusConfig as $key => [$label, $color])
                @php
                    $count = $ordersByStatus[$key] ?? 0;
                    $pct   = round(($count / $totalOrdersCount) * 100);
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $color }};"></span>
                            <span class="text-xs font-bold" style="color:var(--text-soft);">{{ $label }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black" style="color:var(--text);">{{ $count }}</span>
                            <span class="text-[10px]" style="color:var(--text-muted);">{{ $pct }}%</span>
                        </div>
                    </div>
                    <div class="h-1.5 rounded-full overflow-hidden" style="background:var(--surface2);">
                        <div class="h-full rounded-full transition-all duration-700"
                             style="width:{{ $pct }}%;background:{{ $color }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══ Top Products ══ --}}
    <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">

        <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                 style="background:rgba(34,197,94,.1);color:#22c55e;">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-sm" style="color:var(--text);">أكثر المنتجات مبيعاً</h2>
                <p class="text-xs" style="color:var(--text-muted);">Top 5 منتجات</p>
            </div>
        </div>

        @if($topProducts->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 gap-2">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" style="color:var(--border-hover);">
                    <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                <p class="text-sm" style="color:var(--text-muted);">لا توجد بيانات مبيعات بعد</p>
            </div>
        @else
            @php $maxSold = $topProducts->max('total_sold') ?: 1; @endphp
            <div class="divide-y" style="--tw-divide-opacity:1;border-color:var(--border);">
                @foreach($topProducts as $i => $item)
                <div class="flex items-center gap-4 px-6 py-4">

                    {{-- Rank --}}
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-black flex-shrink-0"
                         style="background:{{ $i === 0 ? 'rgba(245,158,11,.15)' : 'var(--surface2)' }};
                                color:{{ $i === 0 ? 'var(--electric)' : 'var(--text-muted)' }};
                                border:1px solid {{ $i === 0 ? 'rgba(245,158,11,.3)' : 'var(--border)' }};">
                        {{ $i + 1 }}
                    </div>

                    {{-- Product Image --}}
                    @if($item->product?->image_url)
                    <img src="{{ asset('storage/' . $item->product->image_url) }}"
                         alt="{{ $item->product->name }}"
                         class="w-11 h-11 object-cover rounded-xl flex-shrink-0"
                         style="border:1px solid var(--border);">
                    @else
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:var(--surface2);border:1px solid var(--border);">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--border-hover);">
                            <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                    @endif

                    {{-- Info + Bar --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1.5">
                            <p class="text-sm font-black truncate" style="color:var(--text);">
                                {{ $item->product?->name ?? 'منتج محذوف' }}
                            </p>
                            <div class="flex items-center gap-3 flex-shrink-0 mr-4">
                                <span class="text-xs font-bold" style="color:var(--text-soft);">
                                    {{ $item->total_sold }} وحدة
                                </span>
                                <span class="text-sm font-black" style="color:var(--electric);">
                                    {{ number_format($item->revenue, 0) }} ج.م
                                </span>
                            </div>
                        </div>
                        {{-- Progress bar --}}
                        <div class="h-1.5 rounded-full overflow-hidden" style="background:var(--surface2);">
                            <div class="h-full rounded-full transition-all duration-700"
                                 style="width:{{ ($item->total_sold / $maxSold) * 100 }}%;
                                        background:{{ $i === 0 ? 'var(--electric)' : 'rgba(245,158,11,0.4)' }};"></div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </div>

</div>

</x-layout>
