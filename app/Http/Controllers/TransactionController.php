<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCompleted;
use App\Mail\TransactionStatusUpdated;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        /** @var \App\Models\User|null $authUser */
        $authUser = Auth::user();
        $transaction = Transaction::create(["user_id"=> $authUser? $authUser->id : null,"total"=>0,"status"=>'completed']);
        $total = 0;
        foreach ($data['items'] as $i) {
            $total += $i['quantity'] * $i['unit_price'];
            TransactionItem::create(["transaction_id"=>$transaction->id]+$i);
        }
        $transaction->total = $total;
        $transaction->completed_at = now();
        // generate simple pdf receipt
        $pdf = PDF::loadView('pdf.receipt', compact('transaction'));
        $path = 'receipts/txn_'.$transaction->id.'.pdf';
        Storage::disk('public')->put($path, $pdf->output());
        $transaction->receipt_path = $path;
        $transaction->save();

        Mail::to($transaction->user->email)->send(new TransactionCompleted($transaction));

        return redirect()->back()->with('status','Transaction completed and email sent');
    }

    public function index()
    {
        $transactions = Transaction::with('user')->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $data = $request->validate(['status'=>'required|string']);
        $transaction->status = $data['status'];
        $transaction->save();
        Mail::to($transaction->user->email)->send(new TransactionStatusUpdated($transaction));
        return redirect()->back()->with('status','Status updated and email sent');
    }
}
