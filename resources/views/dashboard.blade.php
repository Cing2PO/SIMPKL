<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMPKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-4xl font-bold text-gray-900">SIMPKL Dashboard</h1>
                <p class="text-gray-600 mt-2">Student Internship Management System</p>
            </div>

            <!-- Quick Links Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Users Card -->
                <a href="{{ route('users.index') }}" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 hover:border-l-4 hover:border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Users</h3>
                            <p class="text-gray-600 text-sm mt-1">Manage system users</p>
                        </div>
                        <div class="text-3xl text-blue-500">👥</div>
                    </div>
                </a>

                <!-- Institutions Card -->
                <a href="{{ route('institutions.index') }}" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 hover:border-l-4 hover:border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Institutions</h3>
                            <p class="text-gray-600 text-sm mt-1">Placement locations</p>
                        </div>
                        <div class="text-3xl text-green-500">🏢</div>
                    </div>
                </a>

                <!-- Placements Card -->
                <a href="{{ route('placements.index') }}" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 hover:border-l-4 hover:border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Placements</h3>
                            <p class="text-gray-600 text-sm mt-1">Student placements</p>
                        </div>
                        <div class="text-3xl text-purple-500">📍</div>
                    </div>
                </a>

                <!-- Attendances Card -->
                <a href="{{ route('attendances.index') }}" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 hover:border-l-4 hover:border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Attendances</h3>
                            <p class="text-gray-600 text-sm mt-1">Attendance records</p>
                        </div>
                        <div class="text-3xl text-yellow-500">📋</div>
                    </div>
                </a>

                <!-- Logbooks Card -->
                <a href="{{ route('logbooks.index') }}" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 hover:border-l-4 hover:border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Logbooks</h3>
                            <p class="text-gray-600 text-sm mt-1">Daily activities</p>
                        </div>
                        <div class="text-3xl text-red-500">📖</div>
                    </div>
                </a>

                <!-- Evaluations Card -->
                <a href="{{ route('evaluations.index') }}" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 hover:border-l-4 hover:border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Evaluations</h3>
                            <p class="text-gray-600 text-sm mt-1">Performance evaluations</p>
                        </div>
                        <div class="text-3xl text-indigo-500">⭐</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
