<x-layout>
    <x-slot name="title">إدارة الكوبونات</x-slot>

    <div dir="rtl" class="min-h-screen bg-base-200">
        <div class="container mx-auto px-4 py-8">

            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <div>
                    <h1 class="text-2xl font-black" style="font-family:'Cairo',sans-serif;">
                        <i class="fa-solid fa-tag text-warning me-2"></i>
                        إدارة الكوبونات
                    </h1>
                    <p class="text-base-content/50 text-sm mt-1">{{ $coupons->total() }} كوبون</p>
                </div>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-warning font-black gap-2">
                    <i class="fa-solid fa-plus fa-sm"></i>
                    كوبون جديد
                </a>
            </div>

            <div class="card bg-base-100 border border-base-300 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-sm">
                        <thead class="bg-base-200">
                            <tr class="text-xs font-black text-base-content/50">
                                <th>الكود</th>
                                <th>النوع</th>
                                <th>القيمة</th>
                                <th>الحد الأدنى</th>
                                <th>الاستخدام</th>
                                <th>الصلاحية</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr class="hover">
                                    <td>
                                        <span class="font-black tracking-wider badge badge-ghost badge-lg">
                                            {{ $coupon->code }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($coupon->type === 'percentage')
                                            <span class="badge badge-info badge-sm font-bold">نسبة %</span>
                                        @else
                                            <span class="badge badge-secondary badge-sm font-bold">مبلغ ثابت</span>
                                        @endif
                                    </td>
                                    <td class="font-black text-warning">
                                        {{ $coupon->type === 'percentage' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' ج.م' }}
                                        @if($coupon->max_discount)
                                            <br><span class="text-[10px] text-base-content/40 font-normal">بحد {{ number_format($coupon->max_discount, 0) }} ج.م</span>
                                        @endif
                                    </td>
                                    <td class="text-xs">
                                        {{ $coupon->min_order_amount > 0 ? number_format($coupon->min_order_amount, 0) . ' ج.م' : '—' }}
                                    </td>
                                    <td class="text-xs">
                                        <span class="font-bold">{{ $coupon->used_count }}</span>
                                        @if($coupon->usage_limit)
                                            / {{ $coupon->usage_limit }}
                                        @else
                                            / ∞
                                        @endif
                                    </td>
                                    <td class="text-xs text-base-content/50">
                                        @if($coupon->expires_at)
                                            {{ $coupon->expires_at->format('Y/m/d') }}
                                            @if($coupon->expires_at->isPast())
                                                <br><span class="text-error text-[10px]">منتهي</span>
                                            @else
                                                <br><span class="text-success text-[10px]">{{ $coupon->expires_at->diffForHumans() }}</span>
                                            @endif
                                        @else
                                            <span class="text-base-content/30">بلا حد</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="badge {{ $coupon->is_active ? 'badge-success' : 'badge-error' }} font-bold cursor-pointer border-0">
                                                {{ $coupon->is_active ? 'مفعل' : 'موقوف' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="flex gap-1">
                                            <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                               class="btn btn-xs btn-ghost border border-base-300 hover:border-warning hover:text-warning">
                                                <i class="fa-solid fa-pen fa-xs"></i>
                                            </a>
                                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                                  onsubmit="return confirm('هتحذف الكوبون؟')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-xs btn-ghost border border-base-300 hover:border-error hover:text-error">
                                                    <i class="fa-solid fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="flex flex-col items-center py-16 gap-3">
                                            <i class="fa-solid fa-tag text-4xl text-base-content/20"></i>
                                            <p class="text-base-content/40 font-bold">لا توجد كوبونات</p>
                                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-warning btn-sm font-black">
                                                أنشئ أول كوبون
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($coupons->hasPages())
                    <div class="p-4 border-t border-base-300 flex justify-center">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
