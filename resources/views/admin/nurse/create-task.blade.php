@extends('layouts.layout')

@section('content')
<div class="min-h-screen ">

    <div class="max-w-6xl mx-auto">

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white p-8 shadow-lg rounded-lg">

            <h2 class="text-2xl font-semibold mb-6 border-b pb-3">Create Nurse Task</h2>

            <form action="{{ route('nurse.task.save') }}" method="POST">
                @csrf

                {{-- ================= COMMON DATES ================= --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date"
                            class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date"
                            class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                    </div>
                </div>

                {{-- ================= TASKS ================= --}}
                <h3 class="text-lg font-semibold mb-3">Tasks</h3>

                <div id="tasksContainer" class="space-y-4">

                    {{-- TASK BLOCK --}}
                    <div class="task-item border rounded-lg p-4 relative bg-gray-50">

                        {{-- Add / Remove --}}
                        <div class="absolute top-2 right-2 flex gap-2">
                            <button type="button" class="add-task-btn text-blue-600 text-xl font-bold hover:text-blue-800">+</button>
                            <button type="button" class="remove-task-btn text-red-600 text-xl font-bold hover:text-red-800">&times;</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                            {{-- User --}}
                            <div>
                                <label class="font-medium text-gray-600">User</label>
                                <select name="tasks[0][user_id]" class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                                    <option value="">Select</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Department --}}
                            <div>
                                <label class="font-medium text-gray-600">Department</label>
                                <select name="tasks[0][department_id]" class="mt-1 p-2 border rounded w-full bg-gray-50">
                                    <option value="">Select</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Room --}}
                            <div>
                                <label class="font-medium text-gray-600">Room</label>
                                <select name="tasks[0][room_id]" class="mt-1 p-2 border rounded w-full bg-gray-50">
                                    <option value="">Select</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->room_no }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nurse --}}
                            <div>
                                <label class="font-medium text-gray-600">Nurse</label>
                                <select name="tasks[0][nurse_id]" class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                                    <option value="">Select</option>
                                    @foreach($nurses as $nurse)
                                        <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Doctor --}}
                            <div>
                                <label class="font-medium text-gray-600">Doctor</label>
                                <select name="tasks[0][doctor_id]" class="mt-1 p-2 border rounded w-full bg-gray-50">
                                    <option value="">Select</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Start Time --}}
                            <div>
                                <label class="font-medium text-gray-600">Start Time</label>
                                <select name="tasks[0][start_time]" class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                                    <option value="">Select</option>
                                    @for($i=0; $i<24; $i++)
                                        @php
                                            $hour = $i % 12 == 0 ? 12 : $i % 12;
                                            $ampm = $i < 12 ? 'AM' : 'PM';
                                            $t = sprintf('%02d:00', $hour) . ' ' . $ampm;
                                        @endphp
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- End Time --}}
                            <div>
                                <label class="font-medium text-gray-600">End Time</label>
                                <select name="tasks[0][end_time]" class="mt-1 p-2 border rounded w-full bg-gray-50" required>
                                    <option value="">Select</option>
                                    @for($i=0; $i<24; $i++)
                                        @php
                                            $hour = $i % 12 == 0 ? 12 : $i % 12;
                                            $ampm = $i < 12 ? 'AM' : 'PM';
                                            $t = sprintf('%02d:00', $hour) . ' ' . $ampm;
                                        @endphp
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>

                        {{-- Add-ons Section (Above Notes) --}}
                        <div class="mt-4">
                            <label class="font-medium text-gray-600">Task Name</label>
                            <input type="text" name="tasks[0][task_name]" class="mt-1 p-2 border rounded-lg w-full bg-gray-50" placeholder="Task name...">
                        </div>

                        {{-- Notes --}}
                        <div class="mt-4">
                            <label class="font-medium text-gray-600">Notes</label>
                            <textarea name="tasks[0][notes]" class="mt-1 p-2 border rounded-lg w-full min-h-[90px]" placeholder="Task details..." required></textarea>
                        </div>

                    </div>
                </div>

                {{-- SAVE --}}
                <div class="mt-8 text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white shadow">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
let taskIndex = 1;

document.addEventListener('click', function(e) {
    const container = document.getElementById('tasksContainer');

    // ADD
    if (e.target.classList.contains('add-task-btn')) {
        const block = e.target.closest('.task-item');
        const clone = block.cloneNode(true);

        clone.querySelectorAll('select, textarea, input[type="text"]').forEach(el => {
            el.name = el.name.replace(/\d+/, taskIndex);
            el.value = '';
        });

        container.appendChild(clone);
        taskIndex++;
    }

    // REMOVE
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
