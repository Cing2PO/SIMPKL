<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluations Management - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Evaluations Management</h1>
                <p class="text-gray-600 mt-2">Track student placement evaluations</p>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Student</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Institution</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Final Score</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Grade</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Feedback</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($evaluations as $evaluation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $evaluation->placement?->user?->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->placement?->institution?->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                        @if($evaluation->final_score >= 85) bg-green-100 text-green-800
                                        @elseif($evaluation->final_score >= 70) bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $evaluation->final_score }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    @if($evaluation->final_score >= 85)
                                        <span class="text-green-600">A</span>
                                    @elseif($evaluation->final_score >= 70)
                                        <span class="text-blue-600">B</span>
                                    @else
                                        <span class="text-red-600">C</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $evaluation->feedback }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-700">
                                    No evaluations found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="mt-8 grid grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Total Evaluations</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $evaluations->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Average Score</div>
                    <div class="text-2xl font-bold text-gray-900">
                        {{ number_format($evaluations->avg('final_score'), 2) }}
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Highest Score</div>
                    <div class="text-2xl font-bold text-green-600">
                        {{ $evaluations->max('final_score') ?? '-' }}
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-gray-600 text-sm">Lowest Score</div>
                    <div class="text-2xl font-bold text-red-600">
                        {{ $evaluations->min('final_score') ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
