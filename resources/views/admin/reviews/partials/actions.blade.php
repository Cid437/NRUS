<form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete review?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
</form>