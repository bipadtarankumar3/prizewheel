<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $user;
    public $plan;

    public function __construct($payment, $user, $plan)
    {
        $this->payment = $payment;
        $this->user = $user;
        $this->plan = $plan;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Payment Successful - Your ' . ($this->plan->name ?? 'PrizeWheel') . ' Plan is Active!',
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.payment_success_user',
        );
    }

    public function attachments()
    {
        return [];
    }
}
