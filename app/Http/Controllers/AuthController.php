<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institution;
use App\Models\plans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

    // Register Tenant Form
    public function registerTenantForm()
    {
        $plans = plans::orderBy('price')->get();
        return view('auth.register-tenant', compact('plans'));
    }

    // Register Tenant
    public function registerTenant(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'contact_email' => ['required', 'email', 'unique:institutions,contact_email'],
            'contact_phone' => ['required', 'string', 'max:20', 'unique:institutions,contact_phone'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'plan_id' => ['required', 'exists:plans,id'],
        ], [
            'institution_name.required' => 'Nama institusi wajib diisi.',
            'address.required' => 'Alamat institusi wajib diisi.',
            'contact_email.required' => 'Email institusi wajib diisi.',
            'contact_email.unique' => 'Email institusi sudah terdaftar.',
            'contact_phone.required' => 'Nomor telepon wajib diisi.',
            'contact_phone.unique' => 'Nomor telepon sudah terdaftar.',
            'admin_name.required' => 'Nama admin wajib diisi.',
            'admin_email.required' => 'Email admin wajib diisi.',
            'admin_email.unique' => 'Email admin sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'plan_id.required' => 'Silakan pilih paket langganan.',
            'plan_id.exists' => 'Paket yang dipilih tidak valid.',
        ]);

        DB::transaction(function () use ($validated) {
            // Create institution
            $institution = Institution::create([
                'name' => $validated['institution_name'],
                'address' => $validated['address'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'],
                'plan_id' => $validated['plan_id'],
                'status' => 'active',
            ]);

            // Create admin user
            $user = User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
                'institution_id' => $institution->id,
            ]);

            Auth::login($user);
        });

        return redirect('/dashboard')->with('success', 'Institusi berhasil didaftarkan! Selamat datang di SIMPKL.');
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
