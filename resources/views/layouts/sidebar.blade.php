<aside id="sidebar" class="w-50 fixed top-0 left-0 h-screen overflow-y-auto shadow-lg transition-all duration-300 sidebar-collapsed" style="-ms-overflow-style: none; scrollbar-width: none;">
  <!-- Logo Section -->
  <div class="flex items-center justify-center px-4 py-4 border-b border-gray-200 dark:border-gray-700">
    <img src="{{ $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}" alt="{{ $admin && $admin->hospital_name ? $admin->hospital_name . ' Logo' : 'Dreams EMR Logo' }}" class="w-8 h-8 dark:invert">
    <h1 class="text-xl font-bold sidebar-text ml-2">{{ $admin && $admin->hospital_name ? $admin->hospital_name : 'Dreams EMR' }}</h1>
  </div>
  
  <!-- Main Navigation -->
  <nav class="p-4 space-y-3">
    <div>
      <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold uppercase mb-1">Main</p>
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
        <i class="fas fa-tachometer-alt"></i>
        <span class="sidebar-text">Dashboard</span>
      </a>
       <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.manage.admin') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
        <i class="fas fa-users"></i>
        <span class="sidebar-text">Manage admins</span>
      </a>
       <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.Roles & Permission') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
        <i class="fas fa-shield-alt"></i>
        <span class="sidebar-text">Roles & Permissions</span>
      </a>
    </div>
   
    <!-- Healthcare Section -->
    <div>
      <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold uppercase mt-4 mb-1 sidebar-text">Healthcare</p>
      <div id="patients-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <div class="flex items-center space-x-2">
          <i class="fas fa-user-injured"></i>
          <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text">Patients</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="patients-icon"></i>
      </div>
      <div id="patients-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
                <a href="{{ route('admin.registered-users') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.registered-users') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-users"></i>
          <span class="sidebar-text">All Patients</span>
        </a>
        <a href="{{ route('admin.ipd-patients') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.ipd-patients') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-procedures"></i>
          <span class="sidebar-text">IPD Patients</span>
        </a>
        <a href="{{ route('admin.opd-patients') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.opd-patients') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-stethoscope"></i>
          <span class="sidebar-text">OPD Patients</span>
        </a>

        <a href="{{ route('admin.discharged-patients') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.discharged-patients') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-user-times"></i>
          <span class="sidebar-text">Discharged Patients</span>
        </a>

      </div>
      <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
        <i class="fas fa-user-md"></i>
        <span class="sidebar-text">Doctors</span>
      </a>
      <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
        <i class="fas fa-user-nurse"></i>
        <span class="sidebar-text">Nurse</span>
      </a>
      <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
        <i class="fas fa-tint"></i>
        <span class="sidebar-text">Blood Bank</span>
      </a>
      <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
        <i class="fas fa-video"></i>
        <span class="sidebar-text">Online Consult History</span>
      </a>

    </div>
   
    <!-- Manage Section -->
    <div>
      <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold uppercase mt-4 mb-1 sidebar-text">Management</p>
       <div id="employee-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text">Employee Management</span>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="employee-icon"></i>
      </div>
      <div id="employee-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
        <a href="{{ route('admin.departments') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.departments') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-building"></i>
          <span class="sidebar-text">Department</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-user"></i>
          <span class="sidebar-text">Employee Details</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-calendar-alt"></i>
          <span class="sidebar-text">Attendance</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-money-bill-wave"></i>
          <span class="sidebar-text">Salary</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-id-card"></i>
          <span class="sidebar-text">Identity Card</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-clock"></i>
          <span class="sidebar-text">OT Handling</span>
        </a>

      </div>
      <div id="services-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text"> Support & Services</span>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="services-icon"></i>
      </div>
      <div id="services-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
        <a href="{{ route('admin.ward-bed') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.ward-bed') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-bed"></i>
          <span class="sidebar-text">Wards & Beds</span>
        </a>
        <a href="{{ route('admin.stock') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.stock') ? 'bg-gray-200 text-gray-900 dark:bg-primary dark:text-white' : '' }}">
          <i class="fas fa-boxes"></i>
          <span class="sidebar-text">Stock</span>
        </a>
        <a href="{{ route('admin.faq') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-question-circle"></i>
          <span class="sidebar-text">FAQ</span>
        </a>
        <a href="{{ route('admin.banner') }}" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-image"></i>
          <span class="sidebar-text">Banners</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-headset"></i>
          <span class="sidebar-text">Support & Help Desk</span>
        </a>
      </div>
      <div id="pharmacy-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text">Pharmacy</span>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="pharmacy-icon"></i>
      </div>
      <div id="pharmacy-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-shopping-cart"></i>
          <span class="sidebar-text">Sales & Billing</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-cogs"></i>
          <span class="sidebar-text">Inventory</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-pills"></i>
          <span class="sidebar-text">Medicine</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-chart-line"></i>
          <span class="sidebar-text">Reports</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-boxes"></i>
          <span class="sidebar-text">Stock</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-store"></i>
          <span class="sidebar-text">Store</span>
        </a>
      </div>
      <div id="account-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text">Accounts</span>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="account-icon"></i>
      </div>
      <div id="account-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-money-bill-wave"></i>
          <span class="sidebar-text">Transactions</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-file-invoice"></i>
          <span class="sidebar-text">Invoices</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-chart-line"></i>
          <span class="sidebar-text">Reports</span>
        </a>
         <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-dollar-sign"></i>
          <span class="sidebar-text">Pricing & Charges</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-book"></i>
          <span class="sidebar-text">Accounts</span>
        </a>
      </div>
      <div id="lab-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text">Lab Management</span>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="lab-icon"></i>
      </div>
      <div id="lab-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-flask"></i>
          <span class="sidebar-text">Tests</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-vial"></i>
          <span class="sidebar-text">Patients / Samples</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-chart-line"></i>
          <span class="sidebar-text">Reports</span>
        </a>
      </div>
      <div id="reception-toggle" class="flex items-center justify-between mt-4 mb-1 cursor-pointer">
        <span class="text-xs text-black dark:text-gray-400 font-bold uppercase sidebar-text">Reception Management</span>
        <i class="fas fa-chevron-down transition-transform duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200" id="reception-icon"></i>
      </div>
      <div id="reception-dropdown" class="space-y-1 overflow-hidden transition-all duration-300 max-h-0">
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-concierge-bell"></i>
          <span class="sidebar-text">Reception</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-calendar-alt"></i>
          <span class="sidebar-text">Appointments</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-users"></i>
          <span class="sidebar-text">Patients</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-hospital"></i>
          <span class="sidebar-text">Visits</span>
        </a>
        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
          <i class="fas fa-concierge-bell"></i>
          <span class="sidebar-text">Reception</span>
        </a>
      </div>
    </div>
  </nav>

  <style>
    #sidebar::-webkit-scrollbar {
      display: none;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Patients dropdown functionality
      const patientsToggle = document.getElementById('patients-toggle');
      const patientsDropdown = document.getElementById('patients-dropdown');
      const patientsIcon = document.getElementById('patients-icon');
      let patientsOpen = localStorage.getItem('patientsDropdownOpen') === 'true';

      // Set initial state for patients dropdown
      if (patientsOpen) {
        patientsDropdown.style.maxHeight = '300px';
        patientsIcon.style.transform = 'rotate(180deg)';
      } else {
        patientsDropdown.style.maxHeight = '0px';
        patientsIcon.style.transform = 'rotate(0deg)';
      }

      patientsToggle.addEventListener('click', function() {
        patientsOpen = !patientsOpen;
        localStorage.setItem('patientsDropdownOpen', patientsOpen);
        if (patientsOpen) {
          patientsDropdown.style.maxHeight = '300px';
          patientsIcon.style.transform = 'rotate(180deg)';
        } else {
          patientsDropdown.style.maxHeight = '0px';
          patientsIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Services dropdown functionality
      const servicesToggle = document.getElementById('services-toggle');
      const servicesDropdown = document.getElementById('services-dropdown');
      const servicesIcon = document.getElementById('services-icon');
      let servicesOpen = localStorage.getItem('servicesDropdownOpen') === 'true';

      // Set initial state for services dropdown
      if (servicesOpen) {
        servicesDropdown.style.maxHeight = '300px';
        servicesIcon.style.transform = 'rotate(180deg)';
      } else {
        servicesDropdown.style.maxHeight = '0px';
        servicesIcon.style.transform = 'rotate(0deg)';
      }

      servicesToggle.addEventListener('click', function() {
        servicesOpen = !servicesOpen;
        localStorage.setItem('servicesDropdownOpen', servicesOpen);
        if (servicesOpen) {
          servicesDropdown.style.maxHeight = '300px';
          servicesIcon.style.transform = 'rotate(180deg)';
        } else {
          servicesDropdown.style.maxHeight = '0px';
          servicesIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Employee dropdown functionality
      const employeeToggle = document.getElementById('employee-toggle');
      const employeeDropdown = document.getElementById('employee-dropdown');
      const employeeIcon = document.getElementById('employee-icon');
      let employeeOpen = localStorage.getItem('employeeDropdownOpen') === 'true';

      // Set initial state for employee dropdown
      if (employeeOpen) {
        employeeDropdown.style.maxHeight = '300px';
        employeeIcon.style.transform = 'rotate(180deg)';
      } else {
        employeeDropdown.style.maxHeight = '0px';
        employeeIcon.style.transform = 'rotate(0deg)';
      }

      employeeToggle.addEventListener('click', function() {
        employeeOpen = !employeeOpen;
        localStorage.setItem('employeeDropdownOpen', employeeOpen);
        if (employeeOpen) {
          employeeDropdown.style.maxHeight = '300px';
          employeeIcon.style.transform = 'rotate(180deg)';
        } else {
          employeeDropdown.style.maxHeight = '0px';
          employeeIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Pharmacy dropdown functionality
      const pharmacyToggle = document.getElementById('pharmacy-toggle');
      const pharmacyDropdown = document.getElementById('pharmacy-dropdown');
      const pharmacyIcon = document.getElementById('pharmacy-icon');
      let pharmacyOpen = localStorage.getItem('pharmacyDropdownOpen') === 'true';

      // Set initial state for pharmacy dropdown
      if (pharmacyOpen) {
        pharmacyDropdown.style.maxHeight = '300px';
        pharmacyIcon.style.transform = 'rotate(180deg)';
      } else {
        pharmacyDropdown.style.maxHeight = '0px';
        pharmacyIcon.style.transform = 'rotate(0deg)';
      }

      pharmacyToggle.addEventListener('click', function() {
        pharmacyOpen = !pharmacyOpen;
        localStorage.setItem('pharmacyDropdownOpen', pharmacyOpen);
        if (pharmacyOpen) {
          pharmacyDropdown.style.maxHeight = '300px';
          pharmacyIcon.style.transform = 'rotate(180deg)';
        } else {
          pharmacyDropdown.style.maxHeight = '0px';
          pharmacyIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Account dropdown functionality
      const accountToggle = document.getElementById('account-toggle');
      const accountDropdown = document.getElementById('account-dropdown');
      const accountIcon = document.getElementById('account-icon');
      let accountOpen = localStorage.getItem('accountDropdownOpen') === 'true';

      // Set initial state for account dropdown
      if (accountOpen) {
        accountDropdown.style.maxHeight = '300px';
        accountIcon.style.transform = 'rotate(180deg)';
      } else {
        accountDropdown.style.maxHeight = '0px';
        accountIcon.style.transform = 'rotate(0deg)';
      }

      accountToggle.addEventListener('click', function() {
        accountOpen = !accountOpen;
        localStorage.setItem('accountDropdownOpen', accountOpen);
        if (accountOpen) {
          accountDropdown.style.maxHeight = '300px';
          accountIcon.style.transform = 'rotate(180deg)';
        } else {
          accountDropdown.style.maxHeight = '0px';
          accountIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Lab dropdown functionality
      const labToggle = document.getElementById('lab-toggle');
      const labDropdown = document.getElementById('lab-dropdown');
      const labIcon = document.getElementById('lab-icon');
      let labOpen = localStorage.getItem('labDropdownOpen') === 'true';

      // Set initial state for lab dropdown
      if (labOpen) {
        labDropdown.style.maxHeight = '300px';
        labIcon.style.transform = 'rotate(180deg)';
      } else {
        labDropdown.style.maxHeight = '0px';
        labIcon.style.transform = 'rotate(0deg)';
      }

      labToggle.addEventListener('click', function() {
        labOpen = !labOpen;
        localStorage.setItem('labDropdownOpen', labOpen);
        if (labOpen) {
          labDropdown.style.maxHeight = '300px';
          labIcon.style.transform = 'rotate(180deg)';
        } else {
          labDropdown.style.maxHeight = '0px';
          labIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Reception dropdown functionality
      const receptionToggle = document.getElementById('reception-toggle');
      const receptionDropdown = document.getElementById('reception-dropdown');
      const receptionIcon = document.getElementById('reception-icon');
      let receptionOpen = localStorage.getItem('receptionDropdownOpen') === 'true';

      // Set initial state for reception dropdown
      if (receptionOpen) {
        receptionDropdown.style.maxHeight = '300px';
        receptionIcon.style.transform = 'rotate(180deg)';
      } else {
        receptionDropdown.style.maxHeight = '0px';
        receptionIcon.style.transform = 'rotate(0deg)';
      }

      receptionToggle.addEventListener('click', function() {
        receptionOpen = !receptionOpen;
        localStorage.setItem('receptionDropdownOpen', receptionOpen);
        if (receptionOpen) {
          receptionDropdown.style.maxHeight = '300px';
          receptionIcon.style.transform = 'rotate(180deg)';
        } else {
          receptionDropdown.style.maxHeight = '0px';
          receptionIcon.style.transform = 'rotate(0deg)';
        }
      });


    });
  </script>
</aside>
