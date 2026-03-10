@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container mt-5">
    <h1>Transactions</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->user->name }}</td>
                        <td>{{ $t->total }}</td>
                        <td>{{ $t->status }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.transactions.updateStatus', $t) }}" class="d-flex gap-2">
                                @csrf
                                <input class="form-control form-control-sm" style="width: 120px;" type="text" name="status" value="{{ $t->status }}" required>
                                <button class="btn btn-sm btn-theme" type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection