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

    <form method="GET" class="mb-3 d-flex gap-2">
        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}" class="form-control">
        <button type="submit" class="btn btn-primary">Go</button>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Photo</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>
                        @if($p->photos->first())
                            <img src="{{ asset('storage/'.$p->photos->first()->file) }}" width="50">
                        @endif
                    </td>
                    <td>{{ $p->price }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy',$p) }}" class="d-inline" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links('pagination::bootstrap-5') }}

    <h3>Import CSV</h3>
    <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".csv" class="form-control mb-2">
        <button type="submit" class="btn btn-theme">Upload</button>
    </form>
</div>
@endsection