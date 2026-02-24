@extends('layouts.app')

@section('title', 'Ubah Kata Sandi - SIMPKL')
@section('page_title', 'Ubah Kata Sandi')
@section('page_subtitle', 'Perbarui kata sandi akun Anda untuk keamanan yang lebih baik')

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

        <!-- Change Password Form -->
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

                <form method="POST" action="{{ route('auth.updatePassword') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Password Field -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('current_password') border-red-500 @enderror"
                            placeholder="Masukkan kata sandi saat ini"
                            required
                        />
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                            placeholder="Masukkan kata sandi baru (minimal 8 karakter)"
                            required
                        />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">Kata sandi harus mengandung kombinasi huruf besar, huruf kecil, angka, dan karakter khusus untuk keamanan maksimal.</p>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Konfirmasi kata sandi baru"
                            required
                        />
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Persyaratan Kata Sandi:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Minimal 8 karakter</li>
                            <li>• Mengandung setidaknya satu huruf besar (A-Z)</li>
                            <li>• Mengandung setidaknya satu huruf kecil (a-z)</li>
                            <li>• Mengandung setidaknya satu angka (0-9)</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4 border-t border-gray-200">
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition"
                        >
                            Ubah Kata Sandi
                        </button>
                        <a href="{{ route('auth.profile') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tips Card -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-yellow-900 mb-2">💡 Tips Keamanan</h3>
            <ul class="text-sm text-yellow-800 space-y-2">
                <li>• Jangan bagikan kata sandi Anda kepada siapa pun</li>
                <li>• Gunakan kata sandi yang unik dan kuat</li>
                <li>• Ubah kata sandi secara berkala untuk keamanan yang lebih baik</li>
                <li>• Jangan gunakan tanggal lahir atau nama dalam kata sandi</li>
            </ul>
        </div>
    </div>
@endsection
