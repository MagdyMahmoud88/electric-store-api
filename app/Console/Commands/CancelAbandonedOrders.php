<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelAbandonedOrders extends Command
{
    protected $signature   = 'orders:cancel-abandoned';
    protected $description = 'إلغاء الطلبات المعلقة التي لم يكتمل دفعها خلال ساعة';

    public function handle(): void
    {
        $abandoned = Order::where('status', 'pending')
            ->where('payment_status', 'unpaid')
            ->where('created_at', '<', now()->subHour())
            ->get();

        if ($abandoned->isEmpty()) {
            $this->info('لا توجد طلبات معلقة.');
            return;
        }

        foreach ($abandoned as $order) {
            try {
                DB::transaction(function () use ($order) {
                    // ✅ إرجاع المخزون
                    foreach ($order->items as $item) {
                        $item->product?->increment('stock', $item->quantity);
                    }

                    $order->update([
                        'status'         => 'cancelled',
                        'payment_status' => 'failed',
                    ]);
                });

                Log::info("Abandoned order #{$order->order_number} cancelled — stock restored.");

            } catch (\Exception $e) {
                Log::error("Failed to cancel order #{$order->order_number}: " . $e->getMessage());
            }
        }

        $this->info("تم إلغاء {$abandoned->count()} طلب معلق.");
    }
}
