@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-5">
    <h1>Edit Product</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update',$product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" value="{{ old('name',$product->name) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Slug:</label>
            <input type="text" name="slug" value="{{ old('slug',$product->slug) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Price:</label>
            <input type="number" step="0.01" name="price" value="{{ old('price',$product->price) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Stock:</label>
            <input type="number" name="stock" value="{{ old('stock',$product->stock) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Category ID:</label>
            <input type="text" name="category_id" value="{{ old('category_id',$product->category_id) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Brand ID:</label>
            <input type="text" name="brand_id" value="{{ old('brand_id',$product->brand_id) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Primary Photo:</label>
            <input type="file" name="photo" accept="image/*" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">More Photos:</label>
            <input type="file" name="photos[]" multiple accept="image/*" class="form-control">
        </div>
        <button type="submit" class="btn btn-theme">Save</button>
    </form>
</div>
@endsection