<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * التحقق الكامل من صلاحيات الأدمن.
     *
     * الفحوصات بالترتيب:
     *  1. المستخدم مسجّل دخول (Auth::check)
     *  2. الإيميل متحقق منه (email_verified_at)
     *  3. الحساب مفعّل (is_active) — عشان لو الأدمن وقفنا حسابه
     *  4. لديه صلاحية أدمن (is_admin)
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ── 1. لازم يكون مسجّل دخول ──────────────────────────
        if (! Auth::check()) {
            return $this->redirectOrAbort($request, route('login'), 401);
        }

        $user = Auth::user();

        // ── 2. الإيميل لازم يكون متحقق منه ──────────────────
        if (! $user->hasVerifiedEmail()) {
            return $this->redirectOrAbort($request, route('verification.email'), 403);
        }

        // ── 3. الحساب لازم يكون active ───────────────────────
        // (غيّر is_active لو بتستخدم column بمسمى مختلف)
        if (isset($user->is_active) && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $this->redirectOrAbort($request, route('login'), 403, 'تم تعطيل حسابك.');
        }

        // ── 4. لازم يكون أدمن ────────────────────────────────
        if (! $user->isAdmin()) {
            abort(403, 'ليس لديك صلاحية للوصول.');
        }

        return $next($request);
    }

    /**
     * AJAX → JSON  |  Web → Redirect
     */
    private function redirectOrAbort(
        Request $request,
        string  $redirectTo,
        int     $status,
        string  $message = 'غير مصرح.'
    ): Response {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return redirect($redirectTo)->with('error', $message);
    }
}
