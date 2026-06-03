<x-layout title="إتمام الدفع">

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

<div class="bg-base-200 min-h-screen flex items-center justify-center p-4" dir="rtl"
     style="font-family:'Cairo',sans-serif;">
<div class="w-full max-w-md">

  {{-- Header --}}
  <div class="text-center mb-6">
    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3"
         style="background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.2);">
      <svg class="w-7 h-7" style="color:#c9a96e" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 9h20"/>
      </svg>
    </div>
    <h1 class="text-lg font-bold">إتمام الدفع</h1>
    <p class="text-sm text-base-content/50 mt-1">الطلب رقم {{ $order->order_number }}</p>
  </div>

  {{-- Order Summary --}}
  <div class="card bg-base-100 border border-base-300 shadow-none mb-4">
    <div class="card-body p-5 space-y-2">
      <div class="flex justify-between text-sm">
        <span class="text-base-content/50">المجموع الفرعي</span>
        <span>{{ number_format($order->subtotal, 2) }} ج.م</span>
      </div>
      @if($order->discount > 0)
      <div class="flex justify-between text-sm">
        <span class="text-base-content/50">الخصم</span>
        <span style="color:#4caf7d">— {{ number_format($order->discount, 2) }} ج.م</span>
      </div>
      @endif
      <div class="flex justify-between text-sm">
        <span class="text-base-content/50">الشحن</span>
        <span class="{{ $order->shipping == 0 ? 'text-success' : '' }}">
          {{ $order->shipping == 0 ? 'مجاني' : number_format($order->shipping, 2) . ' ج.م' }}
        </span>
      </div>
      <div class="flex justify-between text-sm">
        <span class="text-base-content/50">ضريبة 14%</span>
        <span>{{ number_format($order->tax, 2) }} ج.م</span>
      </div>
      <div class="divider my-1"></div>
      <div class="flex justify-between items-baseline">
        <span class="font-bold">الإجمالي</span>
        <span class="text-2xl font-bold" style="color:#c9a96e">
          {{ number_format($order->total, 2) }}
          <span class="text-xs font-normal text-base-content/40">ج.م</span>
        </span>
      </div>
    </div>
  </div>

  {{-- Test Mode --}}
  @if($mode === 'test')
  <div class="flex items-center gap-2 mb-4 py-2 px-4 rounded-xl text-xs"
       style="background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);color:#c9a96e;">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span>وضع الاختبار — بطاقة: <strong class="font-mono">5123450000000008</strong> | CVV: <strong>100</strong> | Exp: <strong>12/25</strong></span>
  </div>
  @endif

  {{-- Kashier Button Container --}}
  <div class="card bg-base-100 border border-base-300 shadow-none mb-4">
    <div class="card-body p-5 text-center">
      <p class="text-xs text-base-content/40 mb-4 flex items-center justify-center gap-1">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
        </svg>
        اضغط الزرار أدناه لإتمام الدفع بأمان عبر Kashier
      </p>

      <div id="kashier-btn-container" class="flex justify-center min-h-[44px] items-center">
        <span class="loading loading-spinner loading-sm opacity-40"></span>
      </div>

      <p class="text-xs text-base-content/30 mt-3 flex items-center justify-center gap-1">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
        </svg>
        مدفوعاتك محمية بتشفير SSL — مدعوم من Kashier
      </p>
    </div>
  </div>

  {{-- Payment Methods --}}
  <div class="flex justify-center gap-2 mb-4">
    <span class="badge badge-sm bg-base-100 border border-base-300 text-base-content/40 font-bold text-xs">VISA</span>
    <span class="badge badge-sm bg-base-100 border border-base-300 text-base-content/40 font-bold text-xs">Mastercard</span>
    <span class="badge badge-sm bg-base-100 border border-base-300 text-base-content/40 font-bold text-xs">Meeza</span>
    <span class="badge badge-sm bg-base-100 border border-base-300 text-base-content/40 font-bold text-xs">Fawry</span>
  </div>

  <div class="text-center">
    <a href="{{ route('checkout.index') }}"
       class="text-xs text-base-content/40 hover:text-base-content/70 transition-colors">
      ← العودة وتعديل الطلب
    </a>
  </div>

</div>
</div>

{{-- ← Kashier script في @push('kashier') عشان يتحمل قبل @stack('scripts') --}}
@push('kashier')
<script
  src="{{ $scriptSrc }}"
  data-amount="{{ $amount }}"
  data-description="طلب رقم {{ $orderId }}"
  data-hash="{{ $hash }}"
  data-currency="{{ $currency }}"
  data-orderId="{{ $orderId }}"
  data-merchantId="{{ $mid }}"
  data-merchantRedirect="{{ $callbackUrl }}"
  data-store="{{ env('KASHIER_STORE_NAME') }}"
  data-type="external"
  data-display="ar"
  data-allow-card-token="false">
</script>
@endpush

@push('scripts')
<script>
// امسح الـ spinner بعد تحميل الصفحة
window.addEventListener('load', function() {
    setTimeout(function() {
        var spinner = document.querySelector('#kashier-btn-container .loading');
        if (spinner) spinner.style.display = 'none';
    }, 1000);
});
</script>
@endpush

</x-layout>