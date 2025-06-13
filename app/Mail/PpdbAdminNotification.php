<?php

namespace App\Mail;

use App\Models\Ppdb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PpdbAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Ppdb $ppdb)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran PPDB Baru - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ppdb-admin-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
