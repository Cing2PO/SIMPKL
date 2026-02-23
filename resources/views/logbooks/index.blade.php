<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbooks Management - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Logbooks Management</h1>
                <p class="text-gray-600 mt-2">Manage daily activity logbooks</p>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Student</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Institution</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Activity</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($logbooks as $logbook)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $logbook->placement?->user?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->placement?->institution?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->date?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->activity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $logbook->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-700">
                                    No logbooks found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Total Logbook Entries</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $logbooks->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
