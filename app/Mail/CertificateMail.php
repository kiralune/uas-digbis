<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public Transaction $transaction;
    public string $certificatePath;

    public function __construct(Transaction $transaction, string $certificatePath)
    {
        $this->transaction = $transaction;
        $this->certificatePath = $certificatePath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Certificate Kehadiran Anda - ' . $this->transaction->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate',
            with: [
                'transaction' => $this->transaction,
            ],
        );
    }

    public function build(): static
    {
        $certificatePath = ltrim($this->certificatePath, '/');

        if (Storage::disk('public')->exists($certificatePath)) {
            $this->attachFromStorageDisk('public', $certificatePath, 'e-certificate.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        return $this;
    }
}

