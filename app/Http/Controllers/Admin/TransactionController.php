<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TransactionStatusUpdated;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $transactions = Transaction::with('user');
            return DataTables::of($transactions)
                ->addColumn('user_name', function($transaction) {
                    return $transaction->user->name ?? 'N/A';
                })
                ->addColumn('actions', function($transaction) {
                    return view('admin.transactions.partials.actions', compact('transaction'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'status' => 'required|string|in:processing,completed,cancelled',
            'total' => 'required|numeric|min:0',
        ]);

        $transaction->update($data);

        if ($data['status'] === 'completed' && !$transaction->completed_at) {
            $transaction->completed_at = now();
            $transaction->save();
        }

        return redirect()->route('admin.transactions.index')->with('status', 'Transaction updated successfully');
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $data = $request->validate(['status'=>'required|string']);
        $oldStatus = $transaction->status;
        $transaction->status = $data['status'];
        if ($data['status'] === 'completed') {
            $transaction->completed_at = now();
            // Deduct stock only if status was not already completed
            if ($oldStatus !== 'completed') {
                $transaction->load('items.product');
                foreach ($transaction->items as $item) {
                    if ($item->product) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            }
        }
        $transaction->save();
        Mail::to($transaction->user->email)->send(new TransactionStatusUpdated($transaction));
        return redirect()->back()->with('status','Status updated');
    }
}