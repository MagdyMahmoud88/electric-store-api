<?php

namespace App\Http\Controllers;
use App\Models\Wishlist;
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

    public function toggle(int $productId)
    {
        $user = Auth::user();

        $existing = $user->wishlists()->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $message = 'تم الحذف من المفضلة';
        } else {
            $user->wishlists()->create(['product_id' => $productId]);
            $inWishlist = true;
            $message = 'تم الإضافة للمفضلة';
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
