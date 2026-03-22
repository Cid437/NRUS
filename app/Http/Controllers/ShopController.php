<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->paginate(12);
        $categories = DB::table('categories')->get();
        $brands = DB::table('brands')->get();

        $types = ['product' => 'Product', 'service' => 'Service'];

        return view('shop.index', compact('products', 'categories', 'brands', 'types'));
    }

    public function show(Product $product)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($product->id);
        if (!$product->is_active) {
            abort(404);
        }
        return view('shop.show', compact('product'));
    }
}
