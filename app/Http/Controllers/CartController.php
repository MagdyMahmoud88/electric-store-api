<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
    // ─── Helper: جيب السلة من المكان الصح ──────────────
    private function getCart(): array
    {
        if (Auth::check()) {
            return CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->mapWithKeys(function ($item) {
                    $product = $item->product;
                    $price = $product->final_price;


                    return [$item->product_id => [
                        'product_id' => $item->product_id,
                        'name'       => $product->name,
                        'price'      => $price,
                        'image'      => $product->image_url ? asset('storage/' . $product->image_url) : null,
                        'brand'      => $product->brand->name ?? null,
                        'variant'    => $item->variant,
                        'quantity'   => $item->quantity,
                    ]];
                })
                ->toArray();
        }

        return session('cart', []);
    }

    // ─── Helper: احفظ السلة في المكان الصح ─────────────
    private function saveCart(array $cart): void
    {
        if (Auth::check()) {
            // DB — امسح القديم واحفظ الجديد
            CartItem::where('user_id', Auth::id())->delete();

            foreach ($cart as $productId => $item) {
                CartItem::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $productId,
                    'variant'    => $item['variant'] ?? null,
                    'quantity'   => $item['quantity'],
                ]);
            }
        } else {
            session(['cart' => $cart]);
        }
    }

    // ─── index ──────────────────────────────────────────
    public function index()
    {
        $cart = $this->getCart();

        $suggested = Product::when(
            !empty($cart),
            fn($q) => $q->whereNotIn('id', array_keys($cart))
        )
        ->inRandomOrder()
        ->take(4)
        ->get();

        return view('cart.index', compact('cart', 'suggested'));
    }

    // ─── add ────────────────────────────────────────────
    public function add(Request $request, $productId)
    {
        $request->validate([
            'variant' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($productId);
        $cart    = $this->getCart();

     $product = Product::findOrFail($productId);
     $cart    = $this->getCart();

     $currentQty = $cart[$productId]['quantity'] ?? 0;
     $maxStock   = $product->stock ?? 99;

     if ($currentQty >= $maxStock) {
         return back()->with('error', 'لا يمكن إضافة كمية أكبر من المتاح');
     }

     if (isset($cart[$productId])) {
         $cart[$productId]['quantity']++;

        } else {
         $price = $product->final_price;


         $cart[$productId] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $price,
                'image'      => $product->image_url ? asset('storage/' . $product->image_url) : null,
                'brand'      => $product->brand->name ?? null,
                'variant'    => $request->input('variant'),
                'quantity'   => 1,
            ];
        }

        $this->saveCart($cart);
        session()->forget('coupon');

        return back()->with('success', 'تمت إضافة المنتج إلى السلة');
    }

    // ─── update ─────────────────────────────────────────
    public function update(Request $request, $productId)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        $cart   = $this->getCart();
        $action = $request->input('action');

        if (!isset($cart[$productId])) {
            return back()->with('error', 'المنتج غير موجود في السلة');
        }

        if ($action === 'increase') {
            $product = Product::find($productId);
            if (!$product) {
                unset($cart[$productId]);
                $this->saveCart($cart);
                return back()->with('error', 'المنتج لم يعد متاحاً');
            }

            if ($cart[$productId]['quantity'] >= ($product->stock ?? 99)) {
                return back()->with('error', 'لا يمكن إضافة كمية أكبر من المتاح');
            }
            $cart[$productId]['quantity']++;

        } elseif ($action === 'decrease') {
            $cart[$productId]['quantity']--;
            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
            }
        }

        $this->saveCart($cart);
        session()->forget('coupon');

        return back();
    }

    // ─── remove ─────────────────────────────────────────
    public function remove($productId)
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
        session()->forget('coupon');

        return back()->with('success', 'تمت إزالة المنتج من السلة');
    }

    // ─── clear ──────────────────────────────────────────
    public function clear()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
session()->forget('coupon');
        return back()->with('success', 'تم تفريغ السلة');
    }
}
