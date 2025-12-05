<aside id="sidebar" class="w-64 fixed top-0 left-0 h-screen overflow-y-auto shadow-xl transition-all duration-300 " style="-ms-overflow-style: none; scrollbar-width: none; z-index: 1006;">
  <!-- Logo Section -->
  <div class="flex items-center justify-center px-4 py-5 border-b border-gray-100  shadow-sm" style="height: 80px; background-color:#daf6f6;">
    <div class="flex items-center justify-center w-12 h-12 rounded-lg  bg-gray-900/20">
      <img src="{{ $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}"
        alt="{{ $admin && $admin->hospital_name ? $admin->hospital_name . ' Logo' : 'Dreams EMR Logo' }}"
        class="w-8 h-8">
    </div>
    <h1 class="text-lg font-bold sidebar-text ml-3 text-cyan-600 text-cyan-400">{{ $admin && $admin->hospital_name ? $admin->hospital_name : 'Dreams EMR' }}</h1>
  </div>

  <!-- Main Navigation -->
  <nav class="p-4 space-y-4" style="background-color: #f3fcfc;">
    <div>
      <p class="text-xs text-bg-white text-bg-white-400 font-semibold uppercase mb-3 tracking-wider bg-white-50  px-3 py-2 rounded-lg border border-bg-white-100 border-bg-white-800" style="background-color:#e6f8f8;">Main</p>
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.dashboard') ? ' text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
        <i class="fas fa-tachometer-alt text-bg-white text-bg-white group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
        <span class="sidebar-text font-medium text-bg-white hover:bg-mint">Dashboard</span>
      </a>
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.manage.admin') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
        <i class="fas fa-users text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
        <span class="sidebar-text font-medium text-bg-white">Manage admins</span>
      </a>
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.Roles & Permission') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
        <i class="fas fa-shield-alt text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
        <span class="sidebar-text font-medium text-bg-white">Roles & Permissions</span>
      </a>
    </div>

    <!-- Healthcare Section -->
    <div>
      <p class="text-xs text-bg-white text-bg-white-400 font-semibold uppercase mt-6 mb-3 tracking-wider bg-white-50 bg-white-900/20 px-3 py-2 rounded-lg border border-bg-white-100 border-bg-white-800 sidebar-text" style="background-color:#e6f8f8;">Healthcare</p>

      <div id="patients-toggle" class="flex items-center justify-between mt-2 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-user-injured text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white w-5 text-center"></i>
          <span class="text-sm text-bg-white text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white group-hover:text-bg-white-200">Patients</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="patients-icon"></i>
      </div>

      <div id="patients-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.registered-users') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.registered-users') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-users text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">All Patients</span>
        </a>
        <a href="{{ route('admin.ipd-patients') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.ipd-patients') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-procedures text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">IPD Patients</span>
        </a>
        <a href="{{ route('admin.opd-patients') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.opd-patients') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-stethoscope text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">OPD Patients</span>
        </a>
        <a href="{{ route('admin.emergency-patients') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.emergency-patients') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-ambulance text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">Emergency Patients</span>
        </a>
      </div>

      <div id="doctors-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-user-md text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white group-hover:text-bg-white">Doctors</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="doctors-icon"></i>
      </div>

      <div id="doctors-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.doctors') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-user-md text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">All Doctors</span>
        </a>
        <a href="{{ route('admin.appointments') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-calendar-alt text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">Appointments</span>
        </a>
        <a href="{{ route('admin.video-consultations') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-video text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">Online Consult</span>
        </a>
      </div>

      <div id="nurses-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-user-nurse text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm  text-bg-white text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white group-hover:text-bg-white ">Nurses</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="nurses-icon"></i>
      </div>

      <div id="nurses-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.nurses') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.nurses') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-user-nurse text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm text-bg-white">All Nurses</span>
        </a>
      </div>

      <div id="bloodbank-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-tint text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Blood Bank</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="bloodbank-icon"></i>
      </div>

      <div id="bloodbank-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <!-- Blood Bank sub-links will be added here later -->
      </div>
    </div>

    <!-- Manage Section -->
    <div>
      <p class="text-xs text-bg-white text-bg-white-400 font-semibold uppercase mt-6 mb-3 tracking-wider bg-white-50 bg-white-900/20 px-3 py-2 rounded-lg border border-bg-white-100 border-bg-white-800 sidebar-text" style="background-color:#e6f8f8;">Management</p>

      <div id="employee-toggle" class="flex items-center justify-between mt-2 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-users-cog text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Employee</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="employee-icon"></i>
      </div>

      <div id="employee-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.departments') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.departments') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-building text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Department</span>
        </a>
        <a href="{{ route('admin.employees.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.employees.*') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-user text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Employee Details</span>
        </a>
        <a href="{{ route('admin.specialities.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.specialities.*') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-star text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Specialities</span>
        </a>
        <a href="{{ route('admin.attendance.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.attendance.*') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-calendar-alt text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Attendance</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-money-bill-wave text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Salary</span>
        </a>
        <!-- <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-id-card text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Identity Card</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-clock text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">OT Handling</span>
        </a> -->
      </div>

      <div id="services-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-headset text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Services</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="services-icon"></i>
      </div>

      <div id="services-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.ward-bed') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.ward-bed') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-bed text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Wards & Beds</span>
        </a>
        <a href="{{ route('admin.stock') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.stock') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-boxes text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Stock</span>
        </a>
        <a href="{{ route('admin.rooms') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.rooms') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-door-open text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Rooms</span>
        </a>
        <a href="{{ route('admin.faq') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.faq') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-question-circle text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">FAQ</span>
        </a>
        <a href="{{ route('admin.banner') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.banner') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-image text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Banners</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-headset text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Support & Help Desk</span>
        </a>
      </div>

      <div id="pharmacy-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-pills text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Pharmacy</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 text-sm" id="pharmacy-icon"></i>
      </div>

      <div id="pharmacy-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-shopping-cart text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Sales & Billing</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-cogs text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Inventory</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-pills text-bg-white-500 text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Medicine</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-chart-line text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Reports</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-boxes text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Stock</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-store text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Store</span>
        </a>
      </div>

      <div id="account-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-file-invoice-dollar text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Accounts</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 text-sm" id="account-icon"></i>
      </div>

      <div id="account-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-money-bill-wave text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Transactions</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-file-invoice text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Invoices</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-chart-line text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Reports</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-dollar-sign text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Pricing & Charges</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-book text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Accounts</span>
        </a>
      </div>

      <div id="lab-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-flask text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Lab</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 text-sm" id="lab-icon"></i>
      </div>

      <div id="lab-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.test.checkup') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-flask text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Test/Checkup</span>
        </a>
        <a href="{{ route('hospital.schedule.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-vial text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Hospital / Schedule</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-chart-line text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Reports</span>
        </a>
      </div>

      <div id="reception-toggle" class="flex items-center justify-between mt-3 mb-1 cursor-pointer px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white-50 hover:bg-white-900/20 border border-transparent hover:border-bg-white-200 group">
        <div class="flex items-center space-x-3">
          <i class="fas fa-concierge-bell text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-5 text-center"></i>
          <span class="text-sm text-bg-white-700 text-bg-white-300 font-semibold sidebar-text group-hover:text-bg-white-800 group-hover:text-bg-white-200">Reception</span>
        </div>
        <i class="fas fa-chevron-down transition-transform duration-200 text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 text-sm" id="reception-icon"></i>
      </div>

      <div id="reception-dropdown" class="space-y-2 overflow-hidden transition-all duration-300 max-h-0 ml-4 border-l-2 border-bg-white-200 border-bg-white-700 pl-3 mt-1">
        <a href="{{ route('admin.reception.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-concierge-bell text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Reception</span>
        </a>
        <a href="{{ route('admin.appointments') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
          <i class="fas fa-calendar-alt text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Appointments</span>
        </a>
        <a href="{{ route('admin.receptions.visit') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.registered-users') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-users text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Patients</span>
        </a>
        <a href="{{ route('admin.visits.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('admin.visits.*') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
          <i class="fas fa-hospital text-bg-white-500 text-bg-white-400 group-hover:text-bg-white-600 group-hover:text-bg-white-300 w-4 text-center text-sm"></i>
          <span class="sidebar-text text-sm">Visits</span>
        </a>
      </div>
    </div>
  </nav>

  <style>
  {{ route('admin.dashboard') }}sidebar::-webkit-scrollbar {
  display: none;
  }

  {{ route('admin.dashboard') }}sidebar {
  scrollbar-width: none;
  -ms-overflow-style: none;
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
        patientsDropdown.style.maxHeight = '400px';
        patientsIcon.style.transform = 'rotate(180deg)';
      } else {
        patientsDropdown.style.maxHeight = '0px';
        patientsIcon.style.transform = 'rotate(0deg)';
      }

      patientsToggle.addEventListener('click', function() {
        patientsOpen = !patientsOpen;
        localStorage.setItem('patientsDropdownOpen', patientsOpen);
        if (patientsOpen) {
          patientsDropdown.style.maxHeight = '400px';
          patientsIcon.style.transform = 'rotate(180deg)';
        } else {
          patientsDropdown.style.maxHeight = '0px';
          patientsIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Doctors dropdown functionality
      const doctorsToggle = document.getElementById('doctors-toggle');
      const doctorsDropdown = document.getElementById('doctors-dropdown');
      const doctorsIcon = document.getElementById('doctors-icon');
      let doctorsOpen = localStorage.getItem('doctorsDropdownOpen') === 'true';

      // Set initial state for doctors dropdown
      if (doctorsOpen) {
        doctorsDropdown.style.maxHeight = '400px';
        doctorsIcon.style.transform = 'rotate(180deg)';
      } else {
        doctorsDropdown.style.maxHeight = '0px';
        doctorsIcon.style.transform = 'rotate(0deg)';
      }

      doctorsToggle.addEventListener('click', function() {
        doctorsOpen = !doctorsOpen;
        localStorage.setItem('doctorsDropdownOpen', doctorsOpen);
        if (doctorsOpen) {
          doctorsDropdown.style.maxHeight = '400px';
          doctorsIcon.style.transform = 'rotate(180deg)';
        } else {
          doctorsDropdown.style.maxHeight = '0px';
          doctorsIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Nurses dropdown functionality
      const nursesToggle = document.getElementById('nurses-toggle');
      const nursesDropdown = document.getElementById('nurses-dropdown');
      const nursesIcon = document.getElementById('nurses-icon');
      let nursesOpen = localStorage.getItem('nursesDropdownOpen') === 'true';

      // Set initial state for nurses dropdown
      if (nursesOpen) {
        nursesDropdown.style.maxHeight = '400px';
        nursesIcon.style.transform = 'rotate(180deg)';
      } else {
        nursesDropdown.style.maxHeight = '0px';
        nursesIcon.style.transform = 'rotate(0deg)';
      }

      nursesToggle.addEventListener('click', function() {
        nursesOpen = !nursesOpen;
        localStorage.setItem('nursesDropdownOpen', nursesOpen);
        if (nursesOpen) {
          nursesDropdown.style.maxHeight = '400px';
          nursesIcon.style.transform = 'rotate(180deg)';
        } else {
          nursesDropdown.style.maxHeight = '0px';
          nursesIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Blood Bank dropdown functionality
      const bloodbankToggle = document.getElementById('bloodbank-toggle');
      const bloodbankDropdown = document.getElementById('bloodbank-dropdown');
      const bloodbankIcon = document.getElementById('bloodbank-icon');
      let bloodbankOpen = localStorage.getItem('bloodbankDropdownOpen') === 'true';

      // Set initial state for bloodbank dropdown
      if (bloodbankOpen) {
        bloodbankDropdown.style.maxHeight = '400px';
        bloodbankIcon.style.transform = 'rotate(180deg)';
      } else {
        bloodbankDropdown.style.maxHeight = '0px';
        bloodbankIcon.style.transform = 'rotate(0deg)';
      }

      bloodbankToggle.addEventListener('click', function() {
        bloodbankOpen = !bloodbankOpen;
        localStorage.setItem('bloodbankDropdownOpen', bloodbankOpen);
        if (bloodbankOpen) {
          bloodbankDropdown.style.maxHeight = '400px';
          bloodbankIcon.style.transform = 'rotate(180deg)';
        } else {
          bloodbankDropdown.style.maxHeight = '0px';
          bloodbankIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Employee dropdown functionality
      const employeeToggle = document.getElementById('employee-toggle');
      const employeeDropdown = document.getElementById('employee-dropdown');
      const employeeIcon = document.getElementById('employee-icon');
      let employeeOpen = localStorage.getItem('employeeDropdownOpen') === 'true';

      // Set initial state for employee dropdown
      if (employeeOpen) {
        employeeDropdown.style.maxHeight = '400px';
        employeeIcon.style.transform = 'rotate(180deg)';
      } else {
        employeeDropdown.style.maxHeight = '0px';
        employeeIcon.style.transform = 'rotate(0deg)';
      }

      employeeToggle.addEventListener('click', function() {
        employeeOpen = !employeeOpen;
        localStorage.setItem('employeeDropdownOpen', employeeOpen);
        if (employeeOpen) {
          employeeDropdown.style.maxHeight = '400px';
          employeeIcon.style.transform = 'rotate(180deg)';
        } else {
          employeeDropdown.style.maxHeight = '0px';
          employeeIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Services dropdown functionality
      const servicesToggle = document.getElementById('services-toggle');
      const servicesDropdown = document.getElementById('services-dropdown');
      const servicesIcon = document.getElementById('services-icon');
      let servicesOpen = localStorage.getItem('servicesDropdownOpen') === 'true';

      // Set initial state for services dropdown
      if (servicesOpen) {
        servicesDropdown.style.maxHeight = '400px';
        servicesIcon.style.transform = 'rotate(180deg)';
      } else {
        servicesDropdown.style.maxHeight = '0px';
        servicesIcon.style.transform = 'rotate(0deg)';
      }

      servicesToggle.addEventListener('click', function() {
        servicesOpen = !servicesOpen;
        localStorage.setItem('servicesDropdownOpen', servicesOpen);
        if (servicesOpen) {
          servicesDropdown.style.maxHeight = '400px';
          servicesIcon.style.transform = 'rotate(180deg)';
        } else {
          servicesDropdown.style.maxHeight = '0px';
          servicesIcon.style.transform = 'rotate(0deg)';
        }
      });

      // Pharmacy dropdown functionality
      const pharmacyToggle = document.getElementById('pharmacy-toggle');
      const pharmacyDropdown = document.getElementById('pharmacy-dropdown');
      const pharmacyIcon = document.getElementById('pharmacy-icon');
      let pharmacyOpen = localStorage.getItem('pharmacyDropdownOpen') === 'true';

      // Set initial state for pharmacy dropdown
      if (pharmacyOpen) {
        pharmacyDropdown.style.maxHeight = '400px';
        pharmacyIcon.style.transform = 'rotate(180deg)';
      } else {
        pharmacyDropdown.style.maxHeight = '0px';
        pharmacyIcon.style.transform = 'rotate(0deg)';
      }

      pharmacyToggle.addEventListener('click', function() {
        pharmacyOpen = !pharmacyOpen;
        localStorage.setItem('pharmacyDropdownOpen', pharmacyOpen);
        if (pharmacyOpen) {
          pharmacyDropdown.style.maxHeight = '400px';
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
        accountDropdown.style.maxHeight = '400px';
        accountIcon.style.transform = 'rotate(180deg)';
      } else {
        accountDropdown.style.maxHeight = '0px';
        accountIcon.style.transform = 'rotate(0deg)';
      }

      accountToggle.addEventListener('click', function() {
        accountOpen = !accountOpen;
        localStorage.setItem('accountDropdownOpen', accountOpen);
        if (accountOpen) {
          accountDropdown.style.maxHeight = '400px';
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
        labDropdown.style.maxHeight = '400px';
        labIcon.style.transform = 'rotate(180deg)';
      } else {
        labDropdown.style.maxHeight = '0px';
        labIcon.style.transform = 'rotate(0deg)';
      }

      labToggle.addEventListener('click', function() {
        labOpen = !labOpen;
        localStorage.setItem('labDropdownOpen', labOpen);
        if (labOpen) {
          labDropdown.style.maxHeight = '400px';
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
        receptionDropdown.style.maxHeight = '400px';
        receptionIcon.style.transform = 'rotate(180deg)';
      } else {
        receptionDropdown.style.maxHeight = '0px';
        receptionIcon.style.transform = 'rotate(0deg)';
      }

      receptionToggle.addEventListener('click', function() {
        receptionOpen = !receptionOpen;
        localStorage.setItem('receptionDropdownOpen', receptionOpen);
        if (receptionOpen) {
          receptionDropdown.style.maxHeight = '400px';
          receptionIcon.style.transform = 'rotate(180deg)';
        } else {
          receptionDropdown.style.maxHeight = '0px';
          receptionIcon.style.transform = 'rotate(0deg)';
        }
      });
    });
  </script>
</aside>