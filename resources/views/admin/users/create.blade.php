<!DOCTYPE html>
<html>
<head><title>Create User</title></head>
<body>
@include('components.navbar')
<h1>Create User</h1>
@if($errors->any())<div style="color:red"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <label>Name:</label><input type="text" name="name" value="{{ old('name') }}" required><br>
    <label>Email:</label><input type="email" name="email" value="{{ old('email') }}" required><br>
    <label>Password:</label><input type="password" name="password" required><br>
    <label>Confirm Password:</label><input type="password" name="password_confirmation" required><br>
    <label>Role:</label>
    <select name="role" required>
        <option value="">Select Role</option>
        <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
        <option value="user" {{ old('role')=='user'?'selected':'' }}>User</option>
        <option value="guest" {{ old('role')=='guest'?'selected':'' }}>Guest</option>
    </select><br>
    <label>Active:</label><input type="checkbox" name="is_active" value="1" checked><br>
    <button type="submit">Create User</button>
    <a href="{{ route('admin.users.index') }}" style="margin-left: 1rem;">Cancel</a>
</form>
</body>
</html>
