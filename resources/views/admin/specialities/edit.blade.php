@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Speciality</h1>

        <form action="{{ route('admin.specialities.update', $speciality) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="skill" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill Name *</label>
                <input type="text" name="skill" id="skill" value="{{ old('skill', $speciality->skill) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                @error('skill') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                @if($speciality->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $speciality->image) }}" alt="{{ $speciality->skill }}" class="h-32 w-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.specialities.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Speciality</button>
            </div>
        </form>
    </div>
</div>
@endsection
