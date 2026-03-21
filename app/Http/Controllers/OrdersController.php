<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()->with('items.product')->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('transactions'));
    }
}