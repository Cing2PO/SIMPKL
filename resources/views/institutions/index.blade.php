@extends('layouts.app')

@section('title', 'Institutions Management - SIMPKL')
@section('page_title', 'Institutions Management')
@section('page_subtitle', 'Manage all institutions/placement locations')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Institutions</h1>
            </div>
            <a href="{{ route('institutions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                + Add New Institution
            </a>
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Address</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Phone</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($institutions as $institution)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $institution->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $institution->address }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->contact_email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $institution->contact_phone }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($institution->status === 'active') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($institution->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('institutions.show', $institution->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                    <a href="{{ route('institutions.edit', $institution->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                    <form method="POST" action="{{ route('institutions.delete', $institution->id) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-700">No institutions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $institutions->links() }}
        </div>

        <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Total Institutions</div>
                <div class="text-2xl font-bold text-gray-900">{{ $institutions->total() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Active</div>
                <div class="text-2xl font-bold text-green-600">{{ $institutions->where('status', 'active')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm">Inactive</div>
                <div class="text-2xl font-bold text-gray-600">{{ $institutions->where('status', 'inactive')->count() }}</div>
            </div>
        </div>
    </div>
@endsection