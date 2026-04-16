<x-layout>

<style>
*, *::before, *::after { box-sizing: border-box; }

/* ── Layout ── */
.page { max-width: 1200px; margin: 40px auto; padding: 0 24px; display: grid; grid-template-columns: 1fr 340px; gap: 28px; align-items: start; }
@media (max-width: 900px) { .page { grid-template-columns: 1fr; } }

/* ── Stepper ── */
.stepper { display: flex; align-items: center; gap: 0; margin-bottom: 32px; }
.step { display: flex; align-items: center; gap: 10px; flex: 1; cursor: pointer; }
.step-circle { width: 36px; height: 36px; border-radius: 50%; border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: var(--text-muted); transition: all .3s; flex-shrink: 0; }
.step.active .step-circle { border-color: var(--electric); background: var(--electric-dim); color: var(--electric); }
.step.done .step-circle { border-color: var(--success); background: rgba(34,197,94,.12); color: var(--success); }
.step-label { font-size: 13px; font-weight: 600; color: var(--text-muted); transition: color .3s; }
.step.active .step-label { color: var(--text); }
.step.done .step-label { color: var(--success); }
.step-line { flex: 1; height: 1px; background: var(--border); margin: 0 8px; max-width: 60px; }
.step-line.done { background: var(--success); }

/* ── Alert ── */
.alert { border-radius: var(--radius-sm); padding: 16px 20px; margin-bottom: 24px; font-size: 14px; border: 1px solid; }
.alert-error { background: rgba(239,68,68,.08); border-color: rgba(239,68,68,.3); color: #fca5a5; }
.alert-error ul { padding-right: 18px; }
.alert-success { background: rgba(34,197,94,.08); border-color: rgba(34,197,94,.3); color: #86efac; }

/* ── Card ── */
.form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
.card-body { padding: 32px; }
.section-label { font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border); }

/* ── Step panels ── */
.step-panel { display: none; }
.step-panel.active { display: block; animation: fadeIn .3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

/* ── Grid ── */
.grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
@media (max-width: 600px) { .grid2, .grid3 { grid-template-columns: 1fr; } }

/* ── Form controls ── */
.field { display: flex; flex-direction: column; gap: 8px; }
.field label { font-size: 13px; font-weight: 600; color: var(--text-soft); display: flex; align-items: center; gap: 5px; }
.req { color: var(--electric); font-size: 16px; line-height: 1; }
.f-input, .f-select, .f-textarea {
    background: var(--surface2); border: 1px solid var(--border);
    border-radius: var(--radius-sm); color: var(--text);
    font-family: 'Cairo', sans-serif; font-size: 14px;
    padding: 11px 16px; transition: border-color .2s, box-shadow .2s;
    outline: none; width: 100%;
}
.f-input:focus, .f-select:focus, .f-textarea:focus { border-color: var(--electric); box-shadow: 0 0 0 3px var(--electric-glow); }
.f-input::placeholder, .f-textarea::placeholder { color: var(--text-muted); }
.f-select { cursor: pointer; }
.f-select option { background: var(--surface2); }
.f-textarea { resize: vertical; min-height: 100px; line-height: 1.7; }

/* Price row */
.input-group { position: relative; }
.input-group .f-input { padding-left: 56px; }
.input-group .suffix { position: absolute; left: 0; top: 0; bottom: 0; width: 50px; display: flex; align-items: center; justify-content: center; background: var(--border); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; font-size: 11px; font-weight: 700; color: var(--text-muted); }
.price-result { margin-top: 10px; padding: 12px 16px; background: var(--electric-dim); border: 1px solid var(--electric-glow); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: space-between; font-size: 14px; }
.price-result span { color: var(--text-muted); }
.price-result strong { color: var(--electric); font-size: 18px; font-weight: 900; }
.discount-badge { display: inline-block; padding: 2px 8px; background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3); border-radius: 99px; font-size: 12px; color: #fca5a5; font-weight: 700; }

/* Brand selector */
.brand-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 4px; }
.brand-option { display: none; }
.brand-label {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    padding: 10px 8px; border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); cursor: pointer;
    transition: all .2s; text-align: center;
    background: var(--surface2);
}
.brand-label:hover { border-color: var(--border-hover); }
.brand-option:checked + .brand-label { border-color: var(--electric); background: var(--electric-dim); }
.brand-logo-wrap { width: 44px; height: 44px; border-radius: 8px; background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; color: var(--electric); overflow: hidden; }
.brand-logo-wrap img { width: 100%; height: 100%; object-fit: contain; }
.brand-label-text { font-size: 11px; font-weight: 700; color: var(--text-soft); }
.brand-option:checked + .brand-label .brand-label-text { color: var(--electric); }

/* Upload */
.upload-zone { border: 2px dashed var(--border); border-radius: var(--radius-sm); padding: 28px 20px; text-align: center; cursor: pointer; transition: border-color .2s, background .2s; position: relative; overflow: hidden; }
.upload-zone:hover, .upload-zone.dragover { border-color: var(--electric); background: var(--electric-dim); }
.upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.upload-icon { width: 44px; height: 44px; background: var(--electric-dim); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: var(--electric); }
.upload-title { font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 4px; }
.upload-sub { font-size: 12px; color: var(--text-muted); }
.upload-badge { display: inline-block; margin-top: 10px; font-size: 11px; font-weight: 700; color: var(--electric); background: var(--electric-dim); border: 1px solid var(--electric-glow); padding: 3px 10px; border-radius: 99px; }
.thumbs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: 10px; margin-top: 16px; }
.thumb { position: relative; aspect-ratio: 1; border-radius: var(--radius-sm); overflow: hidden; border: 2px solid var(--border); }
.thumb:first-child { border-color: var(--electric); }
.thumb img { width: 100%; height: 100%; object-fit: cover; }
.thumb .main-badge { position: absolute; top: 4px; right: 4px; background: var(--electric); color: #070810; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 99px; }
.thumb .remove-btn { position: absolute; top: 4px; left: 4px; width: 20px; height: 20px; border-radius: 50%; background: rgba(239,68,68,.9); border: none; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; opacity: 0; transition: opacity .2s; }
.thumb:hover .remove-btn { opacity: 1; }

/* Step nav */
.step-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border); }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; border-radius: var(--radius-sm); font-family: 'Cairo', sans-serif; font-size: 14px; font-weight: 700; cursor: pointer; border: 1px solid transparent; transition: all .2s; }
.btn-primary { background: var(--electric); color: #070810; border-color: var(--electric); }
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 20px var(--electric-glow); }
.btn-ghost { background: transparent; color: var(--text-muted); border-color: var(--border); }
.btn-ghost:hover { color: var(--text); border-color: var(--border-hover); }
.btn-submit { background: var(--electric); color: #070810; border-color: var(--electric); font-size: 15px; padding: 13px 30px; }
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 24px var(--electric-glow); }

/* Preview card */
.preview-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); position: sticky; top: 88px; overflow: hidden; }
.preview-header { padding: 16px 20px; border-bottom: 1px solid var(--border); }
.preview-title { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); }
.preview-img-wrap { height: 200px; background: var(--surface2); display: flex; align-items: center; justify-content: center; overflow: hidden; }
.preview-img-wrap img { width: 100%; height: 100%; object-fit: contain; }
.preview-img-wrap .no-img { display: flex; flex-direction: column; align-items: center; gap: 8px; color: var(--text-muted); font-size: 13px; }
.preview-body { padding: 18px 20px; }
.preview-name { font-size: 17px; font-weight: 800; color: var(--text); margin-bottom: 4px; min-height: 24px; }
.preview-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; }
.preview-cat { font-size: 12px; color: var(--text-muted); display: inline-flex; align-items: center; gap: 5px; }
.preview-cat::before { content: ''; display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: var(--electric); }
.preview-brand { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 99px; background: rgba(168,85,247,.1); border: 1px solid rgba(168,85,247,.2); color: #a855f7; }
.preview-desc { font-size: 13px; color: var(--text-soft); line-height: 1.7; min-height: 36px; margin-bottom: 14px; }
.preview-price-row { display: flex; align-items: baseline; gap: 10px; margin-bottom: 12px; flex-wrap: wrap; }
.preview-price { font-size: 24px; font-weight: 900; color: var(--electric); }
.preview-original { font-size: 13px; color: var(--text-muted); text-decoration: line-through; }
.preview-discount-pill { padding: 2px 8px; background: rgba(239,68,68,.15); border-radius: 99px; font-size: 11px; color: #fca5a5; font-weight: 700; border: 1px solid rgba(239,68,68,.25); }
.preview-stock { display: flex; align-items: center; gap: 7px; font-size: 13px; color: var(--text-soft); }
.stock-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--success); flex-shrink: 0; }
.preview-footer { padding: 12px 20px; border-top: 1px solid var(--border); background: var(--surface2); }
.preview-note { font-size: 11px; color: var(--text-muted); text-align: center; }

.mt-4 { margin-top: 16px; }
.mt-5 { margin-top: 20px; }

/* Mobile dots */
.step-dots { display: none; justify-content: center; gap: 6px; margin-bottom: 24px; }
@media (max-width: 600px) { .step-dots { display: flex; } .stepper { display: none; } }
.step-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--border); transition: all .3s; }
.step-dot.active { background: var(--electric); width: 24px; border-radius: 4px; }
.step-dot.done { background: var(--success); }

@media (max-width: 768px) { .page { padding: 0 16px; margin: 20px auto; } .card-body { padding: 20px; } }
</style>

<div class="page">

    <!-- LEFT: Form -->
    <div>

        @if ($errors->any())
        <div class="alert alert-error">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Stepper -->
        <div class="stepper" id="stepper">
            <div class="step active" data-step="1" onclick="goStep(1)">
                <div class="step-circle" id="sc1">١</div>
                <div class="step-label">المعلومات الأساسية</div>
            </div>
            <div class="step-line" id="sl1"></div>
            <div class="step" data-step="2" onclick="goStep(2)">
                <div class="step-circle" id="sc2">٢</div>
                <div class="step-label">التسعير</div>
            </div>
            <div class="step-line" id="sl2"></div>
            <div class="step" data-step="3" onclick="goStep(3)">
                <div class="step-circle" id="sc3">٣</div>
                <div class="step-label">الصور</div>
            </div>
        </div>

        <div class="step-dots">
            <div class="step-dot active" id="d1"></div>
            <div class="step-dot" id="d2"></div>
            <div class="step-dot" id="d3"></div>
        </div>

        <div class="form-card">
            <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                  method="POST" enctype="multipart/form-data" class="card-body" id="mainForm">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <!-- ── Step 1: Basic Info ── -->
                <div class="step-panel active" id="panel1">
                    <div class="section-label">المعلومات الأساسية</div>

                    <div class="grid2">
                        <div class="field">
                            <label>اسم المنتج <span class="req">*</span></label>
                            <input class="f-input" type="text" name="name" id="f_name"
                                   placeholder="مثلاً: كشاف LED 50 واط"
                                   value="{{ old('name', $product->name ?? '') }}" />
                        </div>
                        <div class="field">
                            <label>التصنيف <span class="req">*</span></label>
                            <select class="f-select" name="category_id" id="f_cat">
                                <option value="" disabled selected>اختر القسم...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- الماركة --}}
                    <div class="field mt-4">
                        <label>الماركة</label>
                        @if($brands->count() > 0)
                        <div class="brand-grid">
                            {{-- خيار "بدون ماركة" --}}
                            <div>
                                <input type="radio" name="brand_id" id="brand_none" value=""
                                       class="brand-option"
                                       {{ old('brand_id', $product->brand_id ?? 'none') == '' ? 'checked' : '' }}>
                                <label for="brand_none" class="brand-label">
                                    <div class="brand-logo-wrap" style="color:var(--text-muted);">—</div>
                                    <span class="brand-label-text">بدون ماركة</span>
                                </label>
                            </div>
                            @foreach($brands as $brand)
                            <div>
                                <input type="radio" name="brand_id" id="brand_{{ $brand->id }}"
                                       value="{{ $brand->id }}" class="brand-option"
                                       {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'checked' : '' }}>
                                <label for="brand_{{ $brand->id }}" class="brand-label">
                                    <div class="brand-logo-wrap">
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}">
                                        @else
                                            {{ strtoupper(substr($brand->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <span class="brand-label-text">{{ $brand->name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p style="font-size:13px;color:var(--text-muted);">
                            لا توجد ماركات —
                            <a href="{{ route('admin.brands.create') }}" style="color:var(--electric);">أضف ماركة الآن</a>
                        </p>
                        @endif
                    </div>

                    <div class="field mt-4">
                        <label>الكمية المتوفرة</label>
                        <input class="f-input" type="number" name="stock" id="f_stock"
                               placeholder="مثلاً: 100"
                               value="{{ old('stock', $product->stock ?? '') }}" />
                    </div>

                    <div class="field mt-4">
                        <label>وصف المنتج</label>
                        <textarea class="f-textarea" name="description" id="f_desc"
                                  placeholder="اكتب تفاصيل المنتج الفنية هنا...">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="step-nav">
                        <div></div>
                        <button type="button" class="btn btn-primary" onclick="goStep(2)">
                            التالي: التسعير
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- ── Step 2: Pricing ── -->
                <div class="step-panel" id="panel2">
                    <div class="section-label">التسعير</div>
                    <div class="grid2">
                        <div class="field">
                            <label>السعر الأصلي <span class="req">*</span></label>
                            <div class="input-group">
                                <input class="f-input" type="number" name="price" id="f_price"
                                       step="0.01" placeholder="0.00"
                                       value="{{ old('price', $product->price ?? '') }}" />
                                <span class="suffix">EGP</span>
                            </div>
                        </div>
                        <div class="field">
                            <label>نسبة الخصم (%)</label>
                            <div class="input-group">
                                <input class="f-input" type="number" name="discount" id="f_discount"
                                       min="0" max="100" step="1" placeholder="0"
                                       value="{{ old('discount', $product->discount ?? 0) }}" />
                                <span class="suffix">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="price-result mt-4" id="priceResult" style="display:none">
                        <span>السعر بعد الخصم</span>
                        <div style="display:flex;align-items:center;gap:10px">
                            <span id="originalPriceStr" class="preview-original"></span>
                            <strong id="finalPriceStr">—</strong>
                            <span id="discountPillPricing" class="discount-badge" style="display:none"></span>
                        </div>
                    </div>
                    <div class="step-nav">
                        <button type="button" class="btn btn-ghost" onclick="goStep(1)">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            السابق
                        </button>
                        <button type="button" class="btn btn-primary" onclick="goStep(3)">
                            التالي: الصور
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- ── Step 3: Images ── -->
                <div class="step-panel" id="panel3">
                    <div class="section-label">صور المنتج</div>

                    @if(isset($product) && $product->image_url)
                    <div style="margin-bottom:16px;padding:12px 16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);display:flex;align-items:center;gap:12px;">
                        <img src="{{ asset('storage/' . $product->image_url) }}"
                             style="width:56px;height:56px;object-fit:contain;border-radius:8px;border:1px solid var(--border);">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--text-soft);">الصورة الحالية</div>
                            <div style="font-size:11px;color:var(--text-muted);">ارفع صورة جديدة لاستبدالها</div>
                        </div>
                    </div>
                    @endif

                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="main_image" id="imageInput" accept="image/*"  />
                        <div class="upload-icon">
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div class="upload-title">اسحب الصور هنا أو اضغط للاختيار</div>
                        <div class="upload-sub">الأولى ستكون الصورة الرئيسية</div>
                        <span class="upload-badge">PNG / JPG / WEBP</span>
                    </div>
                    <div class="thumbs-grid" id="thumbsGrid"></div>

                    <div class="step-nav">
                        <button type="button" class="btn btn-ghost" onclick="goStep(2)">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            السابق
                        </button>
                        <button type="submit" class="btn btn-submit">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ isset($product) ? 'حفظ التعديلات' : 'حفظ المنتج في المخزن' }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- RIGHT: Live Preview -->
    <div>
        <div class="preview-card">
            <div class="preview-header">
                <div class="preview-title">معاينة المنتج</div>
            </div>
            <div class="preview-img-wrap" id="previewImgWrap">
                <img id="previewImg" src="{{ isset($product) && $product->image_url ? asset('storage/'.$product->image_url) : '' }}"
                     alt="" style="{{ isset($product) && $product->image_url ? '' : 'display:none' }}" />
                <div class="no-img" id="noImgPlaceholder" style="{{ isset($product) && $product->image_url ? 'display:none' : '' }}">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--border-hover)"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>لا توجد صورة بعد</span>
                </div>
            </div>
            <div class="preview-body">
                <div class="preview-name" id="pName">{{ $product->name ?? 'اسم المنتج' }}</div>
                <div class="preview-meta">
                    <div class="preview-cat" id="pCat">{{ $product->category->name ?? 'القسم' }}</div>
                    <div class="preview-brand" id="pBrand" style="{{ isset($product) && $product->brand ? '' : 'display:none' }}">
                        {{ $product->brand->name ?? '' }}
                    </div>
                </div>
                <div class="preview-desc" id="pDesc">{{ $product->description ?? 'سيظهر الوصف هنا...' }}</div>
                <div class="preview-price-row">
                    <div class="preview-price" id="pPrice">{{ isset($product) ? number_format($product->price, 2).' EGP' : '—' }}</div>
                    <div class="preview-original" id="pOriginal" style="display:none"></div>
                    <div class="preview-discount-pill" id="pDiscountPill" style="display:none"></div>
                </div>
                <div class="preview-stock" id="pStock" style="{{ isset($product) && $product->stock > 0 ? '' : 'display:none' }}">
                    <div class="stock-dot"></div>
                    <span id="pStockText">{{ isset($product) ? $product->stock.' وحدة متوفرة' : '' }}</span>
                </div>
            </div>
            <div class="preview-footer">
                <div class="preview-note">تتحدث المعاينة تلقائياً مع إدخالك</div>
            </div>
        </div>
    </div>
</div>

<script>
// ── Stepper ──
let currentStep = 1;
function goStep(n) {
    document.getElementById('panel' + currentStep).classList.remove('active');
    currentStep = n;
    document.getElementById('panel' + n).classList.add('active');
    updateStepperUI();
}
function updateStepperUI() {
    for (let i = 1; i <= 3; i++) {
        const sc = document.getElementById('sc' + i);
        const stepEl = document.querySelector('[data-step="' + i + '"]');
        const dot = document.getElementById('d' + i);
        stepEl.classList.remove('active', 'done');
        dot.classList.remove('active', 'done');
        if (i < currentStep) {
            stepEl.classList.add('done');
            sc.innerHTML = '✓';
            dot.classList.add('done');
        } else if (i === currentStep) {
            stepEl.classList.add('active');
            sc.innerHTML = ['١','٢','٣'][i-1];
            dot.classList.add('active');
        } else {
            sc.innerHTML = ['١','٢','٣'][i-1];
        }
        if (i < 3) {
            document.getElementById('sl' + i).classList.toggle('done', i < currentStep);
        }
    }
}

// ── Live preview ──
const fields = {
    name:     document.getElementById('f_name'),
    cat:      document.getElementById('f_cat'),
    desc:     document.getElementById('f_desc'),
    price:    document.getElementById('f_price'),
    discount: document.getElementById('f_discount'),
    stock:    document.getElementById('f_stock'),
};
const p = {
    name:         document.getElementById('pName'),
    cat:          document.getElementById('pCat'),
    brand:        document.getElementById('pBrand'),
    desc:         document.getElementById('pDesc'),
    price:        document.getElementById('pPrice'),
    original:     document.getElementById('pOriginal'),
    discountPill: document.getElementById('pDiscountPill'),
    stock:        document.getElementById('pStock'),
    stockText:    document.getElementById('pStockText'),
    img:          document.getElementById('previewImg'),
    noImg:        document.getElementById('noImgPlaceholder'),
};

function updatePreview() {
    p.name.textContent = fields.name.value || 'اسم المنتج';
    p.cat.textContent  = fields.cat.options[fields.cat.selectedIndex]?.text || 'القسم';
    p.desc.textContent = fields.desc.value || 'سيظهر الوصف هنا...';

    // Brand
    const checkedBrand = document.querySelector('input[name="brand_id"]:checked');
    const brandLabel = checkedBrand ? document.querySelector('label[for="' + checkedBrand.id + '"] .brand-label-text')?.textContent : null;
    if (brandLabel && brandLabel.trim() !== 'بدون ماركة') {
        p.brand.textContent = brandLabel;
        p.brand.style.display = 'inline';
    } else {
        p.brand.style.display = 'none';
    }

    // Price
    const price = parseFloat(fields.price.value) || 0;
    const disc  = Math.min(100, Math.max(0, parseFloat(fields.discount.value) || 0));
    const final = price * (1 - disc / 100);

    if (price > 0) {
        if (disc > 0) {
            p.price.textContent = final.toLocaleString('ar-EG', {minimumFractionDigits: 2}) + ' EGP';
            p.original.textContent = price.toLocaleString('ar-EG', {minimumFractionDigits: 2}) + ' EGP';
            p.original.style.display = 'inline';
            p.discountPill.textContent = disc + '% خصم';
            p.discountPill.style.display = 'inline';
        } else {
            p.price.textContent = price.toLocaleString('ar-EG', {minimumFractionDigits: 2}) + ' EGP';
            p.original.style.display = 'none';
            p.discountPill.style.display = 'none';
        }
    } else {
        p.price.textContent = '—';
        p.original.style.display = 'none';
        p.discountPill.style.display = 'none';
    }

    // Stock
    const stock = parseInt(fields.stock.value);
    if (!isNaN(stock) && stock > 0) {
        p.stock.style.display = 'flex';
        p.stockText.textContent = stock + ' وحدة متوفرة';
    } else {
        p.stock.style.display = 'none';
    }

    // Pricing step result
    const pr = document.getElementById('priceResult');
    if (price > 0) {
        pr.style.display = 'flex';
        document.getElementById('finalPriceStr').textContent = final.toLocaleString('ar-EG', {minimumFractionDigits: 2}) + ' EGP';
        const origStr = document.getElementById('originalPriceStr');
        const pill    = document.getElementById('discountPillPricing');
        if (disc > 0) {
            origStr.textContent = price.toLocaleString('ar-EG', {minimumFractionDigits: 2}) + ' EGP';
            origStr.style.display = 'inline';
            pill.textContent = 'خصم ' + disc + '%';
            pill.style.display = 'inline';
        } else {
            origStr.style.display = 'none';
            pill.style.display = 'none';
        }
    } else {
        pr.style.display = 'none';
    }
}

Object.values(fields).forEach(f => f?.addEventListener('input', updatePreview));
fields.cat.addEventListener('change', updatePreview);
document.querySelectorAll('input[name="brand_id"]').forEach(r => r.addEventListener('change', updatePreview));

// ── Multi-image ──
const imageInput = document.getElementById('imageInput');
const thumbsGrid = document.getElementById('thumbsGrid');
let imageFiles   = [];

const uploadZone = document.getElementById('uploadZone');
uploadZone.addEventListener('dragover',  e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
uploadZone.addEventListener('drop',      () => uploadZone.classList.remove('dragover'));

imageInput.addEventListener('change', () => {
    imageFiles = [...imageFiles, ...Array.from(imageInput.files)];
    renderThumbs();
});

function renderThumbs() {
    thumbsGrid.innerHTML = '';
    imageFiles.forEach((file, i) => {
        const url = URL.createObjectURL(file);
        const div = document.createElement('div');
        div.className = 'thumb';
        div.innerHTML = `<img src="${url}" alt=""><button class="remove-btn" type="button" onclick="removeImg(${i})">×</button>${i === 0 ? '<span class="main-badge">رئيسية</span>' : ''}`;
        thumbsGrid.appendChild(div);
        if (i === 0) { p.img.src = url; p.img.style.display = 'block'; p.noImg.style.display = 'none'; }
    });
    if (imageFiles.length === 0) { p.img.style.display = 'none'; p.noImg.style.display = 'flex'; }
}

function removeImg(index) {
    imageFiles.splice(index, 1);
    renderThumbs();
}
</script>

</x-layout>
