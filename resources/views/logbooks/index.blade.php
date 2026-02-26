@extends('layouts.app')

@section('title', 'Logbooks Management - SIMPKL')
@section('page_title', 'Logbooks Management')
@section('page_subtitle', 'Manage daily activity logbooks')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">All Logbook Entries</h1>
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Activity</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($logbooks as $logbook)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $logbook->placement?->user?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->placement?->institution?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $logbook->date ? \Carbon\Carbon::parse($logbook->date)->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->activity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $logbook->description }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('placements.show', $logbook->placement_id) }}"
                                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">View
                                    Placement</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-700">No logbooks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Logbook Entries</div>
                <div class="text-2xl font-bold text-gray-900">{{ $logbooks->count() }}</div>
            </div>
        </div>
    </div>
@endsection