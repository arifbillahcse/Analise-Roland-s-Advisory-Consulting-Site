<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadAutoresponder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead)
    {
        //
    }

    public function build(): self
    {
        return $this
            ->subject('Thanks for reaching out — Analise Roland')
            ->view('emails.leads.autoresponder');
    }
}
