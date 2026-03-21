@extends('layouts.app') {{-- Must be the very first line --}}

@section('title', 'Login') {{-- Optional: set the page title --}}

@push('styles') {{-- Optional page-specific CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
@endpush

@section('content')
<div class="container mt-5">
    <h1>Login</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input">
            <label class="form-check-label">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p class="mt-3"><a href="{{ route('register') }}">Register</a></p>
</div>
@endsection