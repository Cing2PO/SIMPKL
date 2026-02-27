@extends('layouts.app')

@section('title', 'Evaluations Management - SIMPKL')
@section('page_title', 'Evaluations Management')
@section('page_subtitle', 'Track student placement evaluations')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">All Evaluations</h1>
        </div>

        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('evaluations.index') }}"
            class="mb-6 flex flex-wrap gap-3 items-center bg-white rounded-lg shadow p-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau institusi..."
                class="flex-1 min-w-[200px] border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="grade"
                class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Grade</option>
                <option value="A" {{ request('grade') === 'A' ? 'selected' : '' }}>A (≥ 85)</option>
                <option value="B" {{ request('grade') === 'B' ? 'selected' : '' }}>B (70 – 84)</option>
                <option value="C" {{ request('grade') === 'C' ? 'selected' : '' }}>C (< 70)</option>
            </select>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">Cari</button>
            @if(request()->hasAny(['search', 'grade']))
                <a href="{{ route('evaluations.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">Reset</a>
            @endif
        </form>

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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Final Score</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Grade</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Feedback</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($evaluations as $evaluation)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $evaluation->placement?->user?->name }}
                            </td>
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
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('placements.show', $evaluation->placement_id) }}"
                                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">View
                                    Placement</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-700">No evaluations found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $evaluations->links() }}
        </div>

        <div class="mt-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Evaluations</div>
                <div class="text-2xl font-bold text-gray-900">{{ $evaluations->total() }}</div>
            </div>
        </div>
    </div>
@endsection