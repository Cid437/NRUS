<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .receipt { border-collapse: collapse; width: 100%; }
        .receipt th, .receipt td { border: 1px solid #ddd; padding: 8px; }
        .receipt th { background: #f2f2f2; }
        .total-row td { font-weight: bold; }
    </style>
</head>
<body>
<h1>Thank you for your order!</h1>
<p>Hi {{ optional($transaction->user)->name ?? 'Customer' }},</p>
<p>Your order <strong>#{{ $transaction->id }}</strong> is being processed. Total: {{ format_currency($transaction->total) }}</p>

<table class="receipt">
    <thead>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaction->items as $item)
            <tr>
                <td>{{ optional($item->product)->name ?? 'Product removed' }}</td>
                <td>{{ optional(optional($item->product)->category)->name ?? optional($item->product)->category ?? 'N/A' }}</td>
                <td>{{ optional(optional($item->product)->brand)->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ format_currency($item->unit_price) }}</td>
                <td>{{ format_currency($item->quantity * $item->unit_price) }}</td>
            </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="5" style="text-align:right;">Total</td>
            <td>{{ format_currency($transaction->total) }}</td>
        </tr>
    </tbody>
</table>

<p>Attached is the downloadable PDF receipt.</p>
</body>
</html>