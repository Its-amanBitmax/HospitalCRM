@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-file-medical text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 ">Add New Document - {{ $user->full_name }}</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.users.visits', $user->id) }}" class="bg-white-600 hover:bg-white-700 text-bg-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <i class="fas fa-arrow-left mr-2"></i>Back to Visits
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 ">
    <form id="createDocumentForm" action="{{ route('admin.users.documents.store', $user->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="space-y-6">
        <!-- Document Details -->
        <div class="section">
          <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-file-medical text-blue-600 text-blue-400"></i>
            Document Details
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Document Type *</label>
              <select name="document_type" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" required>
                <option value="">Select Document Type</option>
                <option value="Medical Report">Medical Report</option>
                <option value="Prescription">Prescription</option>
                <option value="Lab Report">Lab Report</option>
                <option value="X-Ray">X-Ray</option>
                <option value="MRI">MRI</option>
                <option value="CT Scan">CT Scan</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Document File *</label>
              <input type="file" name="document" class="mt-1 block w-full px-3 py-2 border border-gray-300  rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700  transition duration-200" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
              <p class="mt-1 text-sm text-gray-500 text-gray-400">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG</p>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
            <i class="fas fa-save mr-2"></i>Save Document
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
(function() {
if (window.createDocumentScriptLoaded) return;
window.createDocumentScriptLoaded = true;

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
document.getElementById("createDocumentForm").addEventListener("submit", function(e) {
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
      showNotification(data.message || 'Error creating document');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showNotification('Error creating document');
  });
});
})();
</script>
@endsection
