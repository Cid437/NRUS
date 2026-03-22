<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()
            ->with(['items.product.brand', 'items.product.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('orders.index', compact('transactions'));
    }
}