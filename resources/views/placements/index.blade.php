<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placements Management - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Placements Management</h1>
                <p class="text-gray-600 mt-2">Manage student placements at institutions</p>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Student</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Institution</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Mentor</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Start Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">End Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($placements as $placement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $placement->user?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->institution?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->mentor?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->start_date?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->end_date?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($placement->status === 'active') bg-green-100 text-green-800
                                        @elseif($placement->status === 'completed') bg-blue-100 text-blue-800
                                        @elseif($placement->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($placement->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-700">
                                    No placements found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-8 grid grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Total Placements</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $placements->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Active</div>
                    <div class="text-2xl font-bold text-green-600">{{ $placements->where('status', 'active')->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Completed</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $placements->where('status', 'completed')->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Pending</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $placements->where('status', 'pending')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
