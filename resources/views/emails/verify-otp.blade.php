<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>كود التحقق - متجري</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; background: #f5f5f5; direction: rtl; }
    .wrapper { max-width: 560px; margin: 30px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    .header { background: linear-gradient(135deg, #f97316, #f59e0b); padding: 40px 32px; text-align: center; }
    .header .logo { display: inline-flex; align-items: center; gap: 10px; }
    .header .logo-icon { width: 52px; height: 52px; background: rgba(255,255,255,0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px; }
    .header h1 { color: #fff; font-size: 22px; font-weight: 700; margin-top: 14px; }
    .header p { color: rgba(255,255,255,0.85); font-size: 13px; margin-top: 4px; }
    .body { padding: 36px 32px; }
    .greeting { font-size: 16px; color: #374151; margin-bottom: 16px; }
    .desc { font-size: 14px; color: #6b7280; line-height: 1.7; margin-bottom: 28px; }
    .otp-box { background: #fff7ed; border: 2px dashed #f97316; border-radius: 14px; padding: 24px; text-align: center; margin-bottom: 28px; }
    .otp-label { font-size: 13px; color: #9a3412; font-weight: 600; margin-bottom: 10px; }
    .otp-code { font-size: 42px; font-weight: 900; letter-spacing: 10px; color: #ea580c; font-family: 'Courier New', monospace; }
    .otp-expires { font-size: 12px; color: #9a3412; margin-top: 10px; }
    .warning { background: #fef3c7; border-right: 4px solid #f59e0b; padding: 14px 16px; border-radius: 8px; font-size: 13px; color: #92400e; margin-bottom: 24px; line-height: 1.6; }
    .divider { border: none; border-top: 1px solid #f3f4f6; margin: 24px 0; }
    .footer { padding: 20px 32px 28px; text-align: center; background: #fafafa; border-top: 1px solid #f3f4f6; }
    .footer p { font-size: 12px; color: #9ca3af; line-height: 1.8; }
    .footer .brand { color: #f97316; font-weight: 700; }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- Header -->
  <div class="header">
    <div class="logo">
      <div class="logo-icon">⚡</div>
    </div>
    <h1>متجري للأدوات الكهربائية</h1>
    <p>تحقق من بريدك الإلكتروني</p>
  </div>

  <!-- Body -->
  <div class="body">
    <p class="greeting">مرحباً،</p>
    <p class="desc">
      استلمنا طلب للتحقق من بريدك الإلكتروني <strong>{{ $email }}</strong>.
      استخدم الكود التالي لإتمام عملية التحقق:
    </p>

    <!-- OTP Code -->
    <div class="otp-box">
      <p class="otp-label">🔐 كود التحقق الخاص بيك</p>
      <div class="otp-code">{{ $otp }}</div>
      <p class="otp-expires">⏱ صالح لمدة 10 دقائق فقط</p>
    </div>

    <!-- Warning -->
    <div class="warning">
      ⚠️ <strong>مهم:</strong> لو أنت مش طلبت الكود ده، تجاهل الإيميل ده وبلّغنا فوراً.
      متشاركش الكود مع أي حد.
    </div>

    <hr class="divider">
    <p style="font-size:13px; color:#6b7280; line-height:1.7;">
      لو عندك أي مشكلة، تواصل معنا على
      <a href="mailto:support@matgari.com" style="color:#f97316;">support@matgari.com</a>
    </p>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>© {{ date('Y') }} <span class="brand">متجري</span> للأدوات الكهربائية. جميع الحقوق محفوظة.</p>
    <p>الإيميل ده اتبعت تلقائياً، متردش عليه.</p>
  </div>

</div>
</body>
</html>
