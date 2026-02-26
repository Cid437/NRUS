<!DOCTYPE html>
<html>
<body>
<h1>Thank you for your order!</h1>
<p>Hi {{ $transaction->user->name }},</p>
<p>Your order #{{ $transaction->id }} has been completed. Total: {{ $transaction->total }}</p>
<p>See attached receipt.</p>
</body>
</html>