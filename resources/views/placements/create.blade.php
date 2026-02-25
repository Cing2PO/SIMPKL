@extends('layouts.app')

@section('title', 'Add Placement - SIMPKL')
@section('page_title', 'Add Placement')
@section('page_subtitle', 'Create a new student placement')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('placements.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Placements</a>
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
            <form method="POST" action="{{ route('placements.store') }}" class="divide-y divide-gray-200">
                @csrf
                <div class="px-6 py-8 space-y-6">

                    {{-- Institution (hanya untuk superadmin) --}}
                    @if(auth()->user()->role === 'superadmin')
                        <div>
                            <label for="institution_id" class="block text-sm font-medium text-gray-700 mb-2">Institution <span class="text-red-500">*</span></label>
                            <select id="institution_id" name="institution_id" class="w-full px-3 py-2 border @error('institution_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select an institution</option>
                                @foreach($institutions as $institution)
                                    <option value="{{ $institution->id }}" @selected(old('institution_id') == $institution->id)>{{ $institution->name }}</option>
                                @endforeach
                            </select>
                            @error('institution_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <p class="text-sm text-blue-700">
                                <span class="font-medium">Institusi:</span> {{ auth()->user()->institution->name ?? '-' }}
                                <span class="text-blue-500 text-xs">(otomatis dari akun Anda)</span>
                            </p>
                        </div>
                    @endif

                    {{-- Student --}}
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Siswa <span class="text-red-500">*</span></label>
                        <select id="student_id" name="student_id" class="w-full px-3 py-2 border @error('student_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih siswa</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Mentor --}}
                    <div>
                        <label for="mentor_id" class="block text-sm font-medium text-gray-700 mb-2">Mentor (Guru) <span class="text-red-500">*</span></label>
                        <select id="mentor_id" name="mentor_id" class="w-full px-3 py-2 border @error('mentor_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih mentor</option>
                            @foreach($mentors as $mentor)
                                <option value="{{ $mentor->id }}" @selected(old('mentor_id') == $mentor->id)>{{ $mentor->name }} ({{ $mentor->email }})</option>
                            @endforeach
                        </select>
                        @error('mentor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full px-3 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="pending" @selected(old('status', 'pending') === 'pending')>Pending</option>
                            <option value="accepted" @selected(old('status') === 'accepted')>Accepted</option>
                            <option value="rejected" @selected(old('status') === 'rejected')>Rejected</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Dates --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full px-3 py-2 border @error('start_date') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full px-3 py-2 border @error('end_date') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50">
                    <a href="{{ route('placements.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Create Placement</button>
                </div>
            </form>
        </div>
    </div>
@endsection
