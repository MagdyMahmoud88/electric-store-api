{{-- يُستخدم لـ create و edit --}}
<x-layout>
    <x-slot name="title">{{ isset($coupon) ? 'تعديل كوبون' : 'كوبون جديد' }}</x-slot>

    <div dir="rtl" class="min-h-screen bg-base-200">
        <div class="container mx-auto px-4 py-8 max-w-2xl">

            {{-- رأس الصفحة --}}
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.coupons.index') }}"
                   class="btn btn-ghost btn-sm btn-circle border border-base-300">
                    <i class="fa-solid fa-arrow-right fa-sm"></i>
                </a>
                <h1 class="text-2xl font-black" style="font-family:'Cairo',sans-serif;">
                    {{ isset($coupon) ? 'تعديل: ' . $coupon->code : 'كوبون جديد' }}
                </h1>
            </div>

            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <form action="{{ isset($coupon) ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}"
                          method="POST">
                        @csrf
                        @if(isset($coupon)) @method('PUT') @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- الكود --}}
                            <div class="sm:col-span-2">
                                <label class="label"><span class="label-text font-black">كود الكوبون *</span></label>
                                <input type="text" name="code"
                                       value="{{ old('code', $coupon->code ?? '') }}"
                                       placeholder="مثال: SAVE20"
                                       class="input input-bordered w-full uppercase font-black tracking-widest @error('code') input-error @enderror"
                                       style="text-transform:uppercase;">
                                @error('code') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- النوع --}}
                            <div>
                                <label class="label"><span class="label-text font-black">نوع الخصم *</span></label>
                                <select name="type" id="coupon-type"
                                        class="select select-bordered w-full @error('type') select-error @enderror"
                                        onchange="toggleMaxDiscount()">
                                    <option value="percentage" {{ old('type', $coupon->type ?? '') === 'percentage' ? 'selected' : '' }}>
                                        نسبة مئوية %
                                    </option>
                                    <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>
                                        مبلغ ثابت (ج.م)
                                    </option>
                                </select>
                                @error('type') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- القيمة --}}
                            <div>
                                <label class="label"><span class="label-text font-black">قيمة الخصم *</span></label>
                                <input type="number" name="value" step="0.01" min="1"
                                       value="{{ old('value', $coupon->value ?? '') }}"
                                       placeholder="مثال: 20"
                                       class="input input-bordered w-full @error('value') input-error @enderror">
                                @error('value') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- أقصى خصم (للنسبة فقط) --}}
                            <div id="max-discount-field">
                                <label class="label"><span class="label-text font-black">أقصى خصم (ج.م)</span></label>
                                <input type="number" name="max_discount" step="0.01" min="1"
                                       value="{{ old('max_discount', $coupon->max_discount ?? '') }}"
                                       placeholder="اختياري"
                                       class="input input-bordered w-full @error('max_discount') input-error @enderror">
                                @error('max_discount') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- الحد الأدنى للطلب --}}
                            <div>
                                <label class="label"><span class="label-text font-black">الحد الأدنى للطلب (ج.م)</span></label>
                                <input type="number" name="min_order_amount" step="0.01" min="0"
                                       value="{{ old('min_order_amount', $coupon->min_order_amount ?? 0) }}"
                                       placeholder="0 = بلا حد أدنى"
                                       class="input input-bordered w-full">
                            </div>

                            {{-- عدد مرات الاستخدام الكلي --}}
                            <div>
                                <label class="label"><span class="label-text font-black">عدد مرات الاستخدام الكلي</span></label>
                                <input type="number" name="usage_limit" min="1"
                                       value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"
                                       placeholder="اتركه فارغاً = غير محدود"
                                       class="input input-bordered w-full">
                            </div>

                            {{-- مرات لكل يوزر --}}
                            <div>
                                <label class="label"><span class="label-text font-black">الاستخدام لكل مستخدم *</span></label>
                                <input type="number" name="usage_limit_per_user" min="1"
                                       value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? 1) }}"
                                       class="input input-bordered w-full @error('usage_limit_per_user') input-error @enderror">
                                @error('usage_limit_per_user') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- تاريخ البداية --}}
                            <div>
                                <label class="label"><span class="label-text font-black">تاريخ البداية</span></label>
                                <input type="datetime-local" name="starts_at"
                                       value="{{ old('starts_at', isset($coupon) && $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}"
                                       class="input input-bordered w-full">
                            </div>

                            {{-- تاريخ الانتهاء --}}
                            <div>
                                <label class="label"><span class="label-text font-black">تاريخ الانتهاء</span></label>
                                <input type="datetime-local" name="expires_at"
                                       value="{{ old('expires_at', isset($coupon) && $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}"
                                       class="input input-bordered w-full">
                            </div>

                            {{-- الحالة (تفعيل/تعطيل) --}}
                            <div class="sm:col-span-2">
                                <label class="label cursor-pointer justify-start gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="toggle toggle-warning"
                                           {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
                                    <span class="label-text font-black">الكوبون مفعل حالياً</span>
                                </label>
                            </div>

                        </div>

                        {{-- أزرار التحكم --}}
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-base-300">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-ghost font-bold">إلغاء</a>
                            <button type="submit" class="btn btn-warning font-black gap-2">
                                <i class="fa-solid fa-{{ isset($coupon) ? 'floppy-disk' : 'plus' }} fa-sm"></i>
                                {{ isset($coupon) ? 'حفظ التعديلات' : 'إنشاء الكوبون' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleMaxDiscount() {
            const type  = document.getElementById('coupon-type').value;
            const field = document.getElementById('max-discount-field');
            // إخفاء حقل أقصى خصم إذا كان النوع "مبلغ ثابت"
            field.style.display = type === 'percentage' ? 'block' : 'none';
        }
        // التشغيل عند تحميل الصفحة لضبط الحالة الابتدائية
        document.addEventListener('DOMContentLoaded', toggleMaxDiscount);
    </script>
    @endpush
</x-layout>