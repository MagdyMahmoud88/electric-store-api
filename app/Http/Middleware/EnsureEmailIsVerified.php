<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    // ── Routes مسموح للجميع حتى بدون تفعيل ──────────────────
    private const ALLOWED_ROUTES = [
        'verification.*',   // صفحات التفعيل نفسها
        '2fa.*',            // صفحات 2FA
        'logout',           // تسجيل الخروج
        'login',            // تسجيل الدخول
        'login.store',
        'register.*',       // التسجيل
        'password.*',       // reset password
        'welcome',          // الصفحة الرئيسية
        'products.*',       // تصفح المنتجات (بدون شراء)
        'brands.*',         // تصفح الماركات
        'theme.set',        // تغيير الثيم
        'cart.index',       // عرض السلة فقط
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // مش مسجّل → مش محتاج verified
        if (! $user) {
            return $next($request);
        }

        // إيميل متحقق → اسمح
        if ($user->hasVerifiedEmail()) {
            return $next($request);
        }

        // ✅ لو في route مسموح → اسمح حتى بدون تفعيل
        foreach (self::ALLOWED_ROUTES as $pattern) {
            if ($request->routeIs($pattern)) {
                return $next($request);
            }
        }

        // مش متحقق + route محمي → حوّله لصفحة التفعيل
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'يرجى تفعيل بريدك الإلكتروني أولاً.',
            ], 403);
        }

        return redirect()->route('verification.email')
            ->with('info', 'يرجى تفعيل بريدك الإلكتروني للمتابعة.');
    }
}
