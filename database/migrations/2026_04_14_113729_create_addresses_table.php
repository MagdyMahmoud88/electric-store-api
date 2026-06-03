<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ══════════════════════════════════════════════════════════
    //
    //  جدول addresses — عناوين الشحن للمستخدمين
    //
    //  العلاقة: User → hasMany → Address
    //
    //  ملاحظات التصميم:
    //  - first_name + last_name بدل full_name  → سهل sorting وfiltering
    //  - governorate مضاف                      → مطلوب للشحن في مصر
    //  - softDeletes مضاف                      → لو العنوان اتمسح والطلبات
    //                                             القديمة بتشاور عليه، يفضل موجود
    //  - is_default index                       → بنعمل عليه query كتير
    //
    // ══════════════════════════════════════════════════════════

    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            // ── المستخدم ──────────────────────────────────────
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // ── بيانات المستلم ────────────────────────────────
            // ✅ first + last بدل full_name — أسهل في الـ sorting والـ display
            $table->string('first_name', 100);
            $table->string('last_name',  100);
            $table->string('phone',       20);

            // ── بيانات العنوان ────────────────────────────────
            $table->string('governorate', 100);              // المحافظة  — مطلوب للشحن
            $table->string('city',        100);              // المدينة / المركز
            $table->string('area',        100)->nullable();  // الحي / المنطقة
            $table->string('street_address', 500);
            $table->string('building_number', 20)->nullable();
            $table->string('floor',           10)->nullable();
            $table->string('apartment',       10)->nullable();
            $table->string('postal_code',     10)->nullable();
            $table->string('country',          5)->default('EG');

            // ── ملاحظات إضافية ────────────────────────────────
            // مثلاً: "جنب المسجد"، "الدور التاني شمال"
            $table->string('landmark', 255)->nullable();

            // ── العنوان الافتراضي ─────────────────────────────
            $table->boolean('is_default')->default(false);

            $table->timestamps();
            $table->softDeletes();                           // بدل الحذف الكامل

            // ── Indexes ───────────────────────────────────────
            $table->index('user_id');
            $table->index(['user_id', 'is_default']);        // أسرع query لـ default address
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
