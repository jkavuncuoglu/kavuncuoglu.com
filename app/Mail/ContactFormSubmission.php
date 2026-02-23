<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly ContactMessage $contactMessage,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: env('CONTACT_EMAIL', config('mail.from.address')),
            subject: "New contact form message: {$this->contactMessage->subject}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-form-submission',
        );
    }
}
