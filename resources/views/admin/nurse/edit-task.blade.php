@extends('layouts.layout')

@section('content')
<div class="min-h-screen">

    {{-- Success --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h1 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">
            Edit Nurse Tasks
        </h1>

        <form action="{{ route('nurse.task.update', $task->id) }}" method="POST">
            @csrf

            {{-- ================= COMMON DATES ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="font-medium text-gray-600">Start Date</label>
                    <input type="date" name="start_date"
                        value="{{ $tasks->first()->start_date }}"
                        class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                </div>

                <div>
                    <label class="font-medium text-gray-600">End Date</label>
                    <input type="date" name="end_date"
                        value="{{ $tasks->first()->end_date }}"
                        class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                </div>
            </div>

            {{-- ================= TASKS ================= --}}
            <h2 class="text-lg font-semibold mb-2">Tasks</h2>

            <div id="tasksContainer" class="space-y-4">

                @foreach($tasks as $i => $task)
                <div class="task-item border rounded-lg p-4 relative">

                    {{-- Add / Remove --}}
                    <div class="absolute top-2 right-2 flex gap-2">
                        <button type="button" class="add-task-btn text-blue-600 text-xl font-bold">+</button>
                        <button type="button" class="remove-task-btn text-red-600 text-xl font-bold">&times;</button>
                    </div>

                    {{-- 🔑 Hidden Task ID --}}
                    <input type="hidden" name="tasks[{{ $i }}][id]" value="{{ $task->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        {{-- User --}}
                        <div>
                            <label class="font-medium text-gray-600">User</label>
                            <select name="tasks[{{ $i }}][user_id]"
                                class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                                <option value="">Select</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $task->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Department --}}
                        <div>
                            <label class="font-medium text-gray-600">Department</label>
                            <select name="tasks[{{ $i }}][department_id]"
                                class="mt-1 p-2 border rounded w-full bg-gray-50">
                                <option value="">Select</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ $task->department_id == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Room --}}
                        <div>
                            <label class="font-medium text-gray-600">Room</label>
                            <select name="tasks[{{ $i }}][room_id]"
                                class="mt-1 p-2 border rounded w-full bg-gray-50">
                                <option value="">Select</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ $task->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_no }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nurse --}}
                        <div>
                            <label class="font-medium text-gray-600">Nurse</label>
                            <select name="tasks[{{ $i }}][nurse_id]"
                                class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                                <option value="">Select</option>
                                @foreach($nurses as $nurse)
                                    <option value="{{ $nurse->id }}"
                                        {{ $task->nurse_id == $nurse->id ? 'selected' : '' }}>
                                        {{ $nurse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Doctor --}}
                        <div>
                            <label class="font-medium text-gray-600">Doctor</label>
                            <select name="tasks[{{ $i }}][doctor_id]"
                                class="mt-1 p-2 border rounded w-full bg-gray-50">
                                <option value="">Select</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ $task->doctor_id == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Start Time --}}
                        <div>
                            <label class="font-medium text-gray-600">Start Time</label>
                            <input type="text" name="tasks[{{ $i }}][start_time]"
                                value="{{ $task->start_time }}"
                                class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                        </div>

                        {{-- End Time --}}
                        <div>
                            <label class="font-medium text-gray-600">End Time</label>
                            <input type="text" name="tasks[{{ $i }}][end_time]"
                                value="{{ $task->end_time }}"
                                class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                        </div>

                    </div>

                    {{-- Notes --}}
                    <div class="mt-4">
                        <label class="font-medium text-gray-600">Notes</label>
                        <textarea name="tasks[{{ $i }}][notes]"
                            class="mt-1 p-2 border rounded-lg w-full min-h-[90px]"
                            placeholder="Task details...">{{ $task->notes }}</textarea>
                    </div>

                </div>
                @endforeach

            </div>

            {{-- SAVE --}}
            <div class="mt-8 text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white shadow">
                    Update Tasks
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
let taskIndex = {{ $tasks->count() }};

document.addEventListener('click', function(e) {
    const container = document.getElementById('tasksContainer');

    // ADD TASK
    if (e.target.classList.contains('add-task-btn')) {
        const block = e.target.closest('.task-item');
        const clone = block.cloneNode(true);

        clone.querySelectorAll('select, textarea, input').forEach(el => {
            if (el.type !== 'hidden') el.value = '';
            el.name = el.name.replace(/\d+/, taskIndex);
        });

        // remove hidden id for new task
        const hiddenId = clone.querySelector('input[type="hidden"]');
        if (hiddenId) hiddenId.remove();

        container.appendChild(clone);
        taskIndex++;
    }

    // REMOVE TASK
    if (e.target.classList.contains('remove-task-btn')) {
        if (container.children.length > 1) {
            e.target.closest('.task-item').remove();
        } else {
            alert('At least one task is required');
        }
    }
});
</script>

@endsection
