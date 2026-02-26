@extends('layouts.app')

@section('title', 'Evaluasi - ' . ($placement->user?->name ?? '') . ' - SIMPKL')
@section('page_title', 'Evaluasi')
@section('page_subtitle', $placement->user?->name . ' — ' . $placement->institution?->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.show', $placement) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placement Detail</a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        {{-- Sub-page Tabs --}}
        @include('placements._tabs', ['active' => 'evaluations'])

        {{-- Evaluasi List --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Evaluasi</h2>
                @if(auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id)
                    <a href="{{ route('evaluations.create', $placement) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        + Tambah Evaluasi
                    </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Score</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Grade</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Feedback</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            @if(auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id)
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($evaluations as $evaluation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                        @if($evaluation->final_score >= 85) bg-green-100 text-green-800
                                        @elseif($evaluation->final_score >= 70) bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $evaluation->final_score ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    @if($evaluation->final_score !== null)
                                        @if($evaluation->final_score >= 85)
                                            <span class="text-green-600">A</span>
                                        @elseif($evaluation->final_score >= 70)
                                            <span class="text-blue-600">B</span>
                                        @else
                                            <span class="text-red-600">C</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $evaluation->feedback }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $evaluation->created_at?->format('d M Y H:i') }}</td>
                                @if(auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id)
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('evaluations.show', [$placement, $evaluation]) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">View</a>
                                            <a href="{{ route('evaluations.edit', [$placement, $evaluation]) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
                                            <form method="POST" action="{{ route('evaluations.delete', [$placement, $evaluation]) }}"
                                                class="inline" onsubmit="return confirm('Yakin ingin menghapus evaluasi ini?');">
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
                                <td colspan="{{ (auth()->user()->role === 'guru' && auth()->user()->id === $placement->mentor_id) ? 5 : 4 }}"
                                    class="px-6 py-4 text-center text-sm text-gray-500">Belum ada evaluasi untuk placement ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
