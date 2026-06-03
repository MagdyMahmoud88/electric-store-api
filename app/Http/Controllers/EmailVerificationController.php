<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmailOtpMail;
use App\Models\EmailVerificationOtp;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class EmailVerificationController extends Controller
{
    // ─── ثوابت ────────────────────────────────────────────────
    private const OTP_EXPIRES_MINUTES = 10;
    private const RESEND_WAIT_SECONDS = 60;
    private const MAX_VERIFY_ATTEMPTS = 5;

    // ─── عرض الصفحة ───────────────────────────────────────────

    /** صفحة إدخال الإيميل */
    public function showEmailForm()
    {
        if (Auth::check() && Auth::user()->email_verified_at) {
            return redirect()->route('products.index')
                ->with('info', 'بريدك الإلكتروني متحقق بالفعل.');
        }

        return view('auth.verify-email');
    }

    /** صفحة إدخال OTP */
    public function showOtpForm(Request $request)
    {
        if (!$request->session()->has('verify_email')) {
            return redirect()->route('verification.email');
        }

        return view('auth.verify-otp', [
            'email' => $request->session()->get('verify_email'),
        ]);
    }


    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower(trim($request->email));

        // Rate Limit: مرة واحدة كل 60 ثانية لنفس الإيميل
        $rateLimitKey = "send-otp:{$email}";
        if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors([
                'email' => "انتظر {$seconds} ثانية قبل إعادة الإرسال.",
            ]);
        }
        RateLimiter::hit($rateLimitKey, self::RESEND_WAIT_SECONDS);

        // حذف الكودات القديمة لنفس الإيميل
        EmailVerificationOtp::where('email', $email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // حفظ الكود في الداتابيز
        EmailVerificationOtp::create([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(self::OTP_EXPIRES_MINUTES),
        ]);

        // إرسال الإيميل
        Mail::to($email)->send(new VerifyEmailOtpMail($otp, $email));

        // حفظ الإيميل في الـ session
        $request->session()->put('verify_email', $email);

        return redirect()->route('verification.otp.form')
            ->with('success', 'تم إرسال الكود على بريدك الإلكتروني!');
    }

    // ─── التحقق من الكود ──────────────────────────────────────

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->session()->get('verify_email');

        if (!$email) {
            return redirect()->route('verification.email')
                ->withErrors(['otp' => 'انتهت الجلسة، أعد إدخال البريد الإلكتروني.']);
        }

        // Rate Limit: 5 محاولات كل 15 دقيقة
        $rateLimitKey = "verify-otp:{$email}";
        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_VERIFY_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors([
                'otp' => "كثير من المحاولات. انتظر " . ceil($seconds / 60) . " دقيقة.",
            ]);
        }

        $record = EmailVerificationOtp::valid($email)->latest()->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'الكود منتهي الصلاحية. اطلب كوداً جديداً.']);
        }

        // مطابقة الكود
        if ($record->otp !== $request->otp) {
            RateLimiter::hit($rateLimitKey, 15 * 60);
            return back()->withErrors(['otp' => 'الكود غلط، حاول تاني.']);
        }

        RateLimiter::clear($rateLimitKey);
        $record->update(['used' => true]);

        // تحديث المستخدم لو موجود
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update(['email_verified_at' => now()]);
            Auth::login($user);
            ActivityLogger::emailVerified($user);
        }

        $request->session()->forget('verify_email');

        return redirect()->intended('products.index')
            ->with('success', 'تم التحقق من بريدك الإلكتروني بنجاح! 🎉');
    }

    // ─── إعادة الإرسال ────────────────────────────────────────

    public function resendOtp(Request $request)
    {
        $email = $request->session()->get('verify_email');

        if (!$email) {
            return redirect()->route('verification.email');
        }

        // إعادة توجيه لـ sendOtp بنفس الإيميل
        $request->merge(['email' => $email]);
        return $this->sendOtp($request);
    }
}
