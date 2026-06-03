<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Auth::user()
            ->wishlists()
            ->with('product.brand')
            ->latest()
            ->get();

        return view('wishlist.index', compact('items'));
    }

    /**
     * toggle — يضيف أو يحذف من المفضلة (من صفحة المنتج)
     */
    public function toggle(int $productId)
    {
        $user     = Auth::user();
        $existing = $user->wishlists()->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $message    = 'تم الحذف من المفضلة';
            ActivityLogger::wishlistRemoved($user, $productId);
        } else {
            $user->wishlists()->create(['product_id' => $productId]);
            $inWishlist = true;
            $message    = 'تم الإضافة للمفضلة';
            ActivityLogger::wishlistAdded($user, $productId);
        }

        if (request()->wantsJson()) {
            return response()->json([
                'in_wishlist' => $inWishlist,
                'message'     => $message,
                'count'       => $user->wishlists()->count(),
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * saveForLater — يضيف للمفضلة فقط + يشيل من السلة (من صفحة السلة)
     */
    public function saveForLater(int $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'سجل دخولك أولاً لحفظ المنتجات');
        }

        $user = Auth::user();

        // ✅ أضف للـ Wishlist لو مش موجود فقط — مش هنحذف
        if (!$user->wishlists()->where('product_id', $productId)->exists()) {
            $user->wishlists()->create(['product_id' => $productId]);
            ActivityLogger::wishlistAdded($user, $productId);
        }

        // ✅ اشيله من السلة من DB للمستخدم المسجل
        \App\Models\CartItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'تم حفظ المنتج في المفضلة وإزالته من السلة');
    }

    public function remove(int $productId)
    {
        Auth::user()
            ->wishlists()
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'تم الحذف من المفضلة');
    }

    public function clear()
    {
        Auth::user()->wishlists()->delete();

        return back()->with('success', 'تم مسح المفضلة');
    }
}
