<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h1>Admin Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}</p>

<hr>

<a href="{{ route('admin.users.index') }}">Manage Users</a>
<a href="{{ route('admin.products.index') }}">Manage Products</a>
<a href="{{ route('admin.reviews.index') }}">Manage Reviews</a>
<a href="{{ route('admin.transactions.index') }}">Manage Transactions</a>

</body>
</html>