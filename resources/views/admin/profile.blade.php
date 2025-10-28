@extends('layouts.layout')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Admin Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Profile Information -->
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Profile Information</h2>
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="profile">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100" required>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Image</label>
                            @if($admin->profile_image)
                                <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="Current Profile Image" class="w-20 h-20 rounded-full object-cover mb-2">
                            @endif
                            <input type="file" id="profile_image" name="profile_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Organization Information -->
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Organization Information</h2>
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="organization">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="hospital_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" id="hospital_name" name="hospital_name" value="{{ old('hospital_name', $admin->hospital_name) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="company_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                            <textarea id="company_address" name="company_address" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100">{{ old('company_address', $admin->company_address) }}</textarea>
                        </div>
                        <div>
                            <label for="company_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact</label>
                            <input type="text" id="company_contact" name="company_contact" value="{{ old('company_contact', $admin->company_contact) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" id="company_email" name="company_email" value="{{ old('company_email', $admin->company_email) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="company_website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                            <input type="url" id="company_website" name="company_website" value="{{ old('company_website', $admin->company_website) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
                            @if($admin->logo)
                                <img src="{{ asset('storage/' . $admin->logo) }}" alt="Current Logo" class="w-20 h-20 object-cover mb-2">
                            @endif
                            <input type="file" id="logo" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                        Update Organization Info
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Change Password</h2>
            <form action="{{ route('admin.profile.change-password') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100" required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100" required>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-100" required>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
