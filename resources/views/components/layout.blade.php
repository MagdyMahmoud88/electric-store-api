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
    <title>{{ $title ?? 'المتجر الكهربائي' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Tajawal:wght@300;400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<x-nav-bar />

    {{-- ── FLASH MESSAGES ── --}}
    @if(session('success') || session('error'))
    <div class="flash-container" id="flashContainer">
        @if(session('success'))
        <div class="flash-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button class="flash-close" onclick="document.getElementById('flashContainer').remove()">✕</button>
        </div>
        @endif
        @if(session('error'))
        <div class="flash-error">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
            <button class="flash-close" onclick="document.getElementById('flashContainer').remove()">✕</button>
        </div>
        @endif
    </div>
    @endif

    {{-- ── MAIN CONTENT ── --}}
    <main class="main-content">
        {{ $slot }}
    </main>

    <x-footer />

    <script>
    window.addEventListener('scroll', () => {
        document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 20);
    });

    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    document.addEventListener('click', (e) => {
        if (!e.target.closest('[onclick="toggleUserMenu()"]') && !e.target.closest('#userMenu')) {
            const m = document.getElementById('userMenu');
            if (m) m.style.display = 'none';
        }
    });

    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    setTimeout(() => {
        const f = document.getElementById('flashContainer');
        if (f) f.style.transition = 'opacity .5s', f.style.opacity = '0', setTimeout(() => f.remove(), 500);
    }, 4000);
    </script>

    {{-- ✅ مكان scripts الـ components زي wishlist-button --}}
    @stack('scripts')

</body>
</html>
