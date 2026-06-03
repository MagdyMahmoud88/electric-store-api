<x-auth-layout title="تعيين كلمة سر جديدة">

    <div class="auth-card">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div class="auth-badge">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                كلمة سر جديدة
            </div>
            <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 6px;">تعيين كلمة سر جديدة</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:0;">اختار كلمة سر قوية لحماية حسابك</p>
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

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div style="margin-bottom:14px;">
                <label class="auth-label">البريد الإلكتروني</label>
                <div style="position:relative;">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $email ?? '') }}"
                        placeholder="mail@example.com"
                        dir="ltr"
                        class="auth-input {{ $errors->has('email') ? 'error' : '' }}"
                        style="padding-left:40px;"
                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);">
                        <path stroke-linecap="round" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                @error('email')
                <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div style="margin-bottom:14px;">
                <label class="auth-label">كلمة المرور الجديدة</label>
                <div style="position:relative;">
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        placeholder="••••••••"
                        dir="ltr"
                        class="auth-input {{ $errors->has('password') ? 'error' : '' }}"
                        style="padding-left:40px;padding-right:44px;"
                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);">
                        <path stroke-linecap="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <button type="button" onclick="togglePassword('passwordInput','eye1')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0;display:flex;">
                        <svg id="eye1" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div style="margin-bottom:20px;">
                <label class="auth-label">تأكيد كلمة المرور</label>
                <div style="position:relative;">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="confirmInput"
                        placeholder="••••••••"
                        dir="ltr"
                        class="auth-input"
                        style="padding-left:40px;padding-right:44px;"
                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);">
                        <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <button type="button" onclick="togglePassword('confirmInput','eye2')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0;display:flex;">
                        <svg id="eye2" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="auth-btn">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                </svg>
                تعيين كلمة السر
            </button>
        </form>

    </div>

</x-auth-layout>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const show  = input.type === 'password';
        input.type         = show ? 'text' : 'password';
        icon.style.opacity = show ? '1' : '0.4';
    }
</script>
