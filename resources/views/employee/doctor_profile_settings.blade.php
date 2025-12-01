@extends('layouts.doctor-dashboard')

@section('content')

<div class="p-6">

    <div class="bg-white shadow-md rounded-xl p-6 border">

        <h2 class="text-xl font-semibold mb-4">Doctor Profile Settings</h2>

        @if(session('success'))
        <div class="p-3 rounded mb-4" style="background-color: #d1fae5; color: #065f46;">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('doctor.update.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- CARD: Personal Details -->
            <div class="bg-gray-50 p-5 rounded-lg border mb-6">
                <h3 class="text-lg font-semibold mb-4">Personal Information</h3>

                <div class="grid grid-cols-2 gap-4">

                    <!-- Name -->
                    <div>
                        <label class="font-medium">Name</label>
                        <input type="text" name="name"
                            class="w-full p-2 border rounded"
                            value="{{ $doctor->name }}">
                    </div>

                    <div>
                        <label class="font-medium">Email</label>
                        <input type="email" name="email"
                            class="w-full p-2 border rounded"
                            value="{{ $doctor->email }}">
                    </div>

                    <div>
                        <label class="font-medium">Phone</label>
                        <input type="text" name="phone"
                            class="w-full p-2 border rounded"
                            value="{{ $doctor->phone }}">
                    </div>

                    <div>
                        <label class="font-medium">Gender</label>
                        <select name="gender" class="w-full p-2 border rounded">
                            <option value="Male" {{ $doctor->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $doctor->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $doctor->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-medium">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                            class="w-full p-2 border rounded"
                            value="{{ $doctor->date_of_birth ? \Carbon\Carbon::parse($doctor->date_of_birth)->format('Y-m-d') : '' }}">

                    </div>

                    <div>
                        <label class="font-medium">Profile Image</label>
                        <input type="file" name="image"
                            class="w-full p-2 border rounded">
                    </div>

                    <div class="col-span-2">
                        @if($doctor->image)
                        <img src="{{ asset('storage/'.$doctor->image) }}"
                            class="w-24 h-24 rounded-full mt-2 border shadow">
                        @endif
                    </div>

                </div>
            </div>

            <!-- CARD: Address -->
            <div class="bg-gray-50 p-5 rounded-lg border">
                <h3 class="text-lg font-semibold mb-3">Address Details</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Street</label>
                        <input type="text" name="street"
                            class="w-full p-2 border rounded"
                            value="{{ $address->street ?? '' }}">
                    </div>

                    <div>
                        <label class="font-medium">City</label>
                        <input type="text" name="city"
                            class="w-full p-2 border rounded"
                            value="{{ $address->city ?? '' }}">
                    </div>

                    <div>
                        <label class="font-medium">State</label>
                        <input type="text" name="state"
                            class="w-full p-2 border rounded"
                            value="{{ $address->state ?? '' }}">
                    </div>

                    <div>
                        <label class="font-medium">Country</label>
                        <input type="text" name="country"
                            class="w-full p-2 border rounded"
                            value="{{ $address->country ?? '' }}">
                    </div>

                    <div>
                        <label class="font-medium">Postal Code</label>
                        <input type="text" name="postal_code"
                            class="w-full p-2 border rounded"
                            value="{{ $address->postal_code ?? '' }}">
                    </div>
                </div>
            </div>

            <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Save Changes
            </button>

        </form>

    </div>

</div>

@endsection