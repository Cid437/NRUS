<!DOCTYPE html>
<html>
<head><title>Edit Profile</title></head>
<body>
<h1>Edit Profile</h1>
@if(session('status'))<p style="color:green">{{ session('status') }}</p>@endif
@if($errors->any())<div style="color:red"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    <label>Name:</label><input type="text" name="name" value="{{ old('name',$user->name) }}"><br>
    <label>Email:</label><input type="email" name="email" value="{{ old('email',$user->email) }}"><br>
    <label>Photo:</label><input type="file" name="photo" accept="image/*"><br>
    @if($user->photo)
        <img src="{{ asset('storage/'.$user->photo) }}" width="100"><br>
    @endif
    <button type="submit">Save</button>
</form>
</body>
</html>