<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
</head>
<body>
<h1>Verify Your Email Address</h1>
@if (session('status'))
    <div style="color:green;">
        {{ session('status') }}
    </div>
@endif
<p>Before proceeding, please check your email for a verification link.</p>
<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Resend Verification Email</button>
</form>
</body>
</html>