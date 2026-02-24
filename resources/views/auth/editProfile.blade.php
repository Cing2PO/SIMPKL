@extends('layouts.app')

@section('title', 'Ubah Profil - SIMPKL')
@section('page_title', 'Ubah Profil')
@section('page_subtitle', 'Perbarui informasi akun Anda')

@section('content')
    <div class="max-w-2xl">
        <!-- Breadcrumb -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('auth.profile') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Edit Profile Form -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-8">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <h3 class="text-red-800 font-medium mb-2">Ada beberapa kesalahan:</h3>
                        <ul class="text-red-800 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.updateProfile') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                            value="{{ Auth::user()->name }}"
                            required
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                            value="{{ Auth::user()->email }}"
                            required
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Institution Field -->
                    @if(Auth::user()->institution_id)
                        <div>
                            <label for="institution_id" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                            <select
                                id="institution_id"
                                name="institution_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            >
                                <option value="{{ Auth::user()->institution_id }}">{{ Auth::user()->institution->name ?? 'N/A' }}</option>
                            </select>
                        </div>
                    @endif

                    <!-- Role Display -->
                    @if(Auth::user()->role)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                            <div class="px-4 py-2 bg-gray-100 rounded-lg text-gray-900">
                                {{ ucfirst(Auth::user()->role) }}
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Peran tidak dapat diubah. Hubungi administrator jika ada perubahan yang diperlukan.</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition"
                        >
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('auth.profile') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
