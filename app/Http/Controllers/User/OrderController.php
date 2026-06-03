<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // ══════════════════════════════════════════════════════════
    //  index — قائمة طلبات اليوزر
    //  GET /orders
    // ══════════════════════════════════════════════════════════

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'address'])
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    // ══════════════════════════════════════════════════════════
    //  show — تفاصيل طلب واحد
    //  GET /orders/{order}
    // ══════════════════════════════════════════════════════════

    public function show(Order $order)
    {
        // ✅ Policy بدل if/abort يدوي
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'address']);

        return view('user.orders.show', compact('order'));
    }

    // ══════════════════════════════════════════════════════════
    //  store — إنشاء طلب جديد
    //  POST /orders
    // ══════════════════════════════════════════════════════════

    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255'],
            'phone'          => ['required', 'string', 'max:20'],
            'address'        => ['required', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'governorate'    => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'in:cod,kashier,card,vodafone,instapay'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'السلة فارغة.');
        }

        $order = null; // ✅ عشان يكون accessible بعد الـ transaction

        try {
            DB::transaction(function () use ($request, $cart, &$order) {

                $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
                $tax      = 0;
                $shipping = $subtotal >= 500 ? 0 : 45;
                $total    = $subtotal + $tax + $shipping;

                // ── 1. إنشاء الطلب ────────────────────────────
                $order = Order::create([
                    'user_id'        => Auth::id(),
                    'order_number'   => 'ORD-' . strtoupper(uniqid()),
                    'payment_method' => $request->payment_method,
                    'subtotal'       => $subtotal,
                    'tax'            => $tax,
                    'shipping'       => $shipping,
                    'discount'       => 0,
                    'total'          => $total,
                    'status'         => 'pending',
                ]);

                // ── 2. حفظ عنوان الشحن ────────────────────────
                $order->address()->create([
                    'first_name'     => $request->first_name,
                    'last_name'      => $request->last_name,
                    'email'          => $request->email,
                    'phone'          => $request->phone,
                    'governorate'    => $request->governorate,
                    'city'           => $request->city,
                    'street_address' => $request->address,
                    'country'        => 'EG',
                ]);

                // ── 3. حفظ عناصر الطلب ────────────────────────
                foreach ($cart as $item) {
                    $order->items()->create([
                        'product_id' => $item['product_id'],
                        'name'       => $item['name']     ?? '',
                        'price'      => $item['price'],
                        'quantity'   => $item['quantity'],
                        'subtotal'   => $item['price'] * $item['quantity'],
                        'options'    => json_encode($item['options'] ?? []),
                    ]);
                }

                // ── 4. خصم المخزون ────────────────────────────
                $order->deductStock();

                // ── 5. تفريغ السلة ────────────────────────────
                session()->forget('cart');
            });

            // ✅ بعد commit — مش جوا الـ transaction
            ActivityLogger::orderPlaced(Auth::user(), $order);

            Log::info('Order created', [
                'order_id' => $order->id,
                'user_id'  => Auth::id(),
                'total'    => $order->total,
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'تم إنشاء طلبك بنجاح!');

        } catch (\Exception $e) {
            Log::error('خطأ في إنشاء الطلب', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'حدث خطأ أثناء معالجة طلبك. حاول مرة أخرى.');
        }
    }

    // ══════════════════════════════════════════════════════════
    //  cancel — إلغاء الطلب
    //  PATCH /orders/{order}/cancel
    // ══════════════════════════════════════════════════════════

    public function cancel(Order $order)
    {
        // ✅ تأكد إن الطلب بتاع اليوزر ده
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // ✅ بس الطلبات اللي لسه pending تتلغى
        if (! in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'لا يمكن إلغاء هذا الطلب في مرحلته الحالية.');
        }

        try {
            DB::transaction(function () use ($order) {
                // ✅ إرجاع المخزون
                foreach ($order->items as $item) {
                    $item->product?->increment('stock', $item->quantity);
                }

                $order->update(['status' => 'cancelled']);
            });

            ActivityLogger::orderCancelled(Auth::user(), $order); // ✅

            return back()->with('success', 'تم إلغاء الطلب بنجاح.');

        } catch (\Exception $e) {
            Log::error('خطأ في إلغاء الطلب', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return back()->with('error', 'حدث خطأ أثناء إلغاء الطلب. حاول مرة أخرى.');
        }
    }
}
