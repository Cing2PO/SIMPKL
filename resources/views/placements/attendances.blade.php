@extends('layouts.app')

@section('title', 'Absensi - ' . ($placement->user?->name ?? '') . ' - SIMPKL')
@section('page_title', 'Absensi')
@section('page_subtitle', $placement->user?->name . ' — ' . $placement->institution?->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.show', $placement) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placement Detail</a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        {{-- Sub-page Tabs --}}
        @include('placements._tabs', ['active' => 'attendances'])

        {{-- Check-in/Check-out (murid only) --}}
        @if(auth()->user()->role === 'murid' && auth()->user()->id === $placement->student_id)
            <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900">Absensi Hari Ini — {{ now()->format('d M Y') }}</h2>
                </div>
                <div class="px-6 py-6">
                    @if(!$todayAttendance)
                        <div class="flex items-center justify-between">
                            <p class="text-gray-600">Anda belum check-in hari ini.</p>
                            <form method="POST" action="{{ route('attendances.checkIn', $placement) }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 shadow-sm">
                                    ✓ Check In
                                </button>
                            </form>
                        </div>
                    @elseif(!$todayAttendance->clock_out)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-700 font-medium">✓ Sudah check-in pada {{ $todayAttendance->clock_in }}</p>
                                <p class="text-gray-500 text-sm mt-1">Silakan check-out saat selesai.</p>
                            </div>
                            <form method="POST" action="{{ route('attendances.checkOut', $todayAttendance) }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-sm">
                                    ✕ Check Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-2">
                            <p class="text-green-700 font-medium">✓ Absensi hari ini selesai</p>
                            <p class="text-gray-500 text-sm mt-1">
                                Check-in: <span class="font-medium">{{ $todayAttendance->clock_in }}</span> &mdash;
                                Check-out: <span class="font-medium">{{ $todayAttendance->clock_out }}</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Riwayat Attendance --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Riwayat Absensi</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Clock In</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Clock Out</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($attendance->status === 'hadir') bg-green-100 text-green-800
                                                @elseif($attendance->status === 'absen') bg-red-100 text-red-800
                                                @elseif($attendance->status === 'sakit') bg-yellow-100 text-yellow-800
                                                @elseif($attendance->status === 'izin') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->clock_in ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->clock_out ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection