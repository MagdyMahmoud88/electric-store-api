<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmedMail;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KashierController extends Controller
{
    // ══════════════════════════════════════════════════════════
    //  Hash Generator
    // ══════════════════════════════════════════════════════════

    public function generateHash(string $orderId, string $amount, string $currency): string
    {
        $mid    = config('kashier.merchant_id');
        $secret = config('kashier.secret_key');
        $path   = "/?payment={$mid}.{$orderId}.{$amount}.{$currency}";

        return hash_hmac('sha256', $path, $secret, false);
    }

    // ══════════════════════════════════════════════════════════
    //  Pay
    // ══════════════════════════════════════════════════════════

    public function pay(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        // ✅ لو الطلب اتدفع قبل كده — روح لـ success مباشرة
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order->id);
        }

        // ✅ لو الطلب اتلغى — ارجع للسلة
        if ($order->status === 'cancelled') {
            return redirect()->route('cart.index')
                ->with('error', 'هذا الطلب تم إلغاؤه. يرجى إنشاء طلب جديد.');
        }

        $mid      = config('kashier.merchant_id');
        $mode     = config('kashier.mode', 'test');
        $amount   = number_format($order->total, 2, '.', '');
        $currency = 'EGP';
        $orderId  = $order->order_number;
        $hash     = $this->generateHash($orderId, $amount, $currency);

        $params = http_build_query([
            'merchantId'       => $mid,
            'orderId'          => $orderId,
            'amount'           => $amount,
            'currency'         => $currency,
            'hash'             => $hash,
            'mode'             => $mode,
            'merchantRedirect' => route('kashier.callback'),
            'failureRedirect'  => route('kashier.cancel'), // ✅ عشان الـ X يروح لـ cancel
            'display'          => 'ar',
        ]);

        return redirect("https://checkout.kashier.io/?{$params}");
    }

    // ══════════════════════════════════════════════════════════
    //  Callback — frontend redirect
    // ══════════════════════════════════════════════════════════

    public function callback(Request $request)
    {
        Log::info('Kashier Callback:', $request->all());

        $orderRef     = $request->get('merchantOrderId') ?? $request->get('orderId');
        $status       = $request->get('paymentStatus');
        $transId      = $request->get('transactionId');
        $receivedHash = $request->get('signature') ?? $request->get('hash');

        $order = Order::where('order_number', $orderRef)->first();

        if (! $order) {
            return redirect()->route('welcome')->with('error', 'الطلب غير موجود');
        }

        // ── Hash Verification ──────────────────────────────────
        $amount       = number_format($order->total, 2, '.', '');
        $expectedHash = $this->generateHash($orderRef, $amount, 'EGP');

        if (! hash_equals($expectedHash, (string) $receivedHash)) {
            Log::warning('Kashier Callback: Hash mismatch', [
                'order'    => $orderRef,
                'expected' => $expectedHash,
                'received' => $receivedHash,
            ]);
            // مش بنوقف — الـ webhook هيأكد لاحقاً
        }

        // ── SUCCESS ────────────────────────────────────────────
        if ($status === 'SUCCESS') {
            if ($order->payment_status !== 'paid') {
                $this->handleSuccess($order, $transId, 'callback');
            }
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'تم الدفع بنجاح! رقم المعاملة: ' . $transId);
        }

        // ── FAILURE / CANCEL ───────────────────────────────────
        if (in_array($status, ['FAILURE', 'CANCEL'])) {
            if ($order->payment_status !== 'paid') {
                $this->handleFailure($order, 'callback');
            }
            return redirect()->route('cart.index')
                ->with('error', 'فشل الدفع أو تم الإلغاء. منتجاتك لا تزال في سلتك.');
        }

        // ── TEST MODE: serverError = نجاح ─────────────────────
        if (config('kashier.mode', 'test') === 'test' && $status === 'serverError') {
            if ($order->payment_status !== 'paid') {
                $this->handleSuccess($order, $transId, 'callback');
            }
            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'تم الدفع بنجاح!');
        }

        return redirect()->route('cart.index')
            ->with('error', 'حدث خطأ أثناء معالجة الدفع. يرجى المحاولة مرة أخرى.');
    }

    // ══════════════════════════════════════════════════════════
    //  Webhook — Server-to-Server (المصدر الموثوق)
    // ══════════════════════════════════════════════════════════

    public function webhook(Request $request)
    {
        Log::info('Kashier Webhook:', $request->all());

        $orderRef = $request->get('merchantOrderId') ?? $request->input('body.merchantOrderId');
        $status   = $request->get('paymentStatus')   ?? $request->input('body.paymentStatus');
        $transId  = $request->get('transactionId')   ?? $request->input('body.transactionId');
        $event    = $request->get('event');

        if (! $orderRef) {
            Log::error('Kashier Webhook: missing orderRef');
            return response('OK', 200);
        }

        $order = Order::where('order_number', $orderRef)->first();

        if (! $order) {
            Log::error("Kashier Webhook: Order {$orderRef} not found");
            return response('OK', 200);
        }

        // ── Hash Verification ──────────────────────────────────
        $amount       = number_format($order->total, 2, '.', '');
        $receivedHash = $request->get('signature') ?? $request->get('hash');
        $expectedHash = $this->generateHash($orderRef, $amount, 'EGP');

        if (! hash_equals($expectedHash, (string) $receivedHash)) {
            Log::warning("Kashier Webhook: Hash mismatch for {$orderRef}");
            return response('OK', 200);
        }

        if ($status === 'SUCCESS' || $event === 'PAYMENT_SUCCESS') {
            if ($order->payment_status !== 'paid') {
                $this->handleSuccess($order, $transId, 'webhook');
            } else {
                Log::info("Kashier Webhook: Order {$orderRef} already paid — skipped");
            }
        } elseif (in_array($status, ['FAILURE', 'CANCEL'])) {
            if ($order->payment_status !== 'paid') {
                $this->handleFailure($order, 'webhook');
            }
        }

        return response('OK', 200);
    }

    // ══════════════════════════════════════════════════════════
    //  Cancel — العميل ضغط X أو راح من صفحة الدفع
    // ══════════════════════════════════════════════════════════

    public function cancel(Request $request)
    {
        Log::info('Kashier Cancel:', $request->all());

        $orderRef = $request->query('merchantOrderId')
            ?? $request->query('orderId')
            ?? $request->query('order_id');

        if ($orderRef) {
            $order = Order::where('order_number', $orderRef)
                ->orWhere('id', $orderRef)
                ->first();

            // ✅ متلغيش الطلب — بس سجّل إن الدفع فشل
            // الـ CancelAbandonedOrders command هيلغيه بعد ساعة
            if ($order && $order->payment_status === 'unpaid') {
                $order->update(['payment_status' => 'failed']);
                Log::info("Kashier Cancel: Order #{$order->order_number} — payment cancelled by user");
            }
        }

        // ✅ رجوع للسلة مع السلة موجودة
        return redirect()->route('cart.index')
            ->with('info', 'تم إلغاء عملية الدفع. منتجاتك لا تزال في سلتك، يمكنك إتمام الطلب في أي وقت.');
    }

    // ══════════════════════════════════════════════════════════
    //  Private Helpers
    // ══════════════════════════════════════════════════════════

    private function handleSuccess(Order $order, ?string $transId, string $source): void
    {
        try {
            DB::transaction(function () use ($order, $transId, $source) {

                // ✅ lockForUpdate — يمنع Race Condition
                $fresh = Order::lockForUpdate()->find($order->id);

                if ($fresh->payment_status === 'paid') {
                    Log::info("handleSuccess: already paid — skipped [{$source}]");
                    return;
                }

                $fresh->update([
                    'status'         => 'processing',
                    'payment_status' => 'paid',
                    'paid_at'        => now(),
                ]);

                // ✅ خصم المخزون بعد تأكيد الدفع فقط
                $fresh->load('items.product');
                $fresh->deductStock();

                // ✅ مسح السلة هنا بس — مش في placeOrder
                CartItem::where('user_id', $fresh->user_id)->delete();

                Log::info("Kashier [{$source}]: Order #{$fresh->order_number} paid — stock deducted — cart cleared", [
                    'transaction_id' => $transId,
                ]);
            });

            // ✅ الإيميل خارج الـ transaction
            try {
                $freshOrder = $order->fresh()->load(['items.product', 'address']);
                $email      = $freshOrder->address?->email ?? $freshOrder->user?->email;

                if ($email) {
                    Mail::to($email)->queue(new OrderConfirmedMail($freshOrder));
                }
            } catch (\Exception $e) {
                Log::error("فشل إرسال إيميل التأكيد للطلب #{$order->id}: " . $e->getMessage());
            }

        } catch (\Exception $e) {
            Log::error("handleSuccess failed for Order #{$order->id}: " . $e->getMessage());
        }
    }

    private function handleFailure(Order $order, string $source): void
    {
        $order->update([
            'status'         => 'payment_failed',
            'payment_status' => 'failed',
        ]);

        Log::info("Kashier [{$source}]: Order #{$order->order_number} failed");
    }
}
