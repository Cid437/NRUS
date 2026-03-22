<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['photos', 'category', 'brand'])->where('is_active', true);

        if ($request->filled('search')) {
            $searchValue = $request->search;
            $query->where('name', 'like', '%'.$searchValue.'%');
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

        if ($request->filled('type')) {
            // 'type' is optional legacy field; placeholder for service/product type
            $query->where('category', $request->type);
        }

        $products = $query->paginate(12);
        $categories = Category::all();
        $brands = Brand::all();

        $types = ['product' => 'Product', 'service' => 'Service'];

        return view('shop.index', compact('products', 'categories', 'brands', 'types'));
    }

    public function show(Product $product)
    {
        $product = Product::with(['category:id,name', 'brand:id,name'])->findOrFail($product->id);
        if (!$product->is_active) {
            abort(404);
        }
        return view('shop.show', compact('product'));
    }
}
