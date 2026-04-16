@props(['latestProducts'])

<section class="py-16 px-5 md:px-10 bg-base-100">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">أحدث المنتجات</p>
        <h2 class="font-tajawal font-black mb-3 text-base-content" style="font-size:clamp(22px,3vw,34px);">وصل حديثاً</h2>
        <p class="text-sm text-base-content/40">تشكيلة جديدة من أفضل المنتجات الكهربائية</p>
    </div>

    <div class="max-w-[1300px] mx-auto grid gap-4" style="grid-template-columns:repeat(auto-fill,minmax(230px,1fr));">
        @foreach($latestProducts as $p)
        @php
            $stock = $p->stock;
            $fp = $p->price * (1 - ($p->discount ?? 0)/100);
            $stockClass = $stock > 10 ? 'text-green-600 bg-green-400/10 border-green-400/30'
                        : ($stock > 0  ? 'text-amber-500 bg-amber-400/10 border-amber-400/30' : '');
            $stockLabel = $stock > 10 ? 'متوفر' : ($stock > 0 ? 'محدود' : 'نفذ');
        @endphp
        <div class="reveal delay-{{ ($loop->index % 4) + 1 }} flex flex-col rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 bg-base-200 border border-base-content/10 hover:border-amber-400/30">
            <div class="h-44 relative overflow-hidden bg-base-300">
                <img src="{{ asset('storage/' . $p->image_url) }}" alt="{{ $p->name }}"
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                     onerror="this.src='{{ asset('images/placeholder.png') }}'">
                @if($stock > 0)
                <span class="absolute top-2 right-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $stockClass }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $stock > 10 ? 'bg-green-400' : 'bg-amber-400' }}"></span>
                    {{ $stockLabel }}
                </span>
                @endif
            </div>

            <div class="p-4 flex flex-col flex-1">
                <p class="text-sm font-black mb-1 truncate text-base-content">{{ $p->name }}</p>
                <p class="text-xs leading-relaxed mb-3 flex-1 line-clamp-2 text-base-content/40">{{ $p->description }}</p>

                <div class="flex items-center justify-between pt-3 mb-3 border-t border-base-content/10">
                    <span class="text-lg font-black text-amber-400">
                        {{ number_format($fp, 0) }}
                        <span class="text-[11px] font-normal text-base-content/40">ج.م</span>
                    </span>
                    <span class="text-[11px] text-base-content/40">{{ $stock }} وحدة</span>
                </div>

                <div class="flex gap-2">
                    <form action="{{ route('cart.add', $p->id) }}" method="POST" class="flex-1 flex">
                        @csrf
                        <input type="hidden" name="name"     value="{{ $p->name }}">
                        <input type="hidden" name="price"    value="{{ $fp }}">
                        <input type="hidden" name="image"    value="{{ asset('storage/' . $p->image_url) }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                class="btn btn-sm flex-1 font-black text-[13px] border-0 bg-amber-400 text-neutral hover:bg-amber-300"
                                {{ $stock <= 0 ? 'disabled' : '' }}>
                            {{ $stock <= 0 ? 'نفذ' : 'أضف للسلة' }}
                        </button>
                    </form>
                    <a href="{{ route('products.show', $p->id) }}"
                       class="btn btn-sm btn-square bg-base-300 border border-base-content/10 text-base-content/50 hover:border-amber-400/40 hover:text-amber-400">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-10 reveal">
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl font-bold text-[15px] transition-all duration-300 border border-base-content/10 text-base-content/70 hover:border-amber-400 hover:text-amber-400">
            عرض جميع المنتجات
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    </div>
</section>
