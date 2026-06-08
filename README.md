<div align="center">

# ⚡ Electric Tools Store
### متجر الأدوات الكهربائية

متجر إلكتروني متكامل لبيع الأدوات الكهربائية، مبني بـ Laravel مع نظام إدارة شامل

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![DaisyUI](https://img.shields.io/badge/DaisyUI-4-5A0EF8?style=for-the-badge&logo=daisyui&logoColor=white)

</div>

---

## ✨ المميزات

### 🛒 تجربة التسوق
- عرض المنتجات مع التصفية حسب الفئة والماركة
- سلة تسوق متاحة للجميع (زوار ومسجلين)
- **Fast Buy** — شراء فوري بدون سلة
- قائمة المفضلة مع خاصية "حفظ لوقت لاحق"
- نظام كوبونات خصم

### 💳 الدفع والطلبات
- بوابة دفع **Kashier** مع Webhook
- متابعة حالة الطلبات
- إلغاء الطلبات
- نظام إرجاع المنتجات
- تحميل الفواتير PDF

### 👤 حساب المستخدم
- تسجيل + تحقق من الإيميل بـ OTP
- **Two-Factor Authentication (2FA)**
- استعادة كلمة المرور
- إدارة العناوين المتعددة
- تقييم المنتجات
- سجل الطلبات والإرجاع

### 🛠️ لوحة الأدمن
- **داشبورد** مع إحصائيات وإشعارات فورية
- إدارة المنتجات، الفئات، الماركات (مع bulk actions)
- إدارة الطلبات وتحديث حالتها
- إدارة المستخدمين (تفعيل/تعطيل/حذف)
- مراجعة وإدارة التقييمات
- إدارة الكوبونات
- إدارة طلبات الإرجاع
- تقارير المبيعات

---

## 🛠️ التقنيات المستخدمة

| الطبقة | التقنية |
|--------|---------|
| Backend | Laravel 11 |
| Frontend | Blade + Tailwind CSS + DaisyUI |
| Database | MySQL |
| Payment | Kashier Payment Gateway |
| Auth | Laravel Auth + OTP + 2FA |

---

## 🚀 طريقة التشغيل

### المتطلبات
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### الخطوات

```bash
# 1. Clone المشروع
git clone https://github.com/MagdyMahmoud88/electric-tools-store.git
cd electric-tools-store

# 2. تثبيت الـ dependencies
composer install
npm install

# 3. إعداد ملف البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات في .env
# DB_DATABASE=your_db
# DB_USERNAME=your_user
# DB_PASSWORD=your_pass

# 5. تشغيل الـ migrations
php artisan migrate --seed

# 6. بناء الـ assets
npm run build

# 7. تشغيل السيرفر
php artisan serve
```

ثم افتح المتصفح على `http://localhost:8000`

---

## 📁 هيكل المشروع

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # كنترولرز لوحة الأدمن
│   │   └── User/           # كنترولرز المستخدم
│   └── Http/Middleware/    # AdminMiddleware و 2FA
├── resources/views/        # Blade templates
├── routes/web.php          # جميع الروتات
└── database/migrations/    # هيكل قاعدة البيانات
```

---

## 📸 Screenshots

> قريباً

---

## 👨‍💻 المطور

- GitHub: [@MagdyMahmoud88](https://github.com/MagdyMahmoud88)

---

<div align="center">
صُنع بـ ❤️ باستخدام Laravel
</div>
