@extends('layouts.app')

@section('title', $title . ' - SIMPKL')
@section('page_title', $title)
@section('page_subtitle', 'Edit evaluation details')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('evaluations.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Evaluations</a>
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
            <form method="POST" action="{{ route('evaluations.update', $evaluation->id) }}" class="divide-y divide-gray-200">
                @csrf
                <div class="px-6 py-8 space-y-6">
                    <div>
                        <label for="placement_id" class="block text-sm font-medium text-gray-700 mb-2">Placement (Student) <span class="text-red-500">*</span></label>
                        <select id="placement_id" name="placement_id" class="w-full px-3 py-2 border @error('placement_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select a placement</option>
                            @foreach($placements as $placement)
                                <option value="{{ $placement->id }}" @selected(old('placement_id', $evaluation->placement_id) == $placement->id)>{{ $placement->user?->name ?? 'Unknown' }} - {{ $placement->institution?->name ?? 'Unknown' }}</option>
                            @endforeach
                        </select>
                        @error('placement_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="final_score" class="block text-sm font-medium text-gray-700 mb-2">Final Score (0-100)</label>
                        <input type="number" id="final_score" name="final_score" value="{{ old('final_score', $evaluation->final_score) }}" min="0" max="100" class="w-full px-3 py-2 border @error('final_score') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('final_score') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback <span class="text-red-500">*</span></label>
                        <textarea id="feedback" name="feedback" rows="5" class="w-full px-3 py-2 border @error('feedback') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>{{ old('feedback', $evaluation->feedback) }}</textarea>
                        @error('feedback') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50">
                    <a href="{{ route('evaluations.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Update Evaluation</button>
                </div>
            </form>
        </div>
    </div>
@endsection
