<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


   public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
        'status' => 'active',
    ]);

    return back()->with('success', 'Registration successful! Please wait for admin approval.');
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('Admin.Dashboard')
                ->with('success', 'Welcome back, Admin!');
        } elseif ($user->role === 'user') {
            if ($user->status === 'active') {
                return redirect()->route('home')
                    ->with('success', 'Login successful! Welcome back.');
            } else {
                Auth::logout();
                return back()->with('error', 'Your account is inactive. Please wait for admin approval.');
            }
        } else {
            Auth::logout();
            return back()->with('error', 'Invalid user role detected.');
        }
    }

    return back()->with('error', 'The provided credentials do not match our records.');
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');  // Redirects to the home page
}
}
