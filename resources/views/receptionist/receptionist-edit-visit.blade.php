@extends('layouts.receptionist')

@section('content')
<div class="min-h-screen">
  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-calendar-alt text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 ">Edit Patient Visit - {{ $user->full_name }}</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('visits.show', $user->id) }}" class="bg-white-600 hover:bg-white-700  px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Visits
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 ">
    <form id="editVisitForm" action="{{ route('visits.update', [$user->id, $visit->id]) }}" method="POST">
      @csrf
     

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Visit Type -->
        <div>
          <label for="visit_type" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Visit Type</label>
          <select id="visit_type" name="visit_type" class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700" required>
            <option value="">Select Visit Type</option>
            <option value="Checkup" {{ $visit->visit_type == 'Checkup' ? 'selected' : '' }}>Checkup</option>
            <option value="Test" {{ $visit->visit_type == 'Test' ? 'selected' : '' }}>Test</option>
            <option value="Emergency" {{ $visit->visit_type == 'Emergency' ? 'selected' : '' }}>Emergency</option>
            <option value="Follow-up" {{ $visit->visit_type == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
            <option value="Other" {{ $visit->visit_type == 'Other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>

        <!-- Date of Visit -->
        <div>
          <label for="date_of_visit" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Date of Visit</label>
          <input type="date" id="date_of_visit" name="date_of_visit" value="{{ $visit->date_of_visit ? $visit->date_of_visit->format('Y-m-d') : '' }}" class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700" required>
        </div>

        <!-- Chief Complaint -->
        <div class="md:col-span-2">
          <label for="chief_complaint" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Chief Complaint</label>
          <textarea id="chief_complaint" name="chief_complaint" rows="3" class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700 " placeholder="Enter chief complaint">{{ $visit->chief_complaint }}</textarea>
        </div>

        <!-- Referred By -->
        <div>
    <label for="referred_by" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">
        Referred By
    </label>

    <select id="referred_by" name="referred_by"
        class="w-full px-3 py-2 border border-gray-300  rounded-lg 
               focus:ring-blue-500 focus:border-blue-500 bg-white-700 ">

        <option value="" disabled>Select Reception</option>

        @foreach ($receptions as $reception)
            <option value="{{ $reception->id }}" {{ $visit->referred_by == $reception->id ? 'selected' : '' }}>
                {{ $reception->reception_id }}
            </option>
        @endforeach

    </select>
</div>


        <!-- Department/Consultant -->
        <div>
    <label for="department_consultant" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">
        Department/Consultant
    </label>

    <select id="department_consultant" name="department_consultant"
        class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700 ">
        <option value="" disabled>Select Room / Consultant</option>

        @foreach($assignedRooms as $item)
            <option value="{{ $item->id }}" {{ $visit->department_consultant == $item->id ? 'selected' : '' }}>
                {{ $item->room->room_id ?? 'N/A' }} — {{ $item->employee->name ?? 'N/A' }}
            </option>
        @endforeach
    </select>
</div>


      </div>

      <!-- Submit Button -->
      <div class="mt-6 flex justify-end gap-4">
        <a href="{{ route('admin.users.visits', $user->id) }}" class="bg-white-300 hover:bg-white-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200">
          Cancel
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
          Update Visit
        </button>
      </div>
    </form>
  </div>
</div>


@endsection
