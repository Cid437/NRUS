@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Edit Review</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reviews.update', $review) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="product" class="form-label">Product</label>
                            <input type="text" class="form-control" id="product" value="{{ $review->product->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select id="rating" name="rating" class="form-control" required>
                                <option value="">-- Select Rating --</option>
                                <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>⭐ 5 Stars</option>
                                <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>⭐ 4 Stars</option>
                                <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>⭐ 3 Stars</option>
                                <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>⭐ 2 Stars</option>
                                <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>⭐ 1 Star</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Share your thoughts about this product...">{{ old('comment', $review->comment) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection