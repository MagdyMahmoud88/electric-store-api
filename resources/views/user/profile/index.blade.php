<x-layout>
    <x-slot name="title">الملف الشخصي</x-slot>

    <div class="profile-page">

        {{-- ── HERO HEADER ── --}}
        <div class="profile-hero">
            <div class="profile-hero-bg"></div>
            <div class="profile-hero-inner">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-avatar-ring"></div>
                </div>
                <div class="profile-hero-info">
                    <h1 class="profile-name">{{ auth()->user()->name }}</h1>
                    <p class="profile-email">{{ auth()->user()->email }}</p>
                    <div class="profile-joined">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        عضو منذ {{ auth()->user()->created_at->format('Y') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ── STATS ROW ── --}}
        <div class="profile-container">
            <div class="profile-stats">
                <div class="stat-card">
                    <div class="stat-icon stat-icon--orders">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <span class="stat-value">{{ auth()->user()->orders()->count() ?? 0 }}</span>
                        <span class="stat-label">طلباتي</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon--wishlist">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <span class="stat-value">{{ auth()->user()->wishlists()->count() }}</span>
                        <span class="stat-label">المفضلة</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon--reviews">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div class="stat-body">
                        <span class="stat-value">{{ auth()->user()->reviews()->count() ?? 0 }}</span>
                        <span class="stat-label">تقييماتي</span>
                    </div>
                </div>
            </div>

            {{-- ── TABS ── --}}
            <div class="profile-tabs">
                <button class="profile-tab active" onclick="switchTab('info', this)">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    بيانات الحساب
                </button>
                <button class="profile-tab" onclick="switchTab('password', this)">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    كلمة المرور
                </button>
            </div>

            {{-- ── TAB: بيانات الحساب ── --}}
            <div id="tab-info" class="profile-panel">

                @if(session('success'))
                    <div class="profile-alert profile-alert--success">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                    @csrf @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                الاسم الكامل
                            </label>
                            <input type="text" name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   class="form-input @error('name') is-error @enderror"
                                   placeholder="أدخل اسمك">
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                البريد الإلكتروني
                            </label>
                            <input type="email" name="email" disabled
                                   value="{{ old('email', auth()->user()->email) }}"

                                   placeholder="example@email.com">
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-profile-save">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── TAB: كلمة المرور ── --}}
            <div id="tab-password" class="profile-panel" style="display:none;">

                @if(session('success_password'))
                    <div class="profile-alert profile-alert--success">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ session('success_password') }}
                    </div>
                @endif

                <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
                    @csrf @method('PUT')

                    <div class="form-group" style="max-width:480px;">
                        <label class="form-label">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            كلمة المرور الحالية
                        </label>
                        <input type="password" name="current_password"
                               class="form-input @error('current_password') is-error @enderror"
                               placeholder="••••••••">
                        @error('current_password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                كلمة المرور الجديدة
                            </label>
                            <input type="password" name="password"
                                   class="form-input @error('password') is-error @enderror"
                                   placeholder="••••••••">
                            @error('password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                تأكيد كلمة المرور
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="form-input"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-profile-save">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            تحديث كلمة المرور
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- ── STYLES ── --}}
    @push('scripts')
    <style>
    /* ── Page ── */
    .profile-page {
        min-height: 80vh;
        padding-bottom: 4rem;
    }

    /* ── Hero ── */
    .profile-hero {
        position: relative;
        overflow: hidden;
        padding: 3rem 1rem 2.5rem;
        margin-bottom: 0;
    }
    .profile-hero-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--primary, #f59e0b) 0%, transparent 60%);
        opacity: .08;
        pointer-events: none;
    }
    .profile-hero::after {
        content: '⚡';
        position: absolute;
        left: -10px;
        bottom: -20px;
        font-size: 160px;
        opacity: .03;
        pointer-events: none;
        line-height: 1;
    }
    .profile-hero-inner {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 1;
    }
    .profile-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--primary, #f59e0b);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        font-family: 'Cairo', sans-serif;
        position: relative;
        z-index: 1;
    }
    .profile-avatar-ring {
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid var(--primary, #f59e0b);
        opacity: .35;
    }
    .profile-name {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 4px;
        color: var(--text);
        font-family: 'Cairo', sans-serif;
    }
    .profile-email {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0 0 8px;
        direction: ltr;
        text-align: right;
    }
    .profile-joined {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--text-muted);
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 3px 10px;
        border-radius: 99px;
    }

    /* ── Container ── */
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* ── Stats ── */
    .profile-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.1rem 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: border-color .2s, transform .2s;
    }
    .stat-card:hover {
        border-color: var(--primary, #f59e0b);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon--orders  { background: rgba(245,158,11,.12); color: #f59e0b; }
    .stat-icon--wishlist{ background: rgba(239,68,68,.1);  color: #ef4444; }
    .stat-icon--reviews { background: rgba(99,102,241,.1); color: #6366f1; }
    .stat-body { display: flex; flex-direction: column; }
    .stat-value {
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
        color: var(--text);
        font-family: 'Cairo', sans-serif;
    }
    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    /* ── Tabs ── */
    .profile-tabs {
        display: flex;
        gap: 4px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 2rem;
    }
    .profile-tab {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Cairo', sans-serif;
        color: var(--text-muted);
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        margin-bottom: -1px;
        transition: color .2s, border-color .2s;
    }
    .profile-tab:hover { color: var(--text); }
    .profile-tab.active {
        color: var(--primary, #f59e0b);
        border-bottom-color: var(--primary, #f59e0b);
    }

    /* ── Panel ── */
    .profile-panel { animation: fadeUp .25s ease; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Alert ── */
    .profile-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 1.5rem;
        font-family: 'Cairo', sans-serif;
    }
    .profile-alert--success {
        background: rgba(16,185,129,.1);
        color: #059669;
        border: 1px solid rgba(16,185,129,.2);
    }

    /* ── Form ── */
    .profile-form { }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 1.25rem;
    }
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 1.25rem; }
    .form-row .form-group { margin-bottom: 0; }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
        font-family: 'Cairo', sans-serif;
    }
    .form-input {
        width: 100%;
        padding: 11px 14px;
        background: var(--bg, var(--surface));
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text);
        font-size: 14px;
        font-family: 'Cairo', sans-serif;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
        outline: none;
    }
    .form-input:focus {
        border-color: var(--primary, #f59e0b);
        box-shadow: 0 0 0 3px rgba(245,158,11,.12);
    }
    .form-input.is-error { border-color: #E24B4A; }
    .form-error {
        font-size: 12px;
        color: #E24B4A;
        font-family: 'Cairo', sans-serif;
    }
    .form-actions { margin-top: 1.5rem; }

    /* ── Save Button ── */
    .btn-profile-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        background: var(--primary, #f59e0b);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Cairo', sans-serif;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
    }
    .btn-profile-save:hover  { opacity: .88; }
    .btn-profile-save:active { transform: scale(.97); }

    /* ── Responsive ── */
    @media (max-width: 600px) {
        .profile-hero-inner { flex-direction: column; text-align: center; align-items: center; }
        .profile-email { text-align: center; }
        .profile-stats { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
        .profile-tab { padding: 10px 12px; font-size: 13px; }
    }
    </style>

    <script>
    function switchTab(tab, btn) {
        document.querySelectorAll('.profile-panel').forEach(p => p.style.display = 'none');
        document.querySelectorAll('.profile-tab').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + tab).style.display = 'block';
        btn.classList.add('active');
    }

    // فتح تاب كلمة المرور تلقائياً لو في error
    @if($errors->has('current_password') || $errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('password', document.querySelectorAll('.profile-tab')[1]);
        });
    @endif
    </script>
    @endpush

</x-layout>
