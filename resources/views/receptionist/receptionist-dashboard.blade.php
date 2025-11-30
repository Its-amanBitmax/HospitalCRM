@extends('layouts.receptionist')

@section('content')
<div class="p-6 min-h-screen bg-gray-100">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Receptionists Dashboard</h1>

    </div>

    <!-- Receptionist Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($receptions as $reception)
        <div class="bg-white shadow-md rounded-lg p-4 flex items-center gap-4">
            <img src="{{ $reception->employee && $reception->employee->image 
           ? asset('storage/'.$reception->employee->image) 
           : asset('image/default.png') }}"
                alt="Profile"
                class="w-16 h-16 rounded-full object-cover border">

            <div>
                <h3 class="font-semibold text-gray-800">{{ $reception->employee->name ?? 'N/A' }}</h3>
                <p class="text-gray-500 text-sm">{{ $reception->employee->email ?? 'N/A' }}</p>
                <p class="text-gray-500 text-sm">{{ $reception->employee->phone ?? 'N/A' }}</p>
            </div>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">No receptionists found.</p>
        @endforelse
    </div>

</div>
@endsection