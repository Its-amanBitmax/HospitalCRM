@extends('layouts.layout')

@section('content')
<style>
@media print {
  .sidebar, header, footer, .topbar, .notification, .grid.grid-cols-1.md\\:grid-cols-4, .flex.justify-between.items-center.bg-white.\\:bg-white-800.p-4.rounded-lg.shadow.mb-6 { display: none !important; }
  body { margin: 0; padding: 20px; }
  .bg-white.\\:bg-white-800.rounded-lg.shadow-lg.p-6 { box-shadow: none; border: none; }
}
</style>
<div class="min-h-screen">
  <!-- Notification Area -->
  <div id="notification" class="fixed top-4 right-4 z-50 hidden bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300">
    <div class="flex items-center gap-2">
      <i class="fas fa-check-circle"></i>
      <span id="notificationMessage"></span>
    </div>
  </div>

  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-user text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 text-white">User Details</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.registered-users') }}" class="bg-white-600 hover:bg-white-700 text- px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to list
      </a>
     
      <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-edit mr-2"></i>Edit
      </a>
      <button onclick="deleteUser({{ $user->id }})" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-trash mr-2"></i>Delete
      </button>
    </div>
  </div>

  <!-- User Details -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 border-gray-700">
    <div class="space-y-6">
      <!-- Personal Information -->
      <div class="section">
        <h2 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center gap-2">
          <i class="fas fa-user text-blue-600 text-blue-400"></i>
          Personal Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Image</label>
    @if($user->image)
        <div class="mt-2">
            <img src="{{ asset($user->image) }}" alt="User Image" class="w-20 h-20 rounded-full object-cover">
        </div>
    @else
        <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">-</div>
    @endif
</div>

          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Full Name</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->full_name }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Username</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->username }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Email</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->email ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Mobile No</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->mobile_no }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Age</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->age ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Gender</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->gender ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Blood Group</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->blood_group ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Father / Spouse Name</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->father_spouse_name ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Alternate No</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->alternate_no ?: '-' }}</div>
          </div>
        </div>
      </div>

      <!-- Address Details -->
      <div class="section">
        <h2 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center gap-2">
          <i class="fas fa-map-marker-alt text-blue-600 text-blue-400"></i>
          Address Details
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Full Address</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->full_address ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">City</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->city ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">State</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->state ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">PIN Code</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->pin_code ?: '-' }}</div>
          </div>
        </div>
      </div>

      <!-- ID Proof -->
      <div class="section">
        <h2 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center gap-2">
          <i class="fas fa-id-card text-blue-600 text-blue-400"></i>
          ID Proof
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">ID Proof Type</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->id_proof_type ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">ID Number</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->id_number ?: '-' }}</div>
          </div>
        </div>
      </div>

      <!-- Additional Fields -->
      <div class="section">
        <h2 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center gap-2">
          <i class="fas fa-cogs text-blue-600 text-blue-400"></i>
          Additional Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Type</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->type }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Status</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->status }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Registered Through</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->registered_through ?: '-' }}</div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Created At</label>
            <div class="mt-1 block w-full px-3 py-2 bg-white-100 bg-white-600 border border-gray-300 border-gray-600 rounded-md text-gray-800 text-white">{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s') : '-' }}</div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
if (window.showUserScriptLoaded) return;
window.showUserScriptLoaded = true;

var notification = document.getElementById("notification");
var notificationMessage = document.getElementById("notificationMessage");

// Function to show notification
function showNotification(message) {
  notificationMessage.textContent = message;
  notification.classList.remove("hidden");
  notification.classList.add("opacity-100");
  setTimeout(() => {
    notification.classList.remove("opacity-100");
    notification.classList.add("opacity-0");
    setTimeout(() => notification.classList.add("hidden"), 300);
  }, 3000);
}

// Delete User
function deleteUser(id) {
  if (!confirm("Are you sure you want to delete this user?")) return;

  fetch(`/admin/delete-registered-user/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    setTimeout(() => {
      window.location.href = '{{ route("admin.registered-users") }}';
    }, 2000);
  })
  .catch(error => console.error('Error:', error));
}

// Expose function to global scope
window.deleteUser = deleteUser;
})();
</script>
@endsection
