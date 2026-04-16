<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $otp,
        public readonly string $email,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔌 كود التحقق - متجري للأدوات الكهربائية',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-otp',
            with: [
                'otp'   => $this->otp,
                'email' => $this->email,
            ],
        );
    }
}
