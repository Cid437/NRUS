<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,user,guest',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:6', // password is optional
        ]);

        // Only update password if admin entered one
         if ($request->filled('password')) {
        $user->password = $request->password; // Laravel automatically hashes if $casts['password'] = 'hashed'
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('status','User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status','User deleted');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,user,guest',
            'is_active' => 'boolean',
            'password' => 'required|string|min:6|confirmed', // password is required and must be confirmed
        ]);

        $data['password'] = Hash::make($data['password']); // hash the password

        User::create($data);
        return redirect()->route('admin.users.index')->with('status','User created');
    }
}
