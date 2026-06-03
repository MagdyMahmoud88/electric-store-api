<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:20px; direction:rtl; }
        .container { max-width:500px; margin:auto; background:#fff; border-radius:12px; overflow:hidden; }
        .header { background:#0f172a; padding:24px; text-align:center; }
        .header h1 { color:#facc15; margin:0; font-size:20px; }
        .body { padding:32px 24px; text-align:right; }
        .code-box {
            background:#0f172a; color:#facc15;
            font-size:36px; font-weight:bold; letter-spacing:12px;
            text-align:center; padding:20px; border-radius:10px;
            margin:24px 0;
        }
        .footer { background:#f8f8f8; padding:16px 24px; text-align:center; font-size:11px; color:#999; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⚡ متجر الكهرباء</h1>
    </div>
    <div class="body">
        <p>مرحباً <strong>{{ $userName }}</strong>،</p>
        <p>كود التحقق الثنائي للدخول على لوحة التحكم:</p>

        <div class="code-box">{{ $code }}</div>

        <p style="color:#ef4444;font-size:13px;">
            ⚠️ الكود صالح لمدة <strong>10 دقائق</strong> فقط.
        </p>
        <p style="color:#666;font-size:12px;">
            لو مش أنت اللي طلب الكود، تجاهل هذا الإيميل.
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} متجر الكهرباء — هذا الإيميل تم إرساله تلقائياً
    </div>
</div>
</body>
</html>
