@extends('layouts.app')

@section('title', 'Dashboard - SIMPKL')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')
    <!-- Welcome Banner -->
    <div class="mb-8">
        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-10 -mb-10"></div>
            <div class="relative">
                <h1 class="text-3xl font-bold mb-2">Selamat Datang di SIMPKL</h1>
                <p class="text-blue-100 text-lg">Sistem Manajemen Internship & Placement</p>
                <p class="text-blue-200 text-sm mt-2">Kelola data siswa, institusi, penempatan, kehadiran, logbook, dan
                    evaluasi dengan mudah.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Institutions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Institusi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['institutions'] }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Placements -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Penempatan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['placements'] }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ $stats['active_placements'] }} aktif</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Attendances -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Kehadiran</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['attendances'] }}</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <!-- Logbooks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Logbook</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['logbooks'] }}</p>
                </div>
                <div class="bg-red-50 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Evaluations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Evaluasi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['evaluations'] }}</p>
                </div>
                <div class="bg-indigo-50 p-3 rounded-xl">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Section -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Users -->
            <a href="{{ route('users.index') }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition p-6 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">Users</h4>
                        <p class="text-gray-500 text-sm mt-1">Kelola pengguna sistem</p>
                        <span class="inline-flex items-center mt-3 text-blue-600 text-sm font-medium">Buka →</span>
                    </div>
                    <div class="text-4xl opacity-20 group-hover:opacity-40 transition">👥</div>
                </div>
            </a>

            <!-- Institutions -->
            <a href="{{ route('institutions.index') }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition p-6 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition">Institusi</h4>
                        <p class="text-gray-500 text-sm mt-1">Lokasi penempatan siswa</p>
                        <span class="inline-flex items-center mt-3 text-green-600 text-sm font-medium">Buka →</span>
                    </div>
                    <div class="text-4xl opacity-20 group-hover:opacity-40 transition">🏢</div>
                </div>
            </a>

            <!-- Placements -->
            <a href="{{ route('placements.index') }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition p-6 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition">Penempatan
                        </h4>
                        <p class="text-gray-500 text-sm mt-1">Data penempatan siswa</p>
                        <span class="inline-flex items-center mt-3 text-purple-600 text-sm font-medium">Buka →</span>
                    </div>
                    <div class="text-4xl opacity-20 group-hover:opacity-40 transition">📍</div>
                </div>
            </a>

            <!-- Attendances -->
            <a href="{{ route('attendances.index') }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-yellow-200 transition p-6 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-yellow-600 transition">Kehadiran
                        </h4>
                        <p class="text-gray-500 text-sm mt-1">Catatan kehadiran siswa</p>
                        <span class="inline-flex items-center mt-3 text-yellow-600 text-sm font-medium">Buka →</span>
                    </div>
                    <div class="text-4xl opacity-20 group-hover:opacity-40 transition">📋</div>
                </div>
            </a>

            <!-- Logbooks -->
            <a href="{{ route('logbooks.index') }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-red-200 transition p-6 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-red-600 transition">Logbook</h4>
                        <p class="text-gray-500 text-sm mt-1">Aktivitas harian siswa</p>
                        <span class="inline-flex items-center mt-3 text-red-600 text-sm font-medium">Buka →</span>
                    </div>
                    <div class="text-4xl opacity-20 group-hover:opacity-40 transition">📖</div>
                </div>
            </a>

            <!-- Evaluations -->
            <a href="{{ route('evaluations.index') }}"
                class="block bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-200 transition p-6 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition">Evaluasi</h4>
                        <p class="text-gray-500 text-sm mt-1">Penilaian kinerja siswa</p>
                        <span class="inline-flex items-center mt-3 text-indigo-600 text-sm font-medium">Buka →</span>
                    </div>
                    <div class="text-4xl opacity-20 group-hover:opacity-40 transition">⭐</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-8 p-6 bg-blue-50 border border-blue-100 rounded-xl">
        <div class="flex items-start gap-3">
            <span class="text-xl">ℹ️</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Informasi</h3>
                <p class="text-sm text-gray-600">
                    SIMPKL adalah sistem manajemen terintegrasi untuk mengelola program internship dan placement siswa.
                    Gunakan menu di sebelah kiri atau kartu akses cepat di atas untuk navigasi ke berbagai modul.
                </p>
            </div>
        </div>
    </div>
@endsection