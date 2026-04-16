@props(['categories'])

<section class="py-16 px-5 md:px-10 bg-base-200">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">تصفح الأقسام</p>
        <h2 class="font-tajawal font-black text-base-content" style="font-size:clamp(22px,3vw,34px);">كل ما تحتاجه هنا</h2>
    </div>
    <div class="max-w-[1300px] mx-auto grid gap-3" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));">
        @foreach($categories as $cat)
        <a href="{{ route('products.index', ['category' => $cat->id]) }}"
           class="reveal flex flex-col items-center gap-3 rounded-2xl p-6 text-center no-underline transition-all duration-300 hover:-translate-y-1 bg-base-100 border border-base-content/10 hover:border-amber-400/30 hover:bg-base-300">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl bg-amber-400/10 border border-amber-400/20">
                {{ $cat->icon ?? '⚡' }}
            </div>
            <p class="text-sm font-bold text-base-content">{{ $cat->name }}</p>
            <p class="text-[11px] text-base-content/40">{{ $cat->products_count }} منتج</p>
        </a>
        @endforeach
    </div>
</section>
