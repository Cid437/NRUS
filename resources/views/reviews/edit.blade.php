<!DOCTYPE html>
<html>
<head><title>Edit Review</title></head>
<body>
<h1>Edit Review</h1>
@if($errors->any())<div style="color:red"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('reviews.update',$review) }}">
    @csrf
    @method('PUT')
    <label>Rating:</label><input type="number" name="rating" min="1" max="5" value="{{ old('rating',$review->rating) }}"><br>
    <label>Comment:</label><textarea name="comment">{{ old('comment',$review->comment) }}</textarea><br>
    <button type="submit">Save</button>
</form>
</body>
</html>