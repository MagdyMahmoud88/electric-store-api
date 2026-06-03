<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * استقبال كائن الطلب وتمريره للـ Mail
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * إعداد عنوان الرسالة والـ Sender
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تم تأكيد طلبك بنجاح! رقم الطلب ' . $this->order->order_number,
        );
    }

    /**
     * تحديد ملف الـ View الذي يحتوي على تصميم الإيميل
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.confirmed',
        );
    }
}
