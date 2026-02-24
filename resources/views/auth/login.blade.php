@extends('layouts.auth')

@section('title', 'Login - SIMPKL')

@section('content')
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">SIMPKL</h1>
                <p class="text-gray-600">Sistem Manajemen Internship & Placement</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Masuk</h2>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="text-red-800">
                            @foreach ($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email Anda"
                            value="{{ old('email') }}"
                            required
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                            placeholder="Masukkan kata sandi Anda"
                            required
                        />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>

                <!-- Additional Info -->
                <p class="text-center text-gray-600 text-sm mt-6">
                    Belum memiliki akun?
                    <a href="{{ route('auth.registerForm') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        Daftar di sini
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <p class="text-center text-gray-600 text-sm mt-8">
                © 2024 SIMPKL. All rights reserved.
            </p>
        </div>
    </div>
@endsection
