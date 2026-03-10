@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}</p>
    <hr>
</div>
@endsection