<!DOCTYPE html>
<html>
<head><title>Edit User</title></head>
<body>
@include('components.navbar')
<h1>Edit User</h1>
@if($errors->any())<div style="color:red"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.users.update',$user) }}">
    @csrf
    @method('PUT')
    <label>Name:</label><input type="text" name="name" value="{{ old('name',$user->name) }}"><br>
    <label>Email:</label><input type="email" name="email" value="{{ old('email',$user->email) }}"><br>
    <label>Password (leave blank to keep current):</label>
    <input type="password" name="password"><br>
    <select name="role">
        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
        <option value="user" {{ $user->role=='user'?'selected':'' }}>User</option>
        <option value="guest" {{ $user->role=='guest'?'selected':'' }}>Guest</option>
    </select><br>
    <label>Active:</label><input type="checkbox" name="is_active" value="1" {{ $user->is_active?'checked':'' }}><br>
    <button type="submit">Save</button>
</form>
</body>
</html>