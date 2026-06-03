<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>محاولات كثيرة جداً</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white flex items-center justify-center h-screen">
<div class="text-center p-8 bg-slate-800 rounded-2xl shadow-xl max-w-md border border-slate-700">
    <div class="text-amber-500 text-5xl mb-4">⚠️</div>
    <h1 class="text-2xl font-bold mb-2">مهلاً! محاولات كثيرة جداً</h1>
    <p class="text-slate-400 mb-6">{{ $message ?? 'يرجى الانتظار قليلاً قبل المحاولة مرة أخرى للحفاظ على أمان حسابك.' }}</p>
    <a href="{{ url('/') }}" class="bg-amber-500 text-slate-950 px-6 py-2 rounded-xl font-bold hover:bg-amber-400 transition">
        العودة للرئيسية
    </a>
</div>
</body>
</html>
