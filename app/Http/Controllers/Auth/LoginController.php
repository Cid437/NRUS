<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            $intended = $request->session()->get('url.intended');

            if ($user && ! $user->hasVerifiedEmail()) {
                // If the intended URL is the email verification link, allow user to continue.
                if ($intended && str_contains($intended, '/email/verify')) {
                    return redirect()->intended('/');
                }

                // For manual login, keep user logged in and show verification notice.
                return redirect()->route('verification.notice')->with('status', 'Please verify your email first.');
            }

            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
