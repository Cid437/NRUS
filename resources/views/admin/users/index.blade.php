<!DOCTYPE html>
<html>
<head><title>Users</title></head>
<body>
<h1>Users</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Active</th><th>Actions</th></tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->is_active ? 'Yes':'No' }}</td>
            <td>
                <a href="{{ route('admin.users.edit',$user) }}">Edit</a>
                <form method="POST" action="{{ route('admin.users.destroy',$user) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{ $users->links() }}
</body>
</html>