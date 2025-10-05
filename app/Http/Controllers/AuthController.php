<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return Redirect::route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|min:2|max:20|unique:users,username',
            'password' => 'required|string|confirmed',
        ]);

        // Ensure the users.email NOT NULL + unique constraint is satisfied for SQLite.
        // We generate a placeholder unique email based on the username to avoid altering existing migrations.
        $user = User::create([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['username'].'@example.invalid',
            'password' => Hash::make($data['password']),
        ]);

        return Redirect::route('login')->with('success', 'Account created successfully! Please log in.');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return Redirect::route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // attempt login using username (mapped to username column)
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return Redirect::intended(route('home'))->with('success', 'Welcome back!');
        }

        return back()->withErrors(['username' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::route('login')->with('info', 'You have been logged out.');
    }
}
