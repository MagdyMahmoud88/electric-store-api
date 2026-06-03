<x-layout>
    <div dir="rtl" class="min-h-screen bg-base-200 py-8">
        <div class="container mx-auto px-4 max-w-2xl">

            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('orders.show', $order) }}" class="flex items-center gap-1.5 text-sm text-base-content/50 hover:text-base-content mb-3 w-fit">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    رجوع للطلب
                </a>
                <h1 class="text-2xl font-black">طلب إرجاع / ضمان</h1>
                <p class="text-sm text-base-content/50 mt-1">أكمل البيانات وهنتواصل معاك في أقرب وقت</p>
            </div>

            {{-- معلومات المنتج --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
                <div class="card-body p-4 flex flex-row items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-white border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($item->product->image_url)
                            <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain p-1">
                        @endif
                    </div>
                    <div>
                        <p class="font-bold">{{ $item->product_name }}</p>
                        <p class="text-xs text-base-content/50">طلب #{{ $order->id }} • {{ $order->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-warning font-bold mt-0.5">{{ number_format($item->price, 2) }} ج.م</p>
                    </div>
                </div>
            </div>

            {{-- الفورم --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-5 sm:p-6">
                    <form action="{{ route('returns.store', [$order, $item]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- سبب الإرجاع --}}
                        <div class="form-control mb-5">
                            <label class="label pb-1.5">
                                <span class="label-text font-bold">سبب الإرجاع <span class="text-error">*</span></span>
                            </label>
                            <div class="flex flex-col gap-2">
                                @foreach($reasons as $value => $label)
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-base-300 cursor-pointer hover:border-warning transition-colors has-[:checked]:border-warning has-[:checked]:bg-warning/5">
                                        <input type="radio" name="reason" value="{{ $value }}" class="radio radio-warning radio-sm"
                                            {{ old('reason') === $value ? 'checked' : '' }}>
                                        <span class="text-sm font-medium">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('reason')
                            <p class="text-error text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- تفاصيل إضافية --}}
                        <div class="form-control mb-5">
                            <label class="label pb-1.5">
                                <span class="label-text font-bold">تفاصيل إضافية (اختياري)</span>
                            </label>
                            <textarea name="description" rows="3"
                                      placeholder="وصف المشكلة بالتفصيل..."
                                      class="textarea textarea-bordered resize-none text-sm @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-error text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- صور --}}
                        <div class="form-control mb-6">
                            <label class="label pb-1.5">
                                <span class="label-text font-bold">صور توضيحية (اختياري، حتى 4 صور)</span>
                            </label>
                            <input type="file" name="images[]" multiple accept="image/*"
                                   class="file-input file-input-bordered file-input-sm w-full @error('images.*') file-input-error @enderror">
                            <p class="text-xs text-base-content/40 mt-1.5">صور المنتج أو المشكلة — تساعدنا نحل الموضوع أسرع</p>
                            @error('images.*')
                            <p class="text-error text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- تنبيه --}}
                        <div class="alert alert-warning mb-5 text-sm">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-bold">قبل ما تبعت الطلب</p>
                                <p class="text-xs mt-0.5">هنراجع الطلب ونتواصل معاك خلال 24-48 ساعة لتحديد خطوات الإرجاع.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-full font-black">
                            إرسال طلب الإرجاع
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-layout>
