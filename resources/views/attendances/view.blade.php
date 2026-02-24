@extends('layouts.app')

@section('title', 'Attendance Details - SIMPKL')
@section('page_title', 'Attendance Details')
@section('page_subtitle', 'View attendance record information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('attendances.index') }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Attendances</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-8">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                        <div class="text-lg text-gray-900">{{ $attendance->id }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                        <div class="text-lg text-gray-900">{{ $attendance->placement?->user?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                        <div class="text-lg text-gray-900">{{ $attendance->placement?->institution?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <div class="text-lg text-gray-900">
                            {{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('d M Y') : '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($attendance->status === 'hadir') bg-green-100 text-green-800
                                @elseif($attendance->status === 'absen') bg-red-100 text-red-800
                                @elseif($attendance->status === 'sakit') bg-yellow-100 text-yellow-800
                                @elseif($attendance->status === 'izin') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Clock In</label>
                            <div class="text-lg text-gray-900">{{ $attendance->clock_in ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Clock Out</label>
                            <div class="text-lg text-gray-900">{{ $attendance->clock_out ?? '-' }}</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <div class="text-gray-900 whitespace-pre-wrap">{{ $attendance->notes ?? '-' }}</div>
                    </div>
                    <div class="pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                        <div class="text-sm text-gray-600">{{ $attendance->created_at?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Updated At</label>
                        <div class="text-sm text-gray-600">{{ $attendance->updated_at?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Edit</a>
                    <form method="POST" action="{{ route('attendances.delete', $attendance->id) }}" class="inline"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection