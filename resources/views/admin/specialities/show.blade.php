@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 text-white">Speciality Details</h1>
            <a href="{{ route('admin.specialities.edit', $speciality) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        </div>

        <div class="bg-white bg-white-800 shadow-md rounded-lg p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 text-gray-300">ID</label>
                <p class="mt-1 text-sm text-gray-900 text-white">{{ $speciality->id }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Skill Name</label>
                <p class="mt-1 text-sm text-gray-900 text-white">{{ $speciality->skill }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Image</label>
                @if($speciality->image)
                    <img src="{{ asset('storage/' . $speciality->image) }}" alt="{{ $speciality->skill }}" class="mt-1 h-32 w-32 object-cover rounded">
                @else
                    <p class="mt-1 text-sm text-gray-500 text-gray-400">No image uploaded</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Created At</label>
                <p class="mt-1 text-sm text-gray-900 text-white">{{ $speciality->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 text-gray-300">Updated At</label>
                <p class="mt-1 text-sm text-gray-900 text-white">{{ $speciality->updated_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.specialities.index') }}" class="bg-white-300 hover:bg-white-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
