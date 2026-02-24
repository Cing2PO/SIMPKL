@extends('layouts.app')

@section('title', $title . ' - SIMPKL')
@section('page_title', $title)
@section('page_subtitle', 'Update institution information')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('institutions.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">← Back to Institutions</a>
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
            <form method="POST" action="{{ route('institutions.update', $institution->id) }}" class="divide-y divide-gray-200">
                @csrf
                <div class="px-6 py-8 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                        <input type="text" value="{{ $institution->id }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-600 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Institution Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $institution->name) }}" class="w-full px-3 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="3" class="w-full px-3 py-2 border @error('address') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>{{ old('address', $institution->address) }}</textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email <span class="text-red-500">*</span></label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $institution->contact_email) }}" class="w-full px-3 py-2 border @error('contact_email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('contact_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Contact Phone <span class="text-red-500">*</span></label>
                        <input type="tel" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $institution->contact_phone) }}" class="w-full px-3 py-2 border @error('contact_phone') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('contact_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full px-3 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select status</option>
                            <option value="active" @selected(old('status', $institution->status) === 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $institution->status) === 'inactive')>Inactive</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex gap-4 justify-end px-6 py-4 bg-gray-50">
                    <a href="{{ route('institutions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">Update Institution</button>
                </div>
            </form>
        </div>
    </div>
@endsection
