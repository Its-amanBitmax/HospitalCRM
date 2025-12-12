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
            Edit Nurse Task
        </h1>

        <form action="{{ route('nurse.task.update', $task->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Department --}}
                <div>
                    <label class="text-gray-600 font-medium">Department</label>
                    <select name="department_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $task->department_id==$dept->id?'selected':'' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Room --}}
                <div>
                    <label class="text-gray-600 font-medium">Room</label>
                    <select name="room_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $task->room_id==$room->id?'selected':'' }}>{{ $room->room_no }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nurse --}}
                <div>
                    <label class="text-gray-600 font-medium">Nurse</label>
                    <select name="nurse_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50" required>
                        <option value="">Select Nurse</option>
                        @foreach($nurses as $nurse)
                        <option value="{{ $nurse->id }}" {{ $task->nurse_id==$nurse->id?'selected':'' }}>{{ $nurse->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Doctor --}}
                <div>
                    <label class="text-gray-600 font-medium">Doctor</label>
                    <select name="doctor_id" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $task->doctor_id==$doctor->id?'selected':'' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="text-gray-600 font-medium">Status</label>
                    <select name="status" class="mt-1 p-3 border rounded-lg w-full bg-gray-50">
                        <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
                        <option value="in-progress" {{ $task->status=='in-progress'?'selected':'' }}>In Progress</option>
                        <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>
                    </select>
                </div>

            </div>

            {{-- Dates and Notes --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="text-gray-600 font-medium">Start Date</label>
                    <input type="date" name="start_date" class="mt-1 p-2 border rounded-lg w-full" value="{{ $task->start_date }}">
                </div>

                <div>
                    <label class="text-gray-600 font-medium">End Date</label>
                    <input type="date" name="end_date" class="mt-1 p-2 border rounded-lg w-full" value="{{ $task->end_date }}">
                </div>
            </div>

            <div class="mt-4">
                <label class="text-gray-600 font-medium">Notes</label>
                <textarea name="notes" class="mt-1 p-2 border rounded-lg w-full min-h-[100px]" placeholder="Add details..." required>{{ $task->notes }}</textarea>
            </div>

            <div class="mt-8 text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white shadow">
                    Update Task
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
