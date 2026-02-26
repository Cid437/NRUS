<!DOCTYPE html>
<html>
<head><title>Receipt</title></head>
<body>
<h1>Receipt #{{ $transaction->id }}</h1>
<p>Customer: {{ $transaction->user->name }} ({{ $transaction->user->email }})</p>
<p>Total: {{ $transaction->total }}</p>
<table border="1" width="100%">
    <tr><th>Product</th><th>Qty</th><th>Unit</th><th>Subtotal</th></tr>
    @foreach($transaction->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_price }}</td>
            <td>{{ $item->quantity * $item->unit_price }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>