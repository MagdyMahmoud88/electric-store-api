<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ بيعمل الأدمن لو مش موجود — لو موجود ما يعملوش تاني
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@store.com')],
            [
                'name'              => env('ADMIN_NAME', 'Admin'),
                'password'          => Hash::make(env('ADMIN_PASSWORD', 'change-me-now')),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
