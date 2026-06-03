<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // علاقة بالأوردر
            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // علاقة باليوزر (اختياري)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // بيانات Kashier
            $table->string('kashier_order_id');          // order_number بتاعك
            $table->string('transaction_id')->nullable(); // transactionId من Kashier
            $table->string('payment_ref')->nullable();    // مرجع إضافي

            // الحالة
            $table->enum('status', [
                'pending',   // في انتظار الدفع
                'success',   // تم الدفع
                'failed',    // فشل
                'cancelled', // إلغاء
                'refunded',  // مسترجع
            ])->default('pending');

            // المبالغ
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('EGP');

            // طريقة الدفع (card, wallet, etc.)
            $table->string('payment_method')->nullable();

            // الـ Hash للتحقق
            $table->string('hash')->nullable();

            // الـ Response الكامل من Kashier (JSON)
            $table->json('kashier_response')->nullable();

            // ملاحظات
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('kashier_order_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};