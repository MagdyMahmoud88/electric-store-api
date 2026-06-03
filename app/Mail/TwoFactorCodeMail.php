<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// ✅ ShouldQueue → الإيميل يتبعت في الخلفية مش synchronously
class TwoFactorCodeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $code,
        public readonly string $userName,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'كود التحقق الثنائي — لوحة التحكم',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.two-factor-code',
            with: [
                'code'     => $this->code,
                'userName' => $this->userName,
            ],
        );
    }

    // ✅ لو فشل الإرسال يحاول 3 مرات
    public int $tries = 3;

    // ✅ يستنى 30 ثانية بين كل محاولة
    public int $backoff = 30;
}
