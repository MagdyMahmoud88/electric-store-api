<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
class CartController extends Controller
{
    // ─── جلب السلة وعرضها ────────────────────────────────────────────
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total' ));
    }

    // ─── إضافة منتج للسلة ────────────────────────────────────────────
  public function add(Request $request, $productId)
{
    $product = \App\Models\Product::findOrFail($productId);

    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $request->input('quantity', 1);
    } else {
        $cart[$productId] = [
            'name'     => $product->name,
            'price'    => $product->price,
            'image'    => $product->image_url ?? $product->image ?? '',
            'quantity' => $request->input('quantity', 1),
        ];
    }

    session()->put('cart', $cart);

    if (Auth::check()) {
        $this->syncToDatabase($cart);
    }
return back()->with('success', 'تم إضافة المنتج للسلة ✨');
  //  return redirect()->route('cart.index')->with('success', 'تم إضافة المنتج للسلة ✨');
}

    // ─── تحديث الكمية (زيادة أو نقصان) ──────────────────────────────
    public function update(Request $request, $productId)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        $cart = session()->get('cart', []);
$productId = (string) $productId;
        if (!isset($cart[$productId])) {
            return redirect()->route('cart.index')->with('error', 'المنتج غير موجود في السلة');
        }

        if ($request->action === 'increase') {
            $cart[$productId]['quantity']++;
        } elseif ($request->action === 'decrease') {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                // لو الكمية 1 وضغط ناقص، احذف المنتج
                unset($cart[$productId]);
            }
        }

        session()->put('cart', $cart);

        if (Auth::check()) {
            $this->syncToDatabase($cart);
        }

        return redirect()->route('cart.index');
    }

    // ─── حذف منتج من السلة ───────────────────────────────────────────
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
$productId = (string) $productId;
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            if (Auth::check()) {
                $this->syncToDatabase($cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'تم حذف المنتج من السلة');
    }

    // ─── تفريغ السلة كاملة ───────────────────────────────────────────
    public function clear()
    {
        session()->forget('cart');

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        }

        return redirect()->route('cart.index')->with('success', 'تم تفريغ السلة');
    }

    // ─── مزامنة Session مع Database ──────────────────────────────────
    private function syncToDatabase(array $cart): void
    {
        $userId = Auth::id();

        // امسح الـ items القديمة وأعد كتابتها من الـ session
        CartItem::where('user_id', $userId)->delete();

        foreach ($cart as $productId => $details) {
            CartItem::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $details['quantity'],
                'price'      => $details['price'],
            ]);
        }
    }

    // ─── تحميل سلة DB في الـ Session (عند Login) ─────────────────────
    public static function loadFromDatabase(): void
    {
        if (!Auth::check()) return;

        $dbItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($dbItems->isEmpty()) return;

        $cart = [];
        foreach ($dbItems as $item) {
            $cart[$item->product_id] = [
                'name'     => $item->product->name,
                'price'    => $item->price,
                'image'    => $item->product->image_url ?? $item->product->image ?? '',
                'quantity' => $item->quantity,
            ];
        }

        session()->put('cart', $cart);
    }
}
