<x-layout>
    <div dir="rtl" class="min-h-screen bg-base-200 py-8">
        <div class="container mx-auto px-4 max-w-4xl">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-black">طلبات الإرجاع والضمان</h1>
                    <p class="text-sm text-base-content/50 mt-1">تابع حالة طلبات الإرجاع بتاعتك</p>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    طلباتي
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($returns->isEmpty())
                {{-- Empty State --}}
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body items-center text-center py-16">
                        <div class="w-16 h-16 rounded-2xl bg-base-200 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                            </svg>
                        </div>
                        <p class="font-black text-lg">مفيش طلبات إرجاع</p>
                        <p class="text-sm text-base-content/50">لو محتاج ترجع منتج، افتح الطلب وهتلاقي زرار الإرجاع</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-warning btn-sm mt-4 font-bold">عرض طلباتي</a>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-4">
                    @foreach($returns as $return)
                        <div class="card bg-base-100 border border-base-300 shadow-sm hover:border-warning/30 transition-colors">
                            <div class="card-body p-4 sm:p-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">

                                    {{-- معلومات المنتج --}}
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-white border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                                            @if($return->product->image_url)
                                                <img src="{{ $return->product->image_url }}" alt="{{ $return->product->name }}" class="w-full h-full object-contain p-1">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm">{{ $return->product->name }}</p>
                                            <p class="text-xs text-base-content/50">طلب #{{ $return->order_id }}</p>
                                            <p class="text-xs text-base-content/40 mt-0.5">{{ $return->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    {{-- الحالة --}}
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="badge badge-{{ $return->statusColor() }} badge-sm font-bold">
                                            {{ $return->statusLabel() }}
                                        </div>
                                        <a href="{{ route('returns.show', $return) }}" class="btn btn-ghost btn-xs">التفاصيل ←</a>
                                    </div>
                                </div>

                                {{-- السبب --}}
                                <div class="mt-3 pt-3 border-t border-base-200 flex items-center gap-2">
                                    <span class="text-xs text-base-content/40">السبب:</span>
                                    <span class="text-xs font-semibold">{{ $return->reasonLabel() }}</span>
                                </div>

                                {{-- ملاحظة الأدمن --}}
                                @if($return->admin_note)
                                    <div class="mt-2 p-2.5 rounded-lg bg-base-200 text-xs text-base-content/70">
                                        <span class="font-bold">رد المتجر:</span> {{ $return->admin_note }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($returns->hasPages())
                    <div class="flex justify-center mt-6">
                        {{ $returns->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layout>
