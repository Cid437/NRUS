@extends('layouts.app')

@section('title', 'New Product')

@section('content')
<div class="container mt-5">
    <h1>Create Product</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Slug:</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Price:</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Stock:</label>
            <input type="number" name="stock" value="{{ old('stock') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Category:</label>
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Brand:</label>
            <select name="brand_id" class="form-control">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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