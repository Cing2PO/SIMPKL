@extends('layouts.app')

@section('title', 'Logbook - ' . ($placement->user?->name ?? '') . ' - SIMPKL')
@section('page_title', 'Logbook')
@section('page_subtitle', $placement->user?->name . ' — ' . $placement->institution?->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.show', $placement) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placement Detail</a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        {{-- Sub-page Tabs --}}
        @include('placements._tabs', ['active' => 'logbooks'])

        {{-- Logbook List --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Logbook Entries</h2>
                @if(auth()->user()->role === 'murid' && auth()->user()->id === $placement->student_id)
                    <a href="{{ route('logbooks.create', $placement) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        + Tambah Entry
                    </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Activity</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($logbooks as $logbook)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $logbook->activity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $logbook->description }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('logbooks.show', [$placement, $logbook]) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                        @if(auth()->user()->role === 'murid' && auth()->user()->id === $placement->student_id)
                                            <a href="{{ route('logbooks.edit', [$placement, $logbook]) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                            <form method="POST" action="{{ route('logbooks.delete', [$placement, $logbook]) }}"
                                                class="inline" onsubmit="return confirm('Yakin ingin menghapus logbook ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada logbook untuk
                                    placement ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection