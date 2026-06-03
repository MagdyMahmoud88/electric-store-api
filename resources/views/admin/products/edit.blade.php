<x-layout>

{{-- ── Delete form منفصل تماماً خارج form التعديل ── --}}
<form action="{{ route('admin.products.destroy', $product->id) }}"
      method="POST"
      id="deleteForm"
      onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
    @csrf
    @method('DELETE')
</form>

<div class="page-container py-10">

    {{-- Errors --}}
    @if($errors->any())
        <div role="alert" class="alert alert-error mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-base-content">تعديل المنتج</h1>
            <p class="text-sm mt-1" style="color:var(--text-muted)">{{ $product->name }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-ghost btn-sm gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            رجوع
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ── Main form ── --}}
        <div class="lg:col-span-2">
            <form action="{{ route('admin.products.update', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="editForm">
                @csrf
                @method('PUT')

                {{-- ── المعلومات الأساسية ── --}}
                <div class="card mb-6" style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                    <div class="card-body gap-5">

                        <div class="flex items-center gap-3 pb-3" style="border-bottom:1px solid var(--border);">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm"
                                 style="background:var(--electric-dim);color:var(--electric);">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-black tracking-widest uppercase" style="color:var(--text-muted);">المعلومات الأساسية</span>
                        </div>

                        {{-- Name + Category --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-control gap-1">
                                <label class="label py-0">
                                    <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">
                                        اسم المنتج <span style="color:var(--electric);">*</span>
                                    </span>
                                </label>
                                <input type="text"
                                       name="name"
                                       id="f_name"
                                       class="input input-bordered w-full"
                                       style="background:var(--surface2);border-color:var(--border);color:var(--text);"
                                       value="{{ old('name', $product->name) }}"
                                       required>
                            </div>
                            <div class="form-control gap-1">
                                <label class="label py-0">
                                    <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">
                                        التصنيف <span style="color:var(--electric);">*</span>
                                    </span>
                                </label>
                                <select name="category_id"
                                        id="f_cat"
                                        class="select select-bordered w-full"
                                        style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                                    <option value="" disabled>اختر القسم...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Stock --}}
                        <div class="form-control gap-1">
                            <label class="label py-0">
                                <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">الكمية المتوفرة</span>
                            </label>
                            <input type="number"
                                   name="stock"
                                   id="f_stock"
                                   class="input input-bordered w-full"
                                   style="background:var(--surface2);border-color:var(--border);color:var(--text);"
                                   value="{{ old('stock', $product->stock) }}">
                        </div>

                        {{-- Description --}}
                        <div class="form-control gap-1">
                            <label class="label py-0">
                                <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">وصف المنتج</span>
                            </label>
                            <textarea name="description"
                                      id="f_desc"
                                      rows="4"
                                      class="textarea textarea-bordered w-full leading-relaxed"
                                      style="background:var(--surface2);border-color:var(--border);color:var(--text);resize:vertical;">{{ old('description', $product->description) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- ── التسعير ── --}}
                <div class="card mb-6" style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                    <div class="card-body gap-5">

                        <div class="flex items-center gap-3 pb-3" style="border-bottom:1px solid var(--border);">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm"
                                 style="background:var(--electric-dim);color:var(--electric);">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-black tracking-widest uppercase" style="color:var(--text-muted);">التسعير</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-control gap-1">
                                <label class="label py-0">
                                    <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">
                                        السعر الأصلي <span style="color:var(--electric);">*</span>
                                    </span>
                                </label>
                                <label class="input input-bordered flex items-center gap-2 w-full"
                                       style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                                    <span class="text-xs font-black shrink-0" style="color:var(--text-muted);">EGP</span>
                                    <input type="number"
                                           name="price"
                                           id="f_price"
                                           step="0.01"
                                           class="grow"
                                           style="background:transparent;outline:none;color:var(--text);"
                                           value="{{ old('price', $product->price) }}"
                                           required>
                                </label>
                            </div>
                            <div class="form-control gap-1">
                                <label class="label py-0">
                                    <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">نسبة الخصم (%)</span>
                                </label>
                                <label class="input input-bordered flex items-center gap-2 w-full"
                                       style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                                    <span class="text-xs font-black shrink-0" style="color:var(--text-muted);">%</span>
                                    <input type="number"
                                           name="discount_percentage"
                                           id="f_discount_percentage"
                                           min="0"
                                           max="100"
                                           class="grow"
                                           style="background:transparent;outline:none;color:var(--text);"
                                           value="{{ old('discount_percentage', $product->discount_percentage ?? 0) }}">
                                </label>
                            </div>
                        </div>

                        {{-- Price result --}}
                        <div id="priceResult"
                             class="hidden rounded-xl px-4 py-3 flex items-center justify-between text-sm"
                             style="background:var(--electric-dim);border:1px solid var(--electric-glow);">
                            <span style="color:var(--text-soft);">السعر بعد الخصم</span>
                            <div class="flex items-center gap-3">
                                <span id="originalPriceStr" class="line-through" style="color:var(--text-muted);"></span>
                                <strong id="finalPriceStr" class="text-lg font-black" style="color:var(--electric);"></strong>
                                <span id="discountPill"
                                      class="hidden badge badge-sm border"
                                      style="background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);color:#fca5a5;font-weight:700;"></span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── صورة المنتج ── --}}
                <div class="card mb-6" style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">
                    <div class="card-body gap-5">

                        <div class="flex items-center gap-3 pb-3" style="border-bottom:1px solid var(--border);">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm"
                                 style="background:var(--electric-dim);color:var(--electric);">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-black tracking-widest uppercase" style="color:var(--text-muted);">صورة المنتج</span>
                        </div>

                        @if($product->image_url)
                            <div class="flex items-center gap-4 p-3 rounded-xl"
                                 style="background:var(--surface2);border:1px solid var(--border);">
                                <img src="{{ asset('storage/' . $product->image_url) }}"
                                     alt="{{ $product->name }}"
                                     class="w-16 h-16 object-cover rounded-lg"
                                     style="border:1px solid var(--border);">
                                <div>
                                    <p class="text-sm font-semibold mb-1" style="color:var(--text-soft);">الصورة الحالية</p>
                                    <p class="text-xs" style="color:var(--text-muted);">اتركه فارغاً للاحتفاظ بها — أو ارفع صورة جديدة لاستبدالها</p>
                                </div>
                            </div>
                        @endif

                        <label class="flex flex-col items-center justify-center gap-3 p-6 rounded-xl cursor-pointer transition-all duration-200 relative"
                               style="border:2px dashed var(--border);"
                               id="uploadZone">
                            <input type="file"
                                   name="images[]"
                                   id="imageInput"
                                   accept="image/*"
                                   multiple
                                   class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                 style="background:var(--electric-dim);color:var(--electric);">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-semibold" style="color:var(--text);">رفع صورة جديدة <span style="color:var(--text-muted);">(اختياري)</span></p>
                                <p class="text-xs mt-1" style="color:var(--text-muted);">PNG / JPG / WEBP</p>
                            </div>
                        </label>

                        <div id="thumbsGrid" class="grid gap-2" style="grid-template-columns:repeat(auto-fill,minmax(80px,1fr));"></div>

                    </div>
                </div>

                {{-- ── Footer Buttons ── --}}
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <button type="submit"
                            form="deleteForm"
                            class="btn btn-error btn-outline btn-sm gap-2">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        حذف المنتج
                    </button>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">إلغاء</a>
                        <button type="submit" class="btn btn-sm gap-2 font-black"
                                style="background:var(--electric);color:#070810;border-color:var(--electric);">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            حفظ التعديلات
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- ── Preview card ── --}}
        <div class="lg:col-span-1">
            <div class="card sticky top-24 overflow-hidden"
                 style="background:var(--surface);border:1px solid var(--border);border-radius:16px;">

                <div class="px-5 py-4" style="border-bottom:1px solid var(--border);">
                    <p class="text-xs font-black tracking-widest uppercase" style="color:var(--text-muted);">معاينة المنتج</p>
                </div>

                {{-- Preview image --}}
                <div class="h-52 flex items-center justify-center overflow-hidden"
                     style="background:var(--surface2);">
                    <img id="previewImg"
                         src="{{ $product->image_url ? asset('storage/' . $product->image_url) : '' }}"
                         class="w-full h-full object-contain"
                         style="{{ $product->image_url ? '' : 'display:none' }}"
                         alt="">
                    <div id="noImgPlaceholder"
                         style="{{ $product->image_url ? 'display:none' : '' }}"
                         class="flex flex-col items-center gap-2">
                        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                             style="color:var(--border-hover);">
                            <path stroke-linecap="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs" style="color:var(--text-muted);">لا توجد صورة</span>
                    </div>
                </div>

                {{-- Preview body --}}
                <div class="p-5 space-y-3">
                    <h3 id="pName" class="text-lg font-black" style="color:var(--text);">{{ $product->name }}</h3>

                    <div id="pCat"
                         class="inline-flex items-center gap-2 text-xs"
                         style="color:var(--text-muted);">
                        <span class="w-1.5 h-1.5 rounded-full inline-block" style="background:var(--electric);"></span>
                        {{ $product->category->name ?? 'القسم' }}
                    </div>

                    <p id="pDesc" class="text-xs leading-relaxed" style="color:var(--text-soft);">{{ $product->description }}</p>

                    <div class="flex items-baseline gap-2 flex-wrap">
                        <span id="pPrice" class="text-2xl font-black" style="color:var(--electric);">
                            {{ number_format($product->final_price, 2) }} EGP
                        </span>
                        <span id="pOriginal" class="text-sm line-through" style="display:none;color:var(--text-muted);"></span>
                        <span id="pDiscountPill"
                              class="badge badge-sm border"
                              style="display:none;background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);color:#fca5a5;font-weight:700;"></span>
                    </div>

                    <div id="pStock"
                         class="flex items-center gap-2 text-xs"
                         style="{{ $product->stock > 0 ? '' : 'display:none' }};color:var(--text-soft);">
                        <span class="w-2 h-2 rounded-full" style="background:var(--success);"></span>
                        <span id="pStockText">{{ $product->stock }} وحدة متوفرة</span>
                    </div>
                </div>

                <div class="px-5 py-3" style="background:var(--surface2);border-top:1px solid var(--border);">
                    <p class="text-xs text-center" style="color:var(--text-muted);">تتحدث المعاينة تلقائياً مع إدخالك</p>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    #uploadZone:hover {
        border-color: var(--electric) !important;
        background: var(--electric-dim);
    }
    .input:focus, .select:focus, .textarea:focus {
        outline: none;
        border-color: var(--electric) !important;
        box-shadow: 0 0 0 3px var(--electric-glow) !important;
    }
    input[type=number]::-webkit-inner-spin-button { opacity: 0.4; }
</style>

<script>
const fields = {
    name:     document.getElementById('f_name'),
    cat:      document.getElementById('f_cat'),
    desc:     document.getElementById('f_desc'),
    price:    document.getElementById('f_price'),
    discount: document.getElementById('f_discount_percentage'),
    stock:    document.getElementById('f_stock'),
};

function updatePreview() {
    document.getElementById('pName').textContent = fields.name.value || 'اسم المنتج';

    const catEl = fields.cat;
    document.getElementById('pCat').innerHTML =
        `<span class="w-1.5 h-1.5 rounded-full inline-block" style="background:var(--electric);"></span>
         ${catEl.options[catEl.selectedIndex]?.text || 'القسم'}`;

    document.getElementById('pDesc').textContent = fields.desc.value || '';

    const price = parseFloat(fields.price.value) || 0;
    const disc  = Math.min(100, Math.max(0, parseFloat(fields.discount.value) || 0));
    const final = price * (1 - disc / 100);

    if (price > 0) {
        document.getElementById('pPrice').textContent =
            final.toLocaleString('ar-EG', { minimumFractionDigits: 2 }) + ' EGP';

        const priceResult = document.getElementById('priceResult');
        priceResult.classList.remove('hidden');
        priceResult.style.display = 'flex';
        document.getElementById('finalPriceStr').textContent =
            final.toLocaleString('ar-EG', { minimumFractionDigits: 2 }) + ' EGP';

        if (disc > 0) {
            document.getElementById('pOriginal').textContent =
                price.toLocaleString('ar-EG', { minimumFractionDigits: 2 }) + ' EGP';
            document.getElementById('pOriginal').style.display = 'inline';
            document.getElementById('pDiscountPill').textContent = disc + '% خصم';
            document.getElementById('pDiscountPill').style.display = 'inline';

            document.getElementById('originalPriceStr').textContent =
                price.toLocaleString('ar-EG', { minimumFractionDigits: 2 }) + ' EGP';
            document.getElementById('discountPill').textContent = 'خصم ' + disc + '%';
            document.getElementById('discountPill').classList.remove('hidden');
            document.getElementById('discountPill').style.display = 'inline';
        } else {
            document.getElementById('pOriginal').style.display = 'none';
            document.getElementById('pDiscountPill').style.display = 'none';
            document.getElementById('originalPriceStr').textContent = '';
            document.getElementById('discountPill').style.display = 'none';
        }
    }

    const stock = parseInt(fields.stock.value);
    const pStock = document.getElementById('pStock');
    if (!isNaN(stock) && stock > 0) {
        pStock.style.display = 'flex';
        document.getElementById('pStockText').textContent = stock + ' وحدة متوفرة';
    } else {
        pStock.style.display = 'none';
    }
}

Object.values(fields).forEach(f => f?.addEventListener('input', updatePreview));
fields.cat.addEventListener('change', updatePreview);
updatePreview();
// Image preview
document.getElementById('imageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    const img = document.getElementById('previewImg');
    img.src = url;
    img.style.display = 'block';
    document.getElementById('noImgPlaceholder').style.display = 'none';

    const grid = document.getElementById('thumbsGrid');
    grid.innerHTML = '';
    Array.from(this.files).forEach(f => {
        const div = document.createElement('div');
        div.style.cssText = 'aspect-ratio:1;border-radius:8px;overflow:hidden;border:2px solid var(--electric);';
        div.innerHTML = `<img src="${URL.createObjectURL(f)}" style="width:100%;height:100%;object-fit:cover;" alt="">`;
        grid.appendChild(div);
    });
});
</script>

</x-layout>
