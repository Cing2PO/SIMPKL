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
        $users = User::with('institution')->get();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.view', compact('user'));
    }

    public function create()
    {
        $title = "Add new user";
        $institutions = Institution::all();
        return view('users.create', compact('title', 'institutions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,murid,guru',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $title = "Edit user";
        $institutions = Institution::all();
        return view('users.edit', compact('user', 'title', 'institutions'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,murid,guru',
            'institution_id' => 'required|exists:institutions,id',
        ]);

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
        // ✅ Cegah hapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}