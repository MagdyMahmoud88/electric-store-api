<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // نوع النشاط
            $table->string('type');               // login, logout, order_placed, review_added ...
            $table->string('description');        // وصف مقروء للـ Admin

            // الـ Entity المرتبط (polymorphic-style)
            $table->string('loggable_type')->nullable();   // App\Models\Order
            $table->unsignedBigInteger('loggable_id')->nullable();   // 123

            // بيانات إضافية (JSON)
            $table->json('metadata')->nullable();  // { amount: 500, items: 3 }

            // معلومات الجلسة
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url')->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Index للبحث السريع
            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'type']);
            $table->index(['loggable_type', 'loggable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};
