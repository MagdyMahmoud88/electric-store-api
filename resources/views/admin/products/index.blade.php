<x-layout>
    <div dir="rtl" class="p-6 min-h-screen bg-base-200">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 bg-base-100 p-6 rounded-2xl shadow-sm border border-base-300">
            <div>
                <h1 class="text-2xl font-black text-base-content">إدارة المنتجات</h1>
                <p class="text-sm text-base-content/50">إجمالي {{ $products->total() }} منتج في المتجر</p>
            </div>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary font-black px-6">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة منتج
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm gap-2 self-center">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    لوحة التحكم
                </a>
            </div>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="alert alert-success mb-4 text-sm font-bold rounded-xl">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
            @foreach([
                ['إجمالي المنتجات', $stats['total'],    'text-primary',      'bg-primary/10',  null],
                ['نشط',             $stats['active'],   'text-success',      'bg-success/10',  'active'],
                ['موقوف',           $stats['inactive'], 'text-warning',      'bg-warning/10',  'inactive'],
                ['مخزون منخفض',    $stats['low_stock'], 'text-orange-400',  'bg-orange-400/10','low'],
                ['نفذ المخزون',     $stats['out_stock'], 'text-error',       'bg-error/10',    'out'],
            ] as [$label, $val, $color, $bg, $filter])
                <a href="{{ $filter ? route('admin.products.index', array_filter(['status' => in_array($filter, ['active','inactive']) ? $filter : null, 'stock' => in_array($filter, ['low','out']) ? $filter : null])) : route('admin.products.index') }}"
                   class="bg-base-100 border border-base-300 rounded-xl px-4 py-3 flex items-center gap-3 hover:-translate-y-1 transition-all duration-200">
                    <div class="w-9 h-9 rounded-lg {{ $bg }} flex items-center justify-center flex-shrink-0">
                        <span class="text-base font-black {{ $color }}">{{ $val }}</span>
                    </div>
                    <p class="text-[11px] text-base-content/50 font-semibold">{{ $label }}</p>
                </a>
            @endforeach
        </div>

        {{-- Filters --}}
        <div class="bg-base-100 border border-base-300 rounded-2xl p-4 mb-4">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3 items-end">

                <div class="flex-1 min-w-40">
                    <label class="label py-0 mb-1"><span class="label-text text-xs font-bold">بحث</span></label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="اسم المنتج أو الماركة..."
                           class="input input-bordered input-sm w-full">
                </div>

                <div>
                    <label class="label py-0 mb-1"><span class="label-text text-xs font-bold">القسم</span></label>
                    <select name="category" class="select select-bordered select-sm">
                        <option value="">كل الأقسام</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label py-0 mb-1"><span class="label-text text-xs font-bold">الماركة</span></label>
                    <select name="brand" class="select select-bordered select-sm">
                        <option value="">كل الماركات</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }} ({{ $brand->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label py-0 mb-1"><span class="label-text text-xs font-bold">المخزون</span></label>
                    <select name="stock" class="select select-bordered select-sm">
                        <option value="">الكل</option>
                        <option value="available" {{ request('stock') === 'available' ? 'selected' : '' }}>متوفر (+10)</option>
                        <option value="low"       {{ request('stock') === 'low'       ? 'selected' : '' }}>منخفض (1-10)</option>
                        <option value="out"       {{ request('stock') === 'out'       ? 'selected' : '' }}>نفذ</option>
                    </select>
                </div>

                <div>
                    <label class="label py-0 mb-1"><span class="label-text text-xs font-bold">الحالة</span></label>
                    <select name="status" class="select select-bordered select-sm">
                        <option value="">الكل</option>
                        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>موقوف</option>
                    </select>
                </div>

                <div>
                    <label class="label py-0 mb-1"><span class="label-text text-xs font-bold">ترتيب</span></label>
                    <select name="sort" class="select select-bordered select-sm">
                        <option value="">الأحدث</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>السعر: الأقل</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>السعر: الأعلى</option>
                        <option value="name_asc"   {{ request('sort') === 'name_asc'   ? 'selected' : '' }}>الاسم أبجدياً</option>
                        <option value="stock_asc"  {{ request('sort') === 'stock_asc'  ? 'selected' : '' }}>المخزون: الأقل</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-sm btn-primary font-bold">فلتر</button>

                @if(request()->hasAny(['search','category','brand','stock','status','sort']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-ghost border border-base-300">مسح</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-base-100 rounded-2xl shadow-sm border border-base-300 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-right">
                    <thead class="bg-base-200">
                    <tr class="text-base-content/70">
                        <th class="font-black">المنتج</th>
                        <th class="font-black">القسم / الماركة</th>
                        <th class="font-black">السعر</th>
                        <th class="font-black">المخزون</th>
                        <th class="font-black text-center">الحالة</th>
                        <th class="font-black text-center">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            {{-- المنتج --}}
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12 bg-base-200">
                                            @if($product->image_url)
                                                <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-xl">⚡</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm">{{ $product->name }}</div>
                                        <div class="text-xs opacity-40">#{{ $product->id }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- القسم / الماركة --}}
                            <td>
                                <div class="flex flex-col gap-1">
                                <span class="badge badge-ghost badge-sm font-bold">
                                    {{ $product->category->name ?? 'غير مصنف' }}
                                </span>
                                    @if($product->brand)
                                        <span class="text-xs text-base-content/40">{{ $product->brand->name }}</span>
                                    @endif
                                </div>
                            </td>

                            {{-- السعر --}}
                            <td>
                                @if($product->effective_discount > 0)
                                    <div class="flex flex-col">
                                        <span class="line-through text-xs opacity-40">{{ number_format($product->price, 0) }} ج.م</span>
                                        <span class="font-black text-sm text-warning">{{ number_format($product->final_price, 0) }} ج.م</span>
                                        <span class="badge badge-error badge-xs w-fit">-{{ $product->effective_discount }}%</span>
                                    </div>
                                @else
                                    <span class="font-black text-sm">{{ number_format($product->price, 0) }} ج.م</span>
                                @endif
                            </td>

                            {{-- المخزون --}}
                            <td>
                                <div class="flex flex-col gap-1">
                                <span class="font-bold text-sm
                                    {{ $product->stock == 0 ? 'text-error' : ($product->stock <= 10 ? 'text-warning' : '') }}">
                                    {{ $product->stock }} قطعة
                                </span>
                                    <progress
                                        class="progress w-16
                                        {{ $product->stock == 0 ? 'progress-error' : ($product->stock <= 10 ? 'progress-warning' : 'progress-success') }}"
                                        value="{{ min($product->stock, 100) }}"
                                        max="100">
                                    </progress>
                                </div>
                            </td>

                            {{-- ✅ الحالة مع Toggle --}}
                            <td class="text-center">
                                <div class="flex flex-col items-center gap-1">

                                    {{-- Toggle is_active --}}
                                    <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                class="badge cursor-pointer border-0 font-bold text-xs py-2 px-3 transition-all hover:opacity-70"
                                                style="background:{{ $product->is_active ? 'rgba(34,197,94,.15)' : 'rgba(107,114,128,.15)' }};
                                               color:{{ $product->is_active ? '#86efac' : '#9ca3af' }};"
                                                title="اضغط لتغيير الحالة">
                                            {{ $product->is_active ? '● نشط' : '● موقوف' }}
                                        </button>
                                    </form>

                                    {{-- Stock status --}}
                                    @if($product->stock == 0)
                                        <span class="badge badge-error badge-xs font-bold">نفذ</span>
                                    @elseif($product->stock <= 10)
                                        <span class="badge badge-warning badge-xs font-bold">منخفض</span>
                                    @endif
                                </div>
                            </td>

                            {{-- الإجراءات --}}
                            <td>
                                <div class="flex justify-center gap-1">

                                    {{-- تعديل --}}
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="btn btn-square btn-ghost btn-sm text-info border border-base-300"
                                       title="تعديل">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>

                                    {{-- عرض في الموقع --}}
                                    <a href="{{ route('products.show', $product) }}" target="_blank"
                                       class="btn btn-square btn-ghost btn-sm text-success border border-base-300"
                                       title="عرض في الموقع">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    {{-- حذف --}}
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من حذف {{ addslashes($product->name) }}؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-square btn-ghost btn-sm text-error border border-base-300"
                                                title="حذف">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <div class="flex flex-col items-center gap-3 opacity-40">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="font-bold text-sm">لا توجد منتجات مطابقة</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-ghost border border-base-300">عرض الكل</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="p-4 bg-base-200/50 border-t border-base-300">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- Toast --}}
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

</x-layout>
