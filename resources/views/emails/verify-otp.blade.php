<x-auth-layout title="أدخل كود التحقق">

    <div class="auth-card">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div class="auth-badge">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                التحقق من البريد
            </div>
            <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 6px;">أدخل كود التحقق</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:0;">
                تم إرسال كود مكوّن من 6 أرقام إلى
                <span style="color:var(--electric);font-weight:700;">{{ $email }}</span>
            </p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                    <path stroke-linecap="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul style="margin:0;padding:0;list-style:none;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('verification.verify') }}" method="POST" id="otpForm">
            @csrf

            {{-- OTP Inputs --}}
            <div class="otp-grid" style="margin-bottom:24px;">
                @for($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]"
                        class="otp-input"
                        id="otp_{{ $i }}"
                        autocomplete="off"
                    >
                @endfor
            </div>

            {{-- Hidden field --}}
            <input type="hidden" name="otp" id="otpHidden">

            <button type="submit" class="auth-btn" style="margin-bottom:16px;">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                تحقق من الكود
            </button>
        </form>

        {{-- Resend --}}
        <div style="text-align:center;">
            <span style="font-size:13px;color:var(--text-muted);">ما وصلكش الكود؟ </span>
            <form action="{{ route('verification.resend') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;font-size:13px;font-weight:700;color:var(--electric);font-family:'Cairo',sans-serif;padding:0;">
                    أعد الإرسال
                </button>
            </form>
        </div>

    </div>

</x-auth-layout>

<script>
    // ── OTP inputs navigation ──────────────────────────────────
    const inputs = Array.from({length: 6}, (_, i) => document.getElementById(`otp_${i}`));

    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/\D/g, '');
            e.target.value = val;
            if (val && idx < 5) inputs[idx + 1].focus();
            updateHidden();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            text.split('').slice(0, 6).forEach((char, i) => {
                if (inputs[i]) inputs[i].value = char;
            });
            inputs[Math.min(text.length, 5)].focus();
            updateHidden();
        });
    });

    function updateHidden() {
        document.getElementById('otpHidden').value = inputs.map(i => i.value).join('');
    }

    // ── Auto-submit لو اكتملت الـ 6 أرقام ──────────────────────
    inputs[5].addEventListener('input', () => {
        if (inputs.every(i => i.value)) {
            updateHidden();
            document.getElementById('otpForm').submit();
        }
    });

    // Focus أول input
    inputs[0].focus();
</script>
