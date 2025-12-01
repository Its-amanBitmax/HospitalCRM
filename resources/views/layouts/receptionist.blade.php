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

<body class="bg-white-100 bg-white-900 text-black">

    <div class="flex min-h-screen">

        <!-- ==================== SIDEBAR ==================== -->
        <aside id="sidebar" class="w-64 bg-white bg-white-800 h-screen shadow-lg fixed top-0 left-0 transition-all duration-300">

            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <h2 class="text-lg font-bold sidebar-text">Receptionist Panel</h2>
                <button id="sidebar-toggle" class="text-xl">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-4">
                <a href="#" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-house"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                <a href="{{route('receptionist.appointments')}}" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="sidebar-text">Appointments</span>
                </a>

                <a href="{{route('receptionist.patients')}}" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-users"></i>
                    <span class="sidebar-text">Patients</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-file-medical"></i>
                    <span class="sidebar-text">Reports</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                     <i class="fa-solid fa-user"></i>
                    <span class="sidebar-text">Profile Settings</span>
                </a>


            </nav>
        </aside>

        <!-- ================ MAIN CONTENT WRAPPER ================= -->
        <div id="main-content" class="flex-1 flex flex-col ml-64 transition-all duration-300">

            <!-- ====================== HEADER ======================= -->
            <header class="bg-white bg-white-800 shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">@yield('header-title', 'Dashboard')</h1>

                <div class="relative" id="userDropdown">
                    <!-- Trigger -->
                    <div class="flex items-center gap-3 cursor-pointer" id="dropdownToggle">
                        <span class="text-sm font-medium">
                            Welcome, {{ auth('receptionist')->user()->name }}
                        </span>

                        <img src="{{ auth()->user()->image ?? asset('image/default.png') }}"
                            class="w-10 h-10 rounded-full object-cover border">
                    </div>

                    <!-- Dropdown -->
                    <div id="dropdownMenu"
                        class="absolute right-0 mt-4 w-48 bg-white shadow-lg rounded-lg border py-2 z-50 hidden">

                        

                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100">
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

</body>

</html>