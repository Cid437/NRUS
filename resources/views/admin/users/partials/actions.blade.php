<a class="btn btn-sm btn-outline-theme" href="{{ route('admin.users.edit', $user) }}">Edit</a>
<form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete?')" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
</form>