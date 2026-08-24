<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New lead: '.$this->lead->name,
            // So hitting reply in the mail client answers the person who
            // submitted the form, rather than the site's own from-address.
            replyTo: [new Address($this->lead->email, $this->lead->name)],
        );
    }

    public function content(): Content
    {
        // markdown(), not view() — the template is built from the
        // <x-mail::…> components, and only the markdown renderer registers
        // the "mail" view namespace those resolve through.
        return new Content(markdown: 'emails.leads.received');
    }
}
