<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="{{ asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}">
    <title>@yield('title', 'Admin Dashboard')</title>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex relative">
        <div class="sidebar-hover-trigger"></div>
        @include('layouts.sidebar')
        <div id="main-content" class="flex-1 flex flex-col ml-16 transition-all duration-300">
            @include('layouts.header')
            <main class="flex-1 p-6">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
        <!-- Theme Customize Button vertically centered on the right side -->
        <button id="theme-customize-btn" class="fixed top-1/2 right-4 transform -translate-y-1/2 p-2 bg-gray-800 text-white rounded-full shadow-lg hover:bg-gray-700 z-40">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" stroke="none" viewBox="0 0 24 24">
                <path d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
            </svg>
        </button>

        <!-- Theme Customize Panel -->
        <div id="theme-panel" class="fixed top-0 right-0 h-screen w-64 bg-[#0f172a] text-gray-100 shadow-lg transform translate-x-full transition-transform duration-300 z-50">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Customize</h2>
                    <button id="close-theme-panel" class="p-1 rounded hover:bg-gray-700">
                        <i class="fas fa-times w-5 h-5"></i>
                    </button>
                </div>

                <!-- Theme Options -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2">Themes</h3>
                    <div class="space-y-2">
                        <button class="theme-option w-full text-left px-3 py-2 rounded-md hover:bg-gray-700" data-theme="light">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-sun w-4 h-4"></i>
                                <span>Light Mode</span>
                            </span>
                        </button>
                        <button class="theme-option w-full text-left px-3 py-2 rounded-md hover:bg-gray-700" data-theme="dark">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-moon w-4 h-4"></i>
                                <span>Dark Mode</span>
                            </span>
                        </button>
                        <button class="theme-option w-full text-left px-3 py-2 rounded-md hover:bg-gray-700" data-theme="auto">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-adjust w-4 h-4"></i>
                                <span>Auto</span>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Sidebar Modes -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2">Sidebar Mode</h3>
                    <div class="space-y-2">
                        <button class="sidebar-mode-option w-full text-left px-3 py-2 rounded-md hover:bg-gray-700" data-mode="full">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-bars w-4 h-4"></i>
                                <span>Full</span>
                            </span>
                        </button>
                        <button class="sidebar-mode-option w-full text-left px-3 py-2 rounded-md hover:bg-gray-700" data-mode="mini">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-minus w-4 h-4"></i>
                                <span>Mini</span>
                            </span>
                        </button>
                        <button class="sidebar-mode-option w-full text-left px-3 py-2 rounded-md hover:bg-gray-700" data-mode="hover-hidden">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-eye-slash w-4 h-4"></i>
                                <span>Hover Hidden</span>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Layout Options -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 uppercase mb-2">Layout Options</h3>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-700 cursor-pointer">
                            <input type="checkbox" id="hide-header" class="form-checkbox h-4 w-4 text-blue-600">
                            <span>Hide Header</span>
                        </label>
                        <label class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-700 cursor-pointer">
                            <input type="checkbox" id="hide-footer" class="form-checkbox h-4 w-4 text-blue-600">
                            <span>Hide Footer</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .sidebar-scroll::-webkit-scrollbar {
            display: none;
        }
        .sidebar-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
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

        /* Theme Panel Styles */
        #theme-panel {
            z-index: 50;
        }
        #theme-panel.open {
            transform: translateX(0);
        }

        /* Theme Classes */
        .theme-light {
            background-color: #ffffff;
            color: #000000;
        }
        .theme-light #sidebar {
            background-color: #ffffff;
            color: #000000;
            border-right: 1px solid #e5e7eb;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
        }
        .theme-light #main-content {
            background-color: #ffffff;
            color: #000000;
        }
        .theme-light #header {
            background-color: #ffffff;
            color: #000000;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .theme-light #header h1 {
            color: #000000;
        }
        .theme-light #header span {
            color: #000000;
        }
        .theme-light #footer {
            background-color: #ffffff;
            color: #000000;
            border-top: 1px solid #e5e7eb;
        }
        .theme-light #footer p {
            color: #000000;
        }
        .theme-light #theme-customize-btn {
            background-color: #374151;
            color: #ffffff;
        }
        .theme-light .card-bg {
            background-color: #ffffff;
            color: #000000;
        }
        .theme-dark {
            background-color: #0f172a;
            color: #ffffff;
        }
        .theme-dark #sidebar {
            background-color: #0f172a;
            color: #ffffff;
            border-right: 1px solid #374151;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.3);
        }
        .theme-dark #main-content {
            background-color: #0f172a;
            color: #ffffff;
        }
        .theme-dark #header {
            background-color: #1e293b;
            color: #ffffff;
            border-bottom: 1px solid #374151;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }
        .theme-dark #header h1 {
            color: #ffffff;
        }
        .theme-dark #header span {
            color: #e5e7eb;
        }
        .theme-dark #header button {
            color: #ffffff;
        }
        .theme-dark #footer {
            background-color: #1e293b;
            color: #ffffff;
            border-top: 1px solid #374151;
        }
        .theme-dark #theme-customize-btn {
            background-color: #ffffff;
            color: #000000;
        }
        .theme-light #theme-panel {
            background-color: #ffffff;
            color: #000000;
            border-left: 1px solid #e5e7eb;
            box-shadow: -2px 0 4px rgba(0, 0, 0, 0.1);
        }
        .theme-light #theme-panel h2 {
            color: #000000;
        }
        .theme-light #theme-panel .text-gray-400 {
            color: #6b7280;
        }
        .theme-light #theme-panel button:hover {
            background-color: #f3f4f6;
        }
        .theme-light #theme-panel .theme-option:hover,
        .theme-light #theme-panel .sidebar-mode-option:hover {
            background-color: #f3f4f6;
        }
        .theme-auto {
            /* Auto theme based on system preference with primary color #42e3d4 */
        }
        @media (prefers-color-scheme: dark) {
            .theme-auto #sidebar {
                background: linear-gradient(135deg, #42e3d4 0%, #1e293b 100%);
                color: #ffffff;
                border-right: 1px solid #42e3d4;
                box-shadow: 2px 0 10px rgba(66, 227, 212, 0.3);
            }
            .theme-auto #main-content {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #42e3d4 100%);
                color: #ffffff;
            }
            .theme-auto #header {
                background: linear-gradient(135deg, #42e3d4 0%, #1e293b 100%);
                color: #ffffff;
                border-bottom: 1px solid #42e3d4;
                box-shadow: 0 2px 10px rgba(66, 227, 212, 0.3);
            }
            .theme-auto #header h1 {
                color: #ffffff;
            }
            .theme-auto #header span {
                color: #e5e7eb;
            }
            .theme-auto #header button {
                color: #ffffff;
            }
            .theme-auto #footer {
                background: linear-gradient(135deg, #1e293b 0%, #42e3d4 100%);
                color: #ffffff;
                border-top: 1px solid #42e3d4;
            }
            .theme-auto #theme-customize-btn {
                background-color: #42e3d4;
                color: #000000;
                box-shadow: 0 4px 8px rgba(66, 227, 212, 0.4);
            }
            .theme-auto #theme-panel {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                color: #ffffff;
                border-left: 1px solid #42e3d4;
                box-shadow: -2px 0 10px rgba(66, 227, 212, 0.3);
            }
            .theme-auto #theme-panel h2 {
                color: #ffffff;
            }
            .theme-auto #theme-panel .text-gray-400 {
                color: #9ca3af;
            }
            .theme-auto #theme-panel button:hover {
                background-color: #42e3d4;
                color: #000000;
            }
            .theme-auto #theme-panel .theme-option:hover,
            .theme-auto #theme-panel .sidebar-mode-option:hover {
                background-color: #42e3d4;
                color: #000000;
            }
        }
        @media (prefers-color-scheme: light) {
            .theme-auto #sidebar {
                background: linear-gradient(135deg, #42e3d4 0%, #ffffff 100%);
                color: #000000;
                border-right: 1px solid #42e3d4;
                box-shadow: 2px 0 10px rgba(66, 227, 212, 0.3);
            }
            .theme-auto #main-content {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #42e3d4 100%);
                color: #000000;
            }
            .theme-auto #header {
                background: linear-gradient(135deg, #42e3d4 0%, #ffffff 100%);
                color: #000000;
                border-bottom: 1px solid #42e3d4;
                box-shadow: 0 2px 10px rgba(66, 227, 212, 0.3);
            }
            .theme-auto #header h1 {
                color: #000000;
            }
            .theme-auto #header span {
                color: #000000;
            }
            .theme-auto #footer {
                background: linear-gradient(135deg, #ffffff 0%, #42e3d4 100%);
                color: #000000;
                border-top: 1px solid #42e3d4;
            }
            .theme-auto #theme-customize-btn {
                background-color: #42e3d4;
                color: #ffffff;
                box-shadow: 0 4px 8px rgba(66, 227, 212, 0.4);
            }
            .theme-auto #theme-panel {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                color: #000000;
                border-left: 1px solid #42e3d4;
                box-shadow: -2px 0 10px rgba(66, 227, 212, 0.3);
            }
            .theme-auto #theme-panel h2 {
                color: #000000;
            }
            .theme-auto #theme-panel .text-gray-400 {
                color: #6b7280;
            }
            .theme-auto #theme-panel button:hover {
                background-color: #42e3d4;
                color: #ffffff;
            }
            .theme-auto #theme-panel .theme-option:hover,
            .theme-auto #theme-panel .sidebar-mode-option:hover {
                background-color: #42e3d4;
                color: #ffffff;
            }
        }

        /* Sidebar Modes */
        .sidebar-mode-mini #sidebar {
            width: 4rem;
            transition: width 0.3s ease;
        }
        .sidebar-mode-mini #sidebar:hover {
            width: 16rem;
        }
        .sidebar-mode-mini #sidebar:hover nav a {
            justify-content: flex-start;
            align-items: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .sidebar-mode-mini #sidebar:hover .sidebar-text {
            display: inline;
        }
        .sidebar-mode-mini #sidebar:hover nav a svg:last-child {
            display: inline;
        }
        .sidebar-mode-mini #sidebar:hover nav p {
            text-align: left;
        }
        .sidebar-mode-mini #sidebar:hover .flex.items-center.justify-center {
            justify-content: flex-start;
        }
        .sidebar-mode-mini #sidebar nav a {
            justify-content: center;
            align-items: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .sidebar-mode-mini #sidebar .sidebar-text {
            display: none;
        }
        .sidebar-mode-mini #sidebar nav a svg:last-child {
            display: none;
        }
        .sidebar-mode-mini #sidebar nav p {
            text-align: center;
        }
        .sidebar-mode-mini #sidebar .flex.items-center.justify-center {
            justify-content: center;
        }
        .sidebar-mode-mini #main-content {
            margin-left: 4rem;
            transition: margin-left 0.3s ease;
        }
        .sidebar-mode-mini #sidebar:hover ~ #main-content {
            margin-left: 16rem;
        }

        .sidebar-mode-hover-hidden .sidebar-hover-trigger {
            position: absolute;
            left: 0;
            top: 0;
            width: 100px;
            height: 100%;
            z-index: 10;
        }
        .sidebar-mode-hover-hidden #sidebar.expanded {
            width: 16rem;
        }
        .sidebar-mode-hover-hidden #sidebar.expanded nav a {
            justify-content: flex-start;
            align-items: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .sidebar-mode-hover-hidden #sidebar.expanded .sidebar-text {
            display: inline;
        }
        .sidebar-mode-hover-hidden #sidebar.expanded nav a svg:last-child {
            display: inline;
        }
        .sidebar-mode-hover-hidden #sidebar.expanded nav p {
            text-align: left;
        }
        .sidebar-mode-hover-hidden #sidebar.expanded .flex.items-center.justify-center {
            justify-content: flex-start;
        }
        .sidebar-mode-hover-hidden #sidebar nav a {
            justify-content: center;
            align-items: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .sidebar-mode-hover-hidden #sidebar .sidebar-text {
            display: none;
        }
        .sidebar-mode-hover-hidden #sidebar nav a svg:last-child {
            display: none;
        }
        .sidebar-mode-hover-hidden #sidebar nav p {
            text-align: center;
        }
        .sidebar-mode-hover-hidden #sidebar .flex.items-center.justify-center {
            justify-content: center;
        }
        .sidebar-mode-hover-hidden #main-content {
            margin-left: 0;
        }
    </style>
    <script src="https://cdn.tailwindcss.com" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeCustomizeBtn = document.getElementById('theme-customize-btn');
            const themePanel = document.getElementById('theme-panel');
            const closeThemePanel = document.getElementById('close-theme-panel');
            const themeOptions = document.querySelectorAll('.theme-option');
            const sidebarModeOptions = document.querySelectorAll('.sidebar-mode-option');
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarHoverTrigger = document.querySelector('.sidebar-hover-trigger');

            // Theme panel toggle
            themeCustomizeBtn.addEventListener('click', function() {
                themePanel.classList.toggle('open');
            });

            // Close theme panel
            closeThemePanel.addEventListener('click', function() {
                themePanel.classList.remove('open');
            });

            // Theme switching
            themeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const theme = this.getAttribute('data-theme');
                    body.className = body.className.replace(/theme-\w+/g, '');
                    body.classList.add(`theme-${theme}`);
                    localStorage.setItem('theme', theme);
                    themePanel.classList.remove('open');

                    // Toggle Tailwind dark mode class on html
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else if (theme === 'light') {
                        document.documentElement.classList.remove('dark');
                    } else if (theme === 'auto') {
                        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        if (prefersDark) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                });
            });

            // Sidebar mode switching
            sidebarModeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const mode = this.getAttribute('data-mode');
                    body.className = body.className.replace(/sidebar-mode-\w+/g, '');
                    body.classList.add(`sidebar-mode-${mode}`);
                    localStorage.setItem('sidebarMode', mode);
                    themePanel.classList.remove('open');

                    // Update sidebar and main content based on mode
                    if (mode === 'full') {
                        sidebar.classList.remove('sidebar-collapsed');
                        mainContent.classList.remove('ml-16');
                        mainContent.classList.add('ml-64');
                        // Reload page via AJAX when switching to full mode
                        fetch(window.location.href, { method: 'GET' })
                            .then(response => response.text())
                            .then(html => {
                                document.open();
                                document.write(html);
                                document.close();
                            });
                    } else if (mode === 'mini') {
                        sidebar.classList.add('sidebar-collapsed');
                        mainContent.classList.remove('ml-64');
                        mainContent.classList.add('ml-16');
                        // Reload page via AJAX when switching to mini mode
                        fetch(window.location.href, { method: 'GET' })
                            .then(response => response.text())
                            .then(html => {
                                document.open();
                                document.write(html);
                                document.close();
                            });
                    } else if (mode === 'hover-hidden') {
                        sidebar.classList.remove('sidebar-collapsed');
                        mainContent.classList.remove('ml-64');
                        mainContent.classList.remove('ml-16');
                        mainContent.classList.add('ml-0');

                        // Add hover functionality for hover-hidden mode
                        sidebarHoverTrigger.addEventListener('mouseenter', function() {
                            sidebar.classList.add('expanded');
                            sidebar.style.transform = 'translateX(0)';
                        });
                        sidebarHoverTrigger.addEventListener('mouseleave', function() {
                            sidebar.classList.remove('expanded');
                            sidebar.style.transform = 'translateX(-100%)';
                        });
                        sidebar.addEventListener('mouseenter', function() {
                            sidebar.classList.add('expanded');
                            sidebar.style.transform = 'translateX(0)';
                        });
                        sidebar.addEventListener('mouseleave', function() {
                            sidebar.classList.remove('expanded');
                            sidebar.style.transform = 'translateX(-100%)';
                        });
                        // Reload page via AJAX when switching to hover-hidden mode
                        fetch(window.location.href, { method: 'GET' })
                            .then(response => response.text())
                            .then(html => {
                                document.open();
                                document.write(html);
                                document.close();
                            });
                    }
                });
            });

            // Layout options
            const hideHeaderCheckbox = document.getElementById('hide-header');
            const hideFooterCheckbox = document.getElementById('hide-footer');
            const header = document.getElementById('header');
            const footer = document.getElementById('footer');

            // Function to toggle header visibility
            function toggleHeader() {
                if (hideHeaderCheckbox.checked) {
                    header.style.display = 'none';
                } else {
                    header.style.display = 'block';
                }
                localStorage.setItem('hideHeader', hideHeaderCheckbox.checked);
            }

            // Function to toggle footer visibility
            function toggleFooter() {
                if (hideFooterCheckbox.checked) {
                    footer.style.display = 'none';
                } else {
                    footer.style.display = 'block';
                }
                localStorage.setItem('hideFooter', hideFooterCheckbox.checked);
            }

            // Event listeners for checkboxes
            hideHeaderCheckbox.addEventListener('change', toggleHeader);
            hideFooterCheckbox.addEventListener('change', toggleFooter);

            // Load saved preferences
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const savedSidebarMode = localStorage.getItem('sidebarMode') || 'full';
            const savedHideHeader = localStorage.getItem('hideHeader') === 'true';
            const savedHideFooter = localStorage.getItem('hideFooter') === 'true';

            body.classList.add(`theme-${savedTheme}`);
            body.classList.add(`sidebar-mode-${savedSidebarMode}`);

            // Apply Tailwind dark mode class on load
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else if (savedTheme === 'auto') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }

            // Apply saved sidebar mode
            if (savedSidebarMode === 'full') {
                sidebar.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('ml-16');
                mainContent.classList.add('ml-64');
            } else if (savedSidebarMode === 'mini') {
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-16');
            } else if (savedSidebarMode === 'hover-hidden') {
                sidebar.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('ml-64');
                mainContent.classList.remove('ml-16');
                mainContent.classList.add('ml-0');

                // Add hover functionality for hover-hidden mode
                sidebarHoverTrigger.addEventListener('mouseenter', function() {
                    sidebar.classList.add('expanded');
                    sidebar.style.transform = 'translateX(0)';
                });
                sidebarHoverTrigger.addEventListener('mouseleave', function() {
                    sidebar.classList.remove('expanded');
                    sidebar.style.transform = 'translateX(-100%)';
                });
                sidebar.addEventListener('mouseenter', function() {
                    sidebar.classList.add('expanded');
                    sidebar.style.transform = 'translateX(0)';
                });
                sidebar.addEventListener('mouseleave', function() {
                    sidebar.classList.remove('expanded');
                    sidebar.style.transform = 'translateX(-100%)';
                });
            }

            // Apply saved layout options
            hideHeaderCheckbox.checked = savedHideHeader;
            hideFooterCheckbox.checked = savedHideFooter;
            toggleHeader();
            toggleFooter();
        });
    </script>
</body>
</html>
