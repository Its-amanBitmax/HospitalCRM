<header id="header" class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="shrink-0 flex items-center">
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100"> Welcome Admin! </h1>
            </div>
            <div class="flex items-center">
                <span class="text-gray-700 dark:text-gray-300 mr-4">Welcome, {{ Auth::guard('admin')->user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
