<x-layout>
<div class="min-h-screen flex items-center justify-center p-4" style="background:var(--bg-deep);">

    {{-- Background glow effect --}}
    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
        <div style="position:absolute;top:-20%;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(245,158,11,0.06) 0%,transparent 70%);border-radius:50%;"></div>
    </div>

    <div style="position:relative;z-index:1;width:100%;max-width:440px;">

        {{-- Logo (نفس ستايل صفحة الدخول) --}}
        <div class="flex flex-col items-center gap-3 mb-8">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3" style="text-decoration:none;">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl"
                     style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.3);">⚡</div>
                <div style="font-family:'Tajawal',sans-serif;font-size:22px;font-weight:900;color:var(--text);">
                    تـيـار <span style="color:var(--electric);">الكهرباء</span>
                </div>
            </a>
            <p class="text-sm" style="color:var(--text-muted);">استعادة الوصول لحسابك</p>
        </div>

        {{-- Card --}}
        <div class="rounded-[2rem] p-8 shadow-2xl" style="background:var(--surface);border:1px solid var(--border);">

            <div class="text-center mb-8">
                <div class="mx-auto mb-4 w-16 h-16 rounded-2xl flex items-center justify-center shadow-inner"
                     style="background:var(--surface2); border:1px solid var(--border);">
                    <svg class="w-8 h-8" style="color:var(--electric);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-white mb-2">نسيت كلمة السر؟</h2>
                <p class="text-sm px-4" style="color:var(--text-muted);">لا تقلق، أدخل بريدك الإلكتروني وسنرسل لك رابطاً لتعيين كلمة سر جديدة.</p>
            </div>

            {{-- Success Message --}}
            @if(session('status'))
                <div class="mb-6 p-4 rounded-xl text-sm font-bold flex items-center gap-3"
                     style="background:rgba(34,197,94,0.1); color:#4ade80; border:1px solid rgba(34,197,94,0.2);">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div class="form-control gap-1.5">
                    <label class="label py-0 px-1">
                        <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">البريد الإلكتروني</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full transition-all duration-300"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);height:3.5rem;border-radius:1rem;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);flex-shrink:0;">
                            <path stroke-linecap="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" name="email"
                               class="grow bg-transparent outline-none text-left"
                               style="color:var(--text);"
                               dir="ltr"
                               value="{{ old('email') }}"
                               placeholder="mail@example.com">
                    </label>
                    @error('email')
                        <p class="text-xs mt-1 font-bold text-red-400 px-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-xl font-black text-base flex items-center justify-center gap-3 transition-all duration-300 group"
                        style="background:var(--electric);color:#070810;border:none;cursor:pointer;"
                        onmouseover="this.style.boxShadow='0 8px 30px var(--electric-glow)';this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
                    <span>إرسال رابط التغيير</span>
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </button>
            </form>

            {{-- Back to Login --}}
            <div class="text-center mt-8 pt-6" style="border-top:1px solid var(--border);">
                <a href="{{ route('login.index') }}"
                   class="text-sm font-bold flex items-center justify-center gap-2 transition-all"
                   style="color:var(--text-muted);text-decoration:none;"
                   onmouseover="this.style.color='var(--electric)'"
                   onmouseout="this.style.color='var(--text-muted)'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    العودة لتسجيل الدخول
                </a>
            </div>
        </div>

        <p class="text-center text-xs mt-8" style="color:var(--text-muted); opacity:0.6;">
            نظام حماية تيار الكهربائي ⚡ مؤمن بنسبة 100%
        </p>
    </div>
</div>

<style>
    .input:focus-within {
        border-color: var(--electric) !important;
        box-shadow: 0 0 0 4px var(--electric-glow) !important;
    }
    input::placeholder {
        color: var(--text-muted) !important;
        opacity: 0.5;
    }
</style>
</x-layout>
