@extends('layouts.doctor-dashboard')

@section('content')
<div id="visits-content" class="tab-content">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 text-black">Patient Visits</h2>
    </div>

    <!-- 🔍 FILTER SECTION (PURE JS) -->
    <div class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Patient Name -->
            <input id="filterName" type="text" placeholder="Search Patient Name"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 bg-white text-black">

            <!-- Visit Type -->
            <select id="filterVisitType" class="w-full px-4 py-2 border rounded-lg bg-black text-black">
                <option value="">All Visit Types</option>
                <option value="OPD">OPD</option>
                <option value="Emergency">Emergency</option>
                <option value="Checkup">Checkup</option>
            </select>

            <!-- Date -->
            <input id="filterDate" type="date" class="w-full px-4 py-2 border rounded-lg bg-black text-black">

            <!-- Reset Button -->
            <button onclick="resetFilters()" class="px-4 py-2 bg-black text-black rounded-lg hover:bg-gray-600 transition">
                Reset
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table id="visitsTable" class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reception</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visit Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Chief Complaint</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date of Visit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>

            <tbody id="visitsBody" class="bg-white divide-y divide-gray-200">
                @forelse($patients as $visit)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm name">{{ $visit->user->full_name }}</td>
                    <td class="px-6 py-4 text-sm room">{{ $visit->consultantAssignment?->room?->room_id ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm reception">{{ $visit->reception?->reception_id ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm type">{{ $visit->visit_type ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $visit->chief_complaint ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm date">{{ $visit->date_of_visit?->format('Y-m-d') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium space-x-3"></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No visits found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const filterName = document.getElementById("filterName");
    const filterVisitType = document.getElementById("filterVisitType");
    const filterDate = document.getElementById("filterDate");
    const tableBody = document.getElementById("visitsBody");

    function filterTable() {
        const nameValue = filterName.value.toLowerCase();
        const visitTypeValue = filterVisitType.value;
        const dateValue = filterDate.value;

        [...tableBody.getElementsByTagName("tr")].forEach(row => {
            const name = row.querySelector(".name")?.textContent.toLowerCase() || "";
            const type = row.querySelector(".type")?.textContent || "";
            const date = row.querySelector(".date")?.textContent || "";

            const matchName = name.includes(nameValue);
            const matchType = visitTypeValue === "" || type === visitTypeValue;
            const matchDate = dateValue === "" || date === dateValue;

            row.style.display = (matchName && matchType && matchDate) ? "" : "none";
        });
    }

    filterName.addEventListener("input", filterTable);
    filterVisitType.addEventListener("change", filterTable);
    filterDate.addEventListener("change", filterTable);

    function resetFilters() {
        filterName.value = "";
        filterVisitType.value = "";
        filterDate.value = "";
        filterTable();
    }
</script>
@endsection
