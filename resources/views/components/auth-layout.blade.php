<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function() {
            const saved = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
    <title>{{ $title ?? 'متجر الكهرباء' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: var(--bg-deep);
        }

        .auth-wrapper { width: 100%; max-width: 420px; }

        /* ── Brand ── */
        .auth-brand { text-align: center; margin-bottom: 32px; }
        .auth-brand-icon {
            width: 68px; height: 68px;
            border-radius: 18px;
            background: var(--electric-dim);
            border: 1px solid rgba(245,158,11,.25);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .auth-brand-name {
            font-size: 26px; font-weight: 900;
            color: var(--text); margin: 0; letter-spacing: -.5px;
        }
        .auth-brand-sub {
            font-size: 11px; font-weight: 700;
            color: var(--text-muted); margin: 4px 0 0;
            letter-spacing: .12em; text-transform: uppercase;
        }

        /* ── Card ── */
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
        }

        /* ── Badge ── */
        .auth-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 99px;
            background: var(--electric-dim);
            border: 1px solid rgba(245,158,11,.2);
            font-size: 11px; font-weight: 700; color: var(--electric);
            margin-bottom: 12px;
        }

        /* ── Input ── */
        .auth-input {
            width: 100%;
            padding: 11px 16px;
            border-radius: 10px;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
            outline: none;
            box-sizing: border-box;
            transition: border-color .15s, box-shadow .15s;
        }
        .auth-input:focus {
            border-color: var(--electric);
            box-shadow: 0 0 0 3px var(--electric-dim);
        }
        .auth-input.error { border-color: var(--danger); }
        .auth-input::placeholder { color: var(--text-muted); }

        /* ── Button ── */
        .auth-btn {
            width: 100%; height: 50px;
            border-radius: 12px;
            background: var(--electric);
            border: none; color: #070810;
            font-size: 15px; font-weight: 800;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: opacity .2s, transform .15s;
        }
        .auth-btn:hover { opacity: .88; transform: translateY(-1px); }
        .auth-btn:active { transform: scale(.98); }

        .auth-btn-outline {
            width: 100%; height: 44px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-soft);
            font-size: 13px; font-weight: 700;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: border-color .15s, color .15s;
        }
        .auth-btn-outline:hover { border-color: var(--electric); color: var(--electric); }

        /* ── Alerts ── */
        .auth-alert {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px; border-radius: 10px;
            font-size: 13px; margin-bottom: 16px;
        }
        .auth-alert-success {
            background: rgba(34,197,94,.08);
            border: 1px solid rgba(34,197,94,.2);
            color: #86efac;
        }
        .auth-alert-error {
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.2);
            color: #fca5a5;
        }
        .auth-alert-info {
            background: rgba(59,130,246,.08);
            border: 1px solid rgba(59,130,246,.2);
            color: #93c5fd;
        }

        /* ── Error text ── */
        .auth-error { font-size: 12px; color: var(--danger); margin: 5px 0 0; font-weight: 600; }

        /* ── Label ── */
        .auth-label { display: block; font-size: 13px; font-weight: 700; color: var(--text-soft); margin-bottom: 7px; }

        /* ── Divider ── */
        .auth-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0; color: var(--text-muted); font-size: 12px;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        /* ── Link ── */
        .auth-link { color: var(--electric); font-weight: 700; text-decoration: none; font-size: 13px; }
        .auth-link:hover { text-decoration: underline; }

        /* ── Footer ── */
        .auth-footer {
            text-align: center; margin-top: 24px;
            font-size: 12px; color: var(--text-muted);
        }

        /* ── OTP inputs ── */
        .otp-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 6px;
            margin-bottom: 20px;
            width: 100%;
        }
        .otp-input {
            height: 48px;
            width: 100%;
            text-align: center;
            font-size: 18px;
            font-weight: 800;
            border-radius: 10px;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            padding: 0;
            box-sizing: border-box;
        }
        .otp-input:focus {
            border-color: var(--electric);
            box-shadow: 0 0 0 3px var(--electric-dim);
        }
    </style>
</head>
<body>
<div class="auth-page">
    <div class="auth-wrapper">

        {{-- ══ Brand ══ --}}
        <div class="auth-brand">
            <a href="{{ route('welcome') }}" style="text-decoration:none;">
                <div class="auth-brand-icon">
                    <svg width="34" height="34" fill="#f59e0b" viewBox="0 0 24 24">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                </div>
                <p class="auth-brand-name">
                    متجر <span style="color:var(--electric);">الكهرباء</span>
                </p>
                <p class="auth-brand-sub">Electric Store</p>
            </a>
        </div>

        {{-- ══ Content ══ --}}
        {{ $slot }}

        {{-- ══ Footer ══ --}}
        <p class="auth-footer">&copy; {{ date('Y') }} متجر الكهرباء. جميع الحقوق محفوظة.</p>

    </div>
</div>
</body>
</html>
