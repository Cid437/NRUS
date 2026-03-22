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
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        /** @var \App\Models\User|null $authUser */
        $authUser = Auth::user();
        $transaction = Transaction::create(["user_id"=> $authUser? $authUser->id : null,"total"=>0,"status"=>'processing']);
        $total = 0;
        foreach ($cart as $product_id => $item) {
            $product = \App\Models\Product::find($product_id);
            if ($product) {
                $total += $item['quantity'] * $item['price'];
                TransactionItem::create([
                    "transaction_id" => $transaction->id,
                    "product_id" => $product_id,
                    "quantity" => $item['quantity'],
                    "unit_price" => $item['price']
                ]);
            }
        }
        $transaction->total = $total;
        $transaction->completed_at = now();

        // make sure nested relations are loaded for PDF generation and email
        $transaction->load(['user', 'items.product.brand', 'items.product.category']);

        // generate pdf receipt from proper blade table
        $pdf = PDF::loadView('pdf.receipt', compact('transaction'));
        $path = 'receipts/txn_'.$transaction->id.'.pdf';
        Storage::disk('public')->put($path, $pdf->output());
        $transaction->receipt_path = $path;
        $transaction->save();

        // Clear cart
        session()->forget('cart');

        Mail::to($transaction->user->email)->send(new TransactionCompleted($transaction));

        return redirect()->back()->with('status','Transaction completed and email sent');
    }

    public function index()
    {
        if (request()->ajax()) {
            $transactions = Transaction::with('user');
            return DataTables::of($transactions)
                ->addColumn('user_name', function($transaction) {
                    return $transaction->user->name;
                })
                ->addColumn('actions', function($transaction) {
                    return view('admin.transactions.partials.actions', compact('transaction'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.transactions.index');
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $data = $request->validate(['status'=>'required|string']);
        $transaction->status = $data['status'];
        if ($data['status'] === 'completed') {
            $transaction->completed_at = now();
        }
        $transaction->save();
        Mail::to($transaction->user->email)->send(new TransactionStatusUpdated($transaction));
        return redirect()->back()->with('status','Status updated and email sent');
    }
}
