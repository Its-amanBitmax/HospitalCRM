@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-stethoscope text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800">Edit Patient Checkup - {{ $user->full_name }}</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.users.visits', $user->id) }}" class="bg-white-600 hover:bg-white-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Visits
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 ">
    <form id="editCheckupForm" action="{{ route('admin.users.checkups.update', [$user->id, $checkup->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 gap-6">
        <!-- Associated Visit -->
        <div>
          <label for="visit_id" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Associated Visit</label>
          <select id="visit_id" name="visit_id" class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700 ">
            <option value="">Select Visit (Optional)</option>
            @foreach($visits as $visit)
            <option value="{{ $visit->id }}" {{ $checkup->visit_id == $visit->id ? 'selected' : '' }}>
              {{ $visit->date_of_visit ? $visit->date_of_visit->format('d-m-Y') : 'N/A' }} - {{ $visit->visit_type }} - {{ $visit->chief_complaint ?: 'No complaint' }}
            </option>
            @endforeach
          </select>
        </div>

        <!-- Checkup Date -->
        <div>
          <label for="checkup_date" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Checkup Date</label>
          <input type="date" id="checkup_date" name="checkup_date" value="{{ $checkup->checkup_date ? $checkup->checkup_date->format('Y-m-d') : '' }}" class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700 " required>
        </div>

        <!-- Diagnosis -->
        <div>
          <label for="diagnosis" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Diagnosis</label>
          <textarea id="diagnosis" name="diagnosis" rows="3" class="w-full px-3 py-2 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700 " placeholder="Enter diagnosis">{{ $checkup->diagnosis }}</textarea>
        </div>

        <!-- Treatment -->
        <div>
          <label for="treatment" class="block text-sm font-medium text-gray-700 text-gray-300 mb-2">Treatment</label>
          <textarea id="treatment" name="treatment" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white-700 " placeholder="Enter treatment">{{ $checkup->treatment }}</textarea>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mt-6 flex justify-end gap-4">
        <a href="{{ route('admin.users.visits', $user->id) }}" class="bg-white-300 hover:bg-white-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200">
          Cancel
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
          Update Checkup
        </button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('editCheckupForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch(this.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      window.location.href = '{{ route("admin.users.visits", $user->id) }}';
    } else {
      alert('An error occurred while updating the checkup.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while updating the checkup.');
  });
});
</script>
@endsection
