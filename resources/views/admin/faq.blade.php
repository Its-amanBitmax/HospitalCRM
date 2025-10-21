@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
  <!-- Notification Area -->
  <div id="notification" class="fixed top-4 right-4 z-50 hidden bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300">
    <div class="flex items-center gap-2">
      <i class="fas fa-check-circle"></i>
      <span id="notificationMessage"></span>
    </div>
  </div>

  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-question-circle text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">FAQ Management</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-question-circle text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalFaqs">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total FAQs</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-check-circle text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activeFaqs">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Active FAQs</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-times-circle text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="inactiveFaqs">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Inactive FAQs</div>
      </div>
    </div>
  </div>

  <!-- FAQ Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-list text-blue-600 dark:text-blue-400"></i>
        FAQ Details
      </h2>
      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition" id="openFaqModal">
        <i class="fa fa-plus mr-2"></i>Add FAQ
      </button>
    </div>
    <!-- FAQ Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Question</label>
        <input type="text" id="faqQuestionFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter question">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Category</label>
        <input type="text" id="faqCategoryFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter category">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="faqStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Statuses</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
    </div>
    <div>
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">FAQ ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Question</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Answer</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Category</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="faqTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- FAQ Modal -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="faqModal">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="faqModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i>
          Add New FAQ
        </h3>
        <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeFaqModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">FAQ ID</label>
          <input type="number" id="faqId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter FAQ ID">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question</label>
          <input type="text" id="faqQuestion" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Question">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Answer</label>
          <textarea id="faqAnswer" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" rows="4" placeholder="Enter Answer"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
          <input type="text" id="faqCategory" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Category">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="faqStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option>Active</option>
            <option>Inactive</option>
          </select>
        </div>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="saveFaq">Save FAQ</button>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  if (window.faqScriptLoaded) return;
  window.faqScriptLoaded = true;

  var faqs = [];
  var modalFaq = document.getElementById("faqModal");
  var faqTable = document.getElementById("faqTable");
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

  // Open Modal
  document.getElementById("openFaqModal").onclick = () => {
    modalFaq.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("faqModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("faqModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  };

  // Close Modal
  function closeFaqModal() {
    document.getElementById("faqModalContent").classList.remove("scale-100", "opacity-100");
    document.getElementById("faqModalContent").classList.add("scale-95", "opacity-0");
    setTimeout(() => modalFaq.classList.add("hidden"), 300);
  }

  document.getElementById("closeFaqModal").onclick = closeFaqModal;

  window.onclick = e => {
    if (e.target === modalFaq) closeFaqModal();
  };

  // Save FAQ
  document.getElementById("saveFaq").onclick = () => {
    const faqId = document.getElementById("faqId").value.trim();
    const question = document.getElementById("faqQuestion").value.trim();
    const answer = document.getElementById("faqAnswer").value.trim();
    const category = document.getElementById("faqCategory").value.trim();
    const status = document.getElementById("faqStatus").value;
    if (!faqId || !question || !answer || !category) {
      alert("Please fill all fields!");
      return;
    }

    fetch('/admin/faq/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ faq_id: faqId, question, answer, category, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadFaqs();
      closeFaqModal();
      document.querySelectorAll("#faqModal input, #faqModal textarea, #faqModal select").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to save FAQ.");
    });
  };

  // Load FAQs
  function loadFaqs() {
    showFaqLoading();
    fetch('/admin/faq/get-faqs')
      .then(response => response.json())
      .then(data => {
        faqs = data;
        renderFaqs();
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification("Failed to load FAQs.");
      });
  }

  // Loading Function
  function showFaqLoading() {
    faqTable.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-4">
          <div class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading FAQs...
          </div>
        </td>
      </tr>
    `;
  }

  // Render FAQs
  function renderFaqs() {
    faqTable.innerHTML = "";
    faqs.forEach((f, i) => {
      let statusClass = "text-green-500 dark:text-green-400";
      if (f.status === "Inactive") statusClass = "text-red-500 dark:text-red-400";
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${f.faq_id}</td>
        <td>${f.question}</td>
        <td>${f.answer}</td>
        <td>${f.category}</td>
        <td class="${statusClass}">${f.status}</td>
        <td>
          <button class="edit-faq bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${f.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-faq bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${f.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      faqTable.appendChild(row);
    });

    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-faq").forEach(button => {
      button.addEventListener("click", () => editFaq(button.dataset.id));
    });
    document.querySelectorAll(".delete-faq").forEach(button => {
      button.addEventListener("click", () => deleteFaq(button.dataset.id));
    });

    updateDashboard();
  }

  function updateDashboard() {
    document.getElementById("totalFaqs").textContent = faqs.length;
    document.getElementById("activeFaqs").textContent = faqs.filter(f => f.status === "Active").length;
    document.getElementById("inactiveFaqs").textContent = faqs.filter(f => f.status === "Inactive").length;
  }

  // Edit FAQ
  function editFaq(id) {
    const faq = faqs.find(f => f.id == id);
    if (!faq) return;

    document.getElementById("faqId").value = faq.faq_id;
    document.getElementById("faqQuestion").value = faq.question;
    document.getElementById("faqAnswer").value = faq.answer;
    document.getElementById("faqCategory").value = faq.category;
    document.getElementById("faqStatus").value = faq.status;

    document.getElementById("faqModalContent").querySelector("h3").innerHTML = '<i class="fas fa-edit text-blue-600 dark:text-blue-400"></i> Edit FAQ';
    document.getElementById("saveFaq").textContent = "Update FAQ";
    document.getElementById("saveFaq").onclick = () => updateFaq(id);

    modalFaq.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("faqModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("faqModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  }

  // Update FAQ
  function updateFaq(id) {
    const faqId = document.getElementById("faqId").value.trim();
    const question = document.getElementById("faqQuestion").value.trim();
    const answer = document.getElementById("faqAnswer").value.trim();
    const category = document.getElementById("faqCategory").value.trim();
    const status = document.getElementById("faqStatus").value;
    if (!faqId || !question || !answer || !category) {
      alert("Please fill all fields!");
      return;
    }

    fetch(`/admin/faq/update/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ faq_id: faqId, question, answer, category, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadFaqs();
      closeFaqModal();
      document.querySelectorAll("#faqModal input, #faqModal textarea, #faqModal select").forEach(i => i.value = "");
      document.getElementById("faqModalContent").querySelector("h3").innerHTML = '<i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i> Add New FAQ';
      document.getElementById("saveFaq").textContent = "Save FAQ";
      document.getElementById("saveFaq").onclick = () => saveFaq();
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to update FAQ.");
    });
  }

  // Save FAQ (to reset the saveFaq button after editing)
  function saveFaq() {
    const faqId = document.getElementById("faqId").value.trim();
    const question = document.getElementById("faqQuestion").value.trim();
    const answer = document.getElementById("faqAnswer").value.trim();
    const category = document.getElementById("faqCategory").value.trim();
    const status = document.getElementById("faqStatus").value;
    if (!faqId || !question || !answer || !category) {
      alert("Please fill all fields!");
      return;
    }

    fetch('/admin/faq/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ faq_id: faqId, question, answer, category, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadFaqs();
      closeFaqModal();
      document.querySelectorAll("#faqModal input, #faqModal textarea, #faqModal select").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to save FAQ.");
    });
  }

  // Delete FAQ
  function deleteFaq(id) {
    if (!confirm("Are you sure you want to delete this FAQ?")) return;

    fetch(`/admin/faq/delete/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadFaqs();
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to delete FAQ.");
    });
  }

  // FAQ Filters
  document.getElementById("faqQuestionFilter").addEventListener('input', filterFaqs);
  document.getElementById("faqCategoryFilter").addEventListener('input', filterFaqs);
  document.getElementById("faqStatusFilter").addEventListener('change', filterFaqs);

  function filterFaqs() {
    const questionFilter = document.getElementById("faqQuestionFilter").value.toLowerCase();
    const categoryFilter = document.getElementById("faqCategoryFilter").value.toLowerCase();
    const statusFilter = document.getElementById("faqStatusFilter").value;
    const filteredFaqs = faqs.filter(f =>
      f.question.toLowerCase().includes(questionFilter) &&
      f.category.toLowerCase().includes(categoryFilter) &&
      (!statusFilter || f.status === statusFilter)
    );
    faqTable.innerHTML = "";
    filteredFaqs.forEach((f, i) => {
      let statusClass = "text-green-500 dark:text-green-400";
      if (f.status === "Inactive") statusClass = "text-red-500 dark:text-red-400";
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${f.faq_id}</td>
        <td>${f.question}</td>
        <td>${f.answer}</td>
        <td>${f.category}</td>
        <td class="${statusClass}">${f.status}</td>
        <td>
          <button class="edit-faq bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${f.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-faq bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${f.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      faqTable.appendChild(row);
    });

    // Re-attach event listeners
    document.querySelectorAll(".edit-faq").forEach(button => {
      button.addEventListener("click", () => editFaq(button.dataset.id));
    });
    document.querySelectorAll(".delete-faq").forEach(button => {
      button.addEventListener("click", () => deleteFaq(button.dataset.id));
    });
  }

  // Initial Load
  loadFaqs();
})();
</script>

@endsection
