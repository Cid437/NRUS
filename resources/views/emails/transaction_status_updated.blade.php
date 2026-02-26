<!DOCTYPE html>
<html>
<body>
<h1>Order status updated</h1>
<p>Hi {{ $transaction->user->name }},</p>
<p>Your order #{{ $transaction->id }} status is now: {{ $transaction->status }}.</p>
</body>
</html>