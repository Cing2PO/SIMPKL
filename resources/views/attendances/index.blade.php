@extends('layouts.app')

@section('title', 'Attendances Management - SIMPKL')
@section('page_title', 'Attendances Management')
@section('page_subtitle', 'Track student attendance records')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">All Attendance Records</h1>
            @if(auth()->user()->role === 'murid')
            <a href="{{ route('attendances.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">+
                Add Attendance</a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Student</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Institution</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Clock In</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Clock Out</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $attendance->placement?->user?->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $attendance->placement?->institution?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') : '-' }}</td>
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
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('attendances.show', $attendance->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                    @if(auth()->user()->role === 'murid')
                                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                    <form method="POST" action="{{ route('attendances.delete', $attendance->id) }}"
                                        class="inline" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-700">No attendance records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Records</div>
                <div class="text-2xl font-bold text-gray-900">{{ $attendances->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Hadir</div>
                <div class="text-2xl font-bold text-green-600">{{ $attendances->where('status', 'hadir')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Absen</div>
                <div class="text-2xl font-bold text-red-600">{{ $attendances->where('status', 'absen')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Sakit</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $attendances->where('status', 'sakit')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Izin</div>
                <div class="text-2xl font-bold text-blue-600">{{ $attendances->where('status', 'izin')->count() }}</div>
            </div>
        </div>
    </div>
@endsection