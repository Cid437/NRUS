@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
<div class="container mt-5">
    <h1>All Reviews</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->product->name }}</td>
                        <td>{{ $r->rating }}</td>
                        <td>{{ $r->comment }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}" onsubmit="return confirm('Delete review?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $reviews->links() }}
</div>
@endsection