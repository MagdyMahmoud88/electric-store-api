<x-layout title="إتمام الطلب">

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root { --accent: #c9a96e; --accent-dark: #a8844a; }
.co-main-grid { grid-template-columns: 1fr; }
@media (min-width: 768px) { .co-main-grid { grid-template-columns: 1fr 300px; } }
.step-line { flex:1; height:1px; background:oklch(var(--bc)/0.15); max-width:80px; transition:background .3s; }
.step-line.done { background:#4caf7d; }
.field-group { margin-bottom:14px; }
.field-group label { display:block; font-size:11px; color:oklch(var(--bc)/0.5); margin-bottom:5px; letter-spacing:.04em; }
.panel { display:none; }
.panel.active { display:block; }
.address-card { display:flex; align-items:flex-start; gap:10px; padding:12px; border-radius:12px; border:1.5px solid oklch(var(--bc)/0.15); cursor:pointer; transition:all .2s; margin-bottom:8px; }
.address-card:hover { border-color:var(--accent); }
.address-card.selected { border-color:var(--accent); background:rgba(201,169,110,0.05); }
.address-card input[type=radio] { accent-color:var(--accent); margin-top:2px; flex-shrink:0; }
@keyframes slideUp {
    from { opacity:0; transform:translateX(-50%) translateY(10px); }
    to   { opacity:1; transform:translateX(-50%) translateY(0); }
}
</style>
@endpush

<div class="bg-base-200 min-h-screen py-8 px-4" dir="rtl" style="font-family:'Cairo',sans-serif;">
<div class="max-w-4xl mx-auto">

  {{-- Alerts --}}
  @if(session('error'))
  <div class="alert mb-6 py-3 px-4 text-sm rounded-xl"
    style="background:rgba(224,85,85,.1);border:1px solid rgba(224,85,85,.25);color:#e05555;">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
    </svg>
    {{ session('error') }}
  </div>
  @endif

  {{-- Steps --}}
  <div class="flex items-center justify-center mb-8">
    <div class="flex items-center gap-2" id="step1">
      <div id="snum1"
        class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all"
        style="border-color:var(--accent);background:var(--accent);color:#0c0c0e;">1</div>
      <span class="text-sm font-semibold" style="color:var(--accent)">بياناتك</span>
    </div>
    <div class="step-line mx-3" id="sline"></div>
    <div class="flex items-center gap-2" id="step2">
      <div id="snum2"
        class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all border-base-300 text-base-content/40">2</div>
      <span class="text-sm text-base-content/40" id="slabel2">مراجعة الطلب</span>
    </div>
  </div>

  <div class="grid co-main-grid gap-4 items-start">

    {{-- ══ Left Panels ══ --}}
    <div>
      <form method="POST" action="{{ route('checkout.order') }}" id="checkoutForm">
        @csrf

        {{-- ── Panel 1: بيانات التوصيل ── --}}
        <div class="card bg-base-100 border border-base-300 shadow-none panel active" id="panel1">
          <div class="card-body p-5">
            <h2 class="text-sm font-bold mb-4 pb-3 border-b border-base-300 flex items-center gap-2">
              <svg class="w-4 h-4" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              معلومات التوصيل
            </h2>

            {{-- العناوين المحفوظة --}}
            @if(isset($addresses) && $addresses->count() > 0)
            <div class="mb-4">
              <p class="text-xs font-bold text-base-content/40 tracking-widest uppercase mb-3">عناوينك المحفوظة</p>
              @foreach($addresses as $address)
              <div class="address-card {{ isset($defaultAddress) && $defaultAddress?->id === $address->id ? 'selected' : '' }}"
                id="addr-card-{{ $address->id }}"
                onclick="selectAddress(
                  {{ $address->id }},
                  '{{ addslashes($address->first_name) }}',
                  '{{ addslashes($address->last_name) }}',
                  '{{ addslashes($address->phone) }}',
                  '{{ addslashes($address->street_address) }}',
                  '{{ addslashes($address->area ?? '') }}',
                  '{{ addslashes($address->city) }}',
                  '{{ addslashes($address->governorate ?? $address->city) }}'
                )">
                <input type="radio" name="_address_id" value="{{ $address->id }}"
                  {{ isset($defaultAddress) && $defaultAddress?->id === $address->id ? 'checked' : '' }} />
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 flex-wrap">
                    <p class="text-xs font-semibold">{{ $address->first_name }} {{ $address->last_name }}</p>
                    @if($address->is_default)
                      <span class="badge badge-xs font-bold"
                        style="background:rgba(201,169,110,.12);color:var(--accent);border-color:rgba(201,169,110,.2);">افتراضي</span>
                    @endif
                  </div>
                  <p class="text-xs text-base-content/50 mt-0.5">
                    {{ $address->street_address }}@if($address->area), {{ $address->area }}@endif, {{ $address->city }}
                  </p>
                  <p class="text-xs text-base-content/40 mt-0.5">{{ $address->phone }}</p>
                </div>
              </div>
              @endforeach
              <div class="flex items-center gap-2 my-4">
                <div class="flex-1 h-px bg-base-300"></div>
                <span class="text-xs text-base-content/40 px-2">أو أدخل عنواناً جديداً</span>
                <div class="flex-1 h-px bg-base-300"></div>
              </div>
            </div>
            @endif

            {{-- فورم البيانات --}}
            <div class="grid grid-cols-2 gap-3">
              <div class="field-group">
                <label>الاسم الأول <span style="color:#e05555">*</span></label>
                <input type="text" name="first_name" id="inp_first_name"
                  class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                  value="{{ old('first_name', auth()->user()->name ?? '') }}"
                  placeholder="أحمد"  />
                @error('first_name')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
              </div>
              <div class="field-group">
                <label>الاسم الأخير <span style="color:#e05555">*</span></label>
                <input type="text" name="last_name" id="inp_last_name"
                  class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                  value="{{ old('last_name') }}"
                  placeholder="محمد"  />
                @error('last_name')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="field-group">
              <label>البريد الإلكتروني <span style="color:#e05555">*</span></label>
              <input type="email" name="email" id="inp_email"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('email', auth()->user()->email ?? '') }}"
                placeholder="ahmed@example.com" required />
              @error('email')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
              <label>رقم الهاتف <span style="color:#e05555">*</span></label>
              <input type="tel" name="phone" id="inp_phone"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('phone') }}"
                placeholder="+20 100 000 0000" required />
              @error('phone')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
              <label>العنوان بالتفصيل <span style="color:#e05555">*</span></label>
              <input type="text" name="address" id="inp_address"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('address') }}"
                placeholder="الشارع، المبنى، الشقة" required />
              @error('address')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div class="field-group">
                <label>المدينة <span style="color:#e05555">*</span></label>
                <input type="text" name="city" id="inp_city"
                  class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                  value="{{ old('city') }}"
                  placeholder="طنطا" required />
                @error('city')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
              </div>
              <div class="field-group">
                <label>المحافظة <span style="color:#e05555">*</span></label>
                <select name="governorate" id="inp_governorate"
                  class="select select-sm select-bordered w-full focus:border-[#c9a96e]" required>
                  <option value="" disabled {{ !old('governorate') ? 'selected' : '' }}>اختر المحافظة</option>
                  @foreach(['القاهرة','الجيزة','الإسكندرية','الغربية','الشرقية','المنوفية','الدقهلية','كفر الشيخ','دمياط','البحيرة','الإسماعيلية','بورسعيد','السويس','شمال سيناء','جنوب سيناء','الفيوم','بني سويف','المنيا','أسيوط','سوهاج','قنا','الأقصر','أسوان','مطروح','الوادي الجديد','البحر الأحمر'] as $gov)
                    <option value="{{ $gov }}" {{ old('governorate') === $gov ? 'selected' : '' }}>{{ $gov }}</option>
                  @endforeach
                </select>
                @error('governorate')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
              </div>
            </div>

            <a href="{{ route('addresses.index') }}" target="_blank"
              class="flex items-center gap-1 text-xs mt-1 mb-3 w-fit transition-opacity hover:opacity-70"
              style="color:var(--accent);">
              <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
              </svg>
              إضافة عنوان جديد
            </a>

            <button type="button"
              class="btn w-full mt-2 gap-2 font-bold"
              style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;"
              onclick="goToPayment()">
              متابعة لمراجعة الطلب
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
              </svg>
            </button>
          </div>
        </div>

        {{-- ── Panel 2: مراجعة الطلب ── --}}
        <div class="card bg-base-100 border border-base-300 shadow-none panel" id="panel2">
          <div class="card-body p-5">
            <h2 class="text-sm font-bold mb-4 pb-3 border-b border-base-300 flex items-center gap-2">
              <svg class="w-4 h-4" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              مراجعة الطلب
            </h2>

            <div class="rounded-xl p-3 mb-4 space-y-1"
              style="background:oklch(var(--b2)/1);border:1px solid oklch(var(--bc)/0.1);">
              <p class="text-xs font-bold text-base-content/40 mb-2 tracking-widest uppercase">بيانات التوصيل</p>
              <div class="flex justify-between text-xs">
                <span class="text-base-content/50">الاسم</span>
                <span id="review-name" class="font-medium">—</span>
              </div>
              <div class="flex justify-between text-xs">
                <span class="text-base-content/50">الهاتف</span>
                <span id="review-phone" class="font-medium">—</span>
              </div>
              <div class="flex justify-between text-xs">
                <span class="text-base-content/50">العنوان</span>
                <span id="review-address" class="font-medium text-left max-w-[160px] truncate">—</span>
              </div>
            </div>

            <div class="rounded-xl p-3 mb-4 space-y-2"
              style="background:oklch(var(--b2)/1);border:1px solid oklch(var(--bc)/0.1);">
              <p class="text-xs font-bold text-base-content/40 mb-2 tracking-widest uppercase">ملخص المبالغ</p>
              <div class="flex justify-between text-xs">
                <span class="text-base-content/50">المجموع الفرعي</span>
                <span>{{ number_format($subtotal, 0) }} ج.م</span>
              </div>
              @if($discount > 0)
              <div class="flex justify-between text-xs" style="color:#4caf7d;">
                <span>الخصم</span>
                <span>— {{ number_format($discount, 0) }} ج.م</span>
              </div>
              @endif
              <div class="flex justify-between text-xs">
                <span class="text-base-content/50">الشحن</span>
                <span class="{{ $shipping == 0 ? 'text-success' : '' }}">
                  {{ $shipping == 0 ? 'مجاني' : number_format($shipping, 0) . ' ج.م' }}
                </span>
              </div>
                {{--

                  <div class="flex justify-between text-xs">
                <span class="text-base-content/50">ضريبة 14%</span>
                <span>{{ number_format($tax, 0) }} ج.م</span>
              </div>   --}}

              <div class="divider my-1"></div>
              <div class="flex justify-between text-sm font-bold">
                <span>الإجمالي</span>
                <span style="color:var(--accent)">{{ number_format($total, 0) }} ج.م</span>
              </div>
            </div>

            <input type="hidden" name="payment_method" value="card" />

            <div class="flex items-center gap-2 text-xs text-base-content/40 mb-4 p-3 rounded-lg"
              style="background:rgba(201,169,110,0.05);border:1px solid rgba(201,169,110,0.15);">
              <svg class="w-4 h-4 flex-shrink-0" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 9h20"/>
              </svg>
              <span>سيتم تحويلك لبوابة <strong style="color:var(--accent)">Kashier</strong> الآمنة لإتمام الدفع</span>
            </div>

            <div class="flex justify-center gap-2 mb-4">
              <span class="badge badge-sm bg-base-200 border border-base-300 text-base-content/40 font-bold text-xs">VISA</span>
              <span class="badge badge-sm bg-base-200 border border-base-300 text-base-content/40 font-bold text-xs">Mastercard</span>
              <span class="badge badge-sm bg-base-200 border border-base-300 text-base-content/40 font-bold text-xs">Meeza</span>
              <span class="badge badge-sm bg-base-200 border border-base-300 text-base-content/40 font-bold text-xs">Fawry</span>
            </div>

            <button type="submit" class="btn w-full gap-2 font-bold" id="submitBtn"
              style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 9h20"/>
              </svg>
              تأكيد الطلب والانتقال للدفع
            </button>

            <button type="button"
              class="btn btn-ghost btn-sm w-full mt-2 border border-base-300 text-base-content/40 font-normal"
              onclick="goToInfo()">
              <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
              </svg>
              تعديل بياناتي
            </button>

            <div class="flex items-center justify-center gap-1 mt-3 text-xs text-base-content/30">
              <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
              </svg>
              مدفوعاتك محمية بتشفير 256-bit SSL
            </div>
          </div>
        </div>

      </form>
    </div>

    {{-- ══ Right: Order Summary ══ --}}
    <div class="lg:sticky lg:top-24">
      <div class="card bg-base-100 border border-base-300 shadow-none overflow-hidden">

        <div class="p-4 border-b border-base-300">
          <p class="font-bold text-sm flex items-center gap-2">
            <svg class="w-4 h-4" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            ملخص الطلب
          </p>
        </div>

        <div class="p-4 space-y-3 border-b border-base-300">
          @foreach($cartItems as $item)
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center flex-shrink-0 overflow-hidden">
              @if(!empty($item['image']))
                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
              @else
                <svg class="w-5 h-5 opacity-30" fill="none" viewBox="0 0 24 24" stroke="#c9a96e" stroke-width="1.3">
                  <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
              @endif
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-semibold truncate">{{ $item['name'] }}</p>
              <p class="text-xs text-base-content/40 mt-0.5">
                @if(!empty($item['options'])){{ implode(' · ', $item['options']) }} · @endif
                الكمية: {{ $item['quantity'] }}
              </p>
            </div>
            <p class="text-xs font-bold flex-shrink-0" style="color:var(--accent)">
              {{ number_format($item['price'] * $item['quantity'], 0) }} ج.م
            </p>
          </div>
          @endforeach
        </div>

        <div class="p-4 border-b border-base-300">
          @if(session('coupon'))
            <div class="flex items-center gap-2 text-xs py-2 px-3 rounded-lg"
              style="background:rgba(76,175,125,.1);border:1px solid rgba(76,175,125,.25);color:#4caf7d;">
              <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
              </svg>
              <span>كوبون <strong class="mx-1">{{ session('coupon.code') }}</strong> — خصم {{ number_format($discount, 2) }} ج.م</span>
            </div>
          @else
            <form action="{{ route('coupon.apply') }}" method="POST" id="couponForm">
              @csrf
              <div class="flex gap-2">
                <input type="text" name="code" placeholder="كود الخصم"
                  value="{{ old('code') }}"
                  class="input input-xs input-bordered flex-1 focus:border-[#c9a96e]"
                  style="font-family:'Cairo',sans-serif;" />
                <button type="submit"
                  class="btn btn-xs border border-base-300 bg-transparent font-normal text-base-content/50 hover:border-[#c9a96e] hover:text-[#c9a96e]"
                  style="font-family:'Cairo',sans-serif;">تطبيق</button>
              </div>
            </form>
            @if(session('error') && !session('coupon'))
              <p class="text-xs mt-1" style="color:#e05555;">{{ session('error') }}</p>
            @endif
            @if(session('success') && !session('coupon'))
              <p class="text-xs mt-1" style="color:#4caf7d;">{{ session('success') }}</p>
            @endif
          @endif
        </div>

        <div class="p-4 space-y-2">
          <div class="flex justify-between text-sm">
            <span class="text-base-content/50">المجموع</span>
            <span class="font-medium">{{ number_format($subtotal, 0) }} ج.م</span>
          </div>
          @if($discount > 0)
          <div class="flex justify-between text-sm">
            <span class="text-base-content/50">الخصم</span>
            <span class="font-medium" style="color:#4caf7d;">— {{ number_format($discount, 0) }} ج.م</span>
          </div>
          @endif
          <div class="flex justify-between text-sm">
            <span class="text-base-content/50">الشحن</span>
            <span class="font-medium {{ $shipping == 0 ? 'text-success' : '' }}">
              {{ $shipping == 0 ? 'مجاني' : number_format($shipping, 0) . ' ج.م' }}
            </span>
          </div>
            {{--
             <div class="flex justify-between text-sm">
            <span class="text-base-content/50">ضريبة 14%</span>
            <span class="font-medium">{{ number_format($tax, 0) }} ج.م</span>
          </div>
            --}}

          <div class="divider my-1"></div>
          <div class="flex justify-between items-baseline">
            <span class="text-sm font-bold">الإجمالي</span>
            <span class="text-2xl font-bold" style="color:var(--accent)">
              {{ number_format($total, 0) }}
              <span class="text-xs font-normal text-base-content/40">ج.م</span>
            </span>
          </div>
        </div>

        <div class="flex justify-around p-3 border-t border-base-300">
          <div class="flex flex-col items-center gap-1 text-xs text-base-content/40">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            دفع آمن
          </div>
          <div class="flex flex-col items-center gap-1 text-xs text-base-content/40">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
            </svg>
            إرجاع 30 يوم
          </div>
          <div class="flex flex-col items-center gap-1 text-xs text-base-content/40">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            شحن سريع
          </div>
        </div>

        <div class="flex justify-center gap-2 p-3 border-t border-base-300">
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">VISA</span>
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">Mastercard</span>
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">Fawry</span>
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">Instapay</span>
        </div>

      </div>
    </div>

  </div>

</div>
</div>

@push('scripts')
<script>
const checkMark = `<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7l4 4 6-6" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>`;

// ── اختيار العنوان المحفوظ ──
function selectAddress(id, firstName, lastName, phone, street, area, city, governorate) {

    setFieldValue('inp_first_name', firstName);
    setFieldValue('inp_last_name',  lastName);

    setFieldValue('inp_first_name', firstName);
    setFieldValue('inp_last_name',  lastName);
    setFieldValue('inp_phone',      phone);
    setFieldValue('inp_address',    street + (area ? '، ' + area : ''));
    setFieldValue('inp_city',       city);

    const govSelect = document.getElementById('inp_governorate');
    for (let i = 0; i < govSelect.options.length; i++) {
        if (govSelect.options[i].value === governorate || govSelect.options[i].value === city) {
            govSelect.selectedIndex = i;
            clearFieldError(govSelect);
            break;
        }
    }
}

function setFieldValue(id, value) {
    const el = document.getElementById(id);
    if (el) {
        el.value = value;
        if (value.trim()) clearFieldError(el);
    }
}

// ── ملء العنوان الافتراضي عند التحميل ──
@if(isset($defaultAddress) && $defaultAddress)
window.addEventListener('DOMContentLoaded', function() {
    selectAddress(
        {{ $defaultAddress->id }},

        '{{ addslashes($defaultAddress->first_name) }}',
        '{{ addslashes($defaultAddress->last_name) }}',
        '{{ addslashes($defaultAddress->phone) }}',
        '{{ addslashes($defaultAddress->street_address) }}',
        '{{ addslashes($defaultAddress->area ?? '') }}',
        '{{ addslashes($defaultAddress->city) }}',
        '{{ addslashes($defaultAddress->governorate ?? $defaultAddress->city) }}'
    );
});
@endif

// ── Validation helpers ──
function showFieldError(el) {
    el.style.borderColor = '#e05555';
    el.style.boxShadow   = '0 0 0 3px rgba(224,85,85,.12)';
    el.classList.add('input-error');

    // أضف رسالة خطأ لو مش موجودة
    const parent  = el.closest('.field-group') || el.parentNode;
    let errSpan   = parent.querySelector('.field-err-msg');
    if (!errSpan) {
        errSpan = document.createElement('span');
        errSpan.className = 'field-err-msg text-xs block mt-1';
        errSpan.style.color = '#e05555';
        errSpan.style.fontFamily = "'Cairo', sans-serif";
        parent.appendChild(errSpan);
    }
    errSpan.textContent = 'هذا الحقل مطلوب';
}

function clearFieldError(el) {
    el.style.borderColor = '';
    el.style.boxShadow   = '';
    el.classList.remove('input-error');
    const parent  = el.closest('.field-group') || el.parentNode;
    const errSpan = parent.querySelector('.field-err-msg');
    if (errSpan) errSpan.remove();
}

// إزالة الخطأ عند الكتابة
document.querySelectorAll('#panel1 [required]').forEach(el => {
    el.addEventListener('input', function() {
        if (this.value.trim()) clearFieldError(this);
    });
    el.addEventListener('change', function() {
        if (this.value.trim()) clearFieldError(this);
    });
});

// ── Toast ──
function showToast(msg, type = 'error') {
    let toast = document.getElementById('checkout-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'checkout-toast';
        toast.style.cssText = `
            position:fixed; bottom:24px; left:50%; transform:translateX(-50%);
            padding:12px 20px; border-radius:12px;
            font-size:13px; font-family:'Cairo',sans-serif;
            z-index:9999; display:flex; align-items:center; gap:8px;
            box-shadow:0 8px 32px rgba(0,0,0,.35);
            animation: slideUp .3s ease;
            white-space:nowrap;
        `;
        document.body.appendChild(toast);
    }

    const isError = type === 'error';
    toast.style.background    = isError ? 'rgba(30,10,10,.95)' : 'rgba(10,30,10,.95)';
    toast.style.color         = isError ? '#fca5a5' : '#86efac';
    toast.style.border        = isError ? '1px solid rgba(239,68,68,.35)' : '1px solid rgba(34,197,94,.35)';
    toast.innerHTML = `
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            ${isError
                ? '<circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/>'
                : '<path stroke-linecap="round" d="M5 13l4 4L19 7"/>'}
        </svg>
        ${msg}
    `;
    toast.style.display    = 'flex';
    toast.style.opacity    = '1';
    toast.style.transition = '';

    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(() => {
        toast.style.transition = 'opacity .4s';
        toast.style.opacity    = '0';
        setTimeout(() => { toast.style.display = 'none'; }, 400);
    }, 3500);
}

// ── goToPayment ──
function goToPayment() {
    const panel1 = document.getElementById('panel1');
    let valid        = true;
    let firstInvalid = null;

    panel1.querySelectorAll('[required]').forEach(el => {
        if (!el.value.trim()) {
            showFieldError(el);
            if (!firstInvalid) firstInvalid = el;
            valid = false;
        } else {
            clearFieldError(el);
        }
    });

    if (!valid) {
        showToast('من فضلك أكمل جميع البيانات المطلوبة');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => firstInvalid.focus(), 400);
        }
        return;
    }

    const fname = document.getElementById('inp_first_name').value;
    const lname = document.getElementById('inp_last_name').value;
    const phone = document.getElementById('inp_phone').value;
    const addr  = document.getElementById('inp_address').value;
    const city  = document.getElementById('inp_city').value;
    const gov   = document.getElementById('inp_governorate').value;

    document.getElementById('review-name').textContent    = fname + ' ' + lname;
    document.getElementById('review-phone').textContent   = phone;
    document.getElementById('review-address').textContent = addr + '، ' + city + '، ' + gov;

    const s1 = document.getElementById('snum1');
    s1.innerHTML         = checkMark;
    s1.style.background  = '#4caf7d';
    s1.style.borderColor = '#4caf7d';
    document.getElementById('sline').classList.add('done');

    const s2 = document.getElementById('snum2');
    s2.style.borderColor = 'var(--accent)';
    s2.style.background  = 'var(--accent)';
    s2.style.color       = '#0c0c0e';
    document.getElementById('slabel2').style.color = 'var(--accent)';
    document.getElementById('slabel2').classList.add('font-semibold');

    panel1.classList.remove('active');
    document.getElementById('panel2').classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── goToInfo ──
function goToInfo() {
    const s1 = document.getElementById('snum1');
    s1.innerHTML         = '1';
    s1.style.background  = 'var(--accent)';
    s1.style.borderColor = 'var(--accent)';
    s1.style.color       = '#0c0c0e';
    document.getElementById('sline').classList.remove('done');

    const s2 = document.getElementById('snum2');
    s2.style.borderColor = '';
    s2.style.background  = '';
    s2.style.color       = '';
    document.getElementById('slabel2').style.color = '';
    document.getElementById('slabel2').classList.remove('font-semibold');

    document.getElementById('panel2').classList.remove('active');
    document.getElementById('panel1').classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Submit loading ──
document.getElementById('checkoutForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> جاري تأكيد الطلب...`;
});
</script>
@endpush

</x-layout>
