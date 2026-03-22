<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TransactionCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your order receipt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction_completed',
            with: ['transaction' => $this->transaction],
        );
    }

    public function build()
    {
        if ($this->transaction->receipt_path && Storage::disk('public')->exists($this->transaction->receipt_path)) {
            $this->attach(storage_path('app/public/'.$this->transaction->receipt_path));
        }
    }
}
