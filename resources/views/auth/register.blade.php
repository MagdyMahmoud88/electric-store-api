<x-auth-layout title="إنشاء حساب جديد">

    <div class="auth-card">

        {{-- Header --}}
        <div style="text-align:center; margin-bottom:24px;">
            <h1 style="font-size:20px; font-weight:800; color:var(--text); margin:0 0 6px;">أنشئ حسابك الجديد</h1>
            <p style="font-size:13px; color:var(--text-muted); margin:0;">انضم إلينا وابدأ التسوق الآن</p>
        </div>

        {{-- Errors List --}}
        @if($errors->any())
            <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul style="margin:0; padding:0; list-style:none; font-size:13px; line-height:1.5;">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            {{-- Name Input (RTL) --}}
            <div style="margin-bottom:16px;">
                <label class="auth-label">الاسم الكامل</label>
                <div style="position:relative;">
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="محمد أحمد"
                        class="auth-input {{ $errors->has('name') ? 'error' : '' }}"
                        style="padding-right:42px;"

                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute; right:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @error('name')
                <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Input (LTR) --}}
            <div style="margin-bottom:16px;">
                <label class="auth-label">البريد الإلكتروني</label>
                <div style="position:relative;">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="mail@example.com"
                        dir="ltr"
                        class="auth-input {{ $errors->has('email') ? 'error' : '' }}"
                        style="padding-left:42px; text-align: left;"

                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                @error('email')
                <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Input (LTR) --}}
            <div style="margin-bottom:16px;">
                <label class="auth-label">كلمة المرور</label>
                <div style="position:relative;">
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        placeholder="••••••••"
                        dir="ltr"
                        class="auth-input {{ $errors->has('password') ? 'error' : '' }}"
                        style="padding-left:42px; padding-right:42px; text-align: left;"

                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <button type="button" onclick="togglePassword('passwordInput','eye1')"
                            style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0; display:flex; align-items:center;">
                        <svg id="eye1" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password Input (LTR) --}}
            <div style="margin-bottom:22px;">
                <label class="auth-label">تأكيد كلمة المرور</label>
                <div style="position:relative;">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="confirmInput"
                        placeholder="••••••••"
                        dir="ltr"
                        class="auth-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                        style="padding-left:42px; padding-right:42px; text-align: left;"

                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <button type="button" onclick="togglePassword('confirmInput','eye2')"
                            style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0; display:flex; align-items:center;">
                        <svg id="eye2" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="auth-btn">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span>إنشاء الحساب</span>
            </button>
        </form>

        {{-- Divider --}}
        <div class="auth-divider">أو</div>

        {{-- Login Link --}}
        <div style="text-align:center;">
            <span style="font-size:13px; color:var(--text-muted);">لديك حساب بالفعل؟ </span>
            <a href="{{ route('login') }}" class="auth-link">سجل دخولك</a>
        </div>

    </div>

    {{-- Terms note --}}
    <p style="text-align:center; margin-top:18px; font-size:12px; color:var(--text-muted); opacity:0.8; line-height:1.5; padding:0 8px;">
        بالتسجيل أنت توافق على <a href="#" class="auth-link" style="font-size:12px;">شروط الاستخدام</a> و <a href="#" class="auth-link" style="font-size:12px;">سياسة الخصوصية</a> الخاصة بالمتجر
    </p>

</x-auth-layout>

{{-- سكربت ديناميكي مطور للتحكم في الأيقونات معاً بدون تداخل --}}
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
