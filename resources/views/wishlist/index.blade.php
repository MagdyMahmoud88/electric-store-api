<x-layout>
    <x-slot name="title">المفضلة</x-slot>

    {{-- ── PAGE HEADER ── --}}
    <section class="bg-base-200 border-b border-base-300 py-8">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-2xl font-bold" style="font-family: 'Cairo', sans-serif;">
                        <i class="fa-solid fa-heart text-error me-2"></i>
                        قائمة المفضلة
                        @if($items->isNotEmpty())
                            <span class="badge badge-error badge-sm ms-2 w-8 align-middle">
                                {{ $items->count() }}
                            </span>
                        @endif
                    </h1>
                    <p class="text-base-content/60 text-sm mt-1">
                        المنتجات التي أضفتها للمفضلة
                    </p>
                </div>

                @if($items->isNotEmpty())
                    <form action="{{ route('wishlist.clear') }}" method="POST"
                          onsubmit="return confirm('هتمسح كل المفضلة؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline btn-error btn-sm gap-2">
                            <i class="fa-solid fa-trash-can fa-sm"></i>
                            مسح الكل
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    {{-- ── MAIN ── --}}
    <section class="container mx-auto px-4 py-10">

        @if($items->isEmpty())
            {{-- حالة الفراغ --}}
            <div class="flex flex-col items-center justify-center py-24 gap-5 text-center">
                <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center">
                    <i class="fa-regular fa-heart text-4xl text-base-content/30"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-1" style="font-family:'Cairo',sans-serif;">
                        المفضلة فارغة
                    </h2>
                    <p class="text-base-content/50 text-sm">
                        لم تضف أي منتجات للمفضلة بعد
                    </p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-primary gap-2">
                    <i class="fa-solid fa-bag-shopping fa-sm"></i>
                    تصفح المنتجات
                </a>
            </div>

        @else
            {{-- شبكة المنتجات --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($items as $item)
                    @php $product = $item->product; @endphp

                    <div class="card bg-base-100 border border-base-300
                                hover:border-primary hover:shadow-lg
                                transition-all duration-200 group"
                         id="wl-card-{{ $product->id }}">

                        {{-- صورة المنتج --}}
                        <figure class="relative overflow-hidden h-52">
                            <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full">
                                <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain bg-white group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </a>

                            {{-- زرار إزالة من المفضلة --}}
                            <form action="{{ route('wishlist.remove', $product->id) }}"
                                  method="POST"
                                  class="absolute top-3 start-3">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        title="إزالة من المفضلة"
                                        class="btn btn-circle btn-sm bg-base-100/90 border-0
                                               hover:bg-error hover:text-white transition-colors">
                                    <i class="fa-solid fa-trash fa-sm"></i>
                                </button>
                            </form>

                            {{-- badge البراند --}}
                            @if($product->brand)
                                <span class="badge badge-ghost badge-sm
                                             absolute bottom-2 end-2
                                             bg-base-100/80 backdrop-blur-sm">
                                    {{ $product->brand->name }}
                                </span>
                            @endif
                        </figure>

                        <div class="card-body p-4 gap-3">

                            {{-- اسم المنتج --}}
                            <a href="{{ route('products.show', $product->id) }}"
                               class="card-title text-sm font-bold leading-snug
                                      hover:text-primary transition-colors line-clamp-2"
                               style="font-family:'Cairo',sans-serif;">
                                {{ $product->name }}
                            </a>

                            {{-- السعر --}}
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-primary font-bold text-lg">
                                    {{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-base-content/50 text-xs">ج.م</span>

                                @if(isset($product->old_price) && $product->old_price > $product->price)
                                    <span class="text-base-content/40 line-through text-xs">
                                        {{ number_format($product->old_price, 2) }}
                                    </span>
                                    <span class="badge badge-error badge-xs">
                                        خصم {{ round((1 - $product->price / $product->old_price) * 100) }}%
                                    </span>
                                @endif
                            </div>

                            {{-- المخزون --}}
                            @php $outOfStock = isset($product->stock) && $product->stock == 0; @endphp

                            @if(isset($product->stock))
                                @if($product->stock > 0)
                                    <span class="text-success text-xs flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check fa-xs"></i>
                                        متوفر في المخزن
                                    </span>
                                @else
                                    <span class="text-error text-xs flex items-center gap-1">
                                        <i class="fa-solid fa-circle-xmark fa-xs"></i>
                                        نفد من المخزن
                                    </span>
                                @endif
                            @endif

                            {{-- زرار السلة --}}
                            <div class="card-actions mt-auto">
                                @if($outOfStock)
                                    <button class="btn btn-sm w-full gap-2 btn-disabled" disabled>
                                        <i class="fa-solid fa-cart-plus fa-sm"></i>
                                        نفد من المخزن
                                    </button>
                                @else
                                    <form action="{{ route('cart.add', $product->id) }}"
                                          method="POST"
                                          style="width:100%">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm w-full gap-2">
                                            <i class="fa-solid fa-cart-plus fa-sm"></i>
                                            أضف للسلة
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-center text-base-content/40 text-sm mt-10">
                إجمالي {{ $items->count() }} منتج في المفضلة
            </p>
        @endif

    </section>
</x-layout>
