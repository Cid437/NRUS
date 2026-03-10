@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Welcome {{ auth()->user()->name ?? 'Guest' }}</h1>
    <p>This is your home page.</p>
@endsection