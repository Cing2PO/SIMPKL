@extends('layouts.app')

@section('title', 'User Details - SIMPKL')
@section('page_title', 'User Details')
@section('page_subtitle', 'View user information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                ← Back to Users
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-8">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                        <div class="text-lg text-gray-900">{{ $user->id }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <div class="text-lg text-gray-900">{{ $user->name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="text-lg text-gray-900">
                            <a href="mailto:{{ $user->email }}"
                                class="text-blue-600 hover:text-blue-800">{{ $user->email }}</a>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($user->role === 'superadmin') bg-red-100 text-red-800
                                @elseif($user->role === 'admin') bg-blue-100 text-blue-800
                                @elseif($user->role === 'guru') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                        <div class="text-lg text-gray-900">{{ $user->institution?->name ?? '-' }}</div>
                    </div>
                    <div class="pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                        <div class="text-sm text-gray-600">{{ $user->created_at?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Updated At</label>
                        <div class="text-sm text-gray-600">{{ $user->updated_at?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('users.edit', $user->id) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Edit</a>
                    <form method="POST" action="{{ route('users.delete', $user->id) }}" class="inline"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection