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

class LeadAutoresponder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thanks for reaching out — Analise Roland',
            // A reply to the confirmation should reach Analise, not bounce
            // off the no-reply from-address.
            replyTo: array_filter([
                config('site.admin_email') ? new Address(config('site.admin_email')) : null,
            ]),
        );
    }

    public function content(): Content
    {
        // markdown(), not view() — see NewLeadReceived for why.
        return new Content(markdown: 'emails.leads.autoresponder');
    }
}
