@extends('layouts.app')

@section('title', $title . ' - SIMPKL')
@section('page_title', $title)
@section('page_subtitle', 'Create a new attendance record')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Attendances</a>
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
            <form method="POST" action="{{ route('attendances.store') }}" class="divide-y divide-gray-200">
                @csrf
                <div class="px-6 py-8 space-y-6">
                    <div>
                        <label for="placement_id" class="block text-sm font-medium text-gray-700 mb-2">Placement (Student) <span class="text-red-500">*</span></label>
                        <select id="placement_id" name="placement_id" class="w-full px-3 py-2 border @error('placement_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select a placement</option>
                            @foreach($placements as $placement)
                                <option value="{{ $placement->id }}" @selected(old('placement_id') == $placement->id)>{{ $placement->user?->name ?? 'Unknown' }} - {{ $placement->institution?->name ?? 'Unknown' }}</option>
                            @endforeach
                        </select>
                        @error('placement_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="w-full px-3 py-2 border @error('date') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full px-3 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select status</option>
                            <option value="hadir" @selected(old('status') === 'hadir')>Hadir</option>
                            <option value="absen" @selected(old('status') === 'absen')>Absen</option>
                            <option value="sakit" @selected(old('status') === 'sakit')>Sakit</option>
                            <option value="izin" @selected(old('status') === 'izin')>Izin</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="clock_in" class="block text-sm font-medium text-gray-700 mb-2">Clock In</label>
                            <input type="time" id="clock_in" name="clock_in" value="{{ old('clock_in') }}" class="w-full px-3 py-2 border @error('clock_in') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('clock_in') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="clock_out" class="block text-sm font-medium text-gray-700 mb-2">Clock Out</label>
                            <input type="time" id="clock_out" name="clock_out" value="{{ old('clock_out') }}" class="w-full px-3 py-2 border @error('clock_out') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('clock_out') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border @error('notes') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Optional notes">{{ old('notes') }}</textarea>
                        @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50">
                    <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Create Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
