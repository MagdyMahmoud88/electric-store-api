<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        // ── 1. إنشاء الحساب ───────────────────────────────────
        $user = User::create($request->validated());

        // ── 2. تسجيل الدخول ──────────────────────────────────
        Auth::login($user);

        // ── 3. حفظ الإيميل في الـ session ────────────────────
        // ✅ عشان صفحة الـ OTP تعرف على أي إيميل تبعت الكود
        $request->session()->put('verify_email', $user->email);

        // ── 4. بعت الكود تلقائياً ────────────────────────────
        // ✅ بدل ما المستخدم يضغط "إرسال الكود" يدوياً
        app(EmailVerificationController::class)->sendOtp(
            $request->merge(['email' => $user->email])
        );

        return redirect()->route('verification.otp.form')
            ->with('success', 'تم التسجيل بنجاح! 🎉 تحقق من بريدك الإلكتروني وأدخل الكود.');
    }
}
