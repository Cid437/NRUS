@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mt-5">
    <h1>Edit User</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current):</label>
            <input class="form-control" type="password" name="password">
        </div>

        <div class="mb-3">
            <label class="form-label">Role:</label>
            <select class="form-select" name="role">
                <option value="admin" {{ $user->role=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role=='user' ? 'selected' : '' }}>User</option>
                <option value="guest" {{ $user->role=='guest' ? 'selected' : '' }}>Guest</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button class="btn btn-theme" type="submit">Save</button>
        <a class="btn btn-outline-secondary ms-2" href="{{ route('admin.users.index') }}">Cancel</a>
    </form>
</div>
@endsection