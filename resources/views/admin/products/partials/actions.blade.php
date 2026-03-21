<a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm btn-secondary">Edit</a>
<form method="POST" action="{{ route('admin.products.destroy',$product) }}" class="d-inline" onsubmit="return confirm('Delete?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>