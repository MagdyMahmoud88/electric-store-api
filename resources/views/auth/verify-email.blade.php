<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تـيـار - التحقق من البريد</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

  <style>
    :root {
        --electric-yellow: #facc15; /* لون الكهرباء الرئيسي */
        --dark-bg: #0f172a; /* خلفية ليلية عميقة */
    }
    * { font-family: 'Cairo', sans-serif; }

    body {
        background-color: var(--dark-bg);
        background-image: radial-gradient(circle at top right, rgba(250, 204, 21, 0.05), transparent),
                          radial-gradient(circle at bottom left, rgba(250, 204, 21, 0.05), transparent);
    }

    /* تأثير التوهج للوجو */
    .glow-icon {
        filter: drop-shadow(0 0 15px rgba(250, 204, 21, 0.6));
    }

    /* ستايل الكارت المظلم */
    .dark-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(250, 204, 21, 0.2);
    }

    /* زر التيار المتوهج */
    .btn-electric {
        background: linear-gradient(90deg, #facc15, #eab308);
        border: none;
        color: #000;
        box-shadow: 0 0 20px rgba(250, 204, 21, 0.3);
        transition: all 0.3s ease;
    }
    .btn-electric:hover {
        box-shadow: 0 0 30px rgba(250, 204, 21, 0.5);
        transform: translateY(-2px);
    }

    /* تخصيص الـ Input ليتناسب مع الموبايل */
    .electric-input {
        background: rgba(15, 23, 42, 0.8) !important;
        border-color: rgba(250, 204, 21, 0.3) !important;
        color: white !important;
    }
    .electric-input:focus {
        border-color: var(--electric-yellow) !important;
        box-shadow: 0 0 10px rgba(250, 204, 21, 0.2) !important;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    {{-- Alerts --}}
    @if(session('info'))
    <div class="alert bg-blue-900/30 border-blue-500/50 text-blue-200 mb-4 text-sm">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('info') }}
    </div>
    @endif

    {{-- Brand (تـيـار) --}}
    <div class="text-center mb-8">
        <div class="mx-auto mb-4 w-20 h-20 rounded-3xl bg-slate-800 flex items-center justify-center border-2 border-yellow-400/30 glow-icon">
            <svg class="w-12 h-12 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-black text-white tracking-tighter">تـيـار</h1>
        <p class="text-xs text-yellow-400 font-bold tracking-widest uppercase mt-1">Electric Store</p>
    </div>

    {{-- Card --}}
    <div class="card dark-card shadow-2xl rounded-[2rem]">
        <div class="card-body p-8">

            <div class="text-center mb-6">
                <div class="badge badge-outline border-yellow-400/50 text-yellow-400 mb-3 text-[10px] font-bold px-3">الأمان أولاً</div>
                <h2 class="text-xl font-bold text-white mb-1">تحقق من هويتك</h2>
                <p class="text-sm text-slate-400">سنرسل كود التفعيل لبريدك</p>
            </div>

            {{-- Success Alert --}}
            @if(session('success'))
            <div class="alert bg-green-900/30 border-green-500/50 text-green-200 mb-4 text-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-bold text-slate-300">البريد الإلكتروني</span>
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', auth()->user()?->email) }}"
                            placeholder="example@tayar.com"
                            dir="ltr"
                            class="input electric-input input-bordered w-full pl-12 text-left @error('email') input-error @enderror"
                        >
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @error('email')
                        <p class="text-error text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-electric w-full h-14 rounded-2xl text-lg font-black">
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    إرسال الكود
                </button>
            </form>

        </div>
    </div>

    {{-- Footer --}}
    <p class="text-center mt-8 text-slate-500 text-xs">
        &copy; 2026 تـيـار. جميع الحقوق محفوظة.
    </p>

</div>
</body>
</html>
