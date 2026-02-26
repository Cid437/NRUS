<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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

    public function build()
    {
        $email = $this->subject('Your order receipt')
            ->view('emails.transaction_completed')
            ->with(['transaction'=>$this->transaction]);

        if ($this->transaction->receipt_path && Storage::disk('public')->exists($this->transaction->receipt_path)) {
            $email->attach(storage_path('app/public/'.$this->transaction->receipt_path));
        }
        return $email;
    }
}
