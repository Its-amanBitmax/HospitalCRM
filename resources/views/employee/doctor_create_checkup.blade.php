@extends('layouts.doctor-dashboard')

@section('content')
<div class="min-h-screen p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-stethoscope text-2xl text-blue-600"></i>
            <h1 class="text-xl font-semibold">Add New Checkup - {{ $user->full_name }}</h1>
        </div>
        <a href="{{ route('employee.doctor_patients') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-1"></i>Back
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
        <form action="{{ route('employee.users.checkups.store', $user->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">Associated Visit</label>
                    <select name="visit_id" class="block w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
                        <option value="">Select Visit (Optional)</option>
                        @foreach($visits as $visit)
                            <option value="{{ $visit->id }}">
                                {{ $visit->date_of_visit?->format('d-m-Y') }} - {{ $visit->visit_type }} - {{ $visit->chief_complaint ?? 'No complaint' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Checkup Date *</label>
                    <input type="date" name="checkup_date" required class="block w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Diagnosis</label>
                    <textarea name="diagnosis" rows="3" class="block w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300" placeholder="Enter diagnosis"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Treatment</label>
                    <textarea name="treatment" rows="3" class="block w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300" placeholder="Enter treatment"></textarea>
                </div>

            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-1"></i>Save Checkup
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
