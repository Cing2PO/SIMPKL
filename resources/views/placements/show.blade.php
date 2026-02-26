@extends('layouts.app')

@section('title', 'Placement Detail - SIMPKL')
@section('page_title', 'Placement Detail')
@section('page_subtitle', 'View placement information, attendance, and evaluations')

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

        {{-- Check-in/Check-out Section (hanya untuk murid pemilik placement ini) --}}
        @if(auth()->user()->role === 'murid' && auth()->user()->id === $placement->student_id)
            <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900">Absensi Hari Ini — {{ now()->format('d M Y') }}</h2>
                </div>
                <div class="px-6 py-6">
                    @if(!$todayAttendance)
                        {{-- Belum check-in --}}
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
                        {{-- Sudah check-in, belum check-out --}}
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
                        {{-- Sudah check-in dan check-out --}}
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
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
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

        {{-- Logbook Section --}}
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Logbook</h2>
                @if(auth()->user()->role === 'murid' && auth()->user()->id === $placement->student_id)
                    <a href="{{ route('logbooks.create', $placement) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        + Tambah Entry
                    </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Activity</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($logbooks as $logbook)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->activity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $logbook->description }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('logbooks.show', [$placement, $logbook]) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                        @if(auth()->user()->role === 'murid' && auth()->user()->id === $placement->student_id)
                                            <a href="{{ route('logbooks.edit', [$placement, $logbook]) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                            <form method="POST" action="{{ route('logbooks.delete', [$placement, $logbook]) }}"
                                                class="inline" onsubmit="return confirm('Yakin ingin menghapus logbook ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada logbook untuk
                                    placement ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Evaluasi Section --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Evaluasi</h2>
                @if(auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id)
                    <a href="{{ route('evaluations.create', $placement) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        + Tambah Evaluasi
                    </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Score</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Grade</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Feedback</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            @if(auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id)
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($evaluations as $evaluation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                                @if($evaluation->final_score >= 85) bg-green-100 text-green-800
                                                @elseif($evaluation->final_score >= 70) bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                        {{ $evaluation->final_score ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    @if($evaluation->final_score !== null)
                                        @if($evaluation->final_score >= 85)
                                            <span class="text-green-600">A</span>
                                        @elseif($evaluation->final_score >= 70)
                                            <span class="text-blue-600">B</span>
                                        @else
                                            <span class="text-red-600">C</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $evaluation->feedback }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->created_at?->format('d M Y H:i') }}
                                </td>
                                @if(auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id)
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('evaluations.show', [$placement, $evaluation]) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                            <a href="{{ route('evaluations.edit', [$placement, $evaluation]) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                            <form method="POST"
                                                action="{{ route('evaluations.delete', [$placement, $evaluation]) }}" class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus evaluasi ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ (auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id) ? 5 : 4 }}"
                                    class="px-6 py-4 text-center text-sm text-gray-500">Belum ada evaluasi untuk placement ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection