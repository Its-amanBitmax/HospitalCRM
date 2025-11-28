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
      <i class="fas fa-user-edit text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 ">Edit User</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.registered-users') }}" class="bg-white-600 hover:bg-white-700 text-black px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Users
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 ">
    <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="space-y-6">
        <!-- Personal Information -->
        <div class="section">
          <h2 class="text-lg font-semibold text-gray-800  mb-4 flex items-center gap-2">
            <i class="fas fa-user text-blue-600 text-blue-400"></i>
            Personal Information
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Full Name *</label>
              <input type="text" name="full_name" value="{{ $user->full_name }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Username *</label>
              <input type="text" name="username" value="{{ $user->username }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Email</label>
              <input type="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Mobile No *</label>
              <input type="text" name="mobile_no" value="{{ $user->mobile_no }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Age</label>
              <input type="number" name="age" value="{{ $user->age }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" min="0" max="150">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Gender</label>
              <select name="gender" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
                <option value="">Select Gender</option>
                <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Blood Group</label>
              <select name="blood_group" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
                <option value="">Select Blood Group</option>
                <option value="A+" {{ $user->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                <option value="A-" {{ $user->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                <option value="B+" {{ $user->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                <option value="B-" {{ $user->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                <option value="AB+" {{ $user->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                <option value="AB-" {{ $user->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                <option value="O+" {{ $user->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                <option value="O-" {{ $user->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Father / Spouse Name</label>
              <input type="text" name="father_spouse_name" value="{{ $user->father_spouse_name }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Alternate No</label>
              <input type="text" name="alternate_no" value="{{ $user->alternate_no }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
            </div>
          </div>
        </div>

        <!-- Address Details -->
        <div class="section">
          <h2 class="text-lg font-semibold text-gray-800  mb-4 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-blue-600 text-blue-400"></i>
            Address Details
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Full Address</label>
              <textarea name="full_address" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">{{ $user->full_address }}</textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">City</label>
              <input type="text" name="city" value="{{ $user->city }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">State</label>
              <input type="text" name="state" value="{{ $user->state }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">PIN Code</label>
              <input type="text" name="pin_code" value="{{ $user->pin_code }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200">
            </div>
          </div>
        </div>


        <!-- ID Proof -->
        <div class="section">
          <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-id-card text-blue-600 text-blue-400"></i>
            ID Proof
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">ID Proof Type</label>
              <input type="text" name="id_proof_type" value="{{ $user->id_proof_type }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">ID Number</label>
              <input type="text" name="id_number" value="{{ $user->id_number }}" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 transition duration-200">
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
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Type *</label>
              <select name="type" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 transition duration-200" required>
                <option value="ipd" {{ $user->type == 'ipd' ? 'selected' : '' }}>IPD</option>
                <option value="opd" {{ $user->type == 'opd' ? 'selected' : '' }}>OPD</option>
                <option value="emergency" {{ $user->type == 'emergency' ? 'selected' : '' }}>Emergency</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Status *</label>
              <select name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 transition duration-200" required>
                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="discharged" {{ $user->status == 'discharged' ? 'selected' : '' }}>Discharged</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Image</label>
              <input type="file" name="image" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 transition duration-200" accept="image/*">
              @if($user->image)
                <div class="mt-2">
    <img src="{{ asset($user->image) }}" alt="Current Image" class="w-20 h-20 rounded-full object-cover">
    <p class="text-sm text-gray-600 text-gray-400 mt-1">Current image</p>
</div>

              @endif
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
            <i class="fas fa-save mr-2"></i>Update User
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
(function() {
if (window.editUserScriptLoaded) return;
window.editUserScriptLoaded = true;

document.addEventListener('DOMContentLoaded', function() {
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

  // Form submission
  var form = document.getElementById("editUserForm");
  if (form) {
    form.addEventListener("submit", function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          showNotification(data.message);
          setTimeout(() => {
            window.location.href = '{{ route("admin.registered-users") }}';
          }, 2000);
        } else {
          showNotification(data.message || 'Error updating user');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating user');
      });
    });
  }
});
})();
</script>
@endsection
