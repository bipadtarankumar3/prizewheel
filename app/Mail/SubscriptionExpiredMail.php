<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $renewUrl;

    public function __construct($user, $renewUrl = null)
    {
        $this->user = $user;
        $this->renewUrl = $renewUrl ?: url('admin/billing');
    }

    public function envelope()
    {
        return new Envelope(
            subject: '⚠️ Action Required: Your PrizeWheel Subscription Has Expired',
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.subscription_expired',
        );
    }

    public function attachments()
    {
        return [];
    }
}
