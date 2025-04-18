<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaterielsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data to be passed to the email view.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        // Store the data in a protected property
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Détails de l\'Affectation des Matériels',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.materiels-mail',
            with: [
                'utilisateur' => $this->data['utilisateur'],
                'chantier' => $this->data['chantier'],
                'materiels' => $this->data['materiels'],
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
