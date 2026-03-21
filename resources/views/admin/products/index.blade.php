@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container mt-5">
    <h1>Products</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-theme">Create New</a>
        <a href="{{ route('admin.products.trashed') }}" class="btn btn-secondary">View Trashed</a>
    </div>

    <table id="products-table" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Photo</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <h3>Import Excel</h3>
    <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx,.xls" class="form-control mb-2">
        <button type="submit" class="btn btn-theme">Upload</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.products.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'category_name', name: 'category_name' },
            { data: 'brand_name', name: 'brand_name' },
            { data: 'primary_photo', name: 'primary_photo', orderable: false },
            { data: 'price', name: 'price' },
            { data: 'stock', name: 'stock' },
            { data: 'is_active', name: 'is_active' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush