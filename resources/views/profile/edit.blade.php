@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mt-5">
    <h1>Edit Profile</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Photo:</label>
            <input class="form-control" type="file" name="photo" accept="image/*">
        </div>

        @if($user->photo)
            <div class="mb-3">
                <img src="{{ asset('storage/'.$user->photo) }}" width="100" alt="Current profile photo">
            </div>
        @endif

        <button class="btn btn-theme" type="submit">Save</button>
    </form>
</div>
@endsection