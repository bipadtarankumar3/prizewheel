<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewUserAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'New User Registered: ' . ($this->user->name ?? $this->user->email) . ' • Prize Wheel',
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.admin_new_user_alert',
        );
    }

    public function attachments()
    {
        return [];
    }
}
