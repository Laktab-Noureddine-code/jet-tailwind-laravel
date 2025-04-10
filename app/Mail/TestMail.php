<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Affectation;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $affectation;

    /**
     * Create a new message instance.
     */
    public function __construct(Affectation $affectation)
    {
        $this->affectation = $affectation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Confirmation d'Affectation de Matériel IT",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.affectation',
            with: [
                'affectation' => $this->affectation,
                'utilisateur' => $this->affectation->utilisateur,
                'materiel' => $this->affectation->materiel,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
