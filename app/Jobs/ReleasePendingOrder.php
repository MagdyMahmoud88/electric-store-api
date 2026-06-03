<?php
namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReleasePendingOrder implements ShouldQueue
{
use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

protected $order;

public function __construct(Order $order)
{
$this->order = $order;
}

public function handle()
{
// التحقق مما إذا كان الطلب لا يزال معلقاً ولم يتم الدفع
if ($this->order->status === 'pending' && $this->order->payment_status === 'unpaid') {

DB::transaction(function () {
// إعادة الكميات إلى المخزن لكل منتج في الطلب
foreach ($this->order->items as $item) {
$item->product->increment('stock', $item->quantity);
}

// تحديث حالة الطلب إلى ملغي
$this->order->update([
'status' => 'cancelled',
'payment_status' => 'failed'
]);
});
}
}
}
