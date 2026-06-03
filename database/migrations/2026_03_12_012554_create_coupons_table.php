<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                          // كود الكوبون
            $table->enum('type', ['percentage', 'fixed']);             // نسبة مئوية أو مبلغ ثابت
            $table->decimal('value', 8, 2);                           // قيمة الخصم
            $table->decimal('min_order_amount', 8, 2)->default(0);    // أقل قيمة للطلب
            $table->decimal('max_discount', 8, 2)->nullable();        // أقصى خصم (للنسبة المئوية)
            $table->integer('usage_limit')->nullable();                // عدد مرات الاستخدام الكلي
            $table->integer('usage_limit_per_user')->default(1);      // مرات لكل يوزر
            $table->integer('used_count')->default(0);                 // عدد مرات الاستخدام الفعلي
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // جدول لتتبع من استخدم الكوبون
        Schema::create('coupon_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->index(['coupon_id', 'user_id'], 'coupon_id_user_id_index');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_usage');
        Schema::dropIfExists('coupons');
    }
};
