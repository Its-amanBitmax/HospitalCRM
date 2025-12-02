@php
use App\Models\Reception;
use App\Models\Admin;
$employeeId = auth('receptionist')->id();
$hasReception = Reception::where('assigned_employee', $employeeId)->exists();
$admin = Admin::first();
$logoUrl = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/default-logo.png');
$companyName = $admin ? $admin->hospital_name : 'Hospital CRM';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Receptionist Dashboard')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons + Tailwind -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-black" style="background-color: #f3fcfc;">

    @if(!$hasReception)
    <!-- Modal for no reception assigned -->
    <div id="noReceptionModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-100">
            <div class="text-center">
                <!-- Improved Icon -->
                <div class="mx-auto mb-4 w-20 h-20 flex items-center justify-center rounded-full bg-red-100">
                    <i class="fas fa-user-slash text-red-600 text-4xl"></i>
                </div>

                <!-- Heading -->
                <h2 class="text-2xl font-extrabold text-gray-800 mb-3">Access Denied</h2>

                <!-- Message -->
                <p class="text-gray-600 mb-6 leading-relaxed">
                    You do not have any assigned reception. Please contact administration for access.
                </p>

                <!-- Button -->
                <button
                    onclick="window.history.back()"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition-colors duration-200">
                    Go Back
                </button>
            </div>
        </div>
    </div>

    @else

    <div class="flex min-h-screen">

        <!-- ==================== SIDEBAR ==================== -->
        <aside id="sidebar" class="w-64 fixed top-0 left-0 h-screen overflow-y-auto shadow-xl transition-all duration-300" style="-ms-overflow-style: none; scrollbar-width: none; z-index: 1006;">
            <!-- Logo Section -->
            <div class="flex items-center justify-between px-4 py-5 border-b border-gray-100 shadow-sm" style="height: 80px; background-color:#daf6f6;">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg ">
                        <img src="{{ $logoUrl }}" alt="{{ $companyName }} Logo" class="w-8 h-8">
                    </div>
                    <h1 class="text-lg font-bold sidebar-text ml-3 text-cyan-600 text-cyan-400">{{ $companyName }}</h1>
                </div>

            </div>

            <!-- Main Navigation -->
            <nav class="p-4 space-y-4" style="background-color: #f3fcfc;">
                <div>
                    <a href="{{route('receptionists.dashboard')}}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('receptionists.dashboard') ? ' text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 ' : 'text-gray-700 text-gray-300' }}">
                        <i class="fas fa-tachometer-alt text-bg-white text-bg-white group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
                        <span class="sidebar-text font-medium text-bg-white hover:bg-mint">Dashboard</span>
                    </a>
               

               
                    <a href="{{route('receptionist.appointments')}}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('receptionist.appointments') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
                        <i class="fas fa-calendar-check text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
                        <span class="sidebar-text font-medium text-bg-white text-black">Appointments</span>
                    </a>

                    <a href="{{route('receptionist.patients')}}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group {{ request()->routeIs('receptionist.patients') ? 'bg-white-100 text-bg-white-700 border-bg-white-200 bg-white-900/30 text-bg-white-300 border-bg-white-700 shadow-sm' : 'text-gray-700 text-gray-300' }}">
                        <i class="fas fa-users text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
                        <span class="sidebar-text font-medium text-bg-white text-black">Patients</span>
                    </a>
             

                    <a href="{{route('receptionists.profile.view')}}" class="flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 border border-transparent hover:border-bg-white-200 hover:bg-white-50 hover:bg-white-900/20 group text-gray-700 text-gray-300">
                        <i class="fas fa-user text-bg-white text-bg-white-400 group-hover:text-bg-white group-hover:text-bg-white-300 w-5 text-center"></i>
                        <span class="sidebar-text font-medium text-bg-white text-black">Profile Settings</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- ================ MAIN CONTENT WRAPPER ================= -->
        <div id="main-content" class="flex-1 flex flex-col ml-64 transition-all duration-300" style="width: 75%;">

            <!-- ====================== HEADER ======================= -->
            <header class=" shadow-md  flex  items-center justify-between " style="padding: 18px; background-color: #daf6f6;">

                <div>
                    <button id="sidebar-toggle" class="text-xl text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button> <span class="text-xl font-bold ml-2">@yield('header-title', 'Welcome, ' . auth('receptionist')->user()->name)</span>

                </div>

                <div class="relative" id="userDropdown">
                    <!-- Trigger -->
                    <div class="flex items-center gap-3 cursor-pointer" id="dropdownToggle">
                        <span class="text-sm font-medium">
                            {{ auth('receptionist')->user()->name }}
                        </span>
                        @php
                        $user = auth('receptionist')->user();

                        if ($user->image && \Storage::disk('public')->exists($user->image)) {
                        // Generate URL for storage/public folder
                        $imageSrc = \Storage::url($user->image);
                        } else {
                        $imageSrc = 'https://via.placeholder.com/40x40?text=No+Image';
                        }
                        @endphp


                        <img src="{{ $imageSrc }}" class="w-10 h-10 rounded-full object-cover border" alt="Profile Image">
                    </div>

                    <!-- Dropdown -->
                    <div id="dropdownMenu"
                        class="absolute right-0 mt-4 w-48 bg-white shadow-lg rounded-lg border py-2 z-50 hidden">



                        <a href="{{route('receptionists.profile.settings')}}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100">
                            <i class="fa-solid fa-gear"></i>
                            <span>Settings</span>
                        </a>


                        <form method="POST" action="{{route('employee.logout')}}" onsubmit="localStorage.clear();">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-5 py-3 hover:bg-gray-100 text-red-500 w-full text-left">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="sidebar-text">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>


            </header>

            <!-- =================== MAIN PAGE CONTENT ================== -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- ======================== FOOTER ======================== -->


        </div>
    </div>

    <!-- ============== SIDEBAR COLLAPSE STYLES ============== -->
    <style>
        #sidebar.sidebar-collapsed {
            width: 4rem !important;
        }

        #sidebar.sidebar-collapsed .sidebar-text {
            display: none;
        }

        #sidebar.sidebar-collapsed nav a {
            justify-content: center;
        }

        #sidebar.sidebar-collapsed nav a i {
            margin-right: 0;
        }

        #sidebar.sidebar-collapsed~#main-content {
            margin-left: 4rem !important;
        }
    </style>

    <!-- ============== SIDEBAR COLLAPSE SCRIPT ============== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggle = document.getElementById("sidebar-toggle");
            const main = document.getElementById("main-content");

            let collapsed = localStorage.getItem("receptionistSidebar") === "true";

            applyState();

            function applyState() {
                if (collapsed) {
                    sidebar.classList.add("sidebar-collapsed");
                    main.classList.remove("ml-64");
                    main.classList.add("ml-16");
                } else {
                    sidebar.classList.remove("sidebar-collapsed");
                    main.classList.remove("ml-16");
                    main.classList.add("ml-64");
                }
            }

            toggle.addEventListener("click", () => {
                collapsed = !collapsed;
                localStorage.setItem("receptionistSidebar", collapsed);
                applyState();
            });
        });
    </script>
    <script>
        const toggle = document.getElementById('dropdownToggle');
        const menu = document.getElementById('dropdownMenu');

        // Toggle dropdown on click
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');

            if (!dropdown.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d4ed8', // blue
                        secondary: '#10b981', // green
                    },
                },
            },
        }
    </script>

</body>

</html>
@endif