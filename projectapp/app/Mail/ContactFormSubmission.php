<?php

namespace App\Mail;

use App\Models\Contact;
use App\Mail\ContactFormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormSubmission extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("New Contact Form Submission: {$this->contact->name}")
            ->replyTo($this->contact->email, $this->contact->name)
            ->view('emails.contact-form-submission');
    }
}
