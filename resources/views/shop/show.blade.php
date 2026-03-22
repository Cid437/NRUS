@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            @if($product->photos->count() > 0)
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->photos as $index => $photo)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $photo->file) }}" class="d-block w-100" alt="Product Image">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <div class="text-center border p-5">
                    <p>No images available</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="h4 text-primary">{{ format_currency($product->price) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Category:</strong> {{ $product->category->name ?? 'No Category' }}</p>
            <p><strong>Brand:</strong> {{ $product->brand ? $product->brand->name : 'N/A' }}</p>
            <p><strong>Description:</strong></p>
            <p>{{ $product->description ?? 'No description available.' }}</p>

            @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">Add to Cart</button>
                </form>
            @else
                <button type="button" onclick="alert('Please log in first.')" class="btn btn-success btn-lg">Add to Cart</button>
            @endauth
        </div>
    </div>

    @auth
        @php
            $user = auth()->user();
            $hasPurchased = \App\Models\TransactionItem::whereHas('transaction', function($q) use ($user) {
                $q->where('user_id', $user->id)->where('status', 'completed');
            })->where('product_id', $product->id)->exists();
        @endphp
        @if($hasPurchased)
            <div class="mt-5">
                <h3>Leave a Review</h3>
                @php $existingReview = $product->reviews()->where('user_id', $user->id)->first(); @endphp
                @if($existingReview)
                    <p>You have already reviewed this product.</p>
                    <form method="POST" action="{{ route('reviews.update', $existingReview) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Rating:</label>
                            <select name="rating" class="form-control" required>
                                <option value="5" {{ $existingReview->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                                <option value="4" {{ $existingReview->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                                <option value="3" {{ $existingReview->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                                <option value="2" {{ $existingReview->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                                <option value="1" {{ $existingReview->rating == 1 ? 'selected' : '' }}>1 Star</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Comment:</label>
                            <textarea name="comment" class="form-control" rows="3">{{ $existingReview->comment }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label>Rating:</label>
                            <select name="rating" class="form-control" required>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Comment:</label>
                            <textarea name="comment" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                @endif
            </div>
        @endif
    @endauth

    <div class="mt-5">
        <h3>Customer Reviews</h3>
        @if($product->reviews->count() > 0)
            @foreach($product->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $review->user->name }} <small class="text-muted">{{ $review->rating }} Stars</small></h5>
                        <p class="card-text">{{ $review->comment ?? 'No comment.' }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>No reviews yet.</p>
        @endif
    </div>
</div>
@endsection