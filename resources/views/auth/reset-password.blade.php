<x-layout>
<div class="min-h-screen flex items-center justify-center p-4" style="background:var(--bg-deep);">

    {{-- Background glow effect --}}
    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
        <div style="position:absolute;top:-20%;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(245,158,11,0.06) 0%,transparent 70%);border-radius:50%;"></div>
    </div>

    <div style="position:relative;z-index:1;width:100%;max-width:440px;">

        {{-- Logo --}}
        <div class="flex flex-col items-center gap-3 mb-8">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3" style="text-decoration:none;">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl"
                     style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.3);">⚡</div>
                <div style="font-family:'Tajawal',sans-serif;font-size:22px;font-weight:900;color:var(--text);">
                    تـيـار <span style="color:var(--electric);">الكهرباء</span>
                </div>
            </a>
            <p class="text-sm" style="color:var(--text-muted);">تحديث أمان الحساب</p>
        </div>

        {{-- Card --}}
        <div class="rounded-[2rem] p-8 shadow-2xl" style="background:var(--surface);border:1px solid var(--border);">

            <div class="text-center mb-8">
                <div class="mx-auto mb-4 w-16 h-16 rounded-2xl flex items-center justify-center shadow-inner"
                     style="background:var(--surface2); border:1px solid var(--border);">
                    <svg class="w-8 h-8" style="color:#4ade80;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-white mb-2">كلمة سر جديدة</h2>
                <p class="text-sm px-4" style="color:var(--text-muted);">يرجى اختيار كلمة سر قوية يصعب تخمينها لضمان أمان متجرك.</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl text-xs font-bold flex items-center gap-3"
                     style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                {{-- New Password --}}
                <div class="form-control gap-1.5">
                    <label class="label py-0 px-1">
                        <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">كلمة السر الجديدة</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full transition-all duration-300"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);height:3.5rem;border-radius:1rem;">
                        <input type="password" name="password" id="password"
                               class="grow bg-transparent outline-none"
                               style="color:var(--text);"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePass('password', 'eye1')" class="text-gray-500 hover:text-white transition-colors">
                            <svg id="eye1" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </label>
                </div>

                {{-- Confirm Password --}}
                <div class="form-control gap-1.5">
                    <label class="label py-0 px-1">
                        <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">تأكيد كلمة السر</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full transition-all duration-300"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);height:3.5rem;border-radius:1rem;">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="grow bg-transparent outline-none"
                               style="color:var(--text);"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePass('password_confirmation', 'eye2')" class="text-gray-500 hover:text-white transition-colors">
                            <svg id="eye2" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </label>
                </div>

                {{-- Strength Meter --}}
                <div class="p-4 rounded-2xl bg-[#070810]/50 border border-white/5">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-gray-500">قوة الحماية:</span>
                        <span id="strength-text" class="text-xs font-black uppercase tracking-wider">—</span>
                    </div>
                    <div class="flex gap-1.5 h-1.5">
                        <div id="bar-1" class="flex-1 rounded-full bg-white/5 transition-all duration-500"></div>
                        <div id="bar-2" class="flex-1 rounded-full bg-white/5 transition-all duration-500"></div>
                        <div id="bar-3" class="flex-1 rounded-full bg-white/5 transition-all duration-500"></div>
                        <div id="bar-4" class="flex-1 rounded-full bg-white/5 transition-all duration-500"></div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-xl font-black text-base flex items-center justify-center gap-3 transition-all duration-300"
                        style="background:var(--electric);color:#070810;border:none;cursor:pointer;"
                        onmouseover="this.style.boxShadow='0 8px 30px var(--electric-glow)';this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    تحديث كلمة السر
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .input:focus-within {
        border-color: var(--electric) !important;
        box-shadow: 0 0 0 4px var(--electric-glow) !important;
    }
</style>

<script>
function togglePass(id, eye) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

document.getElementById('password').addEventListener('input', function () {
    const val = this.value;
    const text = document.getElementById('strength-text');
    let score = 0;

    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const config = [
        { label: 'ضعيفة جداً', color: '#f87171' }, // Red
        { label: 'ضعيفة', color: '#fb923c' },      // Orange
        { label: 'متوسطة', color: '#facc15' },    // Yellow
        { label: 'قوية', color: '#4ade80' },      // Green
        { label: 'فولاذية ⚡', color: 'var(--electric)' } // Electric
    ];

    const currentScore = val.length === 0 ? -1 : score;
    text.textContent = currentScore === -1 ? '—' : config[currentScore].label;
    text.style.color = currentScore === -1 ? 'gray' : config[currentScore].color;

    for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById(`bar-${i}`);
        if (i <= currentScore) {
            bar.style.backgroundColor = config[currentScore].color;
            if(currentScore >= 3) bar.style.boxShadow = `0 0 8px ${config[currentScore].color}66`;
        } else {
            bar.style.backgroundColor = 'rgba(255,255,255,0.05)';
            bar.style.boxShadow = 'none';
        }
    }
});
</script>
</x-layout>
