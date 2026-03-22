<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['product_id', 'rating', 'comment']);

        // check purchase
        $bought = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transaction_items.product_id', $data['product_id'])
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.status', 'completed')
            ->exists();
        if (! $bought) {
            return back()->withErrors(['product_id'=>'You have not purchased this product']);
        }

        DB::table('reviews')->updateOrInsert(
            ['user_id' => Auth::id(), 'product_id' => $data['product_id']],
            ['rating' => $data['rating'], 'comment' => $data['comment'], 'updated_at' => now()]
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

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['rating', 'comment']);
        DB::table('reviews')->where('id', $review->id)->update($data);
        return redirect()->back()->with('status','Review updated');
    }

    public function index()
    {
        if (request()->ajax()) {
            $reviews = Review::with('user','product');
            return DataTables::of($reviews)
                ->addColumn('user_name', function($review) {
                    return optional($review->user)->name ?? 'Deleted User';
                })
                ->addColumn('product_name', function($review) {
                    return optional($review->product)->name ?? 'Deleted Product';
                })
                ->addColumn('actions', function($review) {
                    return view('admin.reviews.partials.actions', compact('review'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.reviews.index');
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
