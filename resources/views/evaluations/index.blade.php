@extends('layouts.app')

@section('title', 'Evaluations Management - SIMPKL')
@section('page_title', 'Evaluations Management')
@section('page_subtitle', 'Track student placement evaluations')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">All Evaluations</h1>
            @if(auth()->user()->role === 'guru')
            <a href="{{ route('evaluations.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">+
                Add New Evaluation</a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Final Score</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Grade</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Feedback</th>
                        @if(auth()->user()->role === 'guru')
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($evaluations as $evaluation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $evaluation->placement?->user?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->placement?->institution?->name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                    @if($evaluation->final_score >= 85) bg-green-100 text-green-800
                                    @elseif($evaluation->final_score >= 70) bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $evaluation->final_score }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold">
                                @if($evaluation->final_score >= 85)
                                    <span class="text-green-600">A</span>
                                @elseif($evaluation->final_score >= 70)
                                    <span class="text-blue-600">B</span>
                                @else
                                    <span class="text-red-600">C</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $evaluation->feedback }}</td>
                            @if(auth()->user()->role === 'guru')
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('evaluations.show', $evaluation->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                    <a href="{{ route('evaluations.edit', $evaluation->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                    <form method="POST" action="{{ route('evaluations.delete', $evaluation->id) }}"
                                        class="inline" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="{{ auth()->user()->role === 'guru' ? 7 : 6 }}" class="px-6 py-4 text-center text-sm text-gray-700">No evaluations found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Evaluations</div>
                <div class="text-2xl font-bold text-gray-900">{{ $evaluations->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Average Score</div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($evaluations->avg('final_score'), 2) }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Highest Score</div>
                <div class="text-2xl font-bold text-green-600">{{ $evaluations->max('final_score') ?? '-' }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Lowest Score</div>
                <div class="text-2xl font-bold text-red-600">{{ $evaluations->min('final_score') ?? '-' }}</div>
            </div>
        </div>
    </div>
@endsection
