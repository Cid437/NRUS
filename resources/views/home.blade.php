@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-dark text-white py-5" style="margin: -1.5rem -1.5rem 2rem -1.5rem;">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="lead mb-4">Explore our collection of products and find what you're looking for.</p>

            <!-- Search Form -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-lg" placeholder="Search products" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="method" class="form-select form-select-lg">
                        <option value="like" {{ request('method') == 'like' ? 'selected' : '' }}>LIKE</option>
                        <option value="model" {{ request('method') == 'model' ? 'selected' : '' }}>Model</option>
                        <option value="scout" {{ request('method') == 'scout' ? 'selected' : '' }}>Scout</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control form-control-lg" placeholder="Min price" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control form-control-lg" placeholder="Max price" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select form-select-lg">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="number" name="brand_id" class="form-control form-control-lg" placeholder="Brand ID" value="{{ request('brand_id') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container">
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ request('search') ? 'Search Results' : 'Featured Products' }}</h2>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">View All</a>
            </div>

            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($product->primaryPhoto)
                                <img src="{{ asset('storage/' . $product->primaryPhoto->file) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ Str::limit($product->name, 50) }}</h5>
                                <p class="text-muted small">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                                <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                                <p class="h5 text-primary mb-3">{{ format_currency($product->price) }}</p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">{{ request('search') ? 'No products found matching your search.' : 'No products available yet.' }}</p>
                        @if(request('search'))
                            <a href="{{ route('home') }}" class="btn btn-primary">Clear Search</a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection