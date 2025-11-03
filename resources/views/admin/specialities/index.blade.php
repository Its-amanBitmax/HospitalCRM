@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Specialities</h1>
            <a href="{{ route('admin.specialities.create') }}"
               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition transform hover:scale-105">
                + Add New Speciality
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Grid of Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($specialities as $speciality)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">

                    <!-- Image Section -->
                    <div class="relative h-48 bg-gray-100 dark:bg-gray-700">
                        @if($speciality->image)
                            <img src="{{ asset('storage/' . $speciality->image) }}"
                                 alt="{{ $speciality->skill }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        @else
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-500 mt-2">No Image</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-1">
                            {{ $speciality->skill }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Added {{ $speciality->created_at->diffForHumans() }}
                        </p>

                        <!-- Actions -->
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.specialities.show', $speciality) }}"
                                   class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm font-medium">View</a>
                                <a href="{{ route('admin.specialities.edit', $speciality) }}"
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">Edit</a>
                            </div>

                            <form action="{{ route('admin.specialities.destroy', $speciality) }}" method="POST"
                                  onsubmit="return confirm('Delete {{ addslashes($speciality->skill) }}? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 text-sm font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <!-- No Records -->
                <div class="col-span-full text-center py-16">
                    <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No Specialities Found</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Start by creating your first speciality.</p>
                    <a href="{{ route('admin.specialities.create') }}"
                       class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Add First Speciality
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($specialities, 'links'))
            <div class="mt-10">
                {{ $specialities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
