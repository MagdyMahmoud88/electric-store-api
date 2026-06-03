<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\CartItem;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{

    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            $failedUser = User::where('email', $request->email)->first();
            if ($failedUser) {
                ActivityLogger::loginFailed($failedUser);
            }
            return back()->withErrors([
                'email' => 'بيانات الاعتماد المقدمة غير متطابقة مع سجلاتنا.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $this->migrateCartToDatabase($request);
        $user = Auth::user();
        ActivityLogger::login($user);

        if ($user->isAdmin()) {
            $request->session()->put('2fa.required', true);
            $request->session()->forget('2fa.verified');

            app(TwoFactorController::class)->send($request);

            return redirect()->route('2fa.show');
        }

        return redirect()->intended(route('products.index'));
    }

    public function destroy(Request $request)
    {
        if ($user = Auth::user()) {
            ActivityLogger::logout($user);
        }
        $request->session()->forget(['2fa.verified', '2fa.required']);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


    private function migrateCartToDatabase(Request $request): void
    {
    $sessionCart = $request->session()->get('cart', []);

    if (empty($sessionCart)) {
        return;
    }

    $userId = Auth::id();

    DB::transaction(function () use ($userId, $sessionCart) {
        foreach ($sessionCart as $productId => $item) {
            $quantity = (int) $item['quantity'];

            $cartItem = CartItem::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->where('variant', $item['variant'] ?? null)
                                ->first();

            if ($cartItem) {
                // موجود → اجمع الكميات
                $cartItem->increment('quantity', $quantity);
            } else {
                // جديد → أنشئه
                CartItem::create([
                    'user_id'    => $userId,
                    'product_id' => $productId,
                    'variant'    => $item['variant'] ?? null,
                    'quantity'   => $quantity,
                ]);
            }
        }
    });

    $request->session()->forget('cart');
}
}
