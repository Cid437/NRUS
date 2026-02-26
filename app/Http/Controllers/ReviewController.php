<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'=>'required|exists:products,id',
            'rating'=>'required|integer|min:1|max:5',
            'comment'=>'nullable|string',
        ]);

        // check purchase
        $bought = TransactionItem::where('product_id',$data['product_id'])
            ->whereHas('transaction', function($q){
                $q->where('user_id', Auth::id())->where('status','completed');
            })->exists();
        if (! $bought) {
            return back()->withErrors(['product_id'=>'You have not purchased this product']);
        }

        $review = Review::updateOrCreate(
            ['user_id'=>Auth::id(), 'product_id'=>$data['product_id']],
            ['rating'=>$data['rating'],'comment'=>$data['comment']]
        );

        return back()->with('status','Review saved');
    }

    public function edit(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403);
        }
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403);
        }
        $data = $request->validate([
            'rating'=>'required|integer|min:1|max:5',
            'comment'=>'nullable|string',
        ]);
        $review->update($data);
        return redirect()->back()->with('status','Review updated');
    }

    public function index()
    {
        $reviews = Review::with('user','product')->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }
        $review->delete();
        return back()->with('status','Review deleted');
    }
}
