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
            <label class="form-label">Existing Photos:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($product->photos as $photo)
                    <div class="border rounded p-1" style="width:110px; height:110px; overflow:hidden;">
                        <img src="{{ asset('storage/'.$photo->file) }}" alt="" class="img-fluid" style="max-height:100%; width:100%; object-fit:cover;">
                        @if($photo->is_primary)
                            <div class="text-success small">Primary</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

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
            <label class="form-label">Category:</label>
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Brand:</label>
            <select name="brand_id" class="form-control">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
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