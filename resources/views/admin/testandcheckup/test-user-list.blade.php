    @extends('layouts.layout')

    @section('content')
    <div class="container mx-auto" style="width: 75%;">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Test Booked Users</h1>

        @if($users && $users->count() > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sample</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fasting</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                @if($user->testBook && $user->testBook->count() > 0)
                                    @foreach($user->testBook as $index => $booking)
                                        <tr class="hover:bg-gray-50">
                                            @if($index == 0)
                                                <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $user->testBook->count() }}">
                                                    <div class="flex items-center">
                                                        @if($user->image)
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->image) }}" alt="User Image">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                                <span class="text-sm font-medium text-gray-700">{{ substr($user->full_name, 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $user->full_name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $user->mobile_no }}</div>
                                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->test->test_name ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->start_time ?? '-' }} - {{ $booking->end_time ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                                    @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($booking->status ?? 'Unknown') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->test->category ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($booking->test->sample_required ?? false)
                                                    <span class="text-green-600">Yes</span>
                                                    @if($booking->test->sample_type)
                                                        <br><small class="text-gray-500">({{ $booking->test->sample_type }})</small>
                                                    @endif
                                                @else
                                                    <span class="text-red-600">No</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($booking->test->fasting_required ?? false)
                                                    <span class="text-green-600">Yes</span>
                                                @else
                                                    <span class="text-red-600">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No users with test bookings found</h3>
                <p class="text-gray-500">There are currently no users who have booked any tests.</p>
            </div>
        @endif
    </div>
    @endsection
