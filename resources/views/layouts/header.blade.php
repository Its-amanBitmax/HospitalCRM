<header id="header" class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="shrink-0 flex items-center">
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100"> Welcome {{ Auth::guard('admin')->user()->name }}! </h1>
            </div>
            <div class="flex items-center relative">
                <div class="relative">
                    <button id="profileDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                        @if(Auth::guard('admin')->user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_image) }}" alt="Profile Image" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                        @endif
                        <span class="text-gray-700 dark:text-gray-300">{{ Auth::guard('admin')->user()->name }}</span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>
                    <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 hidden">
                        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                       
                        <form method="POST" action="{{ route('admin.logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
