<!DOCTYPE html>
<html>
<head><title>Products</title></head>
<body>
<h1>Products</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<a href="{{ route('admin.products.create') }}">Create new</a> |
<a href="{{ route('admin.products.trashed') }}">View trashed</a>
<form method="GET" style="margin-top:10px;">
    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
    <button type="submit">Go</button>
</form>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Photo</th><th>Price</th><th>Actions</th></tr>
    @foreach($products as $p)
    <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->name }}</td>
        <td>@if($p->photos->first())<img src="{{ asset('storage/'.$p->photos->first()->file) }}" width="50">@endif</td>
        <td>{{ $p->price }}</td>
        <td>
            <a href="{{ route('admin.products.edit',$p) }}">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy',$p) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
{{ $products->links() }}

<h3>Import CSV</h3>
<form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".csv">
    <button type="submit">Upload</button>
</form>
</body>
</html>