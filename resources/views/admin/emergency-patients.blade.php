@extends('layouts.layout')

@section('content')

<style>
@media print {
  .sidebar, header, footer, .topbar, .notification, .grid.grid-cols-1.md\\:grid-cols-4, .flex.justify-between.items-center.bg-white.\\:bg-white-800.p-4.rounded-lg.shadow.mb-6 { display: none !important; }
  body { margin: 0; padding: 20px; }
  .bg-white.\\:bg-white-800.rounded-lg.shadow-lg.p-6 { box-shadow: none; border: none; }
}
#main-content {
  overflow-x: auto !important;
}
::-webkit-scrollbar {
  display: none;
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
      <i class="fas fa-ambulance text-2xl text-red-600 text-red-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 text-white">Emergency Patients</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-users text-3xl text-blue-600 text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="totalPatients">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Total Emergency Patients</div>
      </div>
    </div>
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-check text-3xl text-green-600 text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="activePatients">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Active</div>
      </div>
    </div>
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-times text-3xl text-red-600 text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="inactivePatients">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Inactive</div>
      </div>
    </div>
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-md text-3xl text-purple-600 text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="emergencyPatients">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Emergency</div>
      </div>
    </div>
  </div>

  <!-- Patients Table -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 text-white flex items-center gap-2">
        <i class="fas fa-users text-blue-600 text-blue-400"></i>
        Emergency Patient Details
      </h2>
    </div>

    <!-- Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="patientNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" placeholder="Enter patient name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Filter by Email</label>
        <input type="text" id="patientEmailFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" placeholder="Enter email">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Filter by Status</label>
        <select id="patientStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200">
          <option value="">All</option>
          <option>active</option>
          <option>inactive</option>
          <option>discharged</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-white-500 hover:bg-white-600 text-white px-4 py-2 rounded-lg transition" id="clearPatientFilters">Clear Filters</button>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead class="bg-white-100 bg-white-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">Patient ID</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">Full Name</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">Username</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">Email</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">Phone</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium border-b border-gray-200 border-gray-600 w-48">Action</th>
          </tr>
        </thead>
        <tbody id="patientTable" class="text-gray-800 text-gray-200 divide-y divide-gray-200 divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- View Patient Modal -->
  <div class="fixed inset-0 bg-white bg-opacity-50 flex items-center justify-center hidden z-50" id="viewPatientModal">
    <div class="bg-white bg-white-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="viewPatientModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 text-white flex items-center gap-2">
          <i class="fas fa-user text-blue-600 text-blue-400"></i>
          Patient Details
        </h3>
        <button class="text-gray-500 hover:text-gray-700 text-gray-400 hover:text-gray-200" id="closeViewPatientModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <div class="space-y-4" id="patientDetails"></div>
    </div>
  </div>

  <!-- Edit Patient Modal -->
  <div class="fixed inset-0 bg-white bg-opacity-50 flex items-center justify-center hidden z-50" id="editPatientModal">
    <div class="bg-white bg-white-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="editPatientModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 text-white flex items-center gap-2">
          <i class="fas fa-edit text-blue-600 text-blue-400"></i>
          Edit Patient
        </h3>
        <button class="text-gray-500 hover:text-gray-700 text-gray-400 hover:text-gray-200" id="closeEditPatientModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <form id="editPatientForm" class="space-y-4">
        <input type="hidden" id="editPatientId">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Full Name</label>
            <input type="text" id="editPatientFullname" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Username</label>
            <input type="text" id="editPatientUsername" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Email</label>
            <input type="email" id="editPatientEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Phone</label>
            <input type="text" id="editPatientPhone" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Age</label>
            <input type="number" id="editPatientAge" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" min="0" max="150">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Gender</label>
            <select id="editPatientGender" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200">
              <option value="">Select Gender</option>
              <option>male</option>
              <option>female</option>
              <option>other</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Type</label>
            <select id="editPatientType" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" required>
              <option>ipd</option>
              <option>opd</option>
              <option>emergency</option>
              <option>registered</option>
              <option>discharged</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Status</label>
            <select id="editPatientStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200" required>
              <option>active</option>
              <option>inactive</option>
              <option>discharged</option>
            </select>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Address</label>
          <textarea id="editPatientAddress" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white transition duration-200"></textarea>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Update Patient</button>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script>
  (function() {
    if (window.emergencyPatientsScriptLoaded) return;
    window.emergencyPatientsScriptLoaded = true;

    let patients = [];

    const notification = document.getElementById("notification");
    const notificationMessage = document.getElementById("notificationMessage");

    // ---------- Notification ----------
    function showNotification(msg) {
      notificationMessage.textContent = msg;
      notification.classList.remove("hidden", "opacity-0");
      notification.classList.add("opacity-100");
      setTimeout(() => {
        notification.classList.remove("opacity-100");
        notification.classList.add("opacity-0");
        setTimeout(() => notification.classList.add("hidden"), 300);
      }, 3000);
    }

    // ---------- Load Patients ----------
    function loadPatients() {
      showPatientLoading();
      fetch('/admin/get-emergency-patients')
        .then(r => r.json())
        .then(data => {
          patients = data;
          renderPatients();
          updateDashboard();
        })
        .catch(() => {
          document.getElementById("patientTable").innerHTML = `<tr><td colspan="8" class="text-center py-4 text-red-500">Failed to load data.</td></tr>`;
        });
    }

    function showPatientLoading() {
      document.getElementById("patientTable").innerHTML = `
        <tr>
          <td colspan="8" class="text-center py-4">
            <div class="flex items-center justify-center">
              <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading Patients...
            </div>
          </td>
        </tr>`;
    }

    // ---------- Render Table ----------
    function renderPatients(filtered = patients) {
      const tbody = document.getElementById("patientTable");
      tbody.innerHTML = "";

      if (!filtered.length) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-gray-500">No patients found.</td></tr>`;
        return;
      }

      filtered.forEach((p, i) => {
        const statusClass = p.status === "active" ? "text-green-500 text-green-400" : p.status === "discharged" ? "text-purple-500 text-purple-400" : "text-red-500 text-red-400";

        tbody.insertAdjacentHTML("beforeend", `
          <tr class="hover:bg-white-50 hover:bg-white-700 transition">
            <td class="px-4 py-3">${i + 1}</td>
            <td class="px-4 py-3">${p.user_id || '-'}</td>
            <td class="px-4 py-3">${p.full_name || p.fullname || '-'}</td>
            <td class="px-4 py-3">${p.username}</td>
            <td class="px-4 py-3">${p.email || '-'}</td>
            <td class="px-4 py-3">${p.mobile_no || p.phone_no || '-'}</td>
            <td class="px-4 py-3 ${statusClass}">${p.status}</td>
            <td class="px-4 py-3 space-x-1">
              <a href="/admin/users/${p.id}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm inline-block"><i class="fas fa-eye"></i></a>
              <a href="/admin/users/${p.id}/edit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm inline-block"><i class="fas fa-edit"></i></a>
              <a href="/admin/users/${p.id}/visits" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm inline-block"><i class="fas fa-calendar-alt"></i></a>
              <button onclick="deletePatient(${p.id})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        `);
      });
    }

    // ---------- Dashboard ----------
    function updateDashboard() {
      document.getElementById("totalPatients").textContent = patients.length;
      document.getElementById("activePatients").textContent = patients.filter(p => p.status === "active").length;
      document.getElementById("inactivePatients").textContent = patients.filter(p => p.status === "inactive").length;
      document.getElementById("emergencyPatients").textContent = patients.filter(p => p.type === "emergency").length;
    }

    // ---------- View Modal ----------
    function viewPatient(id) {
      const p = patients.find(x => x.id == id);
      if (!p) return;

      const details = document.getElementById("patientDetails");
      details.innerHTML = `
        <div><strong>Patient ID:</strong> ${p.user_id || '-'}</div>
        <div><strong>Full Name:</strong> ${p.full_name || p.fullname}</div>
        <div><strong>Username:</strong> ${p.username}</div>
        <div><strong>Email:</strong> ${p.email || '-'}</div>
        <div><strong>Phone:</strong> ${p.mobile_no || p.phone_no || '-'}</div>
        <div><strong>Age:</strong> ${p.age || '-'}</div>
        <div><strong>Gender:</strong> ${p.gender || '-'}</div>
        <div><strong>Address:</strong> ${p.address || '-'}</div>
        <div><strong>Type:</strong> ${p.type}</div>
        <div><strong>Status:</strong> <span class="${p.status === 'active' ? 'text-green-600' : p.status === 'discharged' ? 'text-purple-600' : 'text-red-600'}">${p.status}</span></div>
        <div><strong>Registered Through:</strong> ${p.registered_through || '-'}</div>
        <div><strong>Created At:</strong> ${new Date(p.created_at).toLocaleString()}</div>
      `;

      const modal = document.getElementById("viewPatientModal");
      modal.classList.remove("hidden");
      setTimeout(() => document.getElementById("viewPatientModalContent")
        .classList.replace("scale-95", "scale-100")
        .classList.replace("opacity-0", "opacity-100"), 10);
    }

    // ---------- Edit Modal ----------
    function editPatient(id) {
      const p = patients.find(x => x.id == id);
      if (!p) return;

      document.getElementById("editPatientId").value = p.id;
      document.getElementById("editPatientFullname").value = p.full_name || p.fullname || '';
      document.getElementById("editPatientUsername").value = p.username || '';
      document.getElementById("editPatientEmail").value = p.email || '';
      document.getElementById("editPatientPhone").value = p.mobile_no || p.phone_no || '';
      document.getElementById("editPatientAge").value = p.age || '';
      document.getElementById("editPatientGender").value = p.gender || '';
      document.getElementById("editPatientType").value = p.type || '';
      document.getElementById("editPatientStatus").value = p.status || '';
      document.getElementById("editPatientAddress").value = p.address || '';

      const modal = document.getElementById("editPatientModal");
      modal.classList.remove("hidden");
      setTimeout(() => document.getElementById("editPatientModalContent")
        .classList.replace("scale-95", "scale-100")
        .classList.replace("opacity-0", "opacity-100"), 10);
    }

    // ---------- Update Patient ----------
    document.getElementById("editPatientForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const id = document.getElementById("editPatientId").value;
      const payload = {
        fullname: document.getElementById("editPatientFullname").value,
        username: document.getElementById("editPatientUsername").value,
        email: document.getElementById("editPatientEmail").value,
        phone_no: document.getElementById("editPatientPhone").value,
        age: document.getElementById("editPatientAge").value,
        gender: document.getElementById("editPatientGender").value,
        type: document.getElementById("editPatientType").value,
        status: document.getElementById("editPatientStatus").value,
        address: document.getElementById("editPatientAddress").value,
      };

      fetch(`/admin/update-emergency-patient/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
      })
      .then(r => r.json())
      .then(d => {
        showNotification(d.message || "Patient updated.");
        loadPatients();
        closeEditPatientModal();
      })
      .catch(() => showNotification("Update failed."));
    });

    // ---------- Delete Patient ----------
    window.deletePatient = function (id) {
      if (!confirm("Delete this patient? This action cannot be undone.")) return;

      fetch(`/admin/delete-emergency-patient/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      })
      .then(r => r.json())
      .then(d => {
        showNotification(d.message || "Patient deleted.");
        loadPatients();
      })
      .catch(() => showNotification("Delete failed."));
    };

    // ---------- Modal Close ----------
    function closeViewPatientModal() {
      const c = document.getElementById("viewPatientModalContent");
      c.classList.replace("scale-100", "scale-95");
      c.classList.replace("opacity-100", "opacity-0");
      setTimeout(() => document.getElementById("viewPatientModal").classList.add("hidden"), 300);
    }
    function closeEditPatientModal() {
      const c = document.getElementById("editPatientModalContent");
      c.classList.replace("scale-100", "scale-95");
      c.classList.replace("opacity-100", "opacity-0");
      setTimeout(() => document.getElementById("editPatientModal").classList.add("hidden"), 300);
    }

    document.getElementById("closeViewPatientModal").onclick = closeViewPatientModal;
    document.getElementById("closeEditPatientModal").onclick = closeEditPatientModal;
    window.onclick = e => {
      if (e.target.id === "viewPatientModal") closeViewPatientModal();
      if (e.target.id === "editPatientModal") closeEditPatientModal();
    };

    // ---------- Filters ----------
    document.getElementById("patientNameFilter").addEventListener("input", filterPatients);
    document.getElementById("patientEmailFilter").addEventListener("input", filterPatients);
    document.getElementById("patientStatusFilter").addEventListener("change", filterPatients);
    document.getElementById("clearPatientFilters").addEventListener("click", () => {
      document.getElementById("patientNameFilter").value = "";
      document.getElementById("patientEmailFilter").value = "";
      document.getElementById("patientStatusFilter").value = "";
      renderPatients();
    });

    function filterPatients() {
      const name = document.getElementById("patientNameFilter").value.toLowerCase();
      const email = document.getElementById("patientEmailFilter").value.toLowerCase();
      const status = document.getElementById("patientStatusFilter").value;

      const filtered = patients.filter(p => {
        const full = (p.full_name || p.fullname || "").toLowerCase();
        const mail = (p.email || "").toLowerCase();
        return full.includes(name) && mail.includes(email) && (!status || p.status === status);
      });

      renderPatients(filtered);
    }

    // ---------- Init ----------
    loadPatients();

    // expose to global scope for inline onclick
    window.viewPatient = viewPatient;
    window.editPatient = editPatient;
  })();
  </script>
</div>
@endsection
