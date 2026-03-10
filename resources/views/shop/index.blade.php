@extends('layouts.app')

@section('title', 'Shop')

@push('styles')
<style>
    .product-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.6rem 1rem rgba(0,0,0,0.13);
    }
    .price {
        font-weight: 700;
        color: #198754;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
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

    <h2 class="mb-4 text-center">Products</h2>

    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search">
        </div>
        <div class="col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="Min price">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="Max price">
        </div>
        <div class="col-md-2">
            <input type="number" name="category_id" class="form-control" placeholder="Category ID">
        </div>
        <div class="col-md-2">
            <input type="number" name="brand_id" class="form-control" placeholder="Brand ID">
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        @auth
                            <form action="{{ route('transactions.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                            </form>
                        @else
                            <button type="button" onclick="alert('Please log in first.')" class="btn btn-success w-100">Add to Cart</button>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
@endpush