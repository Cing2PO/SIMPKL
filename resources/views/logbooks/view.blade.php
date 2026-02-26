@extends('layouts.app')

@section('title', 'Logbook Details - SIMPKL')
@section('page_title', 'Logbook Details')
@section('page_subtitle', 'View logbook entry information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.show', $placement) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placement Detail</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-8">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                        <div class="text-lg text-gray-900">{{ $logbook->placement?->user?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                        <div class="text-lg text-gray-900">{{ $logbook->placement?->institution?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <div class="text-lg text-gray-900">
                            {{ $logbook->date ? \Carbon\Carbon::parse($logbook->date)->format('d M Y') : '-' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Activity</label>
                        <div class="text-lg text-gray-900">{{ $logbook->activity }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <div class="text-gray-900 whitespace-pre-wrap">{{ $logbook->description }}</div>
                    </div>
                    <div class="pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                        <div class="text-sm text-gray-600">{{ $logbook->created_at?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Updated At</label>
                        <div class="text-sm text-gray-600">{{ $logbook->updated_at?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                @if(auth()->user()->role === 'murid' && auth()->user()->id === $logbook->placement?->student_id)
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('logbooks.edit', [$placement, $logbook]) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Edit</a>
                        <form method="POST" action="{{ route('logbooks.delete', [$placement, $logbook]) }}" class="inline"
                            onsubmit="return confirm('Yakin ingin menghapus logbook ini?');">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection