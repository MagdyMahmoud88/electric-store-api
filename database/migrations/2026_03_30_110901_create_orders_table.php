<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('order_number', 30)->unique();
            $table->string('idempotency_key', 64)->nullable()->unique();

            $table->enum('payment_method', [
                'cod', 'kashier', 'card', 'vodafone', 'instapay',
            ])->default('cod');

            $table->foreignId('coupon_id')
                ->nullable()
                ->constrained('coupons')
                ->nullOnDelete();

            $table->string('coupon_code', 50)->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax',      10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total',    10, 2);

            $table->enum('status', [
                'pending', 'processing', 'shipped',
                'delivered', 'cancelled', 'payment_failed',
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid', 'paid', 'failed', 'refunded',
            ])->default('unpaid');

            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'created_at']);
            $table->index('status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
