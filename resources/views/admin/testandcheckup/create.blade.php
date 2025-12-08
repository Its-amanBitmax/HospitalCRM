@extends('layouts.layout')

@section('content')
<div class="container mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Add New Test / Checkup</h1>
            <p class="text-gray-600 mt-1">Create a new laboratory test or medical checkup</p>
        </div>
        <div class="flex items-center space-x-3 mt-4 md:mt-0">

            <a href="{{route('admin.test.checkup')}}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Tests
            </a>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center space-x-6">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">1</div>
                <span class="ml-3 font-medium text-blue-600">Basic Info</span>
            </div>
            <div class="h-1 w-12 bg-gray-300"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-semibold">2</div>
                <span class="ml-3 font-medium text-gray-500">Sample Details</span>
            </div>
            <div class="h-1 w-12 bg-gray-300"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-semibold">3</div>
                <span class="ml-3 font-medium text-gray-500">Technical Info</span>
            </div>
            <div class="h-1 w-12 bg-gray-300"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-semibold">4</div>
                <span class="ml-3 font-medium text-gray-500">Review</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-flask text-blue-600 mr-3"></i> Test Information Form
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Fill in all required fields marked with *</p>
                </div>

                <form action="{{route('admin.testcheckup.store')}}" method="POST" class="p-6">
                    @csrf

                    <!-- Section 1: Basic Information -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-6 bg-blue-600 rounded-full mr-3"></div>
                            <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Test Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Test Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-stethoscope text-gray-400"></i>
                                    </div>
                                    <input type="text" name="test_name" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Enter test name" required oninput="updateCharCount(this)">
                                </div>
                                <div class="mt-1 text-right">
                                    <span id="charCount" class="text-xs text-gray-500">0/100 characters</span>
                                </div>
                            </div>

                            <!-- Test Code -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Test Code <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded ml-2">Optional</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-barcode text-gray-400"></i>
                                    </div>
                                    <input type="text" name="test_code" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="e.g., CBC-001">
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                    <select name="category" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none">
                                        <option value="">Select Category</option>
                                        <option value="Blood">Blood Test</option>
                                        <option value="Urine">Urine Test</option>
                                        <option value="Radiology">Radiology</option>
                                        <option value="Cardiology">Cardiology</option>
                                        <option value="Hormone">Hormone</option>
                                        <option value="General">General</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-gray-400"></i>
                                    </div>
                                    <select name="department_id" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Pricing & Logistics -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-6 bg-green-600 rounded-full mr-3"></div>
                            <h3 class="text-lg font-semibold text-gray-800">Logistics</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Turnaround Time -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Turnaround Time</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <select name="tat" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none">
                                        <option value="">Select TAT</option>
                                        <option value="2 Hours">2 Hours (Express)</option>
                                        <option value="4 Hours">4 Hours</option>
                                        <option value="24 Hours">24 Hours</option>
                                        <option value="48 Hours">48 Hours</option>
                                        <option value="1 Week">1 Week</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="flex space-x-3">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="status" value="active" checked class="hidden peer">
                                        <div class="px-4 py-3 border border-gray-300 rounded-lg text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-600 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-check-circle mr-2"></i> Active
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="status" value="inactive" class="hidden peer">
                                        <div class="px-4 py-3 border border-gray-300 rounded-lg text-center peer-checked:border-gray-400 peer-checked:bg-gray-100 peer-checked:text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-pause-circle mr-2"></i> Inactive
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Section 3: Sample Details -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-6 bg-purple-600 rounded-full mr-3"></div>
                            <h3 class="text-lg font-semibold text-gray-800">Sample Details</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Sample Required -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sample Required?</label>
                                <div class="flex items-center justify-between bg-gray-100 p-1 rounded-lg">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="sample_required" value="0" checked class="hidden peer" onchange="toggleSampleType(false)">
                                        <div class="px-4 py-2 text-center rounded-md peer-checked:bg-white peer-checked:shadow-sm">No</div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="sample_required" value="1" class="hidden peer" onchange="toggleSampleType(true)">
                                        <div class="px-4 py-2 text-center rounded-md peer-checked:bg-white peer-checked:shadow-sm">Yes</div>
                                    </label>
                                </div>
                            </div>

                            <!-- Sample Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sample Type</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-vial text-gray-400"></i>
                                    </div>
                                    <select name="sample_type" id="sampleType" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none" disabled>
                                        <option value="">Select Sample Type</option>
                                        <option value="Blood">Blood</option>
                                        <option value="Urine">Urine</option>
                                        <option value="Stool">Stool</option>
                                        <option value="Swab">Swab</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Unit -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-ruler text-gray-400"></i>
                                    </div>
                                    <input type="text" name="unit" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="mg/dL, %, bpm etc">
                                </div>
                            </div>
                        </div>

                        <!-- Fasting Required -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Fasting Required?</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="fasting_required" value="0" checked class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-utensils text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">No Fasting</div>
                                                <div class="text-sm text-gray-600">Patient can eat normally</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="fasting_required" value="1" class="hidden peer">
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-colors">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-ban text-orange-600"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">Fasting Required</div>
                                                <div class="text-sm text-gray-600">8-12 hours fasting needed</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Technical Details -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="w-1 h-6 bg-yellow-600 rounded-full mr-3"></div>
                            <h3 class="text-lg font-semibold text-gray-800">Technical Details</h3>
                        </div>

                        <!-- Normal Range -->
                        <div class="mb-2">
                            <!-- <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Normal Range</label>
                                <button type="button" onclick="addRangeField()" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Add Range
                                </button>
                            </div>

                            <div id="rangeFields" class="space-y-3 mb-3">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" name="range_group[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Group (e.g., Adult Male)">
                                    <input type="text" name="range_min[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Min Value">
                                    <input type="text" name="range_max[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Max Value">
                                    <input type="text" name="range_unit[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Unit">
                                </div>
                            </div> -->

                            <!-- <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Or enter JSON format:</label>
                                <textarea name="normal_range" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" rows="2" placeholder='{"male": "13-17 g/dL", "female": "12-15 g/dL"}'></textarea>
                            </div> -->
                        </div>

                        <!-- Instructions -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Patient Instructions</label>
                            <textarea name="instructions" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" rows="4" placeholder="Enter patient instructions here..."></textarea>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button type="button" onclick="addInstruction('fasting')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Add Fasting Instructions
                                </button>
                                <button type="button" onclick="addInstruction('medication')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Add Medication Instructions
                                </button>
                                <button type="button" onclick="addInstruction('activity')" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Add Activity Instructions
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">

                            <div class="flex space-x-3">
                                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    Save Test
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="lg:col-span-1">
            <!-- Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clipboard-check text-green-600 mr-3"></i>
                        Form Summary
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Test Name</div>
                            <div id="summaryTestName" class="font-medium text-gray-800">Not entered</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Category & Department</div>
                            <div class="font-medium text-gray-800">
                                <span id="summaryCategory">Not selected</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span id="summaryDepartment">Not selected</span>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Status</div>
                            <div class="flex items-center justify-between">

                                <span id="summaryStatus" class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                    Active
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 mb-2">Completion</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 25%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 text-right" id="progressText">25% complete</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-600 mr-3"></i>
                        Quick Tips
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-sm text-gray-700">Ensure test name is clear and descriptive</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-sm text-gray-700">Double-check normal range values</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-sm text-gray-700">Provide clear patient instructions</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-sm text-gray-700">Set accurate turnaround time</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateSummary();
        updateProgress();

        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('input', function() {
                updateSummary();
                updateProgress();
            });
            element.addEventListener('change', function() {
                updateSummary();
                updateProgress();
            });
        });
    });

    function updateCharCount(input) {
        const charCount = document.getElementById('charCount');
        const length = input.value.length;
        charCount.textContent = `${length}/100 characters`;
        charCount.style.color = length > 90 ? '#dc2626' : '#6b7280';
    }

    function toggleSampleType(enabled) {
        const sampleTypeSelect = document.getElementById('sampleType');
        sampleTypeSelect.disabled = !enabled;
        sampleTypeSelect.classList.toggle('bg-gray-100', !enabled);
        if (!enabled) sampleTypeSelect.value = '';
    }

    function addRangeField() {
        const rangeFields = document.getElementById('rangeFields');
        const newField = document.createElement('div');
        newField.className = 'grid grid-cols-1 md:grid-cols-4 gap-3 items-start';
        newField.innerHTML = `
        <input type="text" name="range_group[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Group (e.g., Adult Female)" style="width: 100%;">
        <input type="text" name="range_min[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Min Value" style="width: 100%;">
        <input type="text" name="range_max[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Max Value" style="width: 100%;">
        <div class="flex flex-col">
            <input type="text" name="range_unit[]" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2" placeholder="Unit" style="width: 100%;">
           
        </div>
         <button type="button" onclick="removeRangeField(this)" class="px-2 py-1 border border-gray-300 rounded-lg hover:bg-gray-50 text-red-500 text-center" style="width: 30px;">
                X
            </button>
    `;
        rangeFields.appendChild(newField);
    }

    function removeRangeField(button) {
        button.closest('div.grid').remove();
    }


    function removeRangeField(button) {
        button.closest('div.grid').remove();
    }


    function removeRangeField(button) {
        button.closest('.grid').remove();
    }

    function addInstruction(type) {
        const textarea = document.querySelector('textarea[name="instructions"]');
        let instruction = '';
        switch (type) {
            case 'fasting':
                instruction = "• Fast for 8-12 hours before the test\n• Only water is allowed during fasting\n• Avoid alcohol 24 hours before test";
                break;
            case 'medication':
                instruction = "• Inform your doctor about all medications\n• Some medications may need to be paused\n• Bring medication list if possible";
                break;
            case 'activity':
                instruction = "• Avoid strenuous exercise 24 hours before\n• Get adequate rest the night before\n• Avoid smoking before the test";
                break;
        }
        textarea.value = textarea.value ? textarea.value + '\n\n' + instruction : instruction;
    }

    function updateSummary() {
        const testName = document.querySelector('input[name="test_name"]').value;
        const categorySelect = document.querySelector('select[name="category"]');
        const departmentSelect = document.querySelector('select[name="department_id"]');
        const status = document.querySelector('input[name="status"]:checked').value;

        const category = categorySelect.options[categorySelect.selectedIndex]?.text || 'Not selected';
        const department = departmentSelect.options[departmentSelect.selectedIndex]?.text || 'Not selected';

        document.getElementById('summaryTestName').textContent = testName || 'Not entered';
        document.getElementById('summaryCategory').textContent = categorySelect.value ? category : 'Not selected';
        document.getElementById('summaryDepartment').textContent = departmentSelect.value ? department : 'Not selected';

        const statusEl = document.getElementById('summaryStatus');
        statusEl.textContent = status === 'active' ? 'Active' : 'Inactive';
        statusEl.className = `px-3 py-1 text-xs font-medium rounded-full ${status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}`;
    }


    function updateProgress() {
        let progress = 25;
        const fields = [
            document.querySelector('input[name="test_name"]'),
            document.querySelector('select[name="category"]'),
            document.querySelector('select[name="department_id"]'),
            document.querySelector('input[name="price"]'),
            document.querySelector('select[name="tat"]'),
            document.querySelector('textarea[name="instructions"]')
        ];

        fields.forEach(field => {
            if (field && field.value && field.value.trim() !== '') {
                progress += 12.5;
            }
        });

        progress = Math.min(progress, 100);
        document.getElementById('progressBar').style.width = `${progress}%`;
        document.getElementById('progressText').textContent = `${progress}% complete`;
    }

    function showToast(message, type) {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        } else {
            alert(message);
        }
    }
</script>
@endsection