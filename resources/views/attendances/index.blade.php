<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendances Management - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Attendances Management</h1>
                <p class="text-gray-600 mt-2">Track student attendance records</p>
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $attendance->placement?->user?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->placement?->institution?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->date?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($attendance->status === 'present') bg-green-100 text-green-800
                                        @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-700">
                                    No attendance records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Total Records</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $attendances->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Present</div>
                    <div class="text-2xl font-bold text-green-600">{{ $attendances->where('status', 'present')->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Absent</div>
                    <div class="text-2xl font-bold text-red-600">{{ $attendances->where('status', 'absent')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
