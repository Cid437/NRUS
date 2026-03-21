@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container mt-5">
    <h1>Transactions</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table id="transactions-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
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
    $('#transactions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.transactions.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user_name' },
            { data: 'total', name: 'total' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush