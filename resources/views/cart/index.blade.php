<x-layout>
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Noto+Sans+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-main: 'Noto Sans Arabic', sans-serif;
            --font-num: 'Inter', sans-serif;
        }
        .font-numbers { font-family: var(--font-num); font-feature-settings: "tnum"; }
        .cart-container { font-family: var(--font-main); }
    </style>
    @endpush

    <div class="min-h-screen bg-base-200/50 py-10 px-4 sm:px-6 cart-container transition-colors duration-300" dir="rtl">
        <div class="max-w-4xl mx-auto">

            {{-- Header هادئ وبسيط --}}
            <div class="flex justify-between items-end mb-10 border-b border-base-content/10 pb-5">
                <div>
                    <h1 class="text-xl font-bold text-base-content tracking-tight">سلة التسوق</h1>
                    <p class="text-base-content/50 text-[10px] mt-1 font-medium italic">لديك {{ count($cart) }} عناصر مختارة</p>
                </div>
                @if(count($cart) > 0)
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="text-base-content/40 hover:text-error text-[9px] uppercase tracking-widest font-bold transition-all">
                        تفريغ السلة
                    </button>
                </form>
                @endif
            </div>

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                    {{-- قائمة المنتجات --}}
                    <div class="lg:col-span-7 space-y-1">
                        @foreach($cart as $id => $details)
                            <div class="group flex items-center gap-4 p-3 bg-base-100 hover:bg-base-200/50 border border-transparent hover:border-base-300 rounded-xl transition-all shadow-sm">

                                {{-- صورة صغيرة جداً وأنيقة --}}
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-base-200 shrink-0">
                                    <img src="{{ $details['image'] ?? asset('images/placeholder.png') }}"
                                         class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity"
                                         onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                </div>

                                {{-- معلومات المنتج --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xs font-semibold text-base-content truncate">{{ $details['name'] }}</h3>
                                    <div class="flex items-center gap-2 text-[10px] text-base-content/50 mt-1">
                                        <span class="font-numbers">{{ number_format($details['price'], 2) }}</span>
                                        <span class="h-0.5 w-0.5 bg-base-content/20 rounded-full"></span>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="hover:text-error transition-colors">إزالة</button>
                                        </form>
                                    </div>
                                </div>

                                {{-- متحكم الكمية Minimal --}}
                                <div class="flex items-center bg-base-200/50 rounded-lg px-1 py-0.5 border border-base-300/50">
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="decrease">
                                        <button class="w-5 h-5 flex items-center justify-center text-base-content/40 hover:text-base-content text-xs" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                    </form>
                                    <span class="font-numbers text-[11px] font-bold w-5 text-center text-base-content">{{ $details['quantity'] }}</span>
                                    <form action="{{ route('cart.update', $id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="increase">
                                        <button class="w-5 h-5 flex items-center justify-center text-base-content/40 hover:text-base-content text-xs">+</button>
                                    </form>
                                </div>

                                {{-- السعر الإجمالي الصغير --}}
                                <div class="text-left min-w-[60px]">
                                    <span class="font-numbers text-xs font-bold text-base-content">
                                        {{ number_format($details['price'] * $details['quantity'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- الملخص (Sidebar) --}}
                    <div class="lg:col-span-5">
                        <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm">
                            <h2 class="text-[10px] font-bold text-base-content/40 uppercase tracking-[0.2em] mb-6">التفاصيل المالية</h2>

                            <div class="space-y-3">
                                <div class="flex justify-between text-[11px] text-base-content/70">
                                    <span>المجموع الفرعي</span>
                                    <span class="font-numbers">{{ number_format($total, 2) }} ج.م</span>
                                </div>
                                <div class="flex justify-between text-[11px] items-center">
                                    <span class="text-base-content/70">الشحن</span>
                                    <span class="text-success font-bold text-[9px] uppercase tracking-wider">مجاني</span>
                                </div>

                                <div class="divider opacity-5 my-2"></div>

                                <div class="flex justify-between items-end">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] text-base-content/40 font-bold uppercase tracking-wider">الإجمالي المستحق</span>
                                        <div class="flex items-baseline gap-1 mt-1">
                                            <span class="font-numbers text-2xl font-semibold text-base-content tracking-tighter">
                                                {{ number_format($total, 2) }}
                                            </span>
                                            <span class="text-[9px] font-bold text-base-content/30 uppercase">EGP</span>
                                        </div>
                                    </div>

                                    <button class="btn btn-neutral btn-sm px-6 rounded-xl font-bold text-[10px] h-10 shadow-lg shadow-neutral/10 transition-transform active:scale-95">
                                        إتمام الدفع
                                    </button>
                                </div>
                            </div>

                            {{-- أيقونات الأمان صغيرة جداً --}}
                            <div class="mt-6 pt-4 border-t border-base-content/5 flex justify-center items-center gap-4 opacity-20 grayscale">
                                <i class="fa-brands fa-cc-visa text-lg"></i>
                                <i class="fa-brands fa-cc-mastercard text-lg"></i>
                                <i class="fa-solid fa-shield-halved text-[10px]"></i>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-24 border-2 border-dashed border-base-300 rounded-[2rem] bg-base-100/50">
                    <div class="mb-4 opacity-5">
                        <i class="fa-solid fa-shopping-cart text-5xl"></i>
                    </div>
                    <h2 class="text-[11px] font-bold text-base-content/30 uppercase tracking-[0.3em] mb-4">السلة فارغة</h2>
                    <a href="{{ route('products.index') }}" class="btn btn-ghost btn-xs text-[9px] uppercase tracking-widest text-primary">
                        العودة للمتجر
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-layout>
