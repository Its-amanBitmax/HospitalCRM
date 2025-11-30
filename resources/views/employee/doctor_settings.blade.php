@extends('layouts.doctor-dashboard')

@section('content')

<div class="p-6">

    <div class="bg-white shadow-md rounded-xl p-6 border w-full md:w-1/2 mx-auto">

        <h2 class="text-xl font-semibold mb-4">Change Password</h2>

        @if(session('success'))
            <div class="p-3 rounded mb-4 bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('doctor.update.settings') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="font-medium">New Password</label>
                <input type="password" name="new_password" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-medium">Confirm Password</label>
                <input type="password" name="confirm_password" class="w-full p-2 border rounded">
            </div>

            <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Update Password
            </button>
        </form>

    </div>

</div>

@endsection
