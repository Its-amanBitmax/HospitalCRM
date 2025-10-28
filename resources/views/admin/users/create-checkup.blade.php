@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-stethoscope text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Add New Checkup - {{ $user->full_name }}</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.users.visits', $user->id) }}" class="bg-gray-600 hover:bg-gray-700 text-black px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Visits
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <form id="createCheckupForm" action="{{ route('admin.users.checkups.store', $user->id) }}" method="POST">
      @csrf
      <div class="space-y-6">
        <!-- Checkup Details -->
        <div class="section">
          <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-stethoscope text-blue-600 dark:text-blue-400"></i>
            Checkup Details
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Checkup Date *</label>
              <input type="date" name="checkup_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Diagnosis</label>
              <textarea name="diagnosis" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200"></textarea>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Treatment</label>
              <textarea name="treatment" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200"></textarea>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
            <i class="fas fa-save mr-2"></i>Save Checkup
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
(function() {
if (window.createCheckupScriptLoaded) return;
window.createCheckupScriptLoaded = true;

var notification = document.getElementById("notification");
if (!notification) {
  notification = document.createElement('div');
  notification.id = 'notification';
  notification.className = 'fixed top-4 right-4 z-50 hidden bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300';
  notification.innerHTML = '<div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span id="notificationMessage"></span></div>';
  document.body.appendChild(notification);
}
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
document.getElementById("createCheckupForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch(this.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showNotification(data.message);
      setTimeout(() => {
        window.location.href = '{{ route("admin.users.visits", $user->id) }}';
      }, 2000);
    } else {
      showNotification(data.message || 'Error creating checkup');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showNotification('Error creating checkup');
  });
});
})();
</script>
@endsection
