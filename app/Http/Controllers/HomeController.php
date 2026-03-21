<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('photos', 'category', 'brand')->where('is_active', true);

        if ($request->filled('search')) {
            $products = Product::search($request->search)->where('is_active', true)->with('category', 'brand')->take(12)->get();
        } else {
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
            $products = $query->latest()->take(12)->get();
        }

        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }
}