<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
<h1>Welcome {{ auth()->user()->name ?? 'Guest' }}</h1>
@if(auth()->check())
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endif

<a href="{{ route('admin.dashboard') }}">Admin?</a>

</body>
</html>