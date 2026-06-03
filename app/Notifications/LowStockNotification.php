<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification
{
    public function __construct(public Product $product) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // database = في الموقع / mail = إيميل
    }

    // ✅ إشعار داخل الموقع
    public function toDatabase(object $notifiable): array
    {
        return [
            'product_id'   => $this->product->id,
            'product_name' => $this->product->name,
            'stock'        => $this->product->stock,
            'message'      => $this->product->stock === 0
                ? "⚠️ نفذ المخزون: {$this->product->name}"
                : "🔔 مخزون منخفض: {$this->product->name} (متبقي {$this->product->stock})",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->product->stock === 0
            ? "نفذ المخزون: {$this->product->name}"
            : "تحذير: مخزون منخفض للمنتج {$this->product->name}";

        return (new MailMessage)
            ->subject($subject)
            ->line($this->product->stock === 0
                ? "نفذ مخزون المنتج: {$this->product->name}"
                : "المنتج: {$this->product->name} متبقي منه {$this->product->stock} فقط"
            )
            ->action('عرض المنتج', url("/admin/products/{$this->product->id}/edit"))
            ->line('يرجى إعادة تعبئة المخزون في أقرب وقت.');
    }
}
