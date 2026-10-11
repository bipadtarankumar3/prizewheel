<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
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
            subject: 'Welcome to Prize Wheel! Your Account is Ready',
        );
    }

    public function content()
    {
        return new Content(
            view: 'mail.user_welcome',
        );
    }

    public function attachments()
    {
        return [];
    }
}
