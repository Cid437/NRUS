@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">My Orders</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($transactions->count() > 0)
        <div class="row">
            @foreach($transactions as $transaction)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Order #{{ $transaction->id }} - {{ $transaction->created_at->format('M d, Y') }}</h5>
                            <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'warning' }}">{{ ucfirst($transaction->status) }}</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Review</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaction->items as $item)
                                            @php
                                                $product = $item->product;
                                                $review = $product ? $product->reviews()->where('user_id', auth()->id())->first() : null;
                                            @endphp
                                            <tr>
                                                <td>{{ optional($product)->name ?? 'Product removed' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ format_currency($item->unit_price) }}</td>
                                                <td>{{ format_currency($item->quantity * $item->unit_price) }}</td>
                                                <td>
                                                    @if($product)
                                                        @if($review)
                                                            <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary">Edit Review</a>
                                                        @else
                                                            <a href="{{ route('products.show', $product) }}#review" class="btn btn-sm btn-primary">Leave Review</a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Unavailable</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <strong>Total: {{ format_currency($transaction->total) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $transactions->links('pagination::bootstrap-5') }}
    @else
        <div class="text-center">
            <h3>You have no orders yet.</h3>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection