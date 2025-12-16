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

            <h2 class="text-2xl font-semibold mb-6 border-b pb-3">Edit Nurse Tasks</h2>

            <form action="{{ route('nurse.task.update', $tasks->first()->id) }}" method="POST">
                @csrf

                {{-- ================= COMMON DATES ================= --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date"
                               value="{{ $tasks->first()->start_date }}"
                               class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date"
                               value="{{ $tasks->first()->end_date }}"
                               class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                    </div>
                </div>

                {{-- ================= TASKS ================= --}}
                <h3 class="text-lg font-semibold mb-3">Tasks</h3>

                <div id="tasksContainer" class="space-y-4">

                    @foreach($tasks as $i => $task)
                    <div class="task-item border rounded-lg p-4 relative bg-gray-50">

                        {{-- Add / Remove Buttons --}}
                        <div class="absolute top-2 right-2 flex gap-2">
                            <button type="button" class="add-task-btn text-blue-600 text-xl font-bold hover:text-blue-800">+</button>
                            <button type="button" class="remove-task-btn text-red-600 text-xl font-bold hover:text-red-800">&times;</button>
                        </div>

                        {{-- Hidden Task ID --}}
                        <input type="hidden" name="tasks[{{ $i }}][id]" value="{{ $task->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                            {{-- User --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">User</label>
                                <select name="tasks[{{ $i }}][user_id]" class="w-full border p-2 rounded bg-white" required>
                                    <option value="">Select</option>
                                    @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ $task->user_id==$u->id?'selected':'' }}>{{ $u->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Department --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Department</label>
                                <select name="tasks[{{ $i }}][department_id]" class="w-full border p-2 rounded bg-white">
                                    <option value="">Select</option>
                                    @foreach($departments as $d)
                                    <option value="{{ $d->id }}" {{ $task->department_id==$d->id?'selected':'' }}>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Room --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Room</label>
                                <select name="tasks[{{ $i }}][room_id]" class="w-full border p-2 rounded bg-white">
                                    <option value="">Select</option>
                                    @foreach($rooms as $r)
                                    <option value="{{ $r->id }}" {{ $task->room_id==$r->id?'selected':'' }}>{{ $r->room_no }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nurse --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Nurse</label>
                                <select name="tasks[{{ $i }}][nurse_id]" class="w-full border p-2 rounded bg-white" required>
                                    <option value="">Select</option>
                                    @foreach($nurses as $n)
                                    <option value="{{ $n->id }}" {{ $task->nurse_id==$n->id?'selected':'' }}>{{ $n->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Doctor --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Doctor</label>
                                <select name="tasks[{{ $i }}][doctor_id]" class="w-full border p-2 rounded bg-white">
                                    <option value="">Select</option>
                                    @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}" {{ $task->doctor_id==$doc->id?'selected':'' }}>{{ $doc->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Start Time --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">Start Time</label>
                                <select name="tasks[{{ $i }}][start_time]" class="w-full border p-2 rounded bg-white" required>
                                    <option value="">Select</option>
                                    @for($h = 0; $h < 24; $h++)
                                        @for($m = 0; $m < 60; $m += 30)
                                            @php $time = sprintf("%02d:%02d", $h, $m); @endphp
                                            <option value="{{ $time }}" {{ $task->start_time==$time?'selected':'' }}>{{ $time }}</option>
                                        @endfor
                                    @endfor
                                </select>
                            </div>

                            {{-- End Time --}}
                            <div>
                                <label class="block font-medium text-gray-700 mb-1">End Time</label>
                                <select name="tasks[{{ $i }}][end_time]" class="w-full border p-2 rounded bg-white" required>
                                    <option value="">Select</option>
                                    @for($h = 0; $h < 24; $h++)
                                        @for($m = 0; $m < 60; $m += 30)
                                            @php $time = sprintf("%02d:%02d", $h, $m); @endphp
                                            <option value="{{ $time }}" {{ $task->end_time==$time?'selected':'' }}>{{ $time }}</option>
                                        @endfor
                                    @endfor
                                </select>
                            </div>

                        </div>

                        {{-- Notes --}}
                        <div class="mt-4">
                            <label class="block font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="tasks[{{ $i }}][notes]" class="w-full border p-2 rounded bg-white" placeholder="Task details...">{{ $task->notes }}</textarea>
                        </div>

                    </div>
                    @endforeach

                </div>

                {{-- Submit --}}
                <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                        Update Tasks
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
let taskIndex = {{ $tasks->count() }};

document.addEventListener('click', e => {
    const container = document.getElementById('tasksContainer');

    // ADD TASK
    if (e.target.classList.contains('add-task-btn')) {
        const clone = e.target.closest('.task-item').cloneNode(true);

        clone.querySelectorAll('input, select, textarea').forEach(el => {
            if(el.type !== 'hidden') el.value = '';
            el.name = el.name.replace(/\d+/, taskIndex);
        });

        clone.querySelector('input[type="hidden"]')?.remove();
        container.appendChild(clone);
        taskIndex++;
    }

    // REMOVE TASK
    if (e.target.classList.contains('remove-task-btn')) {
        if(container.children.length > 1) {
            e.target.closest('.task-item').remove();
        } else {
            alert('At least one task is required');
        }
    }
});
</script>
@endsection
