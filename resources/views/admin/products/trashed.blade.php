<!DOCTYPE html>
<html>
<head><title>Trashed Products</title></head>
<body>
<h1>Trashed Products</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Deleted At</th><th>Actions</th></tr>
    @foreach($products as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->deleted_at }}</td>
            <td>
                <form method="POST" action="{{ route('admin.products.restore',$p->id) }}">
                    @csrf
                    <button type="submit">Restore</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{ $products->links() }}
</body>
</html>