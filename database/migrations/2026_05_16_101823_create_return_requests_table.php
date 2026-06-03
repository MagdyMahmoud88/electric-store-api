<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // السبب والتفاصيل
            $table->enum('reason', [
                'defective',        // منتج تالف
                'wrong_item',       // منتج مختلف عن المطلوب
                'not_as_described', // مش زي ما وصفناه
                'changed_mind',     // غير رأيه
                'other',            // سبب تاني
            ]);
            $table->text('description')->nullable(); // تفاصيل إضافية من العميل

            // الحالة
            $table->enum('status', [
                'pending',   // في الانتظار
                'approved',  // موافقة
                'rejected',  // مرفوض
                'completed', // تم الإرجاع
            ])->default('pending');

            // ملاحظات الأدمن
            $table->text('admin_note')->nullable();

            // الصور اللي بيبعتها العميل كدليل
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
