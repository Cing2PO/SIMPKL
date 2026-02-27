@extends('layouts.app')

@section('title', 'Users Management - SIMPKL')
@section('page_title', 'Users Management')
@section('page_subtitle', 'Manage all users in the system')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Users</h1>
            </div>
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                + Add New User
            </a>
        </div>

        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('users.index') }}"
            class="mb-6 flex flex-wrap gap-3 items-center bg-white rounded-lg shadow p-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                class="flex-1 min-w-[200px] border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="role"
                class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Role</option>
                <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="guru" {{ request('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="murid" {{ request('role') === 'murid' ? 'selected' : '' }}>Murid</option>
            </select>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">Cari</button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">Reset</a>
            @endif
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Institution</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                            @if($user->role === 'superadmin') bg-red-100 text-red-800
                                                            @elseif($user->role === 'admin') bg-blue-100 text-blue-800
                                                            @elseif($user->role === 'guru') bg-green-100 text-green-800
                                                            @else bg-yellow-100 text-yellow-800
                                                            @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->institution?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                    <form method="POST" action="{{ route('users.delete', $user->id) }}" class="inline"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-700">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>

        <!-- Summary -->
        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Users</div>
                <div class="text-2xl font-bold text-gray-900">{{ $users->total() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Admin</div>
                <div class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'admin')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Guru</div>
                <div class="text-2xl font-bold text-green-600">{{ $users->where('role', 'guru')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Murid</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $users->where('role', 'murid')->count() }}</div>
            </div>
        </div>
    </div>
@endsection