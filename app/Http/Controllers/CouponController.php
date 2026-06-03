<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{

 public function apply(Request $request)
{
    $request->validate([
        'code' => 'required|string|max:50',
    ], [
        'code.required' => 'من فضلك أدخل كود الكوبون',
    ]);

    // ← اقرأ الكارت من DB لو logged in، ومن session لو لأ
    if (Auth::check()) {
        $cart = \App\Models\CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->mapWithKeys(function ($item) {
                $product = $item->product;
                $price   = $product->discount
                    ? round($product->price * (1 - $product->discount / 100), 2)
                    : $product->price;
                return [$item->product_id => [
                    'price'    => $price,
                    'quantity' => $item->quantity,
                ]];
            })->toArray();
    } else {
        $cart = session()->get('cart', []);
    }

    if (empty($cart)) {
        return back()->with('error', 'السلة فارغة');
    }

    $coupon = Coupon::where('code', strtoupper(trim($request->code)))->first();

    if (!$coupon) {
        return back()->with('error', 'كود الكوبون غير صحيح')->withInput();
    }

    if (!$coupon->isValid()) {
        return back()->with('error', 'هذا الكوبون غير متاح حالياً')->withInput();
    }

    if (!Auth::check()) {
        return back()->with('error', 'يجب تسجيل الدخول لاستخدام هذا الكوبون')->withInput();
    }

    if ($coupon->usedByUser(Auth::id())) {
        return back()->with('error', 'لقد استخدمت هذا الكوبون من قبل')->withInput();
    }

    $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

    if ($subtotal < $coupon->min_order_amount) {
        return back()->with('error', 'الحد الأدنى للطلب هو ' . number_format($coupon->min_order_amount, 2) . ' ج.م')->withInput();
    }

    $discount = $coupon->calculateDiscount($subtotal);

    session()->put('coupon', [
        'id'          => $coupon->id,
        'code'        => $coupon->code,
        'type'        => $coupon->type,
        'value'       => $coupon->value,
        'description' => $coupon->description,
        'discount'    => $discount,
    ]);

    return back()->with('success', 'تم تطبيق الكوبون بنجاح!');
}
public function remove()
{
    session()->forget('coupon');
    return back()->with('success', 'تم إزالة الكوبون');
}
}
