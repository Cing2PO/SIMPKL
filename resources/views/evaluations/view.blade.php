@extends('layouts.app')

@section('title', 'Evaluation Detail - SIMPKL')
@section('page_title', 'Evaluation Detail')
@section('page_subtitle', 'View evaluation information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.show', $placement) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placement Detail</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Student</p>
                        <p class="text-lg text-gray-900">{{ $evaluation->placement?->user?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Institution</p>
                        <p class="text-lg text-gray-900">{{ $evaluation->placement?->institution?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Final Score</p>
                        <p class="text-lg text-gray-900">{{ $evaluation->final_score ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Grade</p>
                        <p class="text-lg text-gray-900">
                            @if($evaluation->final_score !== null)
                                @if($evaluation->final_score >= 85) A
                                @elseif($evaluation->final_score >= 70) B
                                @elseif($evaluation->final_score >= 55) C
                                @elseif($evaluation->final_score >= 40) D
                                @else E
                                @endif
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Feedback</p>
                    <p class="text-gray-900 mt-1">{{ $evaluation->feedback ?? '-' }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-500">
                    <div>
                        <p class="font-medium">Created</p>
                        <p>{{ $evaluation->created_at?->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Updated</p>
                        <p>{{ $evaluation->updated_at?->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'guru')
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('evaluations.edit', [$placement, $evaluation]) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                    <form method="POST" action="{{ route('evaluations.delete', [$placement, $evaluation]) }}" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus evaluasi ini?');">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection