@extends('layouts.app')

@section('title', 'Profil Saya - SIMPKL')
@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Kelola informasi akun Anda')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Profile Information Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center">
                            <span class="text-4xl font-bold text-blue-600">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h3>
                            <p class="text-blue-100">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-8">
                    <!-- ID -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ID Pengguna</label>
                        <div class="text-lg text-gray-900">{{ Auth::user()->id }}</div>
                    </div>

                    <!-- Email -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="text-lg text-gray-900">{{ Auth::user()->email }}</div>
                    </div>

                    <!-- Name -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="text-lg text-gray-900">{{ Auth::user()->name }}</div>
                    </div>

                    <!-- Role -->
                    @if(Auth::user()->role)
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                            <div>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                                            @if(Auth::user()->role === 'admin') bg-red-100 text-red-800
                                            @elseif(Auth::user()->role === 'guru') bg-green-100 text-green-800
                                            @elseif(Auth::user()->role === 'murid') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Institution -->
                    @if(Auth::user()->institution_id)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                            <div class="text-lg text-gray-900">
                                {{ Auth::user()->institution->name ?? 'N/A' }}
                            </div>
                        </div>
                    @endif

                    <!-- Account Created Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akun Dibuat</label>
                        <div class="text-lg text-gray-900">
                            {{ Auth::user()->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <a href="{{ route('auth.editProfile') }}"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition">
                    Ubah Profil
                </a>
                <a href="{{ route('auth.changePassword') }}"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                    Ubah Kata Sandi
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Quick Stats Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status Akun</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Status</span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Verifikasi Email</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if(Auth::user()->email_verified_at)
                                    bg-green-100 text-green-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif
                            ">
                            {{ Auth::user()->email_verified_at ? 'Terverifikasi' : 'Belum' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Help & Support Card -->
            <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Butuh Bantuan?</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Jika Anda memiliki pertanyaan atau memerlukan dukungan, silakan hubungi administrator.
                </p>
                <a href="#" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                    Hubungi Kami →
                </a>
            </div>
        </div>
    </div>
@endsection