<x-layout title="إضافة منتج جديد">

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
:root { --accent: #c9a96e; }

/* Steps */
.step-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; border:2px solid oklch(var(--bc)/0.2); color:oklch(var(--bc)/0.4); transition:all .3s; flex-shrink:0; }
.step-circle.active { border-color:var(--accent); background:rgba(201,169,110,.12); color:var(--accent); }
.step-circle.done { border-color:#22c55e; background:rgba(34,197,94,.12); color:#22c55e; }
.step-line { flex:1; height:1px; background:oklch(var(--bc)/0.15); max-width:60px; transition:background .3s; }
.step-line.done { background:#22c55e; }

/* Panels */
.step-panel { display:none; }
.step-panel.active { display:block; animation: fadeUp .25s ease; }
@keyframes fadeUp { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }

/* Upload */
.upload-zone { border:2px dashed oklch(var(--bc)/0.2); border-radius:12px; padding:28px 20px; text-align:center; cursor:pointer; transition:all .2s; position:relative; overflow:hidden; }
.upload-zone:hover, .upload-zone.dragover { border-color:var(--accent); background:rgba(201,169,110,.05); }
.upload-zone input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.thumb { position:relative; aspect-ratio:1; border-radius:10px; overflow:hidden; border:2px solid oklch(var(--bc)/0.15); transition:border-color .2s; }
.thumb:first-child { border-color:var(--accent); }
.thumb img { width:100%; height:100%; object-fit:cover; }
.thumb .main-badge { position:absolute; top:4px; right:4px; background:var(--accent); color:#0c0c0e; font-size:9px; font-weight:800; padding:2px 6px; border-radius:99px; }
.thumb .remove-btn { position:absolute; top:4px; left:4px; width:20px; height:20px; border-radius:50%; background:rgba(239,68,68,.9); border:none; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:12px; opacity:0; transition:opacity .2s; }
.thumb:hover .remove-btn { opacity:1; }

/* Price result */
.price-result { padding:12px 16px; background:rgba(201,169,110,.08); border:1px solid rgba(201,169,110,.2); border-radius:10px; }

/* Preview card */
.preview-img-wrap { height:200px; background:oklch(var(--b2)/1); display:flex; align-items:center; justify-content:center; overflow:hidden; border-bottom:1px solid oklch(var(--bc)/0.1); }
.preview-img-wrap img { width:100%; height:100%; object-fit:contain; }
</style>
@endpush

<div class="bg-base-200 min-h-screen py-8 px-4" dir="rtl" style="font-family:'Cairo',sans-serif;">
<div class="max-w-6xl mx-auto">

  {{-- Header --}}
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-xl font-bold">إضافة منتج جديد</h1>
      <p class="text-xs text-base-content/50 mt-1">أضف منتج جديد لمخزن المتجر</p>
    </div>
    <a href="{{ route('admin.products.index') }}"
      class="btn btn-sm border border-base-300 bg-transparent gap-2 font-normal"
      style="font-family:'Cairo',sans-serif;">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
      </svg>
      العودة للمنتجات
    </a>
  </div>

  {{-- Alerts --}}
  @if($errors->any())
  <div class="alert mb-4 py-3 px-4 text-sm rounded-xl"
    style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.3);color:#fca5a5;">
    <ul class="list-disc list-inside space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(session('success'))
  <div class="alert mb-4 py-3 px-4 text-sm rounded-xl"
    style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.3);color:#86efac;">
    {{ session('success') }}
  </div>
  @endif

  {{-- Stepper --}}
  <div class="flex items-center gap-2 mb-6">
    <div class="flex items-center gap-2">
      <div class="step-circle active" id="sc1">١</div>
      <span class="text-sm font-semibold" id="sl1" style="color:var(--accent)">المعلومات</span>
    </div>
    <div class="step-line" id="sline1"></div>
    <div class="flex items-center gap-2">
      <div class="step-circle" id="sc2">٢</div>
      <span class="text-sm text-base-content/40" id="sl2">التسعير</span>
    </div>
    <div class="step-line" id="sline2"></div>
    <div class="flex items-center gap-2">
      <div class="step-circle" id="sc3">٣</div>
      <span class="text-sm text-base-content/40" id="sl3">الصور</span>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-4 items-start">

    {{-- ══ Form ══ --}}
    <div>
      <div class="card bg-base-100 border border-base-300 shadow-none">
        <div class="card-body p-5">

          <form action="{{ route('admin.products.store') }}" method="POST"
                enctype="multipart/form-data" id="mainForm">
            @csrf

            {{-- ── Panel 1: المعلومات الأساسية ── --}}
            <div class="step-panel active" id="panel1">
              <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase mb-4 pb-3 border-b border-base-300">
                المعلومات الأساسية
              </p>

              <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">اسم المنتج <span style="color:var(--accent)">*</span></label>
                  <input type="text" name="name" id="f_name"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    placeholder="مثلاً: كشاف LED 50 واط"
                    value="{{ old('name') }}" />
                </div>
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">التصنيف <span style="color:var(--accent)">*</span></label>
                  <select name="category_id" id="f_cat"
                    class="select select-sm select-bordered w-full focus:border-[#c9a96e]">
                    <option value="" disabled selected>اختر القسم...</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">البراند</label>
                  <select name="brand_id" id="f_brand"
                    class="select select-sm select-bordered w-full focus:border-[#c9a96e]">
                    <option value="" selected>بدون براند</option>
                    @foreach($brands ?? [] as $brand)
                      <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">الكمية المتوفرة</label>
                  <input type="number" name="stock" id="f_stock"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    placeholder="مثلاً: 100"
                    value="{{ old('stock') }}" />
                </div>
              </div>

              <div class="mb-3">
                <label class="text-xs text-base-content/50 mb-1 block">وصف المنتج</label>
                <textarea name="description" id="f_desc"
                  class="textarea textarea-bordered w-full focus:border-[#c9a96e] text-sm"
                  rows="4"
                  placeholder="اكتب تفاصيل المنتج الفنية هنا...">{{ old('description') }}</textarea>
              </div>

              <div class="flex justify-end pt-4 border-t border-base-300">
                <button type="button" class="btn btn-sm gap-2 font-bold"
                  style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;"
                  onclick="goStep(2)">
                  التالي: التسعير
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                  </svg>
                </button>
              </div>
            </div>

            {{-- ── Panel 2: التسعير ── --}}
            <div class="step-panel" id="panel2">
              <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase mb-4 pb-3 border-b border-base-300">
                التسعير والمخزون
              </p>

              <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">السعر الأصلي <span style="color:var(--accent)">*</span></label>
                  <label class="input input-sm input-bordered flex items-center gap-2 focus-within:border-[#c9a96e]">
                    <input type="number" name="price" id="f_price" class="grow bg-transparent outline-none"
                      step="0.01" placeholder="0.00" value="{{ old('price') }}" />
                    <span class="text-xs text-base-content/40 font-bold">EGP</span>
                  </label>
                </div>
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">نسبة الخصم (%)</label>
                  <label class="input input-sm input-bordered flex items-center gap-2 focus-within:border-[#c9a96e]">
                    <input type="number" name="discount" id="f_discount" class="grow bg-transparent outline-none"
                      min="0" max="100" step="1" placeholder="0" value="{{ old('discount', 0) }}" />
                    <span class="text-xs text-base-content/40 font-bold">%</span>
                  </label>
                </div>
              </div>

              {{-- Price Result --}}
              <div class="price-result mb-4" id="priceResult" style="display:none;">
                <div class="flex justify-between items-center">
                  <span class="text-xs text-base-content/50">السعر بعد الخصم</span>
                  <div class="flex items-center gap-2">
                    <span id="originalPriceStr" class="text-xs text-base-content/40 line-through" style="display:none;"></span>
                    <strong id="finalPriceStr" class="text-base font-bold" style="color:var(--accent)">—</strong>
                    <span id="discountPillPricing" class="badge badge-sm text-xs"
                      style="background:rgba(239,68,68,.15);color:#fca5a5;border-color:rgba(239,68,68,.25);display:none;"></span>
                  </div>
                </div>
              </div>

              <div class="flex justify-between items-center pt-4 border-t border-base-300">
                <button type="button" class="btn btn-sm btn-ghost border border-base-300 gap-2 font-normal"
                  onclick="goStep(1)">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
                  </svg>
                  السابق
                </button>
                <button type="button" class="btn btn-sm gap-2 font-bold"
                  style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;"
                  onclick="goStep(3)">
                  التالي: الصور
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
                  </svg>
                </button>
              </div>
            </div>

            {{-- ── Panel 3: الصور ── --}}
            <div class="step-panel" id="panel3">
              <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase mb-4 pb-3 border-b border-base-300">
                صور المنتج
              </p>

              <div class="upload-zone" id="uploadZone">
                <input type="file" name="images[]" id="imageInput" accept="image/*" multiple />
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mx-auto mb-3"
                  style="background:rgba(201,169,110,.12);color:var(--accent);">
                  <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <p class="text-sm font-semibold mb-1">اسحب الصور هنا أو اضغط للاختيار</p>
                <p class="text-xs text-base-content/50">يمكنك اختيار عدة صور — الأولى ستكون الصورة الرئيسية</p>
                <span class="badge badge-sm mt-2" style="background:rgba(201,169,110,.12);color:var(--accent);border-color:rgba(201,169,110,.2);">
                  PNG / JPG / WEBP
                </span>
              </div>

              <div class="grid grid-cols-4 gap-2 mt-3" id="thumbsGrid"></div>

              <div class="flex justify-between items-center pt-4 mt-4 border-t border-base-300">
                <button type="button" class="btn btn-sm btn-ghost border border-base-300 gap-2 font-normal"
                  onclick="goStep(2)">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
                  </svg>
                  السابق
                </button>
                <button type="submit" class="btn btn-sm gap-2 font-bold" id="submitBtn"
                  style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                  </svg>
                  حفظ المنتج
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

    {{-- ══ Preview Card ══ --}}
    <div class="lg:sticky lg:top-24">
      <div class="card bg-base-100 border border-base-300 shadow-none overflow-hidden">

        <div class="p-3 border-b border-base-300">
          <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase">معاينة المنتج</p>
        </div>

        {{-- Preview Image --}}
        <div class="preview-img-wrap">
          <img id="previewImg" src="" alt="" style="display:none;" />
          <div id="noImgPlaceholder" class="flex flex-col items-center gap-2 text-base-content/20">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
              <path stroke-linecap="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-xs">لا توجد صورة</span>
          </div>
        </div>

        {{-- Preview Body --}}
        <div class="p-4 space-y-2">
          <p class="font-bold text-sm" id="pName">اسم المنتج</p>
          <p class="text-xs text-base-content/50 flex items-center gap-1" id="pCat">
            <span class="w-1.5 h-1.5 rounded-full inline-block" style="background:var(--accent)"></span>
            القسم
          </p>
          <p class="text-xs text-base-content/50 leading-relaxed" id="pDesc">سيظهر الوصف هنا...</p>

          <div class="flex items-baseline gap-2 pt-1">
            <span class="text-xl font-black" id="pPrice" style="color:var(--accent)">—</span>
            <span class="text-xs text-base-content/40 line-through" id="pOriginal" style="display:none;"></span>
            <span class="badge badge-xs" id="pDiscountPill"
              style="background:rgba(239,68,68,.15);color:#fca5a5;border-color:rgba(239,68,68,.25);display:none;"></span>
          </div>

          <div class="flex items-center gap-2 text-xs text-base-content/50" id="pStock" style="display:none;">
            <span class="w-2 h-2 rounded-full bg-success flex-shrink-0"></span>
            <span id="pStockText"></span>
          </div>
        </div>

        <div class="p-3 border-t border-base-300 text-center">
          <p class="text-xs text-base-content/30">تتحدث المعاينة تلقائياً مع إدخالك</p>
        </div>

      </div>
    </div>

  </div>
</div>
</div>

@push('scripts')
<script>
let currentStep = 1;

function goStep(n) {
    if (!validateStep(currentStep)) return; // Validate current step before proceeding

    document.getElementById('panel' + currentStep).classList.remove('active');
    currentStep = n;
    document.getElementById('panel' + n).classList.add('active');
    updateStepper();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateStepper() {
    for (let i = 1; i <= 3; i++) {
        const sc = document.getElementById('sc' + i);
        const lbl = document.getElementById('sl' + i);
        sc.className = 'step-circle';
        if (i < currentStep) {
            sc.classList.add('done');
            sc.textContent = '✓';
            lbl.style.color = '#22c55e';
        } else if (i === currentStep) {
            sc.classList.add('active');
            sc.textContent = ['١','٢','٣'][i-1];
            lbl.style.color = 'var(--accent)';
            lbl.style.fontWeight = '700';
        } else {
            sc.textContent = ['١','٢','٣'][i-1];
            lbl.style.color = '';
            lbl.style.fontWeight = '';
        }
        if (i < 3) {
            document.getElementById('sline' + i).classList.toggle('done', i < currentStep);
        }
    }
}

// Validation functions
function validateStep(step) {
    switch(step) {
        case 1:
            const name = document.getElementById('f_name').value.trim();
            const category = document.getElementById('f_cat').value;
            if (!name) {
                showFieldError('f_name', 'اسم المنتج مطلوب');
                return false;
            }
            if (!category) {
                showFieldError('f_cat', 'يجب اختيار التصنيف');
                return false;
            }
            clearFieldError('f_name');
            clearFieldError('f_cat');
            return true;

        case 2:
            const price = parseFloat(document.getElementById('f_price').value);
            if (!price || price <= 0) {
                showFieldError('f_price', 'السعر يجب أن يكون أكبر من صفر');
                return false;
            }
            clearFieldError('f_price');
            return true;

        default:
            return true;
    }
}

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    field.classList.add('input-error');
    field.focus();

    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) existingError.remove();

    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error text-xs text-error mt-1';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.remove('input-error');
    const error = field.parentNode.querySelector('.field-error');
    if (error) error.remove();
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function calculatePrice(price, discount) {
    const p = parseFloat(price) || 0;
    const d = Math.min(100, Math.max(0, parseFloat(discount) || 0));
    return {
        original: p,
        discount: d,
        final: p * (1 - d / 100)
    };
}

function updatePriceDisplay(priceData, preview = false) {
    const prefix = preview ? 'p' : 'final';
    const pPrice = document.getElementById(`${prefix}Price`);
    const pOriginal = document.getElementById(`${prefix}Original`);
    const pDisc = document.getElementById(`${prefix}DiscountPill`);

    if (priceData.original > 0) {
        if (priceData.discount > 0) {
            pPrice.textContent = priceData.final.toFixed(2) + ' EGP';
            pOriginal.textContent = priceData.original.toFixed(2) + ' EGP';
            pOriginal.style.display = 'inline';
            pDisc.textContent = priceData.discount + '% خصم';
            pDisc.style.display = 'inline';
        } else {
            pPrice.textContent = priceData.original.toFixed(2) + ' EGP';
            pOriginal.style.display = 'none';
            pDisc.style.display = 'none';
        }

        if (!preview) {
            document.getElementById('priceResult').style.display = 'block';
            document.getElementById('originalPriceStr').textContent = priceData.original.toFixed(2) + ' EGP';
            document.getElementById('originalPriceStr').style.display = priceData.discount > 0 ? 'inline' : 'none';
            document.getElementById('discountPillPricing').textContent = 'خصم ' + priceData.discount + '%';
            document.getElementById('discountPillPricing').style.display = priceData.discount > 0 ? 'inline' : 'none';
        }
    } else {
        pPrice.textContent = '—';
        pOriginal.style.display = 'none';
        pDisc.style.display = 'none';
        if (!preview) {
            document.getElementById('priceResult').style.display = 'none';
        }
    }
}

// Live Preview
const fields = {
    name:     document.getElementById('f_name'),
    cat:      document.getElementById('f_cat'),
    desc:     document.getElementById('f_desc'),
    price:    document.getElementById('f_price'),
    discount: document.getElementById('f_discount'),
    stock:    document.getElementById('f_stock'),
};

function updatePreview() {
    document.getElementById('pName').textContent = fields.name.value || 'اسم المنتج';
    document.getElementById('pCat').querySelector('span:last-child') &&
        (document.getElementById('pCat').lastChild.textContent = fields.cat.options[fields.cat.selectedIndex]?.text || 'القسم');
    document.getElementById('pDesc').textContent = fields.desc.value || 'سيظهر الوصف هنا...';

    const priceData = calculatePrice(fields.price.value, fields.discount.value);

    updatePriceDisplay(priceData, true);

    const stock = parseInt(fields.stock.value);
    const pStock = document.getElementById('pStock');
    if (!isNaN(stock) && stock > 0) {
        pStock.style.display = 'flex';
        document.getElementById('pStockText').textContent = stock + ' وحدة متوفرة';
    } else {
        pStock.style.display = 'none';
    }
}

Object.values(fields).forEach(f => f?.addEventListener('input', debounce(updatePreview, 300)));
fields.cat.addEventListener('change', updatePreview);

// Multi-image Upload
const imageInput  = document.getElementById('imageInput');
const thumbsGrid  = document.getElementById('thumbsGrid');
const uploadZone  = document.getElementById('uploadZone');
let imageFiles    = [];
let objectUrls    = []; // Track URLs for cleanup

uploadZone.addEventListener('dragover', e => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});

uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));

uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');

    const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
    if (files.length > 0) {
        imageFiles = [...imageFiles, ...files];
        renderThumbs();
    }
});

imageInput.addEventListener('change', () => {
    const files = Array.from(imageInput.files).filter(file => file.type.startsWith('image/'));
    if (files.length > 0) {
        imageFiles = [...imageFiles, ...files];
        renderThumbs();
    }
    // Clear input so same file can be selected again
    imageInput.value = '';
});

function renderThumbs() {
    // Cleanup old URLs
    objectUrls.forEach(url => URL.revokeObjectURL(url));
    objectUrls = [];

    thumbsGrid.innerHTML = '';
    imageFiles.forEach((file, i) => {
        const url = URL.createObjectURL(file);
        objectUrls.push(url);

        const div = document.createElement('div');
        div.className = 'thumb';
        div.innerHTML = `<img src="${url}" alt=""><button class="remove-btn" type="button" onclick="removeImg(${i})" aria-label="إزالة الصورة">×</button>${i === 0 ? '<span class="main-badge">رئيسية</span>' : ''}`;
        thumbsGrid.appendChild(div);

        if (i === 0) {
            document.getElementById('previewImg').src = url;
            document.getElementById('previewImg').style.display = 'block';
            document.getElementById('noImgPlaceholder').style.display = 'none';
        }
    });

    if (imageFiles.length === 0) {
        document.getElementById('previewImg').style.display = 'none';
        document.getElementById('noImgPlaceholder').style.display = 'flex';
    }
}

function removeImg(index) {
    // Cleanup URL for removed image
    if (objectUrls[index]) {
        URL.revokeObjectURL(objectUrls[index]);
        objectUrls.splice(index, 1);
    }

    imageFiles.splice(index, 1);
    renderThumbs();
}

// Before form submission, create a DataTransfer to properly set files
document.getElementById('mainForm').addEventListener('submit', function() {
    // Create a new DataTransfer and add all accumulated files
    const dt = new DataTransfer();
    imageFiles.forEach(file => dt.items.add(file));
    imageInput.files = dt.files;

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> جاري الحفظ...`;
});
</script>
@endpush

</x-layout>
