<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $admin = auth()->user();

        if ($admin->role === 'superadmin') {
            $users = User::with('institution')->paginate(10);
        } else {
            $users = User::with('institution')
                ->where('institution_id', $admin->institution_id)->paginate(10);
        }

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorizeInstitution($user);
        return view('users.view', compact('user'));
    }

    public function create()
    {
        $title = "Add new user";
        $admin = auth()->user();
        if ($admin->role === 'superadmin') {
            $institutions = Institution::all();
        } else {
            $institutions = Institution::where('id', $admin->institution_id)->get();
        }
        return view('users.create', compact('title', 'institutions'));
    }

    public function store(Request $request)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:superadmin,admin,murid,guru',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        // Paksa institution_id = institution admin (kecuali superadmin)
        if ($admin->role !== 'superadmin') {
            $data['institution_id'] = $admin->institution_id;
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorizeInstitution($user);
        $title = "Edit user";
        $admin = auth()->user();
        if ($admin->role === 'superadmin') {
            $institutions = Institution::all();
        } else {
            $institutions = Institution::where('id', $admin->institution_id)->get();
        }
        return view('users.edit', compact('user', 'title', 'institutions'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeInstitution($user);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:superadmin,admin,murid,guru',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        // Paksa institution_id = institution admin (kecuali superadmin)
        if (auth()->user()->role !== 'superadmin') {
            $data['institution_id'] = auth()->user()->institution_id;
        }

        // ✅ Hash password jika diisi, buang jika kosong
        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function delete(User $user)
    {
        $this->authorizeInstitution($user);

        // ✅ Cegah hapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Pastikan user yang diakses berasal dari institusi yang sama
     */
    private function authorizeInstitution(User $user)
    {
        // Superadmin bisa akses semua
        if (auth()->user()->role === 'superadmin') {
            return;
        }

        if ($user->institution_id !== auth()->user()->institution_id) {
            abort(403, 'Anda tidak memiliki akses ke user ini.');
        }
    }
}