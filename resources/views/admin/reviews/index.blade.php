@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
<div class="container mt-5">
    <h1>All Reviews</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table id="reviews-table" class="table table-bordered table-hover">
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
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.reviews.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user_name' },
            { data: 'product_name', name: 'product_name' },
            { data: 'rating', name: 'rating' },
            { data: 'comment', name: 'comment' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush