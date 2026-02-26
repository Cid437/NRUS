<!DOCTYPE html>
<html>
<head><title>Reviews</title></head>
<body>
<h1>All Reviews</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<table border="1">
    <tr><th>ID</th><th>User</th><th>Product</th><th>Rating</th><th>Comment</th><th>Actions</th></tr>
    @foreach($reviews as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->user->name }}</td>
            <td>{{ $r->product->name }}</td>
            <td>{{ $r->rating }}</td>
            <td>{{ $r->comment }}</td>
            <td>
                <form method="POST" action="{{ route('admin.reviews.destroy',$r) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete review?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{ $reviews->links() }}
</body>
</html>