<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function yearlySales()
    {
        $data = DB::table('transactions')
            ->selectRaw('YEAR(created_at) as year, SUM(total) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year');
        return response()->json($data);
    }

    public function monthlySales()
    {
        $data = DB::table('transactions')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('year','month')
            ->orderBy('year')->orderBy('month')
            ->get();
        return response()->json($data);
    }

    public function rangeBar(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $query = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date');
        if ($from) $query->whereDate('created_at','>=',$from);
        if ($to) $query->whereDate('created_at','<=',$to);
        $data = $query->orderBy('date')->get();
        return response()->json($data);
    }

    public function pieProductContribution()
    {
        $data = DB::table('transactions')
            ->join('transaction_items','transactions.id','=','transaction_items.transaction_id')
            ->join('products','products.id','=','transaction_items.product_id')
            ->selectRaw('products.name as name, SUM(transaction_items.quantity * transaction_items.unit_price) as total')
            ->groupBy('products.name')
            ->get();
        return response()->json($data);
    }
}
