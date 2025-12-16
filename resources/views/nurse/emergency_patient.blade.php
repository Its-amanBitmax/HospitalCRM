@extends('layouts.nursionist')

@section('content')
<div class="px-4 py-3">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="font-bold text-gray-800 mb-1 text-lg">
                <i class="fas fa-ambulance mr-2 text-red-600"></i>Emergency Patients
            </h2>
            <p class="text-gray-600 text-sm">Real-time monitoring of emergency cases</p>
        </div>
        <div class="bg-red-600 text-white rounded-lg px-4 py-2 text-center">
            <div class="font-bold text-xl" id="activeCount">{{ $emergencyPatients->count() }}</div>
            <div class="text-xs">Active Cases</div>
        </div>
    </div>

    <div id="emergencyContent">
        @if($emergencyPatients->count() > 0)
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-white rounded-lg shadow p-3 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                        <i class="fas fa-male"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg">{{ $emergencyPatients->where('gender', 'male')->count() }}</div>
                        <div class="text-gray-500 text-sm">Male</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center mr-3">
                        <i class="fas fa-female"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg">{{ $emergencyPatients->where('gender', 'female')->count() }}</div>
                        <div class="text-gray-500 text-sm">Female</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center mr-3">
                        <i class="fas fa-tint"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg">{{ $emergencyPatients->where('blood_group', '!=', null)->count() }}</div>
                        <div class="text-gray-500 text-sm">Blood Group</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-3 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="font-bold text-lg">{{ $emergencyPatients->where('created_at', '>=', now()->subHours(24))->count() }}</div>
                        <div class="text-gray-500 text-sm">Last 24h</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="mb-3 md:mb-0">
                        <h5 class="font-bold text-gray-800 mb-1">Emergency Patients List</h5>
                        <p class="text-gray-600 text-sm">All active emergency cases</p>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text"
                                class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Search patients..."
                                id="searchInput">
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medical</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrival</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($emergencyPatients as $index => $patient)
                        @php
                            // Set Asia/Kolkata timezone for calculations
                            $timezone = new DateTimeZone('Asia/Kolkata');
                            $now = Carbon\Carbon::now($timezone);
                            $created = Carbon\Carbon::parse($patient->created_at)->setTimezone($timezone);
                            
                            $diffInSeconds = $now->diffInSeconds($created);
                            $diffInMinutes = $now->diffInMinutes($created);
                            $diffInHours = $now->diffInHours($created);
                            $diffInDays = $now->diffInDays($created);
                            
                            // Format time display
                            if ($diffInDays > 0) {
                                if ($diffInDays >= 30) {
                                    $months = floor($diffInDays / 30);
                                    $timeAgo = $months . ($months == 1 ? ' month ago' : ' months ago');
                                } else {
                                    $timeAgo = $diffInDays . ($diffInDays == 1 ? ' day ago' : ' days ago');
                                }
                            } elseif ($diffInHours > 0) {
                                $timeAgo = $diffInHours . ($diffInHours == 1 ? ' hour ago' : ' hours ago');
                            } elseif ($diffInMinutes > 0) {
                                $timeAgo = $diffInMinutes . ($diffInMinutes == 1 ? ' minute ago' : ' minutes ago');
                            } else {
                                $timeAgo = $diffInSeconds . ($diffInSeconds == 1 ? ' second ago' : ' seconds ago');
                            }
                            
                            // Priority logic based on hours
                            if($diffInHours < 1) {
                                $priority = ['color' => 'red', 'icon' => 'exclamation-triangle', 'label' => 'Critical'];
                            } elseif($diffInHours < 6) {
                                $priority = ['color' => 'yellow', 'icon' => 'exclamation-circle', 'label' => 'Urgent'];
                            } else {
                                $priority = ['color' => 'green', 'icon' => 'check-circle', 'label' => 'Stable'];
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 patient-row" data-priority="{{ $diffInHours < 1 ? 'high' : ($diffInHours < 6 ? 'medium' : 'low') }}">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-gray-500 font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold mr-3 
                                            @if($priority['color'] === 'red') bg-red-100 text-red-600
                                            @elseif($priority['color'] === 'yellow') bg-yellow-100 text-yellow-600
                                            @else bg-green-100 text-green-600 @endif">
                                            {{ substr($patient->full_name, 0, 1) }}
                                        </div>
                                        @if($diffInHours < 1)
                                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full animate-pulse">
                                            NEW
                                        </span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $patient->full_name }}</div>
                                        <div class="flex items-center mt-1">
                                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded">
                                                ID: {{ $patient->user_id ?? $patient->id }}
                                            </span>
                                            @if($patient->father_spouse_name)
                                            <span class="text-gray-500 text-xs ml-2">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $patient->father_spouse_name }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="space-y-1">
                                    @if($patient->mobile_no)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-green-600 mr-2 text-sm"></i>
                                        <span class="font-medium">{{ $patient->mobile_no }}</span>
                                    </div>
                                    @endif
                                    @if($patient->email)
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-blue-600 mr-2 text-sm"></i>
                                        <span class="text-sm truncate">{{ $patient->email }}</span>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @if($patient->age)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                        {{ $patient->age }}y
                                    </span>
                                    @endif

                                    @if($patient->gender)
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                                        {{ ucfirst($patient->gender) }}
                                    </span>
                                    @endif

                                    @if($patient->blood_group)
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                                        {{ $patient->blood_group }}
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="inline-flex items-center px-3 py-2 rounded-lg 
                                    @if($priority['color'] === 'red') bg-red-50 text-red-700 border-l-4 border-red-500
                                    @elseif($priority['color'] === 'yellow') bg-yellow-50 text-yellow-700 border-l-4 border-yellow-500
                                    @else bg-green-50 text-green-700 border-l-4 border-green-500 @endif">
                                    <i class="fas fa-{{ $priority['icon'] }} mr-2"></i>
                                    <div>
                                        <div class="font-bold">{{ $priority['label'] }}</div>
                                        <div class="text-xs opacity-75">{{ $timeAgo }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div>
                                    <div class="font-medium">{{ $created->format('d M Y') }}</div>
                                    <div class="text-gray-500 text-sm">
                                        {{ $created->format('h:i A') }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-3 md:mb-0">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <i class="fas fa-sync-alt text-blue-600 text-sm"></i>
                        </div>
                        <div class="text-gray-600 text-sm">
                            Last updated: <span id="lastUpdated">{{ now()->setTimezone('Asia/Kolkata')->format('h:i:s A') }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-gray-600 text-sm">
                            Showing <span id="showingCount">{{ $emergencyPatients->count() }}</span> patients
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow">
            <div class="text-center py-12">
                <div class="mb-4">
                    <i class="fas fa-ambulance text-5xl text-green-400 opacity-50"></i>
                </div>
                <h3 class="font-bold text-green-600 text-lg mb-2">No Active Emergencies</h3>
                <p class="text-gray-600 mb-6">All emergency cases are currently under control.</p>
                <div class="bg-green-50 text-green-700 rounded-lg p-4 max-w-md mx-auto">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <span class="font-medium">System Status: Normal</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    
    // Search functionality
    function attachSearchFunctionality() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                searchTimeout = setTimeout(() => {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.patient-row');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = searchTerm === '' || text.includes(searchTerm) ? '' : 'none';
                    });
                }, 300); // Debounce 300ms
            });
        }
    }
    
    // Initialize search
    attachSearchFunctionality();
    
    // Function to show update notification
    function showUpdateNotification() {
        const notification = document.createElement('div');
        notification.className = 'update-notification';
        notification.innerHTML = `
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded-lg shadow-lg mb-3">
                <div class="flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i>
                    <span>Data updated successfully</span>
                </div>
            </div>
        `;
        
        const container = document.getElementById('emergencyContent');
        if (container) {
            container.insertBefore(notification, container.firstChild);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 500);
            }, 3000);
        }
    }
    
    // Function to format time in Indian timezone
    function formatIndianTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString('en-IN', {
            timeZone: 'Asia/Kolkata',
            hour12: true,
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit'
        });
    }
    
    // Function to update emergency data via AJAX
    function updateEmergencyData() {
        fetch('{{ route("nurse.emergency.patients") }}?ajax=1', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            cache: 'no-cache'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.html) {
                // Update the container with new content
                const container = document.getElementById('emergencyContent');
                if (container) {
                    // Store scroll position
                    const scrollPos = window.scrollY;
                    
                    // Update content
                    container.innerHTML = data.html;
                    
                    // Restore scroll position
                    window.scrollTo(0, scrollPos);
                    
                    // Update active count
                    const activeCountElement = document.getElementById('activeCount');
                    if (activeCountElement && data.count !== undefined) {
                        activeCountElement.textContent = data.count;
                    }
                    
                    // Update showing count
                    const showingCountElement = document.getElementById('showingCount');
                    if (showingCountElement && data.count !== undefined) {
                        showingCountElement.textContent = data.count;
                    }
                    
                    // Update last updated time in Indian format
                    const lastUpdatedElement = document.getElementById('lastUpdated');
                    if (lastUpdatedElement && data.timestamp) {
                        lastUpdatedElement.textContent = formatIndianTime(data.timestamp);
                    }
                    
                    // Reattach search functionality
                    attachSearchFunctionality();
                    
                    // Show update notification
                    showUpdateNotification();
                }
            }
        })
        .catch(error => {
            console.error('Error fetching emergency data:', error);
            // Retry after 30 seconds on error
            setTimeout(updateEmergencyData, 30000);
        });
    }
    
    // Auto-refresh every 60 seconds (1 minute)
    setInterval(updateEmergencyData, 60000);
    
    // Also update every 10 minutes as backup (600000ms = 10 minutes)
    setInterval(() => {
        updateEmergencyData();
    }, 600000);
    
    // Initial call after 5 seconds to ensure page is loaded
    setTimeout(updateEmergencyData, 5000);
});
</script>

<style>
    .patient-row {
        transition: background-color 0.2s ease;
    }

    .patient-row:hover {
        background-color: #f9fafb;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    
    /* Update notification styles */
    .update-notification {
        animation: slideDown 0.5s ease-out;
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Smooth transitions for content updates */
    #emergencyContent {
        transition: opacity 0.3s ease;
    }
    
    #emergencyContent.updating {
        opacity: 0.7;
    }
</style>

@endsection