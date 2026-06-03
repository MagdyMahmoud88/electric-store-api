<x-auth-layout title="تحقق من بريدك">

    {{-- Info Alert --}}
    @if(session('info'))
        <div class="auth-alert auth-alert-info">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('info') }}
        </div>
    @endif

    <div class="auth-card">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div class="auth-badge">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                الأمان أولاً
            </div>
            <h1 style="font-size:19px;font-weight:800;color:var(--text);margin:0 0 6px;">تحقق من هويتك</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:0;">سنرسل كود التفعيل على بريدك الإلكتروني</p>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="auth-alert auth-alert-success">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('verification.send') }}" method="POST">
            @csrf

            <div style="margin-bottom:20px;">
                <label class="auth-label">البريد الإلكتروني</label>
                <div style="position:relative;">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()?->email) }}"
                        placeholder="example@store.com"
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
                إرسال الكود
            </button>
        </form>

    </div>

</x-auth-layout>
