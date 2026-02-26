<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email,'.$user->id,
            'photo'=>'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('user_photos','public');
            $data['photo'] = $path;
        }
        /** @var \App\Models\User $user */
        $user->update($data);
        return back()->with('status','Profile updated');
    }
}
