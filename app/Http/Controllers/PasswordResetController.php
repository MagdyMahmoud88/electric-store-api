<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // ─── الخطوة 1: عرض صفحة إدخال الإيميل ───────────────────

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // ─── الخطوة 2: إرسال رابط الـ reset ──────────────────────

    public function sendLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'تم إرسال رابط إعادة تعيين كلمة السر على بريدك! تحقق من الـ inbox أو الـ spam.')
            : back()->withErrors(['email' => 'البريد الإلكتروني غير مسجل لدينا.']);
    }

    // ─── الخطوة 3: عرض صفحة كتابة كلمة السر الجديدة ─────────

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // ─── الخطوة 4: حفظ كلمة السر الجديدة ────────────────────

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.index')
                ->with('success', 'تم تغيير كلمة السر بنجاح! سجّل دخولك دلوقتي.')
            : back()->withErrors(['email' => 'الرابط منتهي الصلاحية أو غلط. اطلب رابط جديد.']);
    }
}