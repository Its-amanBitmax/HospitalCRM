@extends('layouts.doctor-dashboard')

@section('content')
<div class="min-h-screen p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Patient Reports</h1>
        <a href="{{ route('employee.doctor_patients') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    @if($reports->isEmpty())
        <div class="p-6 text-center text-gray-500">
            <i class="fas fa-file-alt text-4xl mb-3"></i>
            <p>No reports available for your patients.</p>
        </div>
    @else
        <table class="w-full bg-white rounded-lg shadow overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Patient Name</th>
                    <th class="px-6 py-3 text-left">Document Type</th>
                    <th class="px-6 py-3 text-left">Uploaded On</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ optional($report->user)->full_name ?? 'N/A' }}</td>
                    <td class="px-6 py-3">{{ $report->document_type }}</td>
                    <td class="px-6 py-3">{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</td>
                    <td class="px-6 py-3 flex gap-3">
                        <!-- View Document -->
                        <a href="{{ asset('storage/' . $report->document_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Delete Document -->
                        <form action="{{ route('employee.users.documents.delete', [$report->user_id, $report->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
