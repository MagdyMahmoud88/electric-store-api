{{--
    resources/views/components/coupon-form.blade.php
    الاستخدام: <x-coupon-form :subtotal="$subtotal" />
--}}

@php
    $appliedCoupon = session('coupon');
    $couponDiscount = null;

    if ($appliedCoupon && isset($subtotal)) {
        $coupon = \App\Models\Coupon::find($appliedCoupon['id']);

        if ($coupon && $subtotal >= $coupon->min_order_amount) {
            $couponDiscount = $coupon->calculateDiscount($subtotal);
        }
    }
@endphp

<div class="card bg-base-100 border border-base-300" id="coupon-section">
    <div class="card-body p-4">

        <h3 class="font-black text-sm mb-3 flex items-center gap-2">
            <i class="fa-solid fa-tag text-warning"></i>
            كوبون الخصم
        </h3>

        @if($appliedCoupon)
            {{-- كوبون مطبق --}}
            <div class="flex items-center justify-between gap-3 p-3 bg-success/10 border border-success/30 rounded-xl">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <div>
                        <p class="font-black text-sm text-success">{{ $appliedCoupon['code'] }}</p>
                        <p class="text-xs text-base-content/60">{{ $appliedCoupon['description'] }}</p>
                    </div>
                </div>
                <form action="{{ route('coupon.remove') }}" method="POST" id="remove-coupon-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-ghost btn-xs text-error hover:bg-error/10 gap-1">
                        <i class="fa-solid fa-xmark fa-xs"></i>
                        إزالة
                    </button>
                </form>
            </div>

            <div class="flex justify-between items-center mt-2 text-sm">
                <span class="text-base-content/60">قيمة الخصم</span>
                <span class="font-black text-success">
                    - {{ number_format($couponDiscount ?? 0, 2) }} ج.م
                </span>
            </div>
        @else
            {{-- فورم إدخال الكوبون --}}
            <div class="flex gap-2" id="coupon-input-wrapper">
                <input type="text"
                       id="coupon-code"
                       placeholder="أدخل كود الكوبون"
                       class="input input-bordered input-sm flex-1 text-sm uppercase"
                       maxlength="50"
                       style="text-transform:uppercase;">
                <button type="button"
                        id="apply-coupon-btn"
                        onclick="applyCoupon()"
                        class="btn btn-warning btn-sm font-black gap-1 flex-shrink-0">
                    <i class="fa-solid fa-check fa-xs"></i>
                    تطبيق
                </button>
            </div>

            <p id="coupon-message" class="text-xs mt-2 hidden"></p>
        @endif

    </div>
</div>

@once
@push('scripts')
<script>
async function applyCoupon() {
    const input  = document.getElementById('coupon-code');
    const btn    = document.getElementById('apply-coupon-btn');
    const msgEl  = document.getElementById('coupon-message');
    const code   = input?.value?.trim();

    if (!code) {
        showMsg('من فضلك أدخل كود الكوبون', 'error');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="loading loading-spinner loading-xs"></span>';

    try {
        if (!res.ok) {
            const data = await res.json().catch(() => ({}));
            showMsg(data.message || 'حصل خطأ، حاول تاني', 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check fa-xs"></i> تطبيق';
            return;
        }

        const data = await res.json();

        if (data.success) {
            // reload لتحديث السلة بالكامل
            window.location.reload();
        } else {
            showMsg(data.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check fa-xs"></i> تطبيق';
        }
        const data = await res.json();

        if (data.success) {
            // reload لتحديث السلة بالكامل
            window.location.reload();
        } else {
            showMsg(data.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check fa-xs"></i> تطبيق';
        }
    } catch {
        showMsg('حصل خطأ، حاول تاني', 'error');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check fa-xs"></i> تطبيق';
    }
}

function showMsg(text, type) {
    const el = document.getElementById('coupon-message');
    if (!el) return;
    el.textContent = text;
    el.className   = `text-xs mt-2 ${type === 'error' ? 'text-error' : 'text-success'}`;
    el.classList.remove('hidden');
}

// Enter key
document.getElementById('coupon-code')?.addEventListener('keydown', e => {
    if (e.key === 'Enter') { e.preventDefault(); applyCoupon(); }
});
</script>
@endpush
@endonce
