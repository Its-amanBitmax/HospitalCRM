@extends('layouts.layout')

@section('content')
<div class="max-w-lg mx-auto bg-white bg-white-800 p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 text-black">
        Add Task for Dr. {{ $employee->name }}
    </h2>

    <!-- Show all shifts -->
    @if($shifts->isNotEmpty())
        <div class="bg-blue-50 border border-blue-300 text-blue-800 px-4 py-2 rounded mb-4">
            <strong>Doctor Shifts:</strong><br>
            @foreach($shifts as $shift)
                🕒 {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}<br>
            @endforeach
        </div>
    @else
        <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-2 rounded mb-4">
            ⚠️ This doctor does not have any shift assigned.
        </div>
    @endif

    @php
    function formatAmPm($time) {
        return date("h:i A", strtotime($time));
    }

    $shiftTimes = [];
    if ($shifts->isNotEmpty()) {
        foreach ($shifts as $shift) {
            $start = strtotime($shift->start_time);
            $end = strtotime($shift->end_time);

            // Handle overnight shifts
            if ($end < $start) {
                $end += 86400; // Add 24 hours
            }

            for ($time = $start; $time <= $end; $time += 1800) { // 30 minutes
                $timeStr = date("H:i", $time % 86400); // Modulo to handle overnight
                $shiftTimes[] = $timeStr;
            }
        }
        $shiftTimes = array_unique($shiftTimes);
        sort($shiftTimes);
    }
    @endphp

    <form method="POST" action="{{ route('schedules.store', $employee) }}" id="taskForm">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-gray-300 mb-1">Start Date</label>
            <input type="date" name="start_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white-700 text-black" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-gray-300 mb-1">End Date</label>
            <input type="date" name="end_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white-700 text-black" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-gray-300 mb-1">Start Time</label>
            <select name="start_time" id="start_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white-700 text-black" required>
                <option value="">Select Start Time</option>
                @foreach($shiftTimes as $time)
                <option value="{{ $time }}" {{ old('start_time') == $time ? 'selected' : '' }}>
                    {{ formatAmPm($time) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-gray-300 mb-1">End Time</label>
            <select name="end_time" id="end_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white-700 text-black" required>
                <option value="">Select End Time</option>
                @foreach($shiftTimes as $time)
                <option value="{{ $time }}" {{ old('end_time') == $time ? 'selected' : '' }}>
                    {{ formatAmPm($time) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-gray-300 mb-1">Task Type</label>
            <select name="task_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white-700 text-black" required>
                <option value="">Select Task</option>
                <option value="Appointment">Appointment</option>
                <option value="consultation">consultation</option>
                <option value="OPD">OPD</option>
                <option value="IPD">IPD</option>
                <option value="Emergency">Emergency</option>
                <option value="Room Duty">Room Duty</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <p id="shiftError" class="text-red-600 text-sm mb-4 hidden"></p>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-bold">
            Save Task
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('taskForm');
    const startInput = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');
    const errorText = document.getElementById('shiftError');

    // Pass only the time part (HH:MM) from backend to match select values
    const shifts = @json($shifts->map(fn($s) => [
        'start' => \Carbon\Carbon::parse($s->start_time)->format('H:i'),
        'end'   => \Carbon\Carbon::parse($s->end_time)->format('H:i'),
    ]));

    function toMinutes(timeStr) {
        const [h, m] = timeStr.split(':').map(Number);
        return h * 60 + m;
    }

    // Format time as 03:00 AM for display
    function formatDisplay(timeStr) {
        const date = new Date(`2025-01-01 ${timeStr}:00`);
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
    }

    // Properly check if [taskStart, taskEnd] is fully within a shift
    function isTaskWithinShift(taskStartMin, taskEndMin, shiftStartMin, shiftEndMin) {
        const shiftDuration = shiftEndMin >= shiftStartMin 
            ? shiftEndMin - shiftStartMin 
            : (1439 - shiftStartMin) + shiftEndMin + 1; // overnight

        // Normal shift (non-overnight)
        if (shiftEndMin >= shiftStartMin) {
            return taskStartMin >= shiftStartMin && taskEndMin <= shiftEndMin;
        }
        // Overnight shift
        else {
            return (taskStartMin >= shiftStartMin || taskStartMin <= shiftEndMin) &&
                   (taskEndMin >= shiftStartMin || taskEndMin <= shiftEndMin);
        }
    }

    form.addEventListener('submit', function (e) {
        if (shifts.length === 0) {
            e.preventDefault();
            errorText.classList.remove('hidden');
            errorText.textContent = '⚠️ This doctor has no assigned shifts.';
            return;
        }

        const taskStartMin = toMinutes(startInput.value);
        const taskEndMin = toMinutes(endInput.value);

        // Optional: prevent end before start unless overnight shift exists — but for simplicity allow it if within any shift
        let fits = false;

        for (const shift of shifts) {
            const sStart = toMinutes(shift.start);
            const sEnd = toMinutes(shift.end);

            if (isTaskWithinShift(taskStartMin, taskEndMin, sStart, sEnd)) {
                fits = true;
                break;
            }
        }

        if (!fits) {
            e.preventDefault();
            errorText.classList.remove('hidden');
            const shiftDisplay = shifts.map(s => 
                `${formatDisplay(s.start)}–${formatDisplay(s.end)}`
            ).join(', ');
            errorText.textContent = `⚠️ Task timing must be within one of the doctor’s shifts: ${shiftDisplay}`;
        } else {
            errorText.classList.add('hidden');
        }
    });
});
</script>

@endsection