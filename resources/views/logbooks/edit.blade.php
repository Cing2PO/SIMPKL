@extends('layouts.app')

@section('title', $title . ' - SIMPKL')
@section('page_title', $title)
@section('page_subtitle', 'Update logbook entry information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.show', $placement) }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placement Detail</a>
        </div>

        {{-- Info placement --}}
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded">
            <p class="text-sm"><span class="font-medium">Placement:</span> {{ $placement->user?->name ?? 'Unknown' }} — {{ $placement->institution?->name ?? 'Unknown' }}</p>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <p class="font-medium">Please fix the following errors:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <form method="POST" action="{{ route('logbooks.update', [$placement, $logbook]) }}" class="divide-y divide-gray-200">
                @csrf
                <div class="px-6 py-8 space-y-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', $logbook->date ? \Carbon\Carbon::parse($logbook->date)->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border @error('date') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="activity" class="block text-sm font-medium text-gray-700 mb-2">Activity <span class="text-red-500">*</span></label>
                        <input type="text" id="activity" name="activity" value="{{ old('activity', $logbook->activity) }}" class="w-full px-3 py-2 border @error('activity') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Enter activity name" required>
                        @error('activity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                        <textarea id="description" name="description" rows="5" class="w-full px-3 py-2 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Enter activity description" required>{{ old('description', $logbook->description) }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50">
                    <a href="{{ route('placements.show', $placement) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Update Entry</button>
                </div>
            </form>
        </div>
    </div>
@endsection
