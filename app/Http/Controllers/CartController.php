<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{

    // Show Cart Page
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }


    // Add Product to Cart
    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

        } else {

            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
                "image" => $product->photo ?? null
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    // Update Quantity
    public function update(Request $request)
    {
        if($request->id && $request->quantity){

            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            return back()->with('success', 'Cart updated');
        }
    }


    // Remove Product
    public function remove(Request $request)
    {
        if($request->id){

            $cart = session()->get('cart');

            if(isset($cart[$request->id])){

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            return back()->with('success', 'Product removed');
        }
    }

}