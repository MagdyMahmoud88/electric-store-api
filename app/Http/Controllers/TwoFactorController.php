<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->get('2fa.required')) {
            return redirect()->route('welcome');
        }

        return view('auth.two-factor');
    }

    public function send(Request $request)
    {
        $user = $request->user();

        // ✅ RateLimiter::hit($key, $decaySeconds) — positional
        $rateLimitKey = "2fa-send:{$user->id}";

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            return back()->with('error', "كثير من المحاولات. انتظر {$minutes} دقيقة.");
        }

        RateLimiter::hit($rateLimitKey, 300); // 5 دقائق

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put("2fa_code_{$user->id}", bcrypt($code), now()->addMinutes(10));

        Mail::to($user->email)->queue(new TwoFactorCodeMail($code, $user->name));

        return back()->with('info', 'تم إرسال الكود على بريدك الإلكتروني.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        $rateLimitKey = "2fa-verify:{$user->id}";

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            return back()->withErrors([
                'code' => "كثير من المحاولات الخاطئة. انتظر {$minutes} دقيقة.",
            ]);
        }

        $savedHash = Cache::get("2fa_code_{$user->id}");

        if (! $savedHash) {
            return back()->withErrors([
                'code' => 'انتهت صلاحية الكود. اطلب كوداً جديداً.',
            ]);
        }

        if (! password_verify($request->code, $savedHash)) {
            RateLimiter::hit($rateLimitKey, 900); // 15 دقيقة

            $remaining = 5 - RateLimiter::attempts($rateLimitKey);

            return back()->withErrors([
                'code' => "الكود غير صحيح. متبقي {$remaining} محاولة.",
            ]);
        }

        // ── كود صح ✅ ──────────────────────────────────────────
        Cache::forget("2fa_code_{$user->id}");
        RateLimiter::clear($rateLimitKey);

        $request->session()->put('2fa.verified', true);
        $request->session()->put('2fa.verified_at', now());
        $request->session()->forget('2fa.required');

        return redirect()->route('admin.dashboard');
    }
}
