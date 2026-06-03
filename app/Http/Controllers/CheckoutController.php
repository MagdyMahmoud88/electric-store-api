<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\CartItem;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // ══════════════════════════════════════════════════════════
    //  Helpers
    // ══════════════════════════════════════════════════════════

    private function getCartItems(): array
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->map(fn($item) => $item->product ? [
                    'product_id' => $item->product_id,
                    'name'       => $item->product->name,
                    'price'      => $item->product->final_price,
                    'quantity'   => $item->quantity,
                    'image'      => $item->product->image_url
                        ? asset('storage/' . $item->product->image_url)
                        : null,
                    'options'    => $item->variant ? [$item->variant] : [],
                ] : null)
                ->filter()
                ->values()
                ->toArray();
        }

        return session('cart', []);
    }

    private function getCouponDiscount(float $subtotal): float
    {
        if (! session()->has('coupon')) return 0;

        $coupon = Coupon::find(session('coupon.id'));

        if (! $coupon || ! $coupon->isValid()) {
            session()->forget('coupon');
            return 0;
        }

        return $coupon->calculateDiscount($subtotal);
    }

    private function calcTotals(array $cartItems): array
    {
        $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax      = 0;
        $shipping = $subtotal >= 500 ? 0 : 45;
        $discount = $this->getCouponDiscount($subtotal);
        $total    = max(0, ($subtotal + $tax + $shipping) - $discount);

        return compact('subtotal', 'tax', 'shipping', 'discount', 'total');
    }

    // ══════════════════════════════════════════════════════════
    //  index
    // ══════════════════════════════════════════════════════════

    public function index()
    {
        $cartItems = $this->getCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'عربة التسوق فارغة');
        }

        $addresses      = Auth::user()->addresses()->latest()->get();
        $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();

        ['subtotal' => $subtotal, 'tax' => $tax, 'shipping' => $shipping,
            'discount' => $discount, 'total' => $total] = $this->calcTotals($cartItems);

        return view('checkout.index', compact(
            'cartItems', 'subtotal', 'tax', 'shipping', 'total', 'discount',
            'addresses', 'defaultAddress'
        ));
    }

    // ══════════════════════════════════════════════════════════
    //  placeOrder
    // ══════════════════════════════════════════════════════════

    public function placeOrder(CheckoutRequest $request)
    {
        $validated = $request->validated();

        $cartItems = $this->getCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'عربة التسوق فارغة');
        }

        $existingOrder = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->where('payment_status', 'unpaid')
            ->where('created_at', '>', now()->subMinutes(30)) // ✅ 30 دقيقة بدل ساعة
            ->latest()
            ->first();

        if ($existingOrder) {
            // ✅ تحقق إن مبلغ الطلب القديم يساوي المبلغ الحالي
            $currentTotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
            $shipping = $currentTotal >= 500 ? 0 : 45;
            $expectedTotal = $currentTotal + $shipping;

            if (abs($existingOrder->total - $expectedTotal) < 1) {
                return redirect()->route('kashier.pay', ['order_id' => $existingOrder->id]);
            }

            // مبالغ مختلفة — لغّي القديم وعمل جديد
            $existingOrder->update(['status' => 'cancelled']);
        }

        // ── 2. جلب السلة ──────────────────────────────────────

        $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax      = 0;
        $shipping = $subtotal >= 500 ? 0 : 45;

        DB::beginTransaction();

        try {
            $discount = 0;
            $coupon   = null;

            if (session()->has('coupon')) {
                $coupon = Coupon::lockForUpdate()->find(session('coupon.id'));

                if (! $coupon || ! $coupon->isValid()) {
                    session()->forget('coupon');
                    throw new \Exception('الكوبون لم يعد صالحاً');
                }

                if ($subtotal < $coupon->min_order_amount) {
                    throw new \Exception('الحد الأدنى للطلب هو ' . number_format($coupon->min_order_amount, 2) . ' ج.م');
                }

                if ($coupon->usedByUser(Auth::id())) {
                    throw new \Exception('لقد استخدمت هذا الكوبون من قبل');
                }

                $discount = $coupon->calculateDiscount($subtotal);
            }

            $total = max(0, ($subtotal + $tax + $shipping) - $discount);

            // ── 3. إنشاء الطلب ────────────────────────────────
            $order = Order::create([
                'user_id'        => Auth::id(),
                'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
                'payment_method' => $validated['payment_method'] ?? 'kashier',
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'shipping'       => $shipping,
                'discount'       => $discount,
                'total'          => $total,
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'coupon_id'      => $coupon?->id,
            ]);

            // ── 4. حفظ عنوان الشحن ────────────────────────────
            OrderAddress::create([
                'order_id'       => $order->id,
                'first_name'     => $validated['first_name'],
                'last_name'      => $validated['last_name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'governorate'    => $validated['governorate'],
                'city'           => $validated['city'],
                'street_address' => $validated['address'],
                'country'        => 'EG',
            ]);

            // ── 5. عناصر الطلب ────────────────────────────────
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'name'       => $item['name'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                    'subtotal'   => $item['price'] * $item['quantity'],
                    'options'    => json_encode($item['options'] ?? []),
                ]);
            }

            // ── 6. تسجيل الكوبون ──────────────────────────────
            if ($coupon) {
                DB::table('coupon_usage')->insertOrIgnore([
                    'coupon_id'  => $coupon->id,
                    'user_id'    => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $coupon->increment('used_count');
            }

            DB::commit();

            // ✅ السلة والكوبون بيتمسحوا في handleSuccess فقط
            // عشان لو العميل راح من صفحة الدفع يلاقي سلته موجودة

            ActivityLogger::orderPlaced(Auth::user(), $order);
            Log::info('Order created', ['order_id' => $order->id, 'total' => $total]);

            return redirect()->route('kashier.pay', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في إتمام الطلب', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    // ══════════════════════════════════════════════════════════
    //  success
    // ══════════════════════════════════════════════════════════

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'address']);

        return view('checkout.success', compact('order'));
    }

    // ══════════════════════════════════════════════════════════
    //  fastBuy
    // ══════════════════════════════════════════════════════════

    public function fastBuy(Request $request, Product $product)
    {
        $stockAvailable = (int) $product->stock;
        $quantity       = max(1, (int) $request->input('quantity', 1));

        if (! $product->is_active) {
            return back()->with('error', 'هذا المنتج غير متاح حالياً.');
        }

        if ($stockAvailable < $quantity) {
            return back()->with('error', 'عذراً، الكمية المطلوبة غير متوفرة. المتاح: ' . $stockAvailable);
        }

        $user           = auth()->user();
        $defaultAddress = $user->addresses()->where('is_default', true)->first()
            ?? $user->addresses()->latest()->first();

        if (! $defaultAddress) {
            return redirect()->route('addresses.index')
                ->with('error', 'برجاء إضافة عنوان توصيل أولاً.');
        }

        $finalPrice = $product->final_price;
        $subtotal   = $finalPrice * $quantity;
        $tax        = 0;
        $shipping   = $subtotal >= 500 ? 0 : 45;
        $total      = $subtotal + $tax + $shipping;

        try {
            $order = DB::transaction(function () use (
                $user, $product, $quantity,
                $finalPrice, $subtotal, $tax, $shipping, $total,
                $defaultAddress
            ) {
                $order = Order::create([
                    'user_id'        => $user->id,
                    'order_number'   => 'ORD-' . strtoupper(Str::random(10)),
                    'payment_method' => 'kashier',
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'shipping'       => $shipping,
                    'discount'       => 0,
                    'total'          => $total,
                    'status'         => 'pending',
                    'payment_status' => 'unpaid',
                ]);

                OrderAddress::create([
                    'order_id'       => $order->id,
                    'first_name'     => $defaultAddress->first_name,
                    'last_name'      => $defaultAddress->last_name,
                    'email'          => $user->email,
                    'phone'          => $defaultAddress->phone,
                    'governorate'    => $defaultAddress->governorate,
                    'city'           => $defaultAddress->city,
                    'area'           => $defaultAddress->area ?? null,
                    'street_address' => $defaultAddress->street_address,
                    'country'        => 'EG',
                ]);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'price'      => $finalPrice,
                    'quantity'   => $quantity,
                    'subtotal'   => $finalPrice * $quantity,
                    'options'    => json_encode([]),
                ]);

                return $order;
            });

            ActivityLogger::orderPlaced($user, $order);

            return redirect()->route('kashier.pay', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            Log::error('خطأ في الشراء السريع', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء معالجة طلبك. حاول مرة أخرى.');
        }
    }
}
