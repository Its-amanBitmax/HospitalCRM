@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Employee Management</h1>
        <a href="{{ route('admin.employees.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Employee
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($employees as $employee)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Card Header (Image/Placeholder) -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        @if($employee->image)
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->name }}" class="w-24 h-24 object-cover rounded-full border-2 border-gray-300 mx-auto mb-2">
                        @else
                            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-gray-600 text-2xl font-bold">{{ strtoupper(substr($employee->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center">{{ $employee->name }}</h3>
                        @if($employee->professions->isNotEmpty() && $employee->professions->first()->department)
                            <p class="text-sm text-gray-600 dark:text-gray-400 text-center">{{ $employee->professions->first()->department->department_name }}</p>
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-400 text-center">No Department</p>
                        @endif
                    </div>
                </div>

                <!-- Card Body (Details) -->
                <div class="p-4 space-y-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Email:</strong> {{ $employee->email }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</p>
                    @if($employee->professions->isNotEmpty())
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Title:</strong> {{ $employee->professions->first()->title }}</p>
                    @endif
                    @if($employee->expertise->isNotEmpty())
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Expertise:</strong> {{ $employee->expertise->pluck('skill')->implode(', ') }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Experience:</strong> {{ $employee->expertise->pluck('years_of_experience')->implode(', ') }} years</p>
                    @endif
                </div>

                <!-- Card Footer (Actions) -->
                <div class="p-4 bg-gray-50 dark:bg-gray-900 flex justify-between space-x-2 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.employees.show', $employee) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm w-full text-center">View</a>
                    <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-sm w-full text-center">Edit</a>
                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="inline w-full" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm w-full text-center">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500 dark:text-gray-400">No employees found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection