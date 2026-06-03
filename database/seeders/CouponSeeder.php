<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 100,
            'max_discount' => 50,
            'usage_limit' => 100,
            'usage_limit_per_user' => 1,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        Coupon::create([
            'code' => 'SAVE20',
            'type' => 'percentage',
            'value' => 20,
            'min_order_amount' => 200,
            'max_discount' => 100,
            'usage_limit' => 50,
            'usage_limit_per_user' => 1,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        Coupon::create([
            'code' => 'FIXED50',
            'type' => 'fixed',
            'value' => 50,
            'min_order_amount' => 150,
            'usage_limit' => 25,
            'usage_limit_per_user' => 1,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);
    }
}
