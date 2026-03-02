<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
@include('components.navbar')
<h1>Register</h1>
@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
    <label>Name:</label><br>
    <input type="text" name="name" value="{{ old('name') }}"><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}"><br>
    <label>Password:</label><br>
    <input type="password" name="password"><br>
    <label>Confirm Password:</label><br>
    <input type="password" name="password_confirmation"><br>
    <label>Photo:</label><br>
    <input type="file" name="photo" accept="image/*"><br>
    <button type="submit">Register</button>
</form>
<p><a href="{{ route('login') }}">Already have account? Login</a></p>
</body>
</html>