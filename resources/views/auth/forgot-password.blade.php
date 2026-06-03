<x-auth-layout title="نسيت كلمة السر">

    <div class="auth-card">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div class="auth-badge">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                استعادة الحساب
            </div>
            <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 6px;">نسيت كلمة السر؟</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:0;">أدخل بريدك وهنبعتلك رابط إعادة التعيين</p>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="auth-alert auth-alert-success">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Error --}}
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

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div style="margin-bottom:20px;">
                <label class="auth-label">البريد الإلكتروني</label>
                <div style="position:relative;">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
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

            <button type="submit" class="auth-btn">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                إرسال رابط الاستعادة
            </button>
        </form>

        <div class="auth-divider">أو</div>

        <div style="text-align:center;">
            <a href="{{ route('login') }}" class="auth-link">
                ← رجوع لتسجيل الدخول
            </a>
        </div>

    </div>

</x-auth-layout>
