<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $transaction->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; }
        .receipt-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 2px 0; }
        .customer { margin-bottom: 20px; }
        .customer p { margin: 4px 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .total-row td { border: none; }
        .total-row .label { text-align: right; font-weight: bold; padding-right: 10px; }
        .total-row .value { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
<div class="receipt-container">
    <div class="header">
        <h1>Shop Receipt</h1>
        <p>Order #{{ $transaction->id }}</p>
        <p>{{ $transaction->created_at->format('F j, Y H:i') }}</p>
    </div>

    <div class="customer">
        <p><strong>Customer:</strong> {{ optional($transaction->user)->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ optional($transaction->user)->email ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
                <tr>
                    <td>{{ optional($item->product)->name ?? 'Product removed' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ format_currency($item->unit_price) }}</td>
                    <td>{{ format_currency($item->quantity * $item->unit_price) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="label">Total</td>
                <td class="value">{{ format_currency($transaction->total) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>