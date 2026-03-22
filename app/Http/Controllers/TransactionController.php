<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCompleted;
use App\Mail\TransactionStatusUpdated;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $authUser = Auth::user();
        $transactionId = DB::table('transactions')->insertGetId([
            "user_id" => $authUser ? $authUser->id : null,
            "total" => 0,
            "status" => 'processing',
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $total = 0;
        foreach ($cart as $product_id => $item) {
            $product = DB::table('products')->where('id', $product_id)->first();
            if ($product) {
                $total += $item['quantity'] * $item['price'];
                DB::table('transaction_items')->insert([
                    "transaction_id" => $transactionId,
                    "product_id" => $product_id,
                    "quantity" => $item['quantity'],
                    "unit_price" => $item['price'],
                    "created_at" => now(),
                    "updated_at" => now()
                ]);
            }
        }
        DB::table('transactions')->where('id', $transactionId)->update([
            'total' => $total,
            'completed_at' => now(),
            'updated_at' => now()
        ]);

        
        $transaction = Transaction::with('user', 'items.product.category', 'items.product.brand')->find($transactionId);

        // generate pdf receipt from proper blade table
        $pdf = PDF::loadView('pdf.receipt', compact('transaction'));
        $path = 'receipts/txn_'.$transactionId.'.pdf';
        Storage::disk('public')->put($path, $pdf->output());
        DB::table('transactions')->where('id', $transactionId)->update(['receipt_path' => $path]);

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
        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = $request->status;
        $updateData = ['status' => $status, 'updated_at' => now()];
        if ($status === 'completed') {
            $updateData['completed_at'] = now();
            // Deduct stock
            $items = DB::table('transaction_items')->where('transaction_id', $transaction->id)->get();
            foreach ($items as $item) {
                DB::table('products')->where('id', $item->product_id)->decrement('stock', $item->quantity);
            }
        }
        DB::table('transactions')->where('id', $transaction->id)->update($updateData);

        $transactionData = DB::table('transactions')->where('id', $transaction->id)->first();
        $user = DB::table('users')->where('id', $transactionData->user_id)->first();
        $items = DB::table('transaction_items')
            ->leftJoin('products', 'transaction_items.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('transaction_items.quantity', 'transaction_items.unit_price', 'products.name as product_name', 'brands.name as brand_name', 'categories.name as category_name')
            ->where('transaction_items.transaction_id', $transaction->id)
            ->get();

        $transactionObj = (object) [
            'id' => $transactionData->id,
            'status' => $transactionData->status,
            'user' => (object)['name' => $user->name, 'email' => $user->email],
            'items' => $items->map(function($t) {
                return (object)[
                    'quantity' => $t->quantity,
                    'unit_price' => $t->unit_price,
                    'product' => (object)[
                        'name' => $t->product_name,
                        'category' => $t->category_name ? (object)['name' => $t->category_name] : null,
                        'brand' => $t->brand_name ? (object)['name' => $t->brand_name] : null,
                    ]
                ];
            })
        ];

        Mail::to($transactionObj->user->email)->send(new TransactionStatusUpdated($transactionObj));

        return redirect()->back()->with('status','Status updated and email sent');
    }
}
