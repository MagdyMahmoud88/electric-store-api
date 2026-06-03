<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ إنشاء order_addresses لو مش موجود بس
        if (! Schema::hasTable('order_addresses')) {
            Schema::create('order_addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')
                    ->unique()
                    ->constrained('orders')
                    ->cascadeOnDelete();
                $table->string('first_name', 100);
                $table->string('last_name',  100);
                $table->string('email',      255);
                $table->string('phone',       20);
                $table->string('governorate',100);
                $table->string('city',       100);
                $table->string('area',       100)->nullable();
                $table->string('street_address', 500);
                $table->string('building_number', 20)->nullable();
                $table->string('floor',           10)->nullable();
                $table->string('apartment',       10)->nullable();
                $table->string('postal_code',     10)->nullable();
                $table->string('landmark',       255)->nullable();
                $table->string('country',          5)->default('EG');
                $table->timestamps();
            });
        }

        // ✅ شيل عمدة الشحن من orders لو موجودة
        Schema::table('orders', function (Blueprint $table) {
            $cols = ['first_name','last_name','email','phone','address','city','governorate'];
            $existing = array_filter($cols, fn($col) => Schema::hasColumn('orders', $col));
            if (! empty($existing)) {
                $table->dropColumn(array_values($existing));
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('order_number');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('email')->nullable()->after('last_name');
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('address', 500)->nullable()->after('phone');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('governorate', 100)->nullable()->after('city');
        });

        Schema::dropIfExists('order_addresses');
    }
};
