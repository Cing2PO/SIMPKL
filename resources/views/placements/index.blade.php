@extends('layouts.app')

@section('title', 'Placements Management - SIMPKL')
@section('page_title', 'Placements Management')
@section('page_subtitle', 'Manage student placements at institutions')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">All Placements</h1>
            @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                <a href="{{ route('placements.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">+ Add Placement</a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Student</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Institution</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Mentor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Start Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">End Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($placements as $placement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $placement->user?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->institution?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->mentor?->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->start_date ? \Carbon\Carbon::parse($placement->start_date)->format('Y-m-d') : '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $placement->end_date ? \Carbon\Carbon::parse($placement->end_date)->format('Y-m-d') : '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($placement->status === 'active' || $placement->status === 'accepted') bg-green-100 text-green-800
                                                    @elseif($placement->status === 'completed') bg-blue-100 text-blue-800
                                                    @elseif($placement->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                    {{ ucfirst($placement->status) }}
                                </span>
                            </td>
                            @if(in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('placements.edit', $placement) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                        <form method="POST" action="{{ route('placements.delete', $placement) }}" onsubmit="return confirm('Yakin ingin menghapus placement ini?')">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-700">No placements found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Placements</div>
                <div class="text-2xl font-bold text-gray-900">{{ $placements->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Active</div>
                <div class="text-2xl font-bold text-green-600">{{ $placements->whereIn('status', ['active', 'accepted'])->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Completed</div>
                <div class="text-2xl font-bold text-blue-600">{{ $placements->where('status', 'completed')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Pending</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $placements->where('status', 'pending')->count() }}</div>
            </div>
        </div>
    </div>
@endsection