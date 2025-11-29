
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Doctor Dashboard')</title>

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
                <h2 class="text-lg font-bold sidebar-text">Doctor Panel</h2>
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

                <a href="{{ route('employee.doctor_appointments') }}" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="sidebar-text">Appointments</span>
                </a>

               <a href="{{ route('employee.doctor_consultations') }}" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="sidebar-text">Consultations</span>
                </a>

                <a href="{{route('employee.doctor_patients')}}" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-users"></i>
                    <span class="sidebar-text">Patients</span>
                </a>

                <a href="{{route('employee.report')}}" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-file-medical"></i>
                    <span class="sidebar-text">Reports</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700">
                    <i class="fa-solid fa-gear"></i>
                    <span class="sidebar-text">Settings</span>
                </a>

                <form method="POST" action="{{ route('employee.logout') }}" class="inline" onsubmit="localStorage.clear();">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-5 py-3 hover:bg-white-200 hover:bg-white-700 text-red-500 w-full text-left">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- ================ MAIN CONTENT WRAPPER ================= -->
        <div id="main-content" class="flex-1 flex flex-col ml-64 transition-all duration-300">

            <!-- ====================== HEADER ======================= -->
            <header class="bg-white bg-white-800 shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">@yield('header-title', 'Dashboard')</h1>

                    <div class="flex items-center gap-3">
                        <span class="text-sm">Welcome, {{ Auth::user()->name ?? 'Employee' }}</span>
                        <img src="{{ Auth::user()->image ?? asset('image/default.png') }}"
                            class="w-10 h-10 rounded-full object-cover border">
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
        #sidebar.sidebar-collapsed { width: 4rem !important; }
        #sidebar.sidebar-collapsed .sidebar-text { display: none; }
        #sidebar.sidebar-collapsed nav a { justify-content: center; }
        #sidebar.sidebar-collapsed nav a i { margin-right: 0; }
        #sidebar.sidebar-collapsed ~ #main-content { margin-left: 4rem !important; }
    </style>

    <!-- ============== SIDEBAR COLLAPSE SCRIPT ============== -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const toggle = document.getElementById("sidebar-toggle");
            const main = document.getElementById("main-content");

            let collapsed = localStorage.getItem("doctorSidebar") === "true";

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
                localStorage.setItem("doctorSidebar", collapsed);
                applyState();
            });
        });
    </script>

</body>
</html>
