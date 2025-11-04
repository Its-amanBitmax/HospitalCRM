@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <i class="fas fa-check-circle text-xl"></i>
            <span id="toastMessage"></span>
        </div>
    </div>

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-md text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Doctors Management</h1>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fa fa-plus mr-2"></i>Add Doctor
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-user-md text-3xl text-blue-600 dark:text-blue-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $employees->total() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Doctors</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-stethoscope text-3xl text-green-600 dark:text-green-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $employees->filter(function($e) { return $e->specialities->count() > 0; })->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Specialized Doctors</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-clock text-3xl text-purple-600 dark:text-purple-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $employees->filter(function($e) { return $e->shifts->count() > 0; })->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">On Duty</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-graduation-cap text-3xl text-orange-600 dark:text-orange-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $employees->filter(function($e) { return $e->qualifications->count() > 0; })->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Qualified Doctors</div>
            </div>
        </div>
    </div>


    <!-- Employee Cards Grid -->
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($employees as $employee)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 flex flex-col h-full">

            <!-- Card Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-800 dark:text-gray-300">
                    Employee Code: <b class="text-blue-600 dark:text-blue-400">{{ $employee->employee_code ?? 'N/A' }}</b>
                </p>
                <div class="text-center mt-3">
                    <!-- Profile Image or Initial -->
                    @if($employee->image)
                        <img
                            src="{{ asset('storage/' . $employee->image) }}"
                            alt="{{ $employee->name }}"
                            class="w-24 h-24 object-cover rounded-full border-2 border-gray-300 dark:border-gray-600 mx-auto mb-2"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="hidden w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-2 text-white text-2xl font-bold">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>
                    @else
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-2 text-white text-2xl font-bold">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>
                    @endif

                    <!-- Name -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-2">
                        {{ $employee->name }}
                    </h3>

                    <!-- Department -->
                    @if($employee->professions->isNotEmpty() && $employee->professions->first()->department)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $employee->professions->first()->department->department_name ?? $employee->professions->first()->department->name ?? 'N/A' }}
                        </p>
                    @else
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">No Department</p>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-2 flex-1">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Email:</strong> <span class="break-all">{{ $employee->email }}</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}
                </p>

                @if($employee->professions->isNotEmpty())
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Title:</strong> {{ $employee->professions->first()->title ?? 'N/A' }}
                    </p>
                @endif

                @if($employee->specialities->isNotEmpty())
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Specialities:</strong>
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $employee->specialities->pluck('skill')->implode(', ') }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Experience:</strong>
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $employee->specialities->pluck('pivot.years_of_experience')->implode(', ') }} years
                        </span>
                    </p>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-400 italic">No specialities added</p>
                @endif
            </div>

            <!-- Card Footer (Actions) -->
            <div class="p-4 bg-gray-50 dark:bg-gray-900 flex justify-between space-x-2 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <a href="{{ route('admin.employees.show', $employee) }}"
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded text-sm text-center transition">
                   View
                </a>
                <a href="{{ route('admin.employees.edit', $employee) }}"
                   class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-3 rounded text-sm text-center transition">
                   Edit
                </a>
                <form action="{{ route('admin.employees.destroy', $employee) }}"
                      method="POST"
                      class="flex-1"
                      onsubmit="return confirm('Are you sure you want to delete {{ addslashes($employee->name) }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-10">
            <p class="text-gray-500 dark:text-gray-400 text-lg">No doctors found.</p>
        </div>
    @endforelse
</div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $employees->links() }}
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.4s ease-out; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = '{{ session('success') }}';
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        @endif
    });
</script>
@endsection
