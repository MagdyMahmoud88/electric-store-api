<x-auth-layout title="التحقق بخطوتين">

    <div class="auth-card">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div class="auth-badge">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                التحقق بخطوتين
            </div>
            <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 6px;">تحقق من هويتك</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:0;">
                أرسلنا كود التحقق على بريدك الإلكتروني
            </p>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="auth-alert auth-alert-success" style="margin-bottom:20px;">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

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

        {{-- OTP Form --}}
        <form action="{{ route('2fa.verify') }}" method="POST" id="twoFaForm">
            @csrf

            <div style="margin-bottom:8px;text-align:center;">
                <label class="auth-label" style="display:block;margin-bottom:16px;">أدخل الكود المكوّن من 6 أرقام</label>
            </div>

            <div class="otp-grid" style="margin-bottom:24px;">
                @for($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]"
                        class="otp-input"
                        id="fa_{{ $i }}"
                        autocomplete="off"
                    >
                @endfor
            </div>

            <input type="hidden" name="code" id="faHidden">

            <button type="submit" class="auth-btn" style="margin-bottom:16px;">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                تأكيد الدخول
            </button>
        </form>

        {{-- Resend --}}
        <div style="text-align:center;margin-bottom:16px;">
            <span style="font-size:13px;color:var(--text-muted);">ما وصلكش الكود؟ </span>
            <form action="{{ route('2fa.send') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;font-size:13px;font-weight:700;color:var(--electric);font-family:'Cairo',sans-serif;padding:0;">
                    أعد الإرسال
                </button>
            </form>
        </div>

        <div class="auth-divider">أو</div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="auth-btn-outline">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                تسجيل الخروج
            </button>
        </form>

    </div>

</x-auth-layout>

<script>
    const faInputs = Array.from({length: 6}, (_, i) => document.getElementById(`fa_${i}`));

    faInputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/\D/g, '');
            e.target.value = val;
            if (val && idx < 5) faInputs[idx + 1].focus();
            updateFaHidden();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                faInputs[idx - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            text.split('').slice(0, 6).forEach((char, i) => {
                if (faInputs[i]) faInputs[i].value = char;
            });
            faInputs[Math.min(text.length, 5)].focus();
            updateFaHidden();
        });
    });

    function updateFaHidden() {
        document.getElementById('faHidden').value = faInputs.map(i => i.value).join('');
    }

    faInputs[5].addEventListener('input', () => {
        if (faInputs.every(i => i.value)) {
            updateFaHidden();
            document.getElementById('twoFaForm').submit();
        }
    });

    faInputs[0].focus();
</script>
