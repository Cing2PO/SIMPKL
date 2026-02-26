{{-- Reusable tab navigation for placement sub-pages --}}
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="{{ route('placements.attendances', $placement) }}"
                class="flex-1 text-center px-6 py-4 border-b-2 text-sm font-medium transition
                    {{ $active === 'attendances' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-300' }}">
                <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
                Absensi
            </a>
            <a href="{{ route('placements.logbooks', $placement) }}"
                class="flex-1 text-center px-6 py-4 border-b-2 text-sm font-medium transition
                    {{ $active === 'logbooks' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-300' }}">
                <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                Logbook
            </a>
            <a href="{{ route('placements.evaluations', $placement) }}"
                class="flex-1 text-center px-6 py-4 border-b-2 text-sm font-medium transition
                    {{ $active === 'evaluations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-300' }}">
                <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
                Evaluasi
            </a>
        </nav>
    </div>
</div>