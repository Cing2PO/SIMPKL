@extends('layouts.app')

@section('title', $title . ' - SIMPKL')
@section('page_title', $title)
@section('page_subtitle', 'Update user information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Users</a>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <p class="font-medium">Please fix the following errors:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="divide-y divide-gray-200">
                @csrf
                <div class="px-6 py-8 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                        <input type="text" value="{{ $user->id }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-600 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-gray-500 text-xs">(leave blank to keep current)</span></label>
                        <input type="password" id="password" name="password" class="w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Enter new password">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                        <select id="role" name="role" class="w-full px-3 py-2 border @error('role') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select a role</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                            <option value="guru" @selected(old('role', $user->role) === 'guru')>Guru</option>
                            <option value="murid" @selected(old('role', $user->role) === 'murid')>Murid</option>
                        </select>
                        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="institution_id" class="block text-sm font-medium text-gray-700 mb-2">Institution <span class="text-red-500">*</span></label>
                        <select id="institution_id" name="institution_id" class="w-full px-3 py-2 border @error('institution_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select an institution</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" @selected(old('institution_id', $user->institution_id) == $institution->id)>{{ $institution->name }}</option>
                            @endforeach
                        </select>
                        @error('institution_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50">
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Update User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
