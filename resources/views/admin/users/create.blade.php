@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container mt-5">
    <h1>Create User</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input class="form-control" type="password" name="password" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password:</label>
            <input class="form-control" type="password" name="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role:</label>
            <select class="form-select" name="role" required>
                <option value="">Select Role</option>
                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role')=='user' ? 'selected' : '' }}>User</option>
                <option value="guest" {{ old('role')=='guest' ? 'selected' : '' }}>Guest</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
            <label class="form-check-label">Active</label>
        </div>

        <button class="btn btn-theme" type="submit">Create User</button>
        <a class="btn btn-outline-secondary ms-2" href="{{ route('admin.users.index') }}">Cancel</a>
    </form>
</div>
@endsection
