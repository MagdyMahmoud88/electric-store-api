<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupon_usage', function (Blueprint $table) {
            $table->unique(['coupon_id', 'user_id'], 'coupon_usage_coupon_user_unique');
        });
    }

    public function down(): void
    {
        Schema::table('coupon_usage', function (Blueprint $table) {
            $table->dropUnique('coupon_usage_coupon_user_unique');
        });
    }
};
