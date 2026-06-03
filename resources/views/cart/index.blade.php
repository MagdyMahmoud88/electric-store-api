<x-layout title="سلة التسوق">

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root { --accent: #c9a96e; --accent-dark: #a8844a; }
.co-main-grid { grid-template-columns: 1fr; }
@media (min-width: 1024px) { .co-main-grid { grid-template-columns: 1fr 300px; } }
</style>
@endpush

<div class="bg-base-200 min-h-screen p-4" dir="rtl" style="font-family:'Cairo',sans-serif;">
<div class="max-w-5xl mx-auto">

  {{-- Breadcrumb --}}
  <div class="text-sm breadcrumbs mb-4 text-base-content/50">
    <ul>
      <li><a href="{{ route('welcome') }}">الرئيسية</a></li>
      <li><a href="{{ route('products.index') }}">المتجر</a></li>
      <li>سلة التسوق</li>
    </ul>
  </div>

  {{-- Header --}}
  <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
      <h1 class="text-2xl font-bold">سلة التسوق</h1>
      <p class="text-base-content/50 text-sm mt-1">
        {{ count($cart) }} {{ count($cart) === 1 ? 'منتج' : 'منتجات' }} · الشحن محسوب تلقائياً
      </p>
    </div>
    @if(count($cart) > 0)
    <form action="{{ route('cart.clear') }}" method="POST">
      @csrf @method('DELETE')
      <button type="submit"
        class="btn btn-sm btn-ghost text-error border border-base-300 gap-2"
        onclick="return confirm('هل تريد تفريغ السلة بالكامل؟')">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M4 7h16M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
        </svg>
        تفريغ السلة
      </button>
    </form>
    @endif
  </div>

  @if(count($cart) > 0)

  @php
    $subtotal  = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
    $tax       = 0;
    $shipping  = $subtotal >= 500 ? 0 : 45;
    $total     = $subtotal + $tax + $shipping;
    $freeAt    = 500;
    $remaining = max(0, $freeAt - $subtotal);
    $progress  = min(100, round($subtotal / $freeAt * 100));

    $coupon   = session('coupon');
    $discount = 0;
    if ($coupon) {
        $discount = $coupon['discount'] ?? 0;
        $total    = max(0, $total - $discount);
    }
  @endphp

  <div class="grid co-main-grid gap-4 items-start">

    {{-- ══ Items Column ══ --}}
    <div class="flex flex-col gap-3">
      <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase">المنتجات المختارة</p>

      @foreach($cart as $id => $details)
      @php $lineTotal = $details['price'] * $details['quantity']; @endphp

      <div class="card bg-base-100 border border-base-300 shadow-none hover:border-base-content/20 transition-colors">
        <div class="card-body p-4 flex-row items-center gap-4">

          {{-- Image --}}
          <div class="w-16 h-16 rounded-xl bg-base-200 border border-base-300 flex items-center justify-center flex-shrink-0 overflow-hidden relative">
            @if(!empty($details['image']))
              <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover"
                   onerror="this.style.display='none'" loading="lazy">
            @else
              <svg class="w-7 h-7 opacity-30" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="1.3">
                <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            @endif
            @if(!empty($details['is_new']))
              <span class="absolute top-1 right-1 badge badge-xs font-bold"
                style="background:var(--accent);color:#0c0c0e;border:0">جديد</span>
            @endif
          </div>

          {{-- Info --}}
          <div class="flex-1 min-w-0">
            <p class="font-semibold text-sm">{{ $details['name'] }}</p>

            @if(!empty($details['brand']) || !empty($details['variant']))
            <div class="flex gap-1 mt-1 flex-wrap">
              @if(!empty($details['brand']))
                <span class="badge badge-sm bg-base-200 text-base-content/50 border-0">{{ $details['brand'] }}</span>
              @endif
              @if(!empty($details['variant']))
                <span class="badge badge-sm bg-base-200 text-base-content/50 border-0">{{ $details['variant'] }}</span>
              @endif
            </div>
            @endif

            <p class="text-xs mt-1 font-semibold" style="color:var(--accent)">
              {{ number_format($details['price'], 2) }} ج.م / قطعة
            </p>

            <div class="flex items-center gap-3 mt-2">
              <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-xs btn-ghost text-error gap-1 px-0 min-h-0 h-auto">
                  <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M4 7h16M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                  </svg>
                  إزالة
                </button>
              </form>
              <span class="w-1 h-1 rounded-full bg-base-300"></span>
              <form action="{{ route('wishlist.saveForLater', $id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-xs btn-ghost gap-1 px-0 min-h-0 h-auto" style="color:var(--accent)">
                  <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                  </svg>
                  حفظ لاحقاً
                </button>
              </form>
            </div>
          </div>

          {{-- Qty + Price --}}
          <div class="flex flex-col items-end gap-3 flex-shrink-0">
            <div class="join border border-base-300 rounded-lg overflow-hidden">
              <form action="{{ route('cart.update', $id) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="action" value="decrease">
                <button type="submit" class="join-item btn btn-xs btn-ghost w-7 h-7 min-h-0 text-base
                  {{ $details['quantity'] <= 1 ? 'opacity-25 pointer-events-none' : '' }}">−</button>
              </form>
              <span class="join-item flex items-center justify-center w-8 text-sm font-bold">
                {{ $details['quantity'] }}
              </span>
              <form action="{{ route('cart.update', $id) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="action" value="increase">
                <button type="submit" class="join-item btn btn-xs btn-ghost w-7 h-7 min-h-0 text-base">+</button>
              </form>
            </div>
            <p class="text-base font-bold">
              {{ number_format($lineTotal, 2) }}
              <span class="text-xs font-normal text-base-content/50">ج.م</span>
            </p>
          </div>

        </div>
      </div>
      @endforeach

      {{-- Upsell Strip --}}
      @if($remaining > 0)
      <div class="alert border" style="background:rgba(201,169,110,0.05);border-color:rgba(201,169,110,0.2);">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" style="color:var(--accent)"
          fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <div class="flex-1">
          <p class="text-xs" style="color:var(--accent)">
            أضف <strong>{{ number_format($remaining, 0) }} ج.م</strong> فقط وستحصل على شحن مجاني
          </p>
          <progress class="progress w-full mt-1 h-1" value="{{ $progress }}" max="100"
            style="accent-color:var(--accent)"></progress>
        </div>
      </div>
      @endif

      {{-- Suggested Products --}}
      @if(isset($suggested) && $suggested->count() > 0)
      <div class="mt-2">
        <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase mb-3">قد يعجبك أيضاً</p>
        <div class="grid grid-cols-2 gap-2">
          @foreach($suggested->take(4) as $prod)
          @php
            $sugPrice = $prod->discount
              ? round($prod->price * (1 - $prod->discount / 100), 0)
              : $prod->price;
          @endphp
          <div class="card bg-base-100 border border-base-300 shadow-none hover:border-[#c9a96e] transition-colors">
            <div class="card-body p-3 flex-row items-center gap-2">
              <div class="w-10 h-10 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center flex-shrink-0 overflow-hidden">
                @if($prod->image_url)
                  <img src="{{ asset('storage/' . $prod->image_url) }}" alt="{{ $prod->name }}"
                       class="w-full h-full object-cover rounded-lg">
                @else
                  <svg class="w-5 h-5 opacity-30" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="1.3">
                    <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold truncate">{{ Str::limit($prod->name, 28) }}</p>
                <p class="text-xs font-semibold mt-0.5" style="color:var(--accent)">
                  {{ number_format($sugPrice, 0) }} ج.م
                </p>
              </div>
              <form action="{{ route('cart.add', $prod->id) }}" method="POST">
                @csrf
                <button type="submit"
                  class="btn btn-xs btn-ghost w-6 h-6 min-h-0 p-0 border border-base-300 rounded-lg flex-shrink-0"
                  title="أضف للسلة">
                  <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
                  </svg>
                </button>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

    </div>{{-- end items col --}}

    {{-- ══ Summary Column ══ --}}
    <div class="lg:sticky lg:top-24">
      <div class="card bg-base-100 border border-base-300 shadow-none overflow-hidden">

        <div class="p-4 border-b border-base-300">
          <p class="font-bold text-sm">ملخص الطلب</p>
          <p class="text-xs text-base-content/50 mt-1">
            {{ count($cart) }} {{ count($cart) === 1 ? 'منتج' : 'منتجات' }} في سلتك
          </p>
        </div>

        <div class="p-4 space-y-2">
          <div class="flex justify-between text-sm">
            <span class="text-base-content/50">المجموع الفرعي</span>
            <span class="font-medium">{{ number_format($subtotal, 2) }}</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-base-content/50">الخصم</span>
            <span class="font-medium" style="color:var(--accent)">
              — {{ number_format($discount, 2) }}
            </span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-base-content/50">الشحن</span>
            <span class="font-medium {{ $shipping == 0 ? 'text-success' : '' }}">
              {{ $shipping == 0 ? 'مجاني' : number_format($shipping, 2) . ' ج.م' }}
            </span>
          </div>

            {{--
     <div class="flex justify-between text-sm">
            <span class="text-base-content/50">ضريبة القيمة المضافة 14%</span>
            <span class="font-medium">{{ number_format($tax, 2) }}</span>
        </div>

            --}}


          <div class="divider my-1"></div>

          <div>
            <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase">الإجمالي المستحق</p>
            <p class="text-3xl font-bold mt-1">
              <span class="text-xs font-normal text-base-content/40 ml-1">ج.م</span>{{ number_format($total, 2) }}
            </p>
          </div>

          {{-- Coupon --}}
         @if($coupon)
    <div class="alert py-2 px-3 text-xs" style="background:rgba(61,158,106,0.1);border:1px solid rgba(61,158,106,0.3);color:#3d9e6a;">
        ✓ تم تطبيق كوبون <strong>{{ $coupon['code'] }}</strong>
        — خصم {{ number_format($discount, 2) }} ج.م
        <form action="{{ route('coupon.remove') }}" method="POST" style="display:inline;margin-right:auto;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-xs btn-ghost text-error px-1 min-h-0 h-auto">إزالة</button>
        </form>
    </div>
@else
    {{-- ← form عادي بدل fetch --}}
    <form action="{{ route('coupon.apply') }}" method="POST" class="flex gap-2 mt-3">
        @csrf
        <input type="text" name="code" id="couponInput"
            placeholder="كود الخصم"
            value="{{ old('code') }}"
            class="input input-sm input-bordered flex-1 text-sm"
            style="font-family:'Cairo',sans-serif;" />
        <button type="submit"
            class="btn btn-sm border border-base-300 bg-transparent font-normal"
            style="font-family:'Cairo',sans-serif;color:#888;">
            تطبيق
        </button>
    </form>

    @if(session('error'))
        <p class="text-xs mt-1" style="color:#e05555;">{{ session('error') }}</p>
    @endif
    @if(session('success') && !$coupon)
        <p class="text-xs mt-1" style="color:#3d9e6a;">{{ session('success') }}</p>
    @endif
@endif

          {{-- Checkout Button --}}
          <a href="{{ route('checkout.index') }}"
            class="btn w-full mt-2 gap-2 font-bold"
            style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;font-family:'Cairo',sans-serif;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2.2">
              <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            إتمام الطلب والدفع
          </a>
        </div>

        {{-- Trust Badges --}}
        <div class="flex justify-around p-3 border-t border-base-300">
          <div class="flex flex-col items-center gap-1 text-xs text-base-content/40">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            دفع آمن
          </div>
          <div class="flex flex-col items-center gap-1 text-xs text-base-content/40">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
            </svg>
            إرجاع 30 يوم
          </div>
          <div class="flex flex-col items-center gap-1 text-xs text-base-content/40">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            شحن سريع
          </div>
        </div>

        {{-- Payment Methods --}}
        <div class="flex justify-center gap-2 p-3 border-t border-base-300">
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">VISA</span>
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">Mastercard</span>
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">Fawry</span>
          <span class="badge badge-sm bg-base-200 text-base-content/40 border-0 font-bold text-xs">Instapay</span>
        </div>

      </div>
    </div>{{-- end summary col --}}

  </div>

  @else

  {{-- Empty State --}}
  <div class="flex flex-col items-center justify-center py-24 border-2 border-dashed border-base-300 rounded-2xl bg-base-100">
    <div class="opacity-10 mb-6">
      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
        <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
    </div>
    <h2 class="text-xs font-bold tracking-widest text-base-content/40 uppercase mb-5">السلة فارغة</h2>
    <a href="{{ route('products.index') }}"
      class="btn btn-sm btn-ghost border border-base-300 gap-2"
      style="font-family:'Cairo',sans-serif;">
      <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" d="M15 19l-7-7 7-7"/>
      </svg>
      العودة للمتجر
    </a>
  </div>

  @endif

</div>
</div>

@push('scripts')
<script>
function applyCoupon() {
    const code = document.getElementById('couponInput').value.trim();
    const msg  = document.getElementById('couponMsg');
    const btn  = document.getElementById('couponBtn');

    if (!code) {
        msg.style.color = '#e05555';
        msg.textContent = 'من فضلك أدخل كود الخصم';
        return;
    }

    btn.disabled    = true;
    btn.textContent = '...';
    msg.textContent = '';

    fetch('{{ route("coupon.apply") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept':        'application/json',
            'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ code: code })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            msg.style.color = '#3d9e6a';
            msg.textContent = '✓ ' + data.message + ' — خصم ' + data.discount + ' ج.م';
            document.getElementById('couponInput').disabled = true;
            btn.textContent  = '✓';
            btn.style.color  = '#3d9e6a';
            setTimeout(() => location.reload(), 800);
        } else {
            msg.style.color = '#e05555';
            msg.textContent = data.message || 'كود غير صحيح';
            btn.disabled    = false;
            btn.textContent = 'تطبيق';
        }
    })
    .catch(() => {
        msg.style.color = '#e05555';
        msg.textContent = 'حدث خطأ في الاتصال، حاول مرة أخرى';
        btn.disabled    = false;
        btn.textContent = 'تطبيق';
    });
}
</script>
@endpush

</x-layout>
