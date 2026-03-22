@extends('layouts.app')

@section('title', 'Shop')

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
            <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="method" class="form-control">
                <option value="like" {{ request('method') == 'like' ? 'selected' : '' }}>LIKE</option>
                <option value="model" {{ request('method') == 'model' ? 'selected' : '' }}>Model</option>
                <option value="scout" {{ request('method') == 'scout' ? 'selected' : '' }}>Scout</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="Min price" value="{{ request('min_price') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="Max price" value="{{ request('max_price') }}">
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" name="brand_id" class="form-control" placeholder="Brand ID" value="{{ request('brand_id') }}">
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                   <div class="card-body text-center">

                         @if($product->primaryPhoto)
                             <img src="{{ asset('storage/' . $product->primaryPhoto->file) }}"
                              alt="{{ $product->name }}"
                              class="img-fluid mb-2"
                            style="max-height:150px; object-fit:contain;">
                         @else
                           <div class="border bg-light mb-2"
                               style="height:150px; display:flex;align-items:center;justify-content:center;">
                               No image
                            </div>
                        @endif
                        <h5 class="card-title"><a href="{{ route('products.show', $product) }}" class="text-decoration-none">{{ $product->name }}</a></h5>
                         <p class="h5 text-primary mb-3">{{ $product->formatted_price }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        @auth
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
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
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
@endpush