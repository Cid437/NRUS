<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
@include('components.navbar')
<h1>Admin Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}</p>

<hr>

</body>
</html>