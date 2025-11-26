@extends('layouts.layout')  {{-- change according your layout --}}

@section('content')
<!-- Toast Notification -->

  <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-plus text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Add New Reception</h1>
        </div>
        <a href="{{route('admin.reception.index')}}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fa fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>
<div id="toast" style="
    position: fixed;
    top: 20px;
    right: 20px; 
    display: none;
    background-color: #38a169; 
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    z-index: 9999;
    min-width: 250px;
    text-align: right;
">
    <span id="toastMessage"></span>
</div>







<div class="max-w-full mx-auto mt-10 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
   

    

   <form action="{{ route('admin.reception.store') }}" method="POST" autocomplete="off">
    @csrf

    <!-- First Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">

        <!-- Reception ID -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium">
                Reception ID <span class="text-red-500">*</span>
            </label>
            <input type="text" name="reception_id" autocomplete="off" required
                class="w-full mt-1 px-3 py-2 bg-gray-50 dark:bg-gray-700
                border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800 dark:text-white">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium">
                Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password" autocomplete="new-password" required
                class="w-full mt-1 px-3 py-2 bg-gray-50 dark:bg-gray-700
                border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800 dark:text-white">
        </div>

    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

        <!-- Status -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium">Status</label>
            <select name="status" autocomplete="off"
                class="w-full mt-1 px-3 py-2 bg-gray-50 dark:bg-gray-700
                border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800 dark:text-white">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-3 mt-6">
        <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
            Reset
        </button>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
            Save Reception
        </button>
    </div>

</form>

</div>

<script>
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;
    if(type === 'success') {
        toast.style.backgroundColor = '#38a169'; 
    } else if(type === 'error') {
        toast.style.backgroundColor = '#e53e3e'; 
    } else {
        toast.style.backgroundColor = '#3182ce'; 
    }

    toast.style.display = 'flex'; 

    setTimeout(() => {
        toast.style.display = 'none'; 
    }, 3000);
}

@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        showToast("{{ $error }}", 'error');
    @endforeach
@endif
</script>


@endsection
