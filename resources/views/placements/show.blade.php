@extends('layouts.app')

@section('title', 'Placement Detail - SIMPKL')
@section('page_title', 'Placement Detail')
@section('page_subtitle', 'View placement information')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.index') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placements</a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        {{-- Placement Info Card --}}
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Placement</h2>
            </div>
            <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Siswa</label>
                    <div class="mt-1 text-gray-900 font-medium">{{ $placement->user?->name ?? '-' }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Institusi</label>
                    <div class="mt-1 text-gray-900">{{ $placement->institution?->name ?? '-' }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Mentor</label>
                    <div class="mt-1 text-gray-900">{{ $placement->mentor?->name ?? '-' }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Status</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($placement->status === 'accepted') bg-green-100 text-green-800
                                    @elseif($placement->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                            {{ ucfirst($placement->status) }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Mulai</label>
                    <div class="mt-1 text-gray-900">
                        {{ $placement->start_date ? \Carbon\Carbon::parse($placement->start_date)->format('d M Y') : '-' }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Selesai</label>
                    <div class="mt-1 text-gray-900">
                        {{ $placement->end_date ? \Carbon\Carbon::parse($placement->end_date)->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Sub-page Navigation Tabs --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <a href="{{ route('placements.attendances', $placement) }}"
                        class="flex-1 text-center px-6 py-4 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-blue-600 hover:border-blue-300 transition">
                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        Absensi
                        <span
                            class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $placement->attendances_count ?? 0 }}</span>
                    </a>
                    <a href="{{ route('placements.logbooks', $placement) }}"
                        class="flex-1 text-center px-6 py-4 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-blue-600 hover:border-blue-300 transition">
                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Logbook
                        <span
                            class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $placement->logbooks_count ?? 0 }}</span>
                    </a>
                    <a href="{{ route('placements.evaluations', $placement) }}"
                        class="flex-1 text-center px-6 py-4 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-blue-600 hover:border-blue-300 transition">
                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        Evaluasi
                        <span
                            class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $placement->evaluations_count ?? 0 }}</span>
                    </a>
                </nav>
            </div>
            <div class="px-6 py-8 text-center text-gray-500">
                <p class="text-sm">Pilih tab di atas untuk melihat detail absensi, logbook, atau evaluasi.</p>
            </div>
        </div>
    </div>
@endsection