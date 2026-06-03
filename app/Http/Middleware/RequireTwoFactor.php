<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    // ✅ لو الأدمن مش شغال 8 ساعات → يطلب 2FA تاني
    private const SESSION_TIMEOUT_HOURS = 8;

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            return $next($request);
        }

        // لو في صفحة الـ 2FA نفسها → اسمح
        if ($request->routeIs('2fa.*')) {
            return $next($request);
        }

        $verified   = $request->session()->get('2fa.verified');
        $verifiedAt = $request->session()->get('2fa.verified_at');

        // ── Session Timeout ────────────────────────────────────
        // ✅ لو اتحقق من أكتر من 8 ساعات → يطلب 2FA تاني
        if ($verified && $verifiedAt) {
            $hoursElapsed = now()->diffInHours($verifiedAt);

            if ($hoursElapsed >= self::SESSION_TIMEOUT_HOURS) {
                $request->session()->forget(['2fa.verified', '2fa.verified_at']);
                $verified = false;
            }
        }

        if (! $verified) {
            $request->session()->put('2fa.required', true);
            return redirect()->route('2fa.show');
        }

        return $next($request);
    }
}
