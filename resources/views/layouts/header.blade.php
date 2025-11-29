<header id="header" class=" bg-white-800 shadow-lg sticky top-0 z-40 transition-all duration-300" style="background-color:#daf6f6;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            
            <div class="shrink-0 flex items-center">
                <!-- Enhanced Sidebar Toggle Button -->
                <button id="sidebar-toggle" class="mr-4 p-2 rounded-lg text-gray-500 hover:text-indigo-600 text-gray-400 hover:text-indigo-300 hover:bg-white-100 hover:bg-white-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transform hover:scale-105">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                
                <!-- Welcome Message with Animation -->
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-8 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full"></div>
                    <h1 class="text-xl font-bold text-gray-900 text-gray-100 tracking-tight">
                        Welcome <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ Auth::guard('admin')->user()->name }}</span>!
                    </h1>
                </div>
            </div>
            
            <!-- Enhanced Profile Section -->
            <div class="flex items-center relative">
                <div class="relative">
                    <button id="profileDropdownButton" class="flex items-center space-x-3 p-1 rounded-xl hover:bg-white-50 hover:bg-white-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        @if(Auth::guard('admin')->user()->profile_image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_image) }}" alt="Profile Image" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 border-gray-600 shadow-sm">
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white border-gray-800"></div>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center shadow-sm">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                        @endif
                        <span class="text-gray-700 text-gray-300 font-medium">{{ Auth::guard('admin')->user()->name }}</span>
                        <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform duration-200"></i>
                    </button>
                    
                    <!-- Enhanced Dropdown Menu -->
                    <div id="profileDropdown" class="absolute right-0 mt-3 w-56 bg-white bg-white-800 rounded-xl shadow-xl ring-1 ring-bg-white ring-opacity-5 z-50 overflow-hidden transform origin-top-right transition-all duration-200 scale-95 opacity-0 hidden">
                        <div class="p-3 border-b ">
                            <p class="text-sm font-medium text-gray-900 text-white truncate">{{ Auth::guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-500 text-gray-400 truncate">{{ Auth::guard('admin')->user()->email ?? 'Administrator' }}</p>
                        </div>
                        
                        <a href="{{ route('admin.profile') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 text-gray-300 hover:bg-indigo-50 hover:bg-white-700 transition-colors duration-150 group">
                            <i class="fas fa-user-circle mr-3 text-indigo-500 group-hover:text-indigo-600 transition-colors"></i>
                            <span>Profile Settings</span>
                        </a>
                        
                        <div class="border-t border-gray-100 border-gray-700"></div>
                       
                        <form method="POST" action="{{ route('admin.logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-3 text-sm text-gray-700 text-gray-300 hover:bg-red-50 hover:bg-red-900/20 transition-colors duration-150 group">
                                <i class="fas fa-sign-out-alt mr-3 text-red-500 group-hover:text-red-600 transition-colors"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdownButton = document.getElementById('profileDropdownButton');
            const profileDropdown = document.getElementById('profileDropdown');
            const chevronIcon = profileDropdownButton.querySelector('.fa-chevron-down');

            if (profileDropdownButton && profileDropdown) {
                profileDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = profileDropdown.classList.contains('hidden');
                    
                    if (isHidden) {
                        profileDropdown.classList.remove('hidden');
                        setTimeout(() => {
                            profileDropdown.classList.remove('scale-95', 'opacity-0');
                            profileDropdown.classList.add('scale-100', 'opacity-100');
                            chevronIcon.classList.add('rotate-180');
                        }, 10);
                    } else {
                        profileDropdown.classList.remove('scale-100', 'opacity-100');
                        profileDropdown.classList.add('scale-95', 'opacity-0');
                        chevronIcon.classList.remove('rotate-180');
                        setTimeout(() => {
                            profileDropdown.classList.add('hidden');
                        }, 200);
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileDropdownButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.remove('scale-100', 'opacity-100');
                        profileDropdown.classList.add('scale-95', 'opacity-0');
                        chevronIcon.classList.remove('rotate-180');
                        setTimeout(() => {
                            profileDropdown.classList.add('hidden');
                        }, 200);
                    }
                });
            }
            
            // Add subtle animation to header on scroll
            let lastScrollY = window.scrollY;
            const header = document.getElementById('header');
            
            window.addEventListener('scroll', () => {
                if (window.scrollY > lastScrollY && window.scrollY > 50) {
                    header.classList.add('-translate-y-full');
                } else {
                    header.classList.remove('-translate-y-full');
                }
                lastScrollY = window.scrollY;
            });
        });
    </script>
</header>