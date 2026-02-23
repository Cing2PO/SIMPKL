<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Users Management</h1>
                <p class="text-gray-600 mt-2">Manage all users in the system</p>
            </div>

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
                                        @elseif($user->role === 'mentor') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->institution?->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-700">
                                    No users found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-8 grid grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Total Users</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $users->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Admins</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'admin')->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Mentors</div>
                    <div class="text-2xl font-bold text-green-600">{{ $users->where('role', 'mentor')->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Students</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $users->where('role', 'student')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
