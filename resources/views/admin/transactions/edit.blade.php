@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<div class="container mt-5">
    <h1>Edit Transaction #{{ $transaction->id }}</h1>

    <form method="POST" action="{{ route('admin.transactions.update', $transaction) }}">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ $transaction->total }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection