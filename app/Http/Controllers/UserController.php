<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth()->user();
        $search = $request->input('search');
        $role = $request->input('role');

        $query = User::with('institution');

        // Tenant scope manual
        if ($admin->role !== 'superadmin') {
            $query->where('institution_id', $admin->institution_id);
        }

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->paginate(10)->appends($request->query());

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Route model binding sudah enforce scope (404 jika bukan tenant-nya)
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
        // Cegah hapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}