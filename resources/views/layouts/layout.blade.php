<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="icon" type="image/png" href="{{ Auth::guard('admin')->user() && Auth::guard('admin')->user()->logo ? asset('storage/' . Auth::guard('admin')->user()->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50" style="overflow-x: hidden;">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        <div class="flex flex-1">
            @include('layouts.sidebar', ['admin' => Auth::guard('admin')->user()])
            <div id="main-content" class="flex-1 flex flex-col ml-16 transition-all duration-300">
                @include('layouts.header')
                <main class="flex-1 p-6">
                    @yield('content')
                </main>
                @if(!isset($hideFooter))
                    @include('layouts.footer')
                @endif
            </div>
        </div>
    </div>

    <style>
        #sidebar.sidebar-collapsed {
            width: 4rem;
        }
        #sidebar.sidebar-collapsed nav a {
            justify-content: center;
            align-items: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        #sidebar.sidebar-collapsed .sidebar-text {
            display: none;
        }
        #sidebar.sidebar-collapsed nav a svg:last-child {
            display: none;
        }
        #sidebar.sidebar-collapsed nav p {
            text-align: center;
        }
        #sidebar.sidebar-collapsed .flex.items-center.justify-center {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        #sidebar.sidebar-collapsed ~ #main-content {
            margin-left: 4rem;
        }
        #sidebar.sidebar-collapsed ~ #main-content #footer {
            margin-left: 4rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            let sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            // Default to collapsed if not set
            if (localStorage.getItem('sidebarCollapsed') === null) {
                sidebarCollapsed = true;
                localStorage.setItem('sidebarCollapsed', 'true');
            }

            if (!sidebar || !mainContent) return;

            // Function to toggle sidebar
            function toggleSidebar() {
                sidebarCollapsed = !sidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', sidebarCollapsed);

                if (sidebarCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('ml-64');
                    mainContent.classList.add('ml-16');
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                    mainContent.classList.remove('ml-16');
                    mainContent.classList.add('ml-64');
                }
            }

            // Set initial state
            if (sidebarCollapsed) {
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-16');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('ml-16');
                mainContent.classList.add('ml-64');
            }

            // Add event listener to toggle button
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>
</html>
