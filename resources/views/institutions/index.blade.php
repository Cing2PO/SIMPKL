<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institutions Management - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Institutions Management</h1>
                <p class="text-gray-600 mt-2">Manage all institutions/placements locations</p>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Address</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Phone</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($institutions as $institution)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $institution->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->address }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->contact_email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->contact_phone }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($institution->status === 'active') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($institution->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-700">
                                    No institutions found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-8 grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Total Institutions</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $institutions->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Active</div>
                    <div class="text-2xl font-bold text-green-600">{{ $institutions->where('status', 'active')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
