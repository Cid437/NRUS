@extends('layouts.app')

@section('title', 'Trashed Products')

@section('content')
<div class="container mt-5">
    <h1>Trashed Products</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->deleted_at }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.products.restore',$p->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-theme">Restore</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection