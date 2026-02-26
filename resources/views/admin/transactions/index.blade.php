<!DOCTYPE html>
<html>
<head><title>Transactions</title></head>
<body>
<h1>Transactions</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<table border="1">
    <tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Actions</th></tr>
    @foreach($transactions as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->user->name }}</td>
            <td>{{ $t->total }}</td>
            <td>{{ $t->status }}</td>
            <td>
                <form method="POST" action="{{ route('admin.transactions.updateStatus',$t) }}">
                    @csrf
                    <input type="text" name="status" value="{{ $t->status }}">
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{ $transactions->links() }}
</body>
</html>