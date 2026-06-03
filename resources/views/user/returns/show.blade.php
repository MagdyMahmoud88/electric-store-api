<x-layout>
    <div dir="rtl" class="min-h-screen bg-base-200 py-8">
        <div class="container mx-auto px-4 max-w-2xl">

            <div class="mb-6">
                <a href="{{ route('returns.index') }}" class="flex items-center gap-1.5 text-sm text-base-content/50 hover:text-base-content mb-3 w-fit">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    طلبات الإرجاع
                </a>
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-black">تفاصيل طلب الإرجاع</h1>
                    <div class="badge badge-{{ $return->statusColor() }} badge-md font-bold">
                        {{ $return->statusLabel() }}
                    </div>
                </div>
            </div>

            {{-- المنتج --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
                <div class="card-body p-4">
                    <p class="text-xs font-black tracking-widest uppercase text-base-content/30 mb-3">المنتج</p>
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-xl bg-white border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if($return->product?->image_url)
                                <img src="{{ asset('storage/' . $return->product->image_url) }}"
                                     alt="{{ $return->product->name }}"
                                     class="w-full h-full object-contain p-1">
                            @endif
                        </div>
                        <div>
                            <p class="font-bold">{{ $return->product->name }}</p>
                            <p class="text-xs text-base-content/50">طلب #{{ $return->order_id }}</p>
                            <p class="text-xs text-warning font-bold mt-0.5">{{ number_format($return->orderItem->price, 2) }} ج.م</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- تفاصيل الطلب --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
                <div class="card-body p-4 gap-3">
                    <p class="text-xs font-black tracking-widest uppercase text-base-content/30">تفاصيل الطلب</p>

                    <div class="flex justify-between text-sm">
                        <span class="text-base-content/50">سبب الإرجاع</span>
                        <span class="font-semibold">{{ $return->reasonLabel() }}</span>
                    </div>

                    @if($return->description)
                        <div class="flex flex-col gap-1 text-sm">
                            <span class="text-base-content/50">التفاصيل</span>
                            <p class="bg-base-200 rounded-lg p-3 text-sm">{{ $return->description }}</p>
                        </div>
                    @endif

                    <div class="flex justify-between text-sm">
                        <span class="text-base-content/50">تاريخ الطلب</span>
                        <span class="font-semibold">{{ $return->created_at->format('d/m/Y - h:i A') }}</span>
                    </div>
                </div>
            </div>

            {{-- الصور --}}
            @if($return->images && count($return->images) > 0)
                <div class="card bg-base-100 border border-base-300 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <p class="text-xs font-black tracking-widest uppercase text-base-content/30 mb-3">الصور المرفقة</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach($return->images as $img)
                                <a href="{{ Storage::url($img) }}" target="_blank">
                                    <img src="{{ Storage::url($img) }} "
                                         class="w-full h-24 object-cover rounded-xl border border-base-300 hover:opacity-80 transition-opacity">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- رد المتجر --}}
            @if($return->admin_note)
                <div class="card border shadow-sm mb-4
                {{ $return->isApproved() ? 'bg-info/10 border-info/30' : '' }}
                {{ $return->isRejected() ? 'bg-error/10 border-error/30' : '' }}
                {{ $return->isCompleted() ? 'bg-success/10 border-success/30' : '' }}
            ">
                    <div class="card-body p-4">
                        <p class="text-xs font-black tracking-widest uppercase text-base-content/30 mb-2">رد المتجر</p>
                        <p class="text-sm">{{ $return->admin_note }}</p>
                    </div>
                </div>
            @endif

            {{-- في الانتظار --}}
            @if($return->isPending())
                <div class="alert alert-warning text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    طلبك قيد المراجعة، هنتواصل معاك خلال 24-48 ساعة.
                </div>
            @endif

        </div>
    </div>
</x-layout>
