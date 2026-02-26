<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function yearlySales()
    {
        $data = Transaction::selectRaw('YEAR(created_at) as year, SUM(total) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->get();
        return response()->json($data);
    }

    public function monthlySales()
    {
        $data = Transaction::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('year','month')
            ->orderBy('year')->orderBy('month')
            ->get();
        return response()->json($data);
    }

    public function rangeBar(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $query = Transaction::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date');
        if ($from) $query->whereDate('created_at','>=',$from);
        if ($to) $query->whereDate('created_at','<=',$to);
        $data = $query->get();
        return response()->json($data);
    }

    public function pieProductContribution()
    {
        $data = Transaction::join('transaction_items','transactions.id','=','transaction_items.transaction_id')
            ->join('products','products.id','=','transaction_items.product_id')
            ->selectRaw('products.name, SUM(transaction_items.quantity * transaction_items.unit_price) as total')
            ->groupBy('products.name')
            ->get();
        return response()->json($data);
    }
}
