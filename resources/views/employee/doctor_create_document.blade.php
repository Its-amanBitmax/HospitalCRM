@extends('layouts.doctor-dashboard')

@section('content')
<div class="min-h-screen p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Upload Document - {{ $user->full_name }}</h1>
        <a href="{{ route('employee.users.summary', $user->id) }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Back</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border">
        <form action="{{ route('employee.users.documents.store', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Document Type *</label>
                 <select name="document_type" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" required>
                <option value="">Select Document Type</option>
                <option value="Medical Report">Medical Report</option>
                <option value="Prescription">Prescription</option>
                <option value="Lab Report">Lab Report</option>
                <option value="X-Ray">X-Ray</option>
                <option value="MRI">MRI</option>
                <option value="CT Scan">CT Scan</option>
                <option value="Other">Other</option>
              </select></div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Choose Document *</label>
                <input type="file" name="document" required class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Upload Document</button>
            </div>
        </form>
    </div>
</div>
@endsection
