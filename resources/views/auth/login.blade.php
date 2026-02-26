<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}"><br>
    <label>Password:</label><br>
    <input type="password" name="password"><br>
    <label><input type="checkbox" name="remember"> Remember me</label><br>
    <button type="submit">Login</button>
</form>
<p><a href="{{ route('register') }}">Register</a></p>
</body>
</html>