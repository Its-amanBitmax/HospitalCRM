@extends('layouts.receptionist')

@section('content')
<div class=" min-h-screen">

    <h1 class="text-2xl font-bold mb-6">Profile Settings</h1>

    @if(session('success'))
    <div class="bg-green-500 text-white p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('receptionists.profile.update') }}"
        method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Name -->
            <div>
                <label class="font-semibold">Full Name</label>
                <input type="text" name="name"
                    value="{{ old('name', $employee->name) }}"
                    class="w-full p-2 border rounded">
            </div>

            <!-- Email -->
            <div>
                <label class="font-semibold">Email</label>
                <input type="email" name="email"
                    value="{{ old('email', $employee->email) }}"
                    class="w-full p-2 border rounded">
            </div>

            <!-- Phone -->
            <div>
                <label class="font-semibold">Phone</label>
                <input type="text" name="phone"
                    value="{{ old('phone', $employee->phone) }}"
                    class="w-full p-2 border rounded">
            </div>




            <!-- Gender -->
            <div>
                <label class="font-semibold">Gender</label>
                <select name="gender" class="w-full p-2 border rounded">
                    <option value="">Select</option>
                    <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $employee->gender == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Hire Date -->


            <!-- Status -->
            <div>
                <label class="font-semibold">Status</label>
                <select name="status" class="w-full p-2 border rounded">
                    <option value="Active" {{ $employee->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Image -->
            <div>
                <label class="font-semibold">Profile Image</label>
                <input type="file" name="image" class="w-full p-2 border rounded">

                @if($employee->image)
                <img src="{{ Storage::url($employee->image) }}"
                    class="w-24 h-24 mt-3 rounded-full border">
                @endif

            </div>

        </div>

        <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded">
            Save Changes
        </button>

    </form>
</div>
@endsection