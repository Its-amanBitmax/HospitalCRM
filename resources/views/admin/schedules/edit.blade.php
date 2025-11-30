@extends('layouts.layout')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Edit Schedule for Dr. {{ $employee->name }}
        </h2>
        <a href="{{ route('schedules.index', $employee) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to Schedules
        </a>
    </div>

    <form method="POST" action="{{ route('schedules.update', $schedule) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Date Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2"></i>Start Date
                </label>
                <input type="date" name="start_date" id="start_date" value="{{ $schedule->start_date }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                       required>
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2"></i>End Date
                </label>
                <input type="date" name="end_date" id="end_date" value="{{ $schedule->end_date }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                       required>
            </div>
        </div>

        <!-- Time Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clock mr-2"></i>Start Time
                </label>
                <input type="time" name="start_time" id="start_time" value="{{ $schedule->start_time }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       required>
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clock mr-2"></i>End Time
                </label>
                <input type="time" name="end_time" id="end_time" value="{{ $schedule->end_time }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                       required>
            </div>
        </div>

        <!-- Task Type -->
        <div>
            <label for="task_type" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-tasks mr-2"></i>Task Type
            </label>
            <select name="task_type" id="task_type"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                    required>
                <option value="">Select Task Type</option>
                @foreach(['Appointment', 'Consultation', 'OPD', 'IPD', 'Emergency', 'Room Duty', 'Other'] as $type)
                    <option value="{{ $type }}" {{ $schedule->task_type == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('schedules.index', $employee) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center transition duration-200">
                <i class="fas fa-save mr-2"></i>Update Schedule
            </button>
        </div>
    </form>
</div>
@endsection
