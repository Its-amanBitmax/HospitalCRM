@extends('layouts.layout')

@section('content')

<div class="min-h-screen">

    @if (session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
        <ul class="list-disc ml-4">
            @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-8">

        <h1 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">
            Create Nurse Task
        </h1>

        <form action="{{ route('nurse.task.save') }}" method="POST" id="taskForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Department --}}
                <div>
                    <label class="text-gray-600 font-medium">Department (optional)</label>
                    <select name="department_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Room --}}
                <div>
                    <label class="text-gray-600 font-medium">Room (optional)</label>
                    <select name="room_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_no }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nurse --}}
                <div>
                    <label class="text-gray-600 font-medium">Nurse</label>
                    <select name="nurse_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                        <option value="">Select Nurse</option>
                        @foreach($nurses as $nurse)
                        <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Doctor --}}
                <div>
                    <label class="text-gray-600 font-medium">Doctor (optional)</label>
                    <select name="doctor_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <h2 class="mt-6 text-lg font-semibold">Tasks</h2>

            <div id="tasksContainer" class="space-y-4 mt-2">

                {{-- Initial Task Block --}}
                <div class="task-item border rounded-lg p-4 relative">

                    <!-- {{-- Add/Remove Buttons --}}
                    <div class="absolute top-2 right-2 flex gap-1">
                        <button type="button" class="text-blue-500 font-bold text-xl add-task-btn">+</button>
                        <button type="button" class="text-red-500 font-bold text-xl remove-task-btn">&times;</button>
                    </div> -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-600 font-medium">Start Date</label>
                            <input type="date" name="tasks[0][start_date]" class="mt-1 p-2 border rounded-lg w-full">
                        </div>

                        <div>
                            <label class="text-gray-600 font-medium">End Date</label>
                            <input type="date" name="tasks[0][end_date]" class="mt-1 p-2 border rounded-lg w-full">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="text-gray-600 font-medium">Notes</label>
                        <textarea name="tasks[0][notes]" class="mt-1 p-2 border rounded-lg w-full min-h-[100px]" placeholder="Add details..." required></textarea>
                    </div>

                </div>

            </div>

            <div class="mt-8 text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white shadow">
                    Save
                </button>
            </div>

        </form>

    </div>
</div>

<!-- <script>
    let taskIndex = 1; // next task index

    document.addEventListener('click', function(e) {
        const container = document.getElementById('tasksContainer');

        // Add new task
        if(e.target && e.target.classList.contains('add-task-btn')) {
            const newTask = e.target.closest('.task-item').cloneNode(true);

            // Update inputs and textareas
            newTask.querySelectorAll('input, textarea').forEach(function(input) {
                const name = input.getAttribute('name');
                const newName = name.replace(/\d+/, taskIndex);
                input.setAttribute('name', newName);
                input.value = ''; // clear previous value
            });

            container.appendChild(newTask);
            taskIndex++;
        }

        // Remove task
        // if(e.target && e.target.classList.contains('remove-task-btn')) {
        //     const taskItem = e.target.closest('.task-item');
        //     if(container.children.length > 1) { 
        //         taskItem.remove();
        //     } else {
        //         alert('At least one task is required.');
        //     }
        // }
    });
</script> -->

@endsection