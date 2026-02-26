<!DOCTYPE html>
<html>
<head><title>Shop</title></head>
<body>
<h1>Products</h1>
<form method="GET">
    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
    <select name="method">
        <option value="">LIKE</option>
        <option value="model" {{ request('method')=='model'?'selected':'' }}>Model Scope</option>
        <option value="scout" {{ request('method')=='scout'?'selected':'' }}>Scout</option>
    </select>
    <input type="number" name="min_price" placeholder="Min price" value="{{ request('min_price') }}">
    <input type="number" name="max_price" placeholder="Max price" value="{{ request('max_price') }}">
    <input type="text" name="category_id" placeholder="Category ID" value="{{ request('category_id') }}">
    <input type="text" name="brand_id" placeholder="Brand ID" value="{{ request('brand_id') }}">
    <button type="submit">Filter</button>
</form>
<ul>
@foreach($products as $p)
    <li>{{ $p->name }} - {{ $p->price }}</li>
@endforeach
</ul>
{{ $products->links() }}
</body>
</html>