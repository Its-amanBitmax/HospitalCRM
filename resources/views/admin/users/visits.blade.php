@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-calendar-alt text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Patient Visits & Records - {{ $user->full_name }}</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.users.show', $user->id) }}" class="bg-gray-600 hover:bg-gray-700 text-dark px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Profile
      </a>
    </div>
  </div>

  <!-- Tabs -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="mb-6">
      <nav class="flex space-x-4" aria-label="Tabs">
        <button onclick="showTab('visits')" id="visits-tab" class="tab-button active bg-blue-600 text-dark px-4 py-2 rounded-lg">
          <i class="fas fa-calendar mr-2"></i>Visits
        </button>
        <button onclick="showTab('checkups')" id="checkups-tab" class="tab-button bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
          <i class="fas fa-stethoscope mr-2"></i>Checkups
        </button>
        <button onclick="showTab('documents')" id="documents-tab" class="tab-button bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
          <i class="fas fa-file-medical mr-2"></i>Documents
        </button>
      </nav>
    </div>

    <!-- Visits Tab -->
    <div id="visits-content" class="tab-content">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Patient Visits</h2>
        <a href="{{ route('admin.users.visits.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-plus mr-2"></i>Add Visit
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Visit Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Chief Complaint</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Referred By</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department/Consultant</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($visits as $visit)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->visit_type }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->date_of_visit ? $visit->date_of_visit->format('d-m-Y') : '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $visit->chief_complaint ?: '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->referred_by ?: '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->department_consultant ?: '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-blue-600 hover:text-blue-900 mr-2">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No visits found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Checkups Tab -->
    <div id="checkups-content" class="tab-content hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Patient Checkups</h2>
        <a href="{{ route('admin.users.checkups.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-plus mr-2"></i>Add Checkup
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Checkup Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diagnosis</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Treatment</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($checkups as $checkup)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $checkup->checkup_date ? $checkup->checkup_date->format('d-m-Y') : '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $checkup->diagnosis ?: '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $checkup->treatment ?: '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-blue-600 hover:text-blue-900 mr-2">Edit</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No checkups found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Documents Tab -->
    <div id="documents-content" class="tab-content hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Patient Documents</h2>
        <a href="{{ route('admin.users.documents.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-plus mr-2"></i>Add Document
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Document Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">File</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Uploaded Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($documents as $document)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $document->document_type }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                <a href="/{{ $document->document_path }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ basename($document->document_path) }}</a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $document->created_at ? $document->created_at->format('d-m-Y H:i') : '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-blue-600 hover:text-blue-900 mr-2">Download</button>
                <button class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No documents found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function showTab(tabName) {
  // Hide all tab contents
  document.getElementById('visits-content').classList.add('hidden');
  document.getElementById('checkups-content').classList.add('hidden');
  document.getElementById('documents-content').classList.add('hidden');

  // Remove active class from all tabs
  document.getElementById('visits-tab').classList.remove('active', 'bg-blue-600', 'text-white');
  document.getElementById('visits-tab').classList.add('bg-gray-200', 'text-gray-700');
  document.getElementById('checkups-tab').classList.remove('active', 'bg-blue-600', 'text-white');
  document.getElementById('checkups-tab').classList.add('bg-gray-200', 'text-gray-700');
  document.getElementById('documents-tab').classList.remove('active', 'bg-blue-600', 'text-white');
  document.getElementById('documents-tab').classList.add('bg-gray-200', 'text-gray-700');

  // Show selected tab content
  document.getElementById(tabName + '-content').classList.remove('hidden');

  // Add active class to selected tab
  document.getElementById(tabName + '-tab').classList.remove('bg-gray-200', 'text-gray-700');
  document.getElementById(tabName + '-tab').classList.add('active', 'bg-blue-600', 'text-white');
}
</script>
@endsection
