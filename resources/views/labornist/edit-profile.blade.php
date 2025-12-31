@extends('layouts.labornist')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-cyan-50 to-cyan-50 px-8 py-6">
            <h2 class="text-2xl font-bold">Edit Profile</h2>
            <p class="text-sm mt-1">Update your personal and professional information</p>
        </div>

        {{-- ================= MESSAGES ================= --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST"
              action="{{route('laborist.profile.update')}}"
              enctype="multipart/form-data"
              class="p-8">
            @csrf

            {{-- ================= BASIC INFO ================= --}}
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Basic Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $labornist->name) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $labornist->email) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $labornist->phone) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                               value="{{ $labornist->date_of_birth ? \Carbon\Carbon::parse($labornist->date_of_birth)->format('Y-m-d') : '' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ $labornist->gender=='Male'?'selected':'' }}>Male</option>
                            <option value="Female" {{ $labornist->gender=='Female'?'selected':'' }}>Female</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="Active" {{ $labornist->status=='Active'?'selected':'' }} class="text-green-600">Active</option>
                            <option value="Inactive" {{ $labornist->status=='Inactive'?'selected':'' }} class="text-red-600">Inactive</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Department</label>
                        <select name="department_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Select Department</option>
                            @foreach(\App\Models\Department::all() as $dept)
                                <option value="{{ $dept->id }}" {{ $labornist->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Profile Image</label>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="file" name="image" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       id="image-upload"
                                       onchange="previewImage(event)">
                                <div class="border-2 border-dashed border-gray-300 rounded-lg px-4 py-8 text-center hover:border-blue-400 transition duration-200 cursor-pointer">
                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-500">Click to upload</span>
                                </div>
                            </div>
                            @if($labornist->image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/'.$labornist->image) }}"
                                         class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg"
                                         id="image-preview">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                                        <span class="text-white text-xs">Current</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= ADDRESSES ================= --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Addresses</h3>
                    </div>
                    <button type="button" onclick="addAddress()" 
                            class="flex items-center gap-2 bg-green-50 text-green-700 hover:bg-green-100 px-4 py-2 rounded-lg transition duration-200 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Address
                    </button>
                </div>

                <div id="address-wrapper" class="space-y-4">
                    @foreach($labornist->addresses as $address)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative group hover:border-green-300 transition duration-200">
                            <button type="button" onclick="removeAddress(this)" 
                                    class="absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <input type="hidden" name="addresses[{{ $address->id }}][id]" value="{{ $address->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Address Type</label>
                                    <select name="addresses[{{ $address->id }}][address_type]" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                        <option value="Home" {{ $address->address_type == 'Home' ? 'selected' : '' }}>Home</option>
                                        <option value="Work" {{ $address->address_type == 'Work' ? 'selected' : '' }}>Work</option>
                                        <option value="Other" {{ $address->address_type == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Street</label>
                                    <input name="addresses[{{ $address->id }}][street]"
                                           value="{{ $address->street }}"
                                           placeholder="123 Main Street"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">City</label>
                                    <input name="addresses[{{ $address->id }}][city]"
                                           value="{{ $address->city }}"
                                           placeholder="New York"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">State</label>
                                    <input name="addresses[{{ $address->id }}][state]"
                                           value="{{ $address->state }}"
                                           placeholder="NY"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Country</label>
                                    <input name="addresses[{{ $address->id }}][country]"
                                           value="{{ $address->country }}"
                                           placeholder="USA"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Postal Code</label>
                                    <input name="addresses[{{ $address->id }}][postal_code]"
                                           value="{{ $address->postal_code }}"
                                           placeholder="12345"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= QUALIFICATIONS ================= --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Qualifications</h3>
                    </div>
                    <button type="button" onclick="addQualification()"
                            class="flex items-center gap-2 bg-purple-50 text-purple-700 hover:bg-purple-100 px-4 py-2 rounded-lg transition duration-200 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Qualification
                    </button>
                </div>

                <div id="qualification-wrapper" class="space-y-4">
                    @foreach($labornist->qualifications as $q)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative group hover:border-purple-300 transition duration-200">
                            <button type="button" onclick="removeQualification(this)" 
                                    class="absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <input type="hidden" name="qualifications[{{ $q->id }}][id]" value="{{ $q->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Degree</label>
                                    <input name="qualifications[{{ $q->id }}][degree]"
                                           value="{{ $q->degree }}"
                                           placeholder="Bachelor of Science"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Institution</label>
                                    <input name="qualifications[{{ $q->id }}][institution]"
                                           value="{{ $q->institution }}"
                                           placeholder="University Name"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Year Completed</label>
                                    <input name="qualifications[{{ $q->id }}][year_completed]"
                                           value="{{ $q->year_completed }}"
                                           placeholder="2020"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= DOCUMENTS ================= --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Documents</h3>
                    </div>
                    <button type="button" onclick="addDocument()"
                            class="flex items-center gap-2 bg-amber-50 text-amber-700 hover:bg-amber-100 px-4 py-2 rounded-lg transition duration-200 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Document
                    </button>
                </div>

                <div id="document-wrapper" class="space-y-4">
                    @foreach($labornist->documents as $doc)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative group hover:border-amber-300 transition duration-200">
                            <button type="button" onclick="removeDocument(this)" 
                                    class="absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <input type="hidden" name="documents[{{ $doc->id }}][id]" value="{{ $doc->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Document Type</label>
                                    <input type="text"
                                           name="documents[{{ $doc->id }}][document_type]"
                                           value="{{ $doc->document_type }}"
                                           placeholder="License, Certificate, etc."
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm text-gray-600">Upload File</label>
                                    <div class="relative">
                                        <input type="file"
                                               name="documents[{{ $doc->id }}][document_path]"
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                               onchange="updateFileName(this)">
                                        <div class="border border-gray-300 rounded-lg px-4 py-3 bg-white cursor-pointer hover:bg-gray-50 transition duration-200">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-500" id="file-name-{{ $doc->id }}">Choose file...</span>
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($doc->document_path)
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ asset('storage/'.$doc->document_path) }}"
                                           target="_blank"
                                           class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Document
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= SUBMIT ================= --}}
            <div class="pt-8 border-t border-gray-200">
                <div class="flex justify-end space-x-4">
                    <button type="button"
                            onclick="window.history.back()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-200 font-medium shadow-md hover:shadow-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Profile
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
let a = 1000, q = 2000, d = 3000;

function addAddress(){
    a++;
    const addressHtml = `
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative group hover:border-green-300 transition duration-200">
            <button type="button" onclick="removeAddress(this)"
                    class="absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200 opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Address Type</label>
                    <select name="addresses[new_${a}][address_type]" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                        <option value="Home">Home</option>
                        <option value="Work">Work</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Street</label>
                    <input name="addresses[new_${a}][street]" placeholder="123 Main Street" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">City</label>
                    <input name="addresses[new_${a}][city]" placeholder="New York" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">State</label>
                    <input name="addresses[new_${a}][state]" placeholder="NY" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Country</label>
                    <input name="addresses[new_${a}][country]" placeholder="USA" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Postal Code</label>
                    <input name="addresses[new_${a}][postal_code]" placeholder="12345" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                </div>
            </div>
        </div>`;
    document.getElementById('address-wrapper').insertAdjacentHTML('beforeend', addressHtml);
}

function addQualification(){
    q++;
    const qualificationHtml = `
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative group hover:border-purple-300 transition duration-200">
            <button type="button" onclick="removeQualification(this)" 
                    class="absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200 opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Degree</label>
                    <input name="qualifications[new_${q}][degree]" placeholder="Bachelor of Science" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Institution</label>
                    <input name="qualifications[new_${q}][institution]" placeholder="University Name" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Year Completed</label>
                    <input name="qualifications[new_${q}][year_completed]" placeholder="2020" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                </div>
            </div>
        </div>`;
    document.getElementById('qualification-wrapper').insertAdjacentHTML('beforeend', qualificationHtml);
}

function addDocument(){
    d++;
    const documentHtml = `
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 relative group hover:border-amber-300 transition duration-200">
            <button type="button" onclick="removeDocument(this)" 
                    class="absolute top-4 right-4 bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200 opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Document Type</label>
                    <input name="documents[new_${d}][document_type]" placeholder="License, Certificate, etc." class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm text-gray-600">Upload File</label>
                    <div class="relative">
                        <input type="file" name="documents[new_${d}][document_path]"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               onchange="updateFileName(this)">
                        <div class="border border-gray-300 rounded-lg px-4 py-3 bg-white cursor-pointer hover:bg-gray-50 transition duration-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Choose file...</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    document.getElementById('document-wrapper').insertAdjacentHTML('beforeend', documentHtml);
}

function removeAddress(button) {
    button.closest('.border').remove();
}

function removeQualification(button) {
    button.closest('.border').remove();
}

function removeDocument(button) {
    button.closest('.border').remove();
}

function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('image-preview');
    reader.onload = function(){
        if(preview) {
            preview.src = reader.result;
        } else {
            // Create preview if it doesn't exist
            const container = event.target.closest('.space-y-2').querySelector('.flex.items-center.space-x-4');
            if(container) {
                container.innerHTML += `
                    <div class="relative group">
                        <img src="${reader.result}" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" id="image-preview">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                            <span class="text-white text-xs">New</span>
                        </div>
                    </div>
                `;
            }
        }
    }
    reader.readAsDataURL(event.target.files[0]);
}

function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'Choose file...';
    const displaySpan = input.parentElement.querySelector('.text-sm.text-gray-500');
    if(displaySpan) {
        displaySpan.textContent = fileName;
    }
}
</script>
@endsection