<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPKL')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 150ms;
        }

        .sidebar-link.active {
            background-color: #3b82f6;
            color: #ffffff;
        }

        .sidebar-link:not(.active) {
            color: #374151;
        }

        .sidebar-link:not(.active):hover {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar Navigation -->
        <div class="w-64 bg-white shadow-lg overflow-y-auto fixed h-screen">
            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">S</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-blue-600">SIMPKL</h1>
                        <p class="text-xs text-gray-500 -mt-0.5">Student Internship Management</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-4 7 4M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>

                @auth
                    @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Master</p>

                        <!-- Users (Admin + Superadmin) -->
                        <a href="{{ route('users.index') }}"
                            class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Users
                        </a>

                        @if(Auth::user()->role === 'superadmin')
                            <!-- Institutions (Superadmin only) -->
                            <a href="{{ route('institutions.index') }}"
                                class="sidebar-link {{ request()->routeIs('institutions.*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Institutions
                            </a>
                        @endif
                    @endif
                @endauth

                <p class="px-4 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">PKL</p>

                <!-- Placements -->
                <a href="{{ route('placements.index') }}"
                    class="sidebar-link {{ request()->routeIs('placements.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Placements
                </a>




                <!-- Divider -->
                <div class="my-4 border-t border-gray-200"></div>

                <!-- Profile -->
                <a href="{{ route('auth.profile') }}"
                    class="sidebar-link {{ request()->routeIs('auth.profile', 'auth.editProfile', 'auth.changePassword') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    My Profile
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden ml-64">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-sm border-b border-gray-200 px-8 py-4 sticky top-0 z-40">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">@yield('page_title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500">@yield('page_subtitle', '')</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- User Menu -->
                        @auth
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="text-sm hidden sm:block">
                                    <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'User') }}</p>
                                </div>
                            </div>
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="ml-2 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
                                    Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 overflow-auto">
                <div class="p-8">
                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="bg-gray-800 text-gray-300 border-t border-gray-700 mt-8">
                    <div class="max-w-7xl mx-auto px-8 py-12">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                            <!-- About Section -->
                            <div>
                                <h3 class="text-white font-bold text-lg mb-4">SIMPKL</h3>
                                <p class="text-sm text-gray-400">
                                    Sistem Manajemen Internship & Placement untuk memudahkan pengelolaan program magang
                                    dan penempatan siswa.
                                </p>
                            </div>

                            <!-- Quick Links -->
                            <div>
                                <h4 class="text-white font-semibold mb-4">Modul</h4>
                                <ul class="space-y-2 text-sm">
                                    <li><a href="{{ route('users.index') }}"
                                            class="text-gray-400 hover:text-white transition">Users</a></li>
                                    <li><a href="{{ route('institutions.index') }}"
                                            class="text-gray-400 hover:text-white transition">Institutions</a></li>
                                    <li><a href="{{ route('placements.index') }}"
                                            class="text-gray-400 hover:text-white transition">Placements</a></li>
                                </ul>
                            </div>

                            <!-- More Links -->
                            <div>
                                <h4 class="text-white font-semibold mb-4">Lainnya</h4>
                                <ul class="space-y-2 text-sm">


                                    <li><a href="{{ route('auth.profile') }}"
                                            class="text-gray-400 hover:text-white transition">Profile</a></li>
                                    <li><a href="{{ route('dashboard') }}"
                                            class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                                </ul>
                            </div>

                            <!-- Contact Section -->
                            <div>
                                <h4 class="text-white font-semibold mb-4">Kontak</h4>
                                <ul class="space-y-2 text-sm text-gray-400">
                                    <li>Email: info@simpkl.com</li>
                                    <li>Phone: +62 (0) XXX-XXXX</li>
                                    <li>Address: Jakarta, Indonesia</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-700 pt-8 mt-8">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <p class="text-sm text-gray-400">
                                    &copy; {{ date('Y') }} SIMPKL. All rights reserved. | Sistem Manajemen Internship &
                                    Placement
                                </p>
                                <div class="flex gap-4 mt-4 md:mt-0 text-sm">
                                    <a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a>
                                    <a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a>
                                    <a href="#" class="text-gray-400 hover:text-white transition">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>

</html>