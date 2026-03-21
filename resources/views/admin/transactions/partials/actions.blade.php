<a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-sm btn-primary">Edit</a>

<form method="POST" action="{{ route('admin.transactions.updateStatus', $transaction) }}" class="d-inline">
    @csrf
    <select name="status" class="form-control form-control-sm d-inline" style="width: auto;" required>
        <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    <button class="btn btn-sm btn-theme" type="submit">Update Status</button>
</form>