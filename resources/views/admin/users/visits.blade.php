@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
  @if(session('success'))
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
  </div>
  @endif

  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-calendar-alt text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 text-white">Patient Visits & Records - {{ $user->full_name }}</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.users.show', $user->id) }}" class="bg-white-200 hover:bg-white-300 text-gray-900 px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Profile
      </a>
    </div>
  </div>

  <!-- Tabs -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 border-gray-700">
    <div class="mb-6">
      <nav class="flex flex-wrap gap-2" aria-label="Tabs">
        @if($user->type !== 'ipd')
        <button onclick="showTab('visits')" id="visits-tab" class="tab-button px-4 py-2 rounded-lg flex items-center gap-2 transition">
          <i class="fas fa-calendar"></i> Visits
        </button>
        @endif
        <button onclick="showTab('checkups')" id="checkups-tab" class="tab-button px-4 py-2 rounded-lg flex items-center gap-2 transition">
          <i class="fas fa-stethoscope"></i> Checkups
        </button>
        <button onclick="showTab('documents')" id="documents-tab" class="tab-button px-4 py-2 rounded-lg flex items-center gap-2 transition">
          <i class="fas fa-file-medical"></i> Documents
        </button>
        <button onclick="showTab('summary')" id="summary-tab" class="tab-button px-4 py-2 rounded-lg flex items-center gap-2 transition">
          <i class="fas fa-clipboard-list"></i> Summary
        </button>
      </nav>
    </div>

    <!-- Visits Tab -->
    <div id="visits-content" class="tab-content hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 text-white">Patient Visits</h2>
        <a href="{{ route('admin.users.visits.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i class="fas fa-plus"></i> Add Visit
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white bg-white-800 border border-gray-200 border-gray-700">
          <thead class="bg-white-50 bg-white-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Visit Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Chief Complaint</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Referred By</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Department/Consultant</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white bg-white-800 divide-y divide-gray-200 divide-gray-700">
            @forelse($visits as $visit)
            <tr class="hover:bg-white-50 hover:bg-white-700">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->visit_type }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->date_of_visit?->format('d-m-Y') ?? '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-900 text-white">{{ $visit->chief_complaint ?: '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->reception?->reception_id ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->consultantAssignment?->room?->room_id ?? '-' }} —
                {{ $visit->consultantAssignment?->employee?->name ?? '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                <a href="{{ route('admin.users.visits.edit', [$user->id, $visit->id]) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                <form action="{{ route('admin.users.visits.destroy', [$user->id, $visit->id]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this visit?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-gray-400">No visits found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Checkups Tab -->
    <div id="checkups-content" class="tab-content hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 text-white">Patient Checkups</h2>
        <a href="{{ route('admin.users.checkups.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i class="fas fa-plus"></i> Add Checkup
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white bg-white-800 border border-gray-200 border-gray-700">
          <thead class="bg-white-50 bg-white-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Checkup Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Associated Visit</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Diagnosis</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Treatment</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white bg-white-800 divide-y divide-gray-200 divide-gray-700">
            @forelse($checkups as $checkup)
            <tr class="hover:bg-white-50 hover:bg-white-700">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $checkup->checkup_date?->format('d-m-Y') ?? '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">
                @if($checkup->visit)
                {{ $checkup->visit->date_of_visit?->format('d-m-Y') }} - {{ $checkup->visit->visit_type }}
                @else
                -
                @endif
              </td>
              <td class="px-6 py-4 text-sm text-gray-900 text-white">{{ $checkup->diagnosis ?: '-' }}</td>
              <td class="px-6 py-4 text-sm text-gray-900 text-white">{{ $checkup->treatment ?: '-' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                <a href="{{ route('admin.users.checkups.edit', [$user->id, $checkup->id]) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                <form action="{{ route('admin.users.checkups.destroy', [$user->id, $checkup->id]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this checkup?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-gray-400">No checkups found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Documents Tab -->
    <div id="documents-content" class="tab-content hidden">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 text-white">Patient Documents</h2>
        <a href="{{ route('admin.users.documents.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i class="fas fa-plus"></i> Add Document
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white bg-white-800 border border-gray-200 border-gray-700">
          <thead class="bg-white-50 bg-white-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Document Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">File</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Uploaded Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white bg-white-800 divide-y divide-gray-200 divide-gray-700">
            @forelse($documents as $document)
            <tr class="hover:bg-white-50 hover:bg-white-700">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $document->document_type }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <a href="/storage/{{ $document->document_path }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                  {{ basename($document->document_path) }}
                </a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">
                {{ $document->created_at?->format('d-m-Y H:i') ?? '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                <a href="/storage/{{ $document->document_path }}" target="_blank" class="text-blue-600 hover:text-blue-800">Download</a>
                <form action="{{ route('admin.users.documents.destroy', [$user->id, $document->id]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this document?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-gray-400">No documents found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Summary Tab -->
    <div id="summary-content" class="tab-content">
      <div class="space-y-6">
        <!-- Patient Summary -->
        <div class="bg-white-50 bg-white-700 rounded-lg p-6">
          <h2 class="text-xl font-semibold text-gray-800 text-white mb-4">Patient Summary</h2>
          <div class="flex flex-col md:flex-row gap-6 mb-6">
            <!-- Patient Image -->
            <div class="flex-shrink-0">
              @if($user->image)
              <img src="{{ asset($user->image) }}" alt="Patient Image" class="w-24 h-24 rounded-full object-cover border-4 border-white border-gray-600 shadow-lg">
              @else
              <div class="w-24 h-24 rounded-full bg-white-300 bg-white-600 flex items-center justify-center">
                <i class="fas fa-user text-3xl text-gray-600 text-gray-400"></i>
              </div>
              @endif
            </div>
            <!-- Patient Details -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
              <div><span class="font-medium text-gray-700 text-gray-300">Full Name:</span> <span class="text-gray-900 text-white">{{ $user->full_name }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Email:</span> <span class="text-gray-900 text-white">{{ $user->email ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Phone:</span> <span class="text-gray-900 text-white">{{ $user->mobile_no ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Alternate No:</span> <span class="text-gray-900 text-white">{{ $user->alternate_no ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Date of Birth:</span> <span class="text-gray-900 text-white">{{ $user->date_of_birth?->format('d-m-Y') ?? '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Age:</span> <span class="text-gray-900 text-white">{{ $user->age ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Gender:</span> <span class="text-gray-900 text-white">{{ $user->gender ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Blood Group:</span> <span class="text-gray-900 text-white">{{ $user->blood_group ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Father/Spouse:</span> <span class="text-gray-900 text-white">{{ $user->father_spouse_name ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Emergency Contact:</span> <span class="text-gray-900 text-white">{{ $user->emergency_contact ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">ID Proof:</span> <span class="text-gray-900 text-white">{{ $user->id_proof_type ?: '-' }} {{ $user->id_number ? '('.$user->id_number.')' : '' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Registration Date:</span> <span class="text-gray-900 text-white">{{ $user->created_at?->format('d-m-Y') ?? '-' }}</span></div>
            </div>
          </div>
          <!-- Address Section -->
          <div class="border-t border-gray-200 border-gray-600 pt-4">
            <h3 class="text-lg font-medium text-gray-800 text-white mb-2">Address Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <div><span class="font-medium text-gray-700 text-gray-300">Full Address:</span> <span class="text-gray-900 text-white">{{ $user->full_address ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">City:</span> <span class="text-gray-900 text-white">{{ $user->city ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">State:</span> <span class="text-gray-900 text-white">{{ $user->state ?: '-' }}</span></div>
              <div><span class="font-medium text-gray-700 text-gray-300">Pin Code:</span> <span class="text-gray-900 text-white">{{ $user->pin_code ?: '-' }}</span></div>
            </div>
          </div>
        </div>

        <!-- Recent Visits -->
        <div class="bg-white-50 bg-white-700 rounded-lg p-6">
          <h2 class="text-xl font-semibold text-gray-800 text-white mb-4">Recent Visits (Last 2)</h2>
          @if($visits->count() > 0)
          @foreach($visits->take(2) as $visit)
          <div class="bg-white bg-white-800 p-4 rounded-lg mb-3 border border-gray-200 border-gray-600">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
              <div><span class="font-medium text-gray-700 text-gray-300">Type:</span> {{ $visit->visit_type }}</div>
              <div><span class="font-medium text-gray-700 text-gray-300">Date:</span> {{ $visit->date_of_visit?->format('d-m-Y') ?? '-' }}</div>
              <div class="md:col-span-2"><span class="font-medium text-gray-700 text-gray-300">Complaint:</span> {{ $visit->chief_complaint ?: '-' }}</div>
              <div><span class="font-medium text-gray-700 text-gray-300">Referred By:</span> {{ $visit->reception?->reception_id ?? '-' }}</div>
              <div><span class="font-medium text-gray-700 text-gray-300">Consultant:</span> {{ $visit->consultantAssignment?->room?->room_id ?? '-' }} —
                {{ $visit->consultantAssignment?->employee?->name ?? '-' }}
              </div>
            </div>
          </div>
          @endforeach
          @else
          <p class="text-gray-500 text-gray-400">No visits recorded.</p>
          @endif
        </div>

        <!-- All Checkups -->
        <div class="bg-white-50 bg-white-700 rounded-lg p-6">
          <h2 class="text-xl font-semibold text-gray-800 text-white mb-4">All Checkups</h2>
          @if($checkups->count() > 0)
          <div class="space-y-3">
            @foreach($checkups as $checkup)
            <div class="bg-white bg-white-800 p-4 rounded-lg border border-gray-200 border-gray-600">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div><span class="font-medium text-gray-700 text-gray-300">Date:</span> {{ $checkup->checkup_date?->format('d-m-Y') ?? '-' }}</div>
                <div><span class="font-medium text-gray-700 text-gray-300">Visit:</span>
                  @if($checkup->visit)
                  {{ $checkup->visit->date_of_visit?->format('d-m-Y') }} - {{ $checkup->visit->visit_type }}
                  @else
                  -
                  @endif
                </div>
                <div class="md:col-span-2"><span class="font-medium text-gray-700 text-gray-300">Diagnosis:</span> {{ $checkup->diagnosis ?: '-' }}</div>
                <div class="md:col-span-2"><span class="font-medium text-gray-700 text-gray-300">Treatment:</span> {{ $checkup->treatment ?: '-' }}</div>
              </div>
            </div>
            @endforeach
          </div>
          @else
          <p class="text-gray-500 text-gray-400">No checkups recorded.</p>
          @endif
        </div>

        <!-- All Documents -->
        <div class="bg-white-50 bg-white-700 rounded-lg p-6">
          <h2 class="text-xl font-semibold text-gray-800 text-white mb-4">All Documents</h2>
          @if($documents->count() > 0)
          <div class="space-y-3">
            @foreach($documents as $document)
            <div class="bg-white bg-white-800 p-4 rounded-lg border border-gray-200 border-gray-600 flex justify-between items-center">
              <div class="text-sm">
                <p class="font-medium text-gray-900 text-white">{{ $document->document_type }}</p>
                <p class="text-xs text-gray-500 text-gray-400">Uploaded: {{ $document->created_at?->format('d-m-Y H:i') }}</p>
              </div>
              <a href="/storage/{{ $document->document_path }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                <i class="fas fa-download"></i> Download
              </a>
            </div>
            @endforeach
          </div>
          @else
          <p class="text-gray-500 text-gray-400">No documents uploaded.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .tab-button {
    @apply bg-white-200 text-gray-700 bg-white-700 text-gray-300;
  }

  .tab-button.active {
    @apply bg-blue-600 text-white;
  }

  .tab-content {
    @apply transition-opacity duration-300;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Determine default tab based on user type
    const userType = '{{ $user->type }}';
    let defaultTab = 'summary';
    if (userType === 'ipd') {
      defaultTab = 'checkups';
    }
    showTab(defaultTab);
  });

  function showTab(tabName) {
    const allTabs = ['visits', 'checkups', 'documents', 'summary'];
    const availableTabs = allTabs.filter(tab => document.getElementById(tab + '-tab'));

    // Hide all content
    availableTabs.forEach(tab => {
      const content = document.getElementById(tab + '-content');
      if (content) content.classList.add('hidden');
    });

    // Deactivate all buttons
    availableTabs.forEach(tab => {
      const btn = document.getElementById(tab + '-tab');
      if (btn) {
        btn.classList.remove('active', 'bg-blue-600', 'text-white');
        btn.classList.add('bg-white-200', 'text-gray-700', 'bg-white-700', 'text-gray-300');
      }
    });

    // Show selected
    const selectedContent = document.getElementById(tabName + '-content');
    const selectedBtn = document.getElementById(tabName + '-tab');

    if (selectedContent) selectedContent.classList.remove('hidden');
    if (selectedBtn) {
      selectedBtn.classList.remove('bg-white-200', 'text-gray-700', 'bg-white-700', 'text-gray-300');
      selectedBtn.classList.add('active', 'bg-blue-600', 'text-white');
    }
  }
</script>
@endsection