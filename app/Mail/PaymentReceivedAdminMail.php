<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceivedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $user;
    public $plan;
    public $admin;

    public function __construct($payment, $user, $plan, $admin)
    {
        $this->payment = $payment;
        $this->user = $user;
        $this->plan = $plan;
        $this->admin = $admin;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'New Payment Received: ₹' . number_format($this->payment->amount, 2) . ' from ' . ($this->user->name ?? 'Store'),
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.payment_received_admin',
        );
    }

    public function attachments()
    {
        return [];
    }
}
