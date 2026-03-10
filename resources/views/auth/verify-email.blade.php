@extends('layouts.app') {{-- Must be at the top --}}

@section('title', 'Verify Email') {{-- Page title --}}

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
@endpush

@section('content')
<div class="container mt-5">
    <h1>Verify Your Email Address</h1>

    {{-- Success message if email was resent --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <p>Before proceeding, please check your email for a verification link.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-theme">Resend Verification Email</button>
    </form>
</div>
@endsection