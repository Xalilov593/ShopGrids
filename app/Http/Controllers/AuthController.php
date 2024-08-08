<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class AuthController extends Controller
{
    public function showLoginForm(Request $request){
        return view('admin.auth.login');
    }
    public function showRegistrationForm()
    {
        $roles=Role::all();
        return view('admin.auth.register', compact('roles'));

    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->hasRole('user')) {
                return redirect()->route('home')->with('success', 'Logged in successfully.');
            } else {
                return redirect()->route('dashboard')->with('success', 'Logged in successfully.');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
