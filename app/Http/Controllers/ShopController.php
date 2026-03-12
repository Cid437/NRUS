<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // if using scout search, bypass additional filters (not all scopes available)
        if ($request->filled('search') && $request->input('method')==='scout' && method_exists(Product::class,'search')) {
            $products = Product::search($request->search)->paginate(12);
            return view('shop.index', compact('products'));
        }

        $query = Product::with('photos')->where('is_active',true);
        if ($request->filled('search')) {
            $term = $request->search;
            if ($request->input('method')==='model') {
                $query = $query->search($term);
            } else {
                $query->where('name','like','%'.$term.'%');
            }
        }
        if ($request->filled('min_price')) {
            $query->where('price','>=',$request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price','<=',$request->max_price);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id',$request->category_id);
        }
        if ($request->filled('brand_id')) {
            $query->where('brand_id',$request->brand_id);
        }
        $products = $query->paginate(12);
        return view('shop.index', compact('products'));
    }
}
