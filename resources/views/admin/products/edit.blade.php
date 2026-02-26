<!DOCTYPE html>
<html>
<head><title>Edit Product</title></head>
<body>
<h1>Edit Product</h1>
@if($errors->any())<div style="color:red"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.products.update',$product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>Name:</label><input type="text" name="name" value="{{ old('name',$product->name) }}"><br>
    <label>Slug:</label><input type="text" name="slug" value="{{ old('slug',$product->slug) }}"><br>
    <label>Price:</label><input type="number" step="0.01" name="price" value="{{ old('price',$product->price) }}"><br>
    <label>Stock:</label><input type="number" name="stock" value="{{ old('stock',$product->stock) }}"><br>
    <label>Category ID:</label><input type="text" name="category_id" value="{{ old('category_id',$product->category_id) }}"><br>
    <label>Brand ID:</label><input type="text" name="brand_id" value="{{ old('brand_id',$product->brand_id) }}"><br>
    <label>Primary photo:</label><input type="file" name="photo" accept="image/*"><br>
    <label>More photos:</label><input type="file" name="photos[]" multiple accept="image/*"><br>
    <button type="submit">Save</button>
</form>
</body>
</html>