<x-layout>

<div dir="rtl" class="min-h-screen bg-base-200">

    {{-- ══ TICKER ══ --}}
   <x-welcome.ticker/>

    {{-- ══ PAGE HEADER ══ --}}
    <div class="bg-base-100 border-b border-base-300 sticky top-0 z-30 shadow-sm">
        <div class="container mx-auto px-4 pt-4 pb-3">

            {{-- Row 1: Title + Search — same baseline --}}
            <div class="flex items-center gap-4">

                {{-- Mobile filter trigger --}}
                <label for="filter-drawer" class="btn btn-ghost btn-sm btn-square lg:hidden flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                </label>

                {{-- Title block --}}
                <div class="flex-shrink-0">
                    <p class="text-[10px] font-black tracking-widest uppercase text-warning leading-none mb-0.5 hidden sm:block">متجرنا الإلكتروني</p>
                    <h1 class="text-lg sm:text-2xl font-black text-base-content leading-tight">المنتجات الكهربائية</h1>
                    <p class="text-[10px] text-base-content/40 mt-0.5">{{ $products->total() }} منتج متاح</p>
                </div>

                {{-- Divider --}}
                <div class="hidden sm:block w-px h-10 bg-base-300 flex-shrink-0"></div>

                {{-- Search — takes remaining space --}}
                <form method="GET" action="{{ route('products.index') }}"
                      class="flex items-center gap-2 flex-1">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    <label class="input input-bordered flex items-center gap-2 flex-1 h-10">
                        <svg class="w-4 h-4 opacity-40 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="ابحث باسم المنتج أو الماركة..." class="grow min-w-0 text-sm">
                        @if(request('search'))
                            <a href="{{ route('products.index', request()->except('search')) }}"
                               class="opacity-40 hover:opacity-100 transition-opacity flex-shrink-0">✕</a>
                        @endif
                    </label>
                    <button type="submit" class="btn btn-warning font-black h-10 min-h-0 px-5 flex-shrink-0">بحث</button>
                </form>
            </div>

            {{-- Row 2: Category pills — scrollable, no scrollbar --}}
            <div class="flex items-center gap-2 mt-3 overflow-x-auto pb-0.5"
                 style="-webkit-overflow-scrolling:touch;scrollbar-width:none;">
                <style>div::-webkit-scrollbar{display:none}</style>
                <span class="text-[11px] font-bold text-base-content/40 flex-shrink-0 ml-1">تصفية:</span>

                <a href="{{ route('products.index', request()->except('category')) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                          transition-all duration-200 flex-shrink-0 whitespace-nowrap border
                          {{ !request('category')
                             ? 'bg-warning text-warning-content border-warning'
                             : 'bg-base-200 border-base-300 text-base-content/60 hover:border-warning hover:text-warning' }}">
                    الكل
                    <span class="text-[10px] opacity-70">{{ $categories->sum('products_count') }}</span>
                </a>

                @foreach($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->all(), ['category' => $cat->id])) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                              transition-all duration-200 flex-shrink-0 whitespace-nowrap border
                              {{ request('category') == $cat->id
                                 ? 'bg-warning text-warning-content border-warning'
                                 : 'bg-base-200 border-base-300 text-base-content/60 hover:border-warning hover:text-warning' }}">
                        {{ $cat->icon ?? '' }} {{ $cat->name }}
                        <span class="text-[10px] opacity-70">{{ $cat->products_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ DRAWER: mobile overlay + desktop static sidebar ══ --}}
    <div class="drawer lg:drawer-open">
        <input id="filter-drawer" type="checkbox" class="drawer-toggle">

        {{-- ── Main content area ── --}}
        <div class="drawer-content">
            <div class="container mx-auto px-4 py-6">

                {{-- Toolbar --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6
                             pb-4 border-b border-base-300">
                    {{-- Active filter chips --}}
                    <div class="flex items-center gap-2 flex-wrap">
                        @if($activeCategory)
                            <div class="badge badge-warning gap-1 font-bold py-2.5 px-3">
                                {{ $activeCategory->icon ?? '⚡' }} {{ $activeCategory->name }}
                                <a href="{{ route('products.index', request()->except('category')) }}"
                                   class="hover:opacity-60 font-black">✕</a>
                            </div>
                        @endif
                        @if(request('search'))
                            <div class="badge badge-info gap-1 font-bold py-2.5 px-3">
                                🔍 "{{ request('search') }}"
                                <a href="{{ route('products.index', request()->except('search')) }}"
                                   class="hover:opacity-60">✕</a>
                            </div>
                        @endif
                        @if($activeBrand)
                            <div class="badge badge-secondary gap-1 font-bold py-2.5 px-3">
                                🏷️ {{ $activeBrand->name }}
                                <a href="{{ route('products.index', request()->except('brand')) }}"
                                   class="hover:opacity-60">✕</a>
                            </div>
                        @endif
                        <span class="text-xs text-base-content/40 font-semibold">
                            {{ $products->total() }} نتيجة
                        </span>
                    </div>

                    {{-- Sort --}}
                    <form method="GET" action="{{ route('products.index') }}">
                        @foreach(request()->except('sort') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <select name="sort" onchange="this.form.submit()"
                                class="select select-bordered select-sm text-xs font-bold w-40 sm:w-44">
                            <option value="">الأحدث</option>
                            <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>السعر: الأقل أولاً</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>السعر: الأعلى أولاً</option>
                            <option value="name_asc"   {{ request('sort') === 'name_asc'   ? 'selected' : '' }}>الاسم: أ → ي</option>
                        </select>
                    </form>
                </div>

                {{-- Empty state --}}
                @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 gap-4 text-center">
                    <div class="w-20 h-20 rounded-2xl bg-base-100 border border-base-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-base-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                            <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-base font-black">لا توجد منتجات</p>
                    <p class="text-sm text-base-content/50">جرب تغيير كلمة البحث أو الفلتر</p>
                    <a href="{{ route('products.index') }}" class="btn btn-warning btn-sm font-black">عرض كل المنتجات</a>
                </div>

                @else

                {{-- Products Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                    @php
                        $stock      = $product->stock;
                        $finalPrice = number_format($product->price * (1 - ($product->discount ?? 0) / 100), 2);
                        $origPrice  = number_format($product->price, 2);
                        $hasDisc    = ($product->discount ?? 0) > 0;
                    @endphp

                    {{-- card: flex-col so image + body share full height --}}
                    <div class="card bg-base-100 border border-base-300 shadow-sm flex flex-col
                                hover:-translate-y-1 hover:border-warning/50 hover:shadow-lg
                                transition-all duration-300 group overflow-hidden">

                        {{-- ── Image: FIXED height so all cards align ── --}}
                        <figure class="relative overflow-hidden bg-base-200 flex-shrink-0 h-44 sm:h-48">
                            <img src="{{ Storage::url($product->image_url) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full bg-white object-contain p-2 group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('images/placeholder.png') }}'">

                            {{-- TOP-RIGHT: discount --}}
                            @if($hasDisc)
                                <span class="absolute top-2 right-2
                                             bg-error text-error-content text-[10px] font-black
                                             px-2 py-0.5 rounded-full shadow">
                                    -%{{ $product->discount }}
                                </span>
                            @endif

                            {{-- TOP-LEFT: stock status --}}
                            <span class="absolute top-2 left-2
                                         text-[10px] font-bold px-2 py-0.5 rounded-full shadow
                                         backdrop-blur-sm flex items-center gap-1
                                         {{ $stock > 10
                                            ? 'bg-success/20 border border-success/40 text-success'
                                            : ($stock > 0
                                               ? 'bg-warning/20 border border-warning/40 text-warning'
                                               : 'bg-error/20 border border-error/40 text-error') }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                             {{ $stock > 10 ? 'bg-success' : ($stock > 0 ? 'bg-warning animate-pulse' : 'bg-error') }}">
                                </span>
                                {{ $stock > 10 ? 'متوفر' : ($stock > 0 ? 'محدود' : 'نفذ') }}
                            </span>

                            {{-- BOTTOM-RIGHT: category --}}
                            @if($product->category)
                                <span class="absolute bottom-2 right-2 hidden sm:inline-block
                                             bg-base-100/70 backdrop-blur-sm
                                             text-[10px] font-semibold text-base-content/70
                                             px-2 py-0.5 rounded-full border border-base-300/50">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </figure>

                        {{-- ── Body ── --}}
                        <div class="flex flex-col flex-1 p-3 sm:p-4 gap-2">

                            {{-- Name: 2 lines max so short & long names align --}}
                            <h3 class="font-black text-xs sm:text-sm leading-snug line-clamp-2 min-h-[2.4em]">
                                {{ $product->name }}
                            </h3>

                            {{-- Description (desktop only) --}}
                            <p class="hidden sm:block text-[11px] text-base-content/45 leading-relaxed line-clamp-2 flex-1">
                                {{ $product->description }}
                            </p>

                            {{-- ── Price + stock label ── --}}
                            <div class="flex items-end justify-between pt-2 border-t border-base-300 mt-auto">
                                <div>
                                    <p class="text-base sm:text-lg font-black text-warning leading-none">
                                        {{ $finalPrice }}
                                        <span class="text-[10px] font-normal text-base-content/50">ج.م</span>
                                    </p>
                                    @if($hasDisc)
                                        <p class="text-[10px] line-through text-base-content/35 mt-0.5">{{ $origPrice }} ج.م</p>
                                    @endif
                                </div>
                                @if($stock > 0 && $stock <= 10)
                                    <span class="text-[10px] font-black text-warning leading-tight text-left">
                                        ⚠ {{ $stock }}<br>فقط
                                    </span>
                                @endif
                            </div>

                            {{-- ── Actions ── --}}
                            <div class="flex gap-2 mt-1">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1 flex">
                                    @csrf

                                    <input type="hidden" name="name"     value="{{ $product->name }}">
                                    <input type="hidden" name="price"    value="{{ $finalPrice }}">
                                    <input type="hidden" name="image"    value="{{ $product->image_url }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                            class="btn btn-sm flex-1 gap-1.5 font-black text-xs
                                                   {{ $stock > 0 ? 'btn-warning' : 'btn-disabled opacity-50' }}"
                                            {{ $stock <= 0 ? 'disabled' : '' }}>
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="hidden sm:inline">{{ $stock <= 0 ? 'نفذ' : 'أضف للسلة' }}</span>
                                        <span class="sm:hidden">{{ $stock <= 0 ? 'نفذ' : 'سلة' }}</span>
                                    </button>
                                </form>
                                    <x-wishlist-button :product="$product" />
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="btn btn-sm btn-ghost border border-base-300
                                          hover:border-warning hover:text-warning
                                          w-9 p-0 flex-shrink-0 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="flex justify-center mt-8 sm:mt-10">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @endif
                @endif

            </div>
        </div>

        {{-- ── Sidebar ── --}}
        <div class="drawer-side z-40">
            <label for="filter-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

            <aside class="bg-base-100 w-56 min-h-full flex flex-col border-l border-base-300">

                {{-- Header --}}
                <div class="flex items-center justify-between px-4 py-3 border-b border-base-300 flex-shrink-0">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        <span class="text-sm font-black">الفلاتر</span>
                    </div>
                    <label for="filter-drawer" class="btn btn-ghost btn-xs btn-square lg:hidden opacity-50 hover:opacity-100">✕</label>
                </div>

                <div class="flex flex-col flex-1 overflow-y-auto divide-y divide-base-200">

                    {{-- ══ CATEGORIES ══ --}}
                    <div class="py-2">
                        <p class="px-4 pt-1 pb-2 text-[10px] font-black tracking-[.15em] uppercase text-base-content/35">
                            الأقسام
                        </p>
                        @php $noCat = !request('category'); @endphp
                        <a href="{{ route('products.index', request()->except('category')) }}"
                           class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                  {{ $noCat ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content' }}">
                            <span class="w-0.5 h-4 rounded-full transition-all {{ $noCat ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300' }}"></span>
                            <span class="text-sm">📦</span>
                            <span class="flex-1 truncate">جميع المنتجات</span>
                            <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                         {{ $noCat ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40' }}">
                                {{ $categories->sum('products_count') }}
                            </span>
                        </a>
                        @foreach($categories as $cat)
                            @php $cAct = request('category') == $cat->id; @endphp
                            <a href="{{ route('products.index', array_merge(request()->all(), ['category' => $cat->id])) }}"
                               class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                      {{ $cAct ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content' }}">
                                <span class="w-0.5 h-4 rounded-full transition-all {{ $cAct ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300' }}"></span>
                                <span class="text-sm">{{ $cat->icon ?? '⚡' }}</span>
                                <span class="flex-1 truncate">{{ $cat->name }}</span>
                                <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                             {{ $cAct ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40' }}">
                                    {{ $cat->products_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    {{-- ══ BRANDS ══ --}}
                    @if($brands->count() > 0)
                    <div class="py-2" x-data="brandFilter()" x-init="init()">

                        {{-- Section header – click to toggle --}}
                        <button type="button"
                                @click="open = !open"
                                class="w-full flex items-center gap-1.5 px-4 pt-1 pb-2 group">
                            <span class="text-[10px] font-black tracking-[.15em] uppercase text-base-content/35 flex-1 text-right">
                                الماركات
                            </span>
                            @if(request('brand'))
                                <span class="w-1.5 h-1.5 rounded-full bg-warning flex-shrink-0"></span>
                            @endif
                            <svg class="w-3 h-3 text-base-content/30 transition-transform duration-200 flex-shrink-0"
                                 :class="open ? 'rotate-180' : ''"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-collapse>

                            {{-- Search inside brands --}}
                            <div class="px-3 pb-2">
                                <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-base-200 border border-base-300">
                                    <svg class="w-3 h-3 text-base-content/30 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                                    </svg>
                                    <input type="text"
                                           x-model="query"
                                           @input="filter()"
                                           placeholder="ابحث عن ماركة..."
                                           class="grow bg-transparent text-[11px] outline-none text-base-content placeholder:text-base-content/30">
                                    <button x-show="query" @click="query='';filter()"
                                            class="text-base-content/30 hover:text-base-content/60 text-xs leading-none">✕</button>
                                </div>
                            </div>

                            {{-- "الكل" --}}
                            @php $noBrand = !request('brand'); @endphp
                            <a href="{{ route('products.index', request()->except('brand')) }}"
                               class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                      {{ $noBrand ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content' }}">
                                <span class="w-0.5 h-4 rounded-full {{ $noBrand ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300' }}"></span>
                                <span class="flex-1">الكل</span>
                                <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                             {{ $noBrand ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40' }}">
                                    {{ $brands->sum('products_count') }}
                                </span>
                            </a>

                            {{-- Brand items --}}
                            <div id="brand-list" class="max-h-52 overflow-y-auto">
                                @foreach($brands as $brand)
                                    @php $bAct = request('brand') == $brand->id; @endphp
                                    <a href="{{ route('products.index', array_merge(request()->all(), ['brand' => $brand->id])) }}"
                                       data-brand="{{ mb_strtolower($brand->name) }}"
                                       class="brand-item group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                              {{ $bAct ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content' }}">
                                        <span class="w-0.5 h-4 rounded-full {{ $bAct ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300' }}"></span>
                                        <span class="flex-1 truncate">{{ $brand->name }}</span>
                                        <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                                     {{ $bAct ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40' }}">
                                            {{ $brand->products_count }}
                                        </span>
                                    </a>
                                @endforeach

                                {{-- Empty search state --}}
                                <p id="brand-empty"
                                   class="hidden text-center text-[11px] text-base-content/30 py-3 px-4">
                                    لا توجد نتائج
                                </p>
                            </div>

                        </div>
                    </div>
                    @endif

                    {{-- ══ STOCK ══ --}}
                    <div class="py-2">
                        <p class="px-4 pt-1 pb-2 text-[10px] font-black tracking-[.15em] uppercase text-base-content/35">
                            المخزون
                        </p>
                        @foreach([
                            ['all',       '',          'bg-base-content/25', 'جميع المنتجات'],
                            ['available', 'bg-success', 'bg-success/15',     'متوفر فقط'],
                            ['low',       'bg-warning', 'bg-warning/15',     'كمية محدودة'],
                        ] as [$val, $dotBg, $activeBg, $label])
                            @php $sAct = request('stock') === $val; @endphp
                            <a href="{{ route('products.index', array_merge(request()->all(), ['stock' => $val])) }}"
                               class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                      {{ $sAct ? $activeBg . ' font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content' }}
                                      {{ $sAct && $val === 'available' ? 'text-success' : '' }}
                                      {{ $sAct && $val === 'low' ? 'text-warning' : '' }}
                                      {{ $sAct && $val === 'all' ? 'text-base-content' : '' }}">
                                <span class="w-0.5 h-4 rounded-full {{ $sAct ? ($val === 'available' ? 'bg-success' : ($val === 'low' ? 'bg-warning' : 'bg-base-content/40')) : 'bg-transparent group-hover:bg-base-300' }}"></span>
                                <span class="w-2 h-2 rounded-full flex-shrink-0
                                             {{ $dotBg ?: 'bg-base-content/30' }}
                                             {{ $val === 'available' && $sAct ? 'animate-pulse' : '' }}">
                                </span>
                                <span class="flex-1">{{ $label }}</span>
                            </a>
                        @endforeach
                    </div>

                </div>
            </aside>
        </div>
    </div>{{-- /drawer --}}

</div>

<style>
    @keyframes ticker {
        from { transform: translateX(-50%); }
        to   { transform: translateX(0); }
    }
</style>

{{-- Alpine.js (skip if already in layout) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function brandFilter() {
    return {
        open: {{ request('brand') ? 'true' : 'false' }},
        query: '',
        init() {},
        filter() {
            const q = this.query.trim().toLowerCase();
            const items = document.querySelectorAll('.brand-item');
            const empty = document.getElementById('brand-empty');
            let visible = 0;
            items.forEach(el => {
                const name = el.dataset.brand || '';
                const show = !q || name.includes(q);
                el.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            if (empty) empty.classList.toggle('hidden', visible > 0);
        }
    }
}
</script>

</x-layout>
