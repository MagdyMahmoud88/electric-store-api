<x-layout>

<div class="page-container py-10" dir="rtl" style="font-family:'Cairo',sans-serif;">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.orders.index') }}"
                   class="text-sm font-bold transition-colors"
                   style="color:var(--text-muted);"
                   onmouseover="this.style.color='var(--electric)'"
                   onmouseout="this.style.color='var(--text-muted)'">
                    الطلبات
                </a>
                <span style="color:var(--border-hover);">/</span>
                <span class="text-sm font-bold" style="color:var(--text);">
                    #{{ substr($order->id, 0, 8) }}
                </span>
            </div>
            <h1 class="text-2xl font-black" style="color:var(--text);">تفاصيل الطلب</h1>
        </div>

        <div class="flex items-center gap-3">
            {{-- Print --}}
            <button onclick="window.print()"
                    class="btn btn-sm gap-2 font-bold"
                    style="background:var(--surface2);border-color:var(--border);color:var(--text-soft);"
                    onmouseover="this.style.borderColor='var(--electric)';this.style.color='var(--electric)'"
                    onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-soft)'">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                طباعة
            </button>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm gap-2">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                رجوع
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div id="toast" class="toast toast-top toast-center z-50">
        <div class="alert alert-success shadow-lg">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    </div>
    <script>setTimeout(() => document.getElementById('toast')?.remove(), 3000);</script>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ══ Main: Order Items ══ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Items Table --}}
            <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid var(--border);">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                         style="background:var(--electric-dim);color:var(--electric);">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h2 class="font-black text-sm" style="color:var(--text);">
                        المنتجات ({{ $order->orderItems->sum('quantity') }} عنصر)
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="table w-full text-sm">
                        <thead>
                            <tr style="background:var(--surface2);color:var(--text-soft);">
                                <th class="font-black text-right py-3 px-5">المنتج</th>
                                <th class="font-black text-right py-3 px-5">السعر</th>
                                <th class="font-black text-right py-3 px-5">الكمية</th>
                                <th class="font-black text-right py-3 px-5">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr style="border-bottom:1px solid var(--border);">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        @if($item->product?->image_url)
                                        <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-12 h-12 object-cover rounded-xl flex-shrink-0"
                                             style="border:1px solid var(--border);">
                                        @else
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                                             style="background:var(--surface2);border:1px solid var(--border);">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--border-hover);">
                                                <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                            </svg>
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-xs" style="color:var(--text);">
                                                {{ $item->product?->name ?? 'منتج محذوف' }}
                                            </p>
                                            @if($item->product?->category)
                                            <p class="text-[11px]" style="color:var(--text-muted);">
                                                {{ $item->product->category->name }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="text-xs font-bold" style="color:var(--text-soft);">
                                        {{ number_format($item->price, 2) }} ج.م
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="badge badge-ghost badge-sm font-bold">{{ $item->quantity }}</span>
                                </td>
                                <td class="py-4 px-5">
                                    <span class="font-black text-sm" style="color:var(--electric);">
                                        {{ number_format($item->price * $item->quantity, 2) }} ج.م
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Total --}}
                <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid var(--border);background:var(--surface2);">
                    <span class="font-black text-sm" style="color:var(--text-soft);">إجمالي الطلب</span>
                    <span class="font-black text-xl" style="color:var(--electric);">
                        {{ number_format($order->total, 2) }} ج.م
                    </span>
                </div>
            </div>

            {{-- Notes --}}
            @if($order->notes)
            <div class="rounded-2xl p-5" style="background:var(--surface);border:1px solid var(--border);">
                <div class="flex items-center gap-2 mb-3">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--electric);">
                        <path stroke-linecap="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <h3 class="font-black text-sm" style="color:var(--text);">ملاحظات العميل</h3>
                </div>
                <p class="text-sm leading-relaxed" style="color:var(--text-soft);">{{ $order->notes }}</p>
            </div>
            @endif

        </div>

        {{-- ══ Sidebar ══ --}}
        <div class="space-y-5">

            {{-- Order Info --}}
            <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                    <h3 class="font-black text-sm" style="color:var(--text);">معلومات الطلب</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs" style="color:var(--text-muted);">رقم الطلب</span>
                        <span class="font-mono text-xs font-bold" style="color:var(--text);">
                            #{{ substr($order->id, 0, 8) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs" style="color:var(--text-muted);">تاريخ الطلب</span>
                        <span class="text-xs font-bold" style="color:var(--text);">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs" style="color:var(--text-muted);">آخر تحديث</span>
                        <span class="text-xs font-bold" style="color:var(--text);">
                            {{ $order->updated_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-2" style="border-top:1px solid var(--border);">
                        <span class="text-xs" style="color:var(--text-muted);">الحالة الحالية</span>
                        <span class="badge badge-{{ $order->status_color }} badge-sm font-bold">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Change Status --}}
            <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                    <h3 class="font-black text-sm" style="color:var(--text);">تغيير الحالة</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-3">
                        @csrf @method('PATCH')

                        @php
                        $statuses = [
                            'pending'    => 'قيد الانتظار',
                            'processing' => 'قيد التجهيز',
                            'shipped'    => 'تم الشحن',
                            'delivered'  => 'تم التسليم',
                            'cancelled'  => 'ملغي',
                        ];
                        @endphp

                        <div class="space-y-2">
                            @foreach($statuses as $key => $label)
                            <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-150"
                                   style="background:{{ $order->status === $key ? 'var(--electric-dim)' : 'var(--surface2)' }};
                                          border:1px solid {{ $order->status === $key ? 'rgba(245,158,11,.3)' : 'var(--border)' }};">
                                <input type="radio" name="status" value="{{ $key }}"
                                       class="radio radio-sm"
                                       style="--chkbg:var(--electric);"
                                       {{ $order->status === $key ? 'checked' : '' }}>
                                <span class="text-sm font-bold" style="color:{{ $order->status === $key ? 'var(--electric)' : 'var(--text-soft)' }};">
                                    {{ $label }}
                                </span>
                            </label>
                            @endforeach
                        </div>

                        <button type="submit"
                                class="btn btn-sm w-full font-black mt-2"
                                style="background:var(--electric);color:#070810;border:none;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            حفظ الحالة
                        </button>
                    </form>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="rounded-2xl overflow-hidden" style="background:var(--surface);border:1px solid var(--border);">
                <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                    <h3 class="font-black text-sm" style="color:var(--text);">بيانات العميل</h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center font-black text-base flex-shrink-0"
                             style="background:var(--electric-dim);color:var(--electric);border:1px solid rgba(245,158,11,.25);">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-black text-sm" style="color:var(--text);">{{ $order->user->name }}</p>
                            <p class="text-xs" style="color:var(--text-muted);">{{ $order->user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 pt-3" style="border-top:1px solid var(--border);">
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color:var(--text-muted);">إجمالي طلباته</span>
                            <span class="text-xs font-black" style="color:var(--text);">
                                {{ $order->user->orders()->count() }} طلب
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color:var(--text-muted);">عضو منذ</span>
                            <span class="text-xs font-bold" style="color:var(--text);">
                                {{ $order->user->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Print styles --}}
<style>
@media print {
    .main-navbar, .main-footer, .btn, form, a[href] { display: none !important; }
    body { background: white !important; color: black !important; }
    .page-container { padding: 0 !important; }
    * { border-color: #ddd !important; color: black !important; background: white !important; }
    .font-black { color: black !important; }
}
</style>

</x-layout>
