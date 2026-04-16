<x-layout>

<div class="min-h-screen flex items-center justify-center p-4" style="background:var(--bg-deep);">

    {{-- Background glow --}}
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
                    متجر <span style="color:var(--electric);">الكهرباء</span>
                </div>
            </a>
            <p class="text-sm" style="color:var(--text-muted);">مرحباً بعودتك</p>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl p-8" style="background:var(--surface);border:1px solid var(--border);">

            {{-- Errors --}}
            @if($errors->any())
                <div role="alert" class="alert alert-error mb-5 text-sm py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div class="form-control gap-1.5">
                    <label class="label py-0">
                        <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">البريد الإلكتروني</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);flex-shrink:0;">
                            <path stroke-linecap="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" name="email"
                               class="grow bg-transparent outline-none"
                               style="color:var(--text);"
                               value="{{ old('email') }}"
                               placeholder="mail@example.com">
                    </label>
                    <x-error name="email" />
                </div>

                {{-- Password --}}
               {{-- Password --}}
                <div class="form-control gap-1.5">
                    <div class="flex justify-between items-center px-1">
                        <label class="label py-0">
                            <span class="label-text font-semibold text-sm" style="color:var(--text-soft);">كلمة المرور</span>
                        </label>
                        {{-- رابط نسيت كلمة السر الجديد --}}
                        <a href="{{ route('password.request') }}"
                           class="text-xs font-medium transition-colors"
                           style="color:var(--text-muted); text-decoration:none;"
                           onmouseover="this.style.color='var(--electric)'"
                           onmouseout="this.style.color='var(--text-muted)'">
                            نسيت كلمة السر؟
                        </a>
                    </div>

                    <label class="input input-bordered flex items-center gap-3 w-full"
                           style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);flex-shrink:0;">
                            <path stroke-linecap="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" name="password"
                               id="passwordInput"
                               class="grow bg-transparent outline-none"
                               style="color:var(--text);"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                                 style="background:none;border:none;cursor:pointer;padding:0;color:var(--text-muted);">
                            <svg id="eyeIcon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </label>
                    <x-error name="password" />
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-3 pt-1">
                    <input type="checkbox"
                           name="remember"
                           id="remember"
                           value="1"
                           class="checkbox checkbox-sm height-4 w-4 rounded focus:ring-0 bg-amber-500"
                           style="border-color:var(--border-hover);--chkbg:var(--electric);--chkfg:#070810;">
                    <label for="remember" class="text-sm cursor-pointer select-none" style="color:var(--text-soft);">
                        تذكرني
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full mt-2 py-3 rounded-xl font-black text-base flex items-center justify-center gap-2 transition-all duration-200"
                        style="background:var(--electric);color:#070810;border:none;cursor:pointer;"
                        onmouseover="this.style.boxShadow='0 8px 24px var(--electric-glow)';this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.boxShadow='none';this.style.transform='translateY(0)'">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    تسجيل الدخول
                </button>

            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px" style="background:var(--border);"></div>
                <span class="text-xs" style="color:var(--text-muted);">أو</span>
                <div class="flex-1 h-px" style="background:var(--border);"></div>
            </div>

            {{-- Register link --}}
            <div class="text-center">
                <span class="text-sm" style="color:var(--text-muted);">ليس لديك حساب؟ </span>
                <a href="{{ route('register.index') }}"
                   class="text-sm font-black"
                   style="color:var(--electric);text-decoration:none;"
                   onmouseover="this.style.textDecoration='underline'"
                   onmouseout="this.style.textDecoration='none'">
                    أنشئ حساباً الآن
                </a>
            </div>

        </div>

        {{-- Footer note --}}
        <p class="text-center text-xs mt-6" style="color:var(--text-muted);">
            🔒 بياناتك محمية وآمنة تماماً
        </p>

    </div>
</div>

<style>
    .input:focus-within {
        border-color: var(--electric) !important;
        box-shadow: 0 0 0 3px var(--electric-glow) !important;
        outline: none;
    }
    .checkbox:checked {
        background-color: var(--electric);
        border-color: var(--electric);
    }
</style>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.style.opacity = isHidden ? '1' : '0.4';
}
</script>

</x-layout>
