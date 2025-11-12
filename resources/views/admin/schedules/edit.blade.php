@extends('layouts.layout')

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">
        Edit Task for Dr. {{ $employee->name }}
    </h2>

    <form method="POST" action="{{ route('schedules.update', $schedule) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Start Date</label>
            <input type="date" name="start_date" value="{{ $schedule->start_date }}" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-gray-700 dark:text-gray-300">End Date</label>
            <input type="date" name="end_date" value="{{ $schedule->end_date }}" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Start Time</label>
            <input type="time" name="start_time" value="{{ $schedule->start_time }}" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-gray-700 dark:text-gray-300">End Time</label>
            <input type="time" name="end_time" value="{{ $schedule->end_time }}" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Task Type</label>
            <select name="task_type" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white" required>
                @foreach(['Appointment','Video Consultation','OPD','IPD','Emergency','Room Duty','Other'] as $type)
                    <option value="{{ $type }}" {{ $schedule->task_type == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-bold">
            Update Task
        </button>
    </form>
</div>
@endsection
