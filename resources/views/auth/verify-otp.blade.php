<x-layout>

<div class="min-h-screen flex items-center justify-center p-4"
     style="background:var(--bg-deep);">

    {{-- Background glow --}}
    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
        <div style="position:absolute;top:-10%;left:50%;transform:translateX(-50%);
                    width:700px;height:700px;
                    background:radial-gradient(circle,rgba(245,158,11,0.05) 0%,transparent 65%);
                    border-radius:50%;"></div>
    </div>

    <div style="position:relative;z-index:1;width:100%;max-width:420px;">

        {{-- Logo --}}
        <div class="flex flex-col items-center gap-3 mb-8">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3" style="text-decoration:none;">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl"
                     style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.3);
                            box-shadow:0 0 30px rgba(245,158,11,.15);">⚡</div>
                <div style="font-family:'Tajawal',sans-serif;font-size:24px;font-weight:900;color:var(--text);">
                    متجر <span style="color:var(--electric);">الكهرباء</span>
                </div>
            </a>
        </div>

        {{-- Card --}}
        <div class="rounded-3xl overflow-hidden"
             style="background:var(--surface);border:1px solid var(--border);
                    box-shadow:0 32px 80px rgba(0,0,0,.4);">

            {{-- Header strip --}}
            <div class="px-8 pt-8 pb-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase mb-5"
                     style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.25);color:var(--electric);">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:var(--electric);animation:pulse-glow 2s infinite;"></span>
                    تحقق من هويتك
                </div>
                <h2 class="text-2xl font-black mb-2" style="color:var(--text);">أدخل رمز التحقق</h2>
                <p class="text-sm leading-relaxed" style="color:var(--text-muted);">
                    أرسلنا كوداً مكوناً من 6 أرقام إلى
                    <br>
                    <span class="font-black" style="color:var(--electric);">{{ $email }}</span>
                </p>
            </div>

            <div class="px-8 pb-8">

                {{-- Timer bar --}}
                <div class="mb-7">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold tracking-wider uppercase" style="color:var(--text-muted);">صلاحية الكود</span>
                        <span id="timer-text" class="text-sm font-black" style="color:var(--electric);">10:00</span>
                    </div>
                    <div class="h-1 rounded-full overflow-hidden" style="background:var(--surface2);">
                        <div id="progress-bar"
                             class="h-full rounded-full transition-all duration-1000"
                             style="width:100%;background:var(--electric);
                                    box-shadow:0 0 8px var(--electric-glow);"></div>
                    </div>
                </div>

                {{-- Errors --}}
                @error('otp')
                <div class="flex items-center gap-2 px-4 py-3 rounded-xl mb-5 text-sm font-bold"
                     style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.3);color:#fca5a5;">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    {{ $message }}
                </div>
                @enderror

                {{-- OTP Form --}}
                <form action="{{ route('verification.verify') }}" method="POST" id="otp-form">
                    @csrf
                    <input type="hidden" name="otp" id="otp-hidden">

                    {{-- OTP boxes --}}
                    <div class="flex justify-center gap-3 mb-8 flex-row-reverse" id="otp-container">
                        @for($i = 0; $i < 6; $i++)
                        <input class="otp-box @error('otp') otp-error @enderror"
                               type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                               autocomplete="off"
                               style="
                                   width:48px; height:60px;
                                   font-size:1.6rem; font-weight:900;
                                   text-align:center;
                                   background:var(--surface2);
                                   border:2px solid var(--border);
                                   border-radius:14px;
                                   color:var(--text);
                                   outline:none;
                                   transition:all .25s cubic-bezier(.16,1,.3,1);
                                   font-family:'Cairo',sans-serif;
                               ">
                        @endfor
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="verify-btn"
                            class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-black text-base transition-all duration-200"
                            style="background:var(--electric);color:#070810;border:none;cursor:pointer;"
                            onmouseover="this.style.boxShadow='0 10px 32px var(--electric-glow)';this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        تأكيد الرمز
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-5">
                    <div class="flex-1 h-px" style="background:var(--border);"></div>
                    <span class="text-[10px] font-bold tracking-wider uppercase" style="color:var(--text-muted);">أو</span>
                    <div class="flex-1 h-px" style="background:var(--border);"></div>
                </div>

                {{-- Resend --}}
                <div class="text-center">
                    <p class="text-xs mb-2" style="color:var(--text-muted);">لم يصلك الرمز؟</p>
                    <form action="{{ route('verification.resend') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" id="resend-btn" disabled
                                class="text-sm font-black transition-all duration-200 disabled:opacity-30"
                                style="background:none;border:none;color:var(--electric);cursor:pointer;">
                            إعادة الإرسال (<span id="resend-counter">60</span>ث)
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Change email --}}
        <div class="text-center mt-6">
            <a href="{{ route('verification.email') }}"
               class="inline-flex items-center gap-2 text-xs transition-all duration-200"
               style="color:var(--text-muted);text-decoration:none;"
               onmouseover="this.style.color='var(--text)'"
               onmouseout="this.style.color='var(--text-muted)'">
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                تغيير البريد الإلكتروني
            </a>
        </div>

    </div>
</div>

<style>
    @keyframes pulse-glow {
        0%,100% { opacity:1; transform:scale(1); }
        50%      { opacity:.4; transform:scale(1.6); }
    }
    @keyframes shake {
        0%,100% { transform:translateX(0); }
        20%,60% { transform:translateX(-5px); }
        40%,80% { transform:translateX(5px); }
    }
    @keyframes bounce-in {
        0%   { transform:translateY(-6px) scale(.95); opacity:0; }
        100% { transform:translateY(0) scale(1); opacity:1; }
    }

    .otp-box:focus {
        border-color: var(--electric) !important;
        background: var(--electric-dim) !important;
        box-shadow: 0 0 0 3px var(--electric-glow), 0 8px 20px rgba(0,0,0,.2) !important;
        transform: translateY(-3px) scale(1.05) !important;
        color: var(--electric) !important;
    }
    .otp-box.filled {
        border-color: var(--electric) !important;
        color: var(--electric) !important;
        background: rgba(245,158,11,.05) !important;
        animation: bounce-in .2s cubic-bezier(.16,1,.3,1);
    }
    .otp-error {
        border-color: #ef4444 !important;
        background: rgba(239,68,68,.08) !important;
        animation: shake .4s ease;
    }
</style>

<script>
const inputs      = document.querySelectorAll('.otp-box');
const hiddenInput = document.getElementById('otp-hidden');
const form        = document.getElementById('otp-form');

function getOTP() {
    return [...inputs].map(i => i.value).reverse().join('');
}

inputs.forEach((input, i) => {
    input.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g, '');
        e.target.value = val;
        if (val) {
            e.target.classList.add('filled');
            if (i > 0) inputs[i - 1].focus();
        } else {
            e.target.classList.remove('filled');
        }
        if (getOTP().length === 6) {
            hiddenInput.value = getOTP();
            document.getElementById('verify-btn').style.opacity = '.7';
            setTimeout(() => form.submit(), 350);
        }
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !input.value && i < inputs.length - 1) {
            inputs[i + 1].focus();
        }
        // Allow paste
        if (e.key === 'v' && (e.ctrlKey || e.metaKey)) return;
    });

    // Handle paste
    input.addEventListener('paste', e => {
        e.preventDefault();
        const text = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
        const reversed = text.split('').reverse();
        reversed.forEach((char, idx) => {
            if (inputs[idx]) {
                inputs[idx].value = char;
                inputs[idx].classList.add('filled');
            }
        });
        if (text.length === 6) {
            hiddenInput.value = text;
            setTimeout(() => form.submit(), 350);
        }
    });
});

// Focus last input (RTL — rightmost = first digit)
inputs[inputs.length - 1].focus();

// ── Timer ──
let totalSeconds = 600;
const timerText  = document.getElementById('timer-text');
const progressBar = document.getElementById('progress-bar');

const timerInterval = setInterval(() => {
    totalSeconds--;
    const m = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
    const s = String(totalSeconds % 60).padStart(2, '0');
    timerText.textContent = `${m}:${s}`;
    const pct = (totalSeconds / 600) * 100;
    progressBar.style.width = pct + '%';

    // Color shifts as time runs out
    if (pct < 20) {
        progressBar.style.background = '#ef4444';
        progressBar.style.boxShadow  = '0 0 8px rgba(239,68,68,.5)';
        timerText.style.color = '#ef4444';
    } else if (pct < 50) {
        progressBar.style.background = '#f97316';
        timerText.style.color = '#f97316';
    }

    if (totalSeconds <= 0) clearInterval(timerInterval);
}, 1000);

// ── Resend countdown ──
let resendSec     = 60;
const resendBtn   = document.getElementById('resend-btn');
const resendSpan  = document.getElementById('resend-counter');

const resendInterval = setInterval(() => {
    resendSec--;
    resendSpan.textContent = resendSec;
    if (resendSec <= 0) {
        clearInterval(resendInterval);
        resendBtn.disabled = false;
        resendBtn.innerHTML = '✉️ إعادة الإرسال الآن';
    }
}, 1000);
</script>

</x-layout>
