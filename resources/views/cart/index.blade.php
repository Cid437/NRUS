@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!empty($cart))
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Items</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($cart as $id => $item)
                                        @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>
                                                @if($item['image'])
                                                    <img src="{{ asset('storage/' . $item['image']) }}" width="50" alt="Product Image">
                                                @endif
                                            </td>
                                            <td>{{ format_currency($item['price']) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('cart.update') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control d-inline" style="width: 80px;">
                                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                </form>
                                            </td>
                                            <td>{{ format_currency($subtotal) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('cart.remove') }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Summary</h5>
                        <p class="mb-2">Total Items: {{ count($cart) }}</p>
                        <p class="mb-3"><strong>Total: {{ format_currency($total) }}</strong></p>
                        <form method="POST" action="{{ route('transactions.store') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            <h3>Your cart is empty</h3>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection