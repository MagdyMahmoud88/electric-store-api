<x-layout title="تفاصيل القسم">
    <div class="p-6 bg-base-200 min-h-screen" dir="rtl" style="font-family:'Cairo', sans-serif;">
        <div class="max-w-4xl mx-auto">

            {{-- الرأس --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">الرابط: /categories/{{ $category->slug }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">← عودة</a>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">تعديل القسم</a>
                </div>
            </div>

            {{-- كروت سريعة --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="card bg-base-100 p-4 border border-base-300 flex flex-row items-center justify-between shadow-sm">
                    <div>
                        <span class="text-gray-500 text-sm">إجمالي المنتجات</span>
                        <h3 class="text-2xl font-bold mt-1">{{ $category->products_count }} منتج</h3>
                    </div>
                    <div class="p-3 bg-primary/10 text-primary rounded-lg text-xl">📦</div>
                </div>

                <div class="card bg-base-100 p-4 border border-base-300 flex flex-row items-center justify-between shadow-sm">
                    <div>
                        <span class="text-gray-500 text-sm">الحالة الحالية</span>
                        <h3 class="text-2xl font-bold mt-1">
                            @if($category->status === 'active')
                                <span class="text-success text-lg">● نشط</span>
                            @else
                                <span class="text-error text-lg">● مخفي</span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-3 bg-base-200 rounded-lg text-xl">🔔</div>
                </div>
            </div>

            {{-- جدول أحدث المنتجات في هذا القسم --}}
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="p-4 border-b border-base-300">
                    <h3 class="font-bold text-lg">أحدث المنتجات المضافة في هذا القسم</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="table w-full text-right">
                        <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>المخزن</th>
                            <th>تاريخ الإضافة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($category->products as $product)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $product->image_url) }}" class="w-10 h-10 rounded-lg object-cover" onerror="this.src='/images/placeholder.png'">
                                        <span class="font-bold">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ number_format($product->price) }} ج.م</td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge badge-success gap-1">{{ $product->stock }} متوفر</span>
                                    @else
                                        <span class="badge badge-error gap-1">نفذ</span>
                                    @endif
                                </td>
                                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">لا توجد منتجات مرتبطة بهذا القسم حالياً.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-layout>
