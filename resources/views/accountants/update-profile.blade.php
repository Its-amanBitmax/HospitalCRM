@extends('layouts.accountant')

@section('content')
<div class="min-h-screen ">
    <div class="max-w-[960px]">
        <!-- Profile Update Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="h-32 bg-gradient-to-r from-cyan-200 to-cyan-300 relative">
                <div class="absolute bottom-4 left-6 flex items-end">
                    <div class="relative">
                        @if(auth('accountant')->user()->image)
                        <img src="{{ asset('storage/' . auth('accountant')->user()->image) }}"
                            alt="{{ auth('accountant')->user()->name }}"
                            class="h-24 w-24 rounded-full border-4 border-white shadow-md object-cover">
                        @else
                        <div class="h-24 w-24 rounded-full border-4 border-white bg-cyan-100 shadow-md flex items-center justify-center">
                            <span class="text-2xl font-bold text-cyan-600">
                                {{ substr(auth('accountant')->user()->name, 0, 1) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="ml-4 mb-2">
                        <h1 class="text-xl font-bold text-black">{{ auth('accountant')->user()->name }}</h1>
                        <p class="text-black text-opacity-90 text-sm">{{ auth('accountant')->user()->email }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-black text-xs">
                                {{ auth('accountant')->user()->employee_code }}
                            </span>
                            @if(auth('accountant')->user()->department)
                            <span class="px-2 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-black text-xs">
                                {{ auth('accountant')->user()->department->department_name }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('account.update.profile') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @php
                $user = auth('accountant')->user();
                @endphp
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Update Profile Information</h2>
                    <div class="flex gap-3">
                        <a href="#"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg transition">
                            Save Changes
                        </button>
                    </div>
                </div>

                <!-- Personal Info Section -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Personal Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                    required>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                                    required>
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Emergency Contact -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact</label>
                                <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $user->emergency_contact) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                @error('emergency_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image Upload -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Picture</h3>
                        <div class="flex items-center space-x-6">
                            <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-gray-300">
                                @if($user->image)
                                <img id="profile-preview" src="{{ asset('storage/' . $user->image) }}"
                                    alt="Profile Preview" class="h-full w-full object-cover">
                                @else
                                <div id="profile-preview" class="h-full w-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="hidden" onchange="previewImage(event)">
                                <label for="image" class="cursor-pointer">
                                    <div class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Upload New Photo
                                    </div>
                                </label>
                                <p class="text-sm text-gray-500 mt-2">JPG, PNG or GIF (Max 2MB)</p>
                                @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    @if($user->addresses->isNotEmpty())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Address Information</h3>
                        @foreach($user->addresses as $index => $address)
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <h4 class="font-medium text-gray-900 mb-3 capitalize">{{ $address->address_type }} Address</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                                <input type="hidden" name="addresses[{{ $index }}][address_type]" value="{{ $address->address_type }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Street</label>
                                    <input type="text" name="addresses[{{ $index }}][street]"
                                        value="{{ old('addresses.' . $index . '.street', $address->street) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="addresses[{{ $index }}][city]"
                                        value="{{ old('addresses.' . $index . '.city', $address->city) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                    <input type="text" name="addresses[{{ $index }}][state]"
                                        value="{{ old('addresses.' . $index . '.state', $address->state) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                    <input type="text" name="addresses[{{ $index }}][postal_code]"
                                        value="{{ old('addresses.' . $index . '.postal_code', $address->postal_code) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                    <input type="text" name="addresses[{{ $index }}][country]"
                                        value="{{ old('addresses.' . $index . '.country', $address->country) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Professional Information -->
                    @if($user->professions->isNotEmpty())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Information</h3>
                        @foreach($user->professions as $index => $profession)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="hidden" name="professions[{{ $index }}][id]" value="{{ $profession->id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                    <input type="text" name="professions[{{ $index }}][title]"
                                        value="{{ old('professions.' . $index . '.title', $profession->title) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Qualifications -->
                    @if($user->qualifications->isNotEmpty())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Qualifications</h3>
                        @foreach($user->qualifications as $index => $qualification)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="hidden" name="qualifications[{{ $index }}][id]" value="{{ $qualification->id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                                    <input type="text" name="qualifications[{{ $index }}][degree]"
                                        value="{{ old('qualifications.' . $index . '.degree', $qualification->degree) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                                    <input type="text" name="qualifications[{{ $index }}][institution]"
                                        value="{{ old('qualifications.' . $index . '.institution', $qualification->institution) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Year Completed</label>
                                    <input type="text" name="qualifications[{{ $index }}][year_completed]"
                                        value="{{ old('qualifications.' . $index . '.year_completed', $qualification->year_completed) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Family Details -->
                    @if($user->familyDetails->isNotEmpty())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Family Details</h3>
                        @foreach($user->familyDetails as $index => $family)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="hidden" name="familyDetails[{{ $index }}][id]" value="{{ $family->id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" name="familyDetails[{{ $index }}][name]"
                                        value="{{ old('familyDetails.' . $index . '.name', $family->name) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Relationship</label>
                                    <input type="text" name="familyDetails[{{ $index }}][relationship]"
                                        value="{{ old('familyDetails.' . $index . '.relationship', $family->relationship) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                    <input type="date" name="familyDetails[{{ $index }}][date_of_birth]"
                                        value="{{ old('familyDetails.' . $index . '.date_of_birth', $family->date_of_birth) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                    <input type="text" name="familyDetails[{{ $index }}][contact_number]"
                                        value="{{ old('familyDetails.' . $index . '.contact_number', $family->contact_number) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Bank Details -->
                    @if($user->payroll)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bank Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="hidden" name="payroll[id]" value="{{ $user->payroll->id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                                    <input type="text" name="payroll[bank_name]"
                                        value="{{ old('payroll.bank_name', $user->payroll->bank_name) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                                    <input type="text" name="payroll[bank_account]"
                                        value="{{ old('payroll.bank_account', $user->payroll->bank_account) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">IFSC Code</label>
                                    <input type="text" name="payroll[ifsc_code]"
                                        value="{{ old('payroll.ifsc_code', $user->payroll->ifsc_code) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">UPI ID</label>
                                    <input type="text" name="payroll[upi_number]"
                                        value="{{ old('payroll.upi_number', $user->payroll->upi_number) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">PF Number</label>
                                    <input type="text" name="payroll[pf_number]"
                                        value="{{ old('payroll.pf_number', $user->payroll->pf_number) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profile-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    // Replace div with image
                    const img = document.createElement('img');
                    img.id = 'profile-preview';
                    img.src = e.target.result;
                    img.className = 'h-full w-full object-cover';
                    preview.parentNode.replaceChild(img, preview);
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tab switching functionality
    function switchTab(tabName) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-cyan-500', 'text-cyan-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        // Add active class to clicked tab
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active', 'border-cyan-500', 'text-cyan-600');
        document.querySelector(`[data-tab="${tabName}"]`).classList.remove('border-transparent', 'text-gray-500');

        // Show selected tab content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById(`${tabName}-tab`).classList.remove('hidden');
    }

    // Initialize first tab as active
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('personal');
    });
</script>

<style>
    .tab-button.active {
        border-color: #06b6d4;
        color: #06b6d4;
    }
</style>
@endsection