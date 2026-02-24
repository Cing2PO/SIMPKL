<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Login Form
    public function loginForm()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai dengan catatan kami.',
        ])->onlyInput('email');
    }

    // Register Form
    public function registerForm()
    {
        return view('auth.register');
    }

    // Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Pendaftaran berhasil!');
    }

    // Profile
    public function profile()
    {
        return view('auth.profile');
    }

    // Edit Profile Form
    public function editProfile()
    {
        return view('auth.editProfile');
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('auth.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    // Change Password Form
    public function changePassword()
    {
        return view('auth.changePassword');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('auth.profile')->with('success', 'Kata sandi berhasil diubah!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
