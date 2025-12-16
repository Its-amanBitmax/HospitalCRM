@extends('layouts.nursionist')

@section('content')

<style>
.input{width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;margin-bottom:5px;}
.btn{padding:8px 14px;background:#2563eb;color:#fff;border-radius:6px;}
.section{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px;margin-bottom:20px;}
.grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;}
.grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
.flex-between{display:flex;justify-content:space-between;align-items:center;}
[data-box]{position:relative;}
.absolute{position:absolute;}
.right-2{right:0.5rem;}
.top-2{top:0.5rem;}
.text-red-600{color:#dc2626;}
@media(max-width:768px){.grid-2,.grid-3{grid-template-columns:1fr;}}
</style>

<form method="POST" action="{{ route('nurse.update.profile') }}" enctype="multipart/form-data">
@csrf

{{-- hidden deleted trackers --}}
<input type="hidden" id="deleted_addresses" name="deleted_addresses">
<input type="hidden" id="deleted_professions" name="deleted_professions">
<input type="hidden" id="deleted_qualifications" name="deleted_qualifications">
<input type="hidden" id="deleted_family_details" name="deleted_family_details">
<input type="hidden" id="deleted_documents" name="deleted_documents">

{{-- ================= BASIC DETAILS ================= --}}
<div class="section">
<h2 class="text-xl font-bold mb-3">Basic Details</h2>
<div class="grid-2">
<input class="input" name="name" value="{{ $nurse->name }}" placeholder="Name">
<input class="input" name="email" value="{{ $nurse->email }}" placeholder="Email">
<input class="input" name="phone" value="{{ $nurse->phone }}" placeholder="Phone">
<select class="input" name="gender">
<option value="">Select Gender</option>
<option value="male" {{ $nurse->gender=='male'?'selected':'' }}>Male</option>
<option value="female" {{ $nurse->gender=='female'?'selected':'' }}>Female</option>
</select>
<input type="date" class="input" name="date_of_birth" value="{{ $nurse->dob?\Carbon\Carbon::parse($nurse->dob)->format('Y-m-d'):'' }}">
<input type="date" class="input" name="hire_date" value="{{ $nurse->hire_date?\Carbon\Carbon::parse($nurse->hire_date)->format('Y-m-d'):'' }}">
<input class="input" name="status" value="{{ $nurse->status }}" placeholder="Status">
<input class="input" name="department_id" value="{{ $nurse->department_id }}" placeholder="Department ID">
</div>
</div>

{{-- ================= IMAGE ================= --}}
<div class="section">
<h2 class="text-xl font-bold mb-3">Profile Image</h2>
<input type="file" name="image">
@if($nurse->image)
<img src="{{ asset('storage/'.$nurse->image) }}" class="w-24 h-24 mt-2 rounded">
@endif
</div>



{{-- ================= PROFESSIONS ================= --}}
<div class="section">
<div class="flex-between mb-2">
<h2 class="text-xl font-bold">Professions</h2>
<!-- <button type="button" onclick="addProfession()" class="btn">+ Add</button> -->
</div>
<div id="professions-container">
@foreach($nurse->professions as $i=>$p)
<div data-box class="grid-2 border p-3 mb-3 rounded">
<!-- <button type="button" onclick="removeItem(this,'professions',{{ $p->id }})" class="absolute right-2 top-2 text-red-600">✖</button> -->
<input type="hidden" name="professions[{{ $i }}][id]" value="{{ $p->id }}">
<input class="input" name="professions[{{ $i }}][title]" value="{{ $p->title }}" placeholder="Title">
<input class="input" name="professions[{{ $i }}][department_id]" value="{{ $p->department_id }}" placeholder="Department ID">
</div>
@endforeach
</div>
</div>




{{-- ================= ADDRESSES ================= --}}
<div class="section">
<div class="flex-between mb-2">
<h2 class="text-xl font-bold">Addresses</h2>
<button type="button" onclick="addAddress()" class="btn">+ Add</button>
</div>
<div id="addresses-container">
@foreach($nurse->addresses as $i=>$a)
<div data-box class="grid-3 border p-3 mb-3 rounded">
<button type="button" onclick="removeItem(this,'addresses',{{ $a->id }})" class="absolute right-2 top-2 text-red-600">✖</button>
<input type="hidden" name="addresses[{{ $i }}][id]" value="{{ $a->id }}">
<input class="input" name="addresses[{{ $i }}][address_type]" value="{{ $a->address_type }}" placeholder="Type">
<input class="input" name="addresses[{{ $i }}][street]" value="{{ $a->street }}" placeholder="Street">
<input class="input" name="addresses[{{ $i }}][city]" value="{{ $a->city }}" placeholder="City">
<input class="input" name="addresses[{{ $i }}][state]" value="{{ $a->state }}" placeholder="State">
<input class="input" name="addresses[{{ $i }}][country]" value="{{ $a->country }}" placeholder="Country">
<input class="input" name="addresses[{{ $i }}][postal_code]" value="{{ $a->postal_code }}" placeholder="Postal Code">
</div>
@endforeach
</div>
</div>




{{-- ================= QUALIFICATIONS ================= --}}
<div class="section">
<div class="flex-between mb-2">
<h2 class="text-xl font-bold">Qualifications</h2>
<button type="button" onclick="addQualification()" class="btn">+ Add</button>
</div>
<div id="qualifications-container">
@foreach($nurse->qualifications as $i=>$q)
<div data-box class="grid-3 border p-3 mb-3 rounded">
<button type="button" onclick="removeItem(this,'qualifications',{{ $q->id }})" class="absolute right-2 top-2 text-red-600">✖</button>
<input type="hidden" name="qualifications[{{ $i }}][id]" value="{{ $q->id }}">
<input class="input" name="qualifications[{{ $i }}][degree]" value="{{ $q->degree }}" placeholder="Degree">
<input class="input" name="qualifications[{{ $i }}][institution]" value="{{ $q->institution }}" placeholder="Institution">
<input class="input" name="qualifications[{{ $i }}][year_completed]" value="{{ $q->year_completed }}" placeholder="Year">
</div>
@endforeach
</div>
</div>

{{-- ================= FAMILY DETAILS ================= --}}
<div class="section">
<div class="flex-between mb-2">
<h2 class="text-xl font-bold">Family Details</h2>
<button type="button" onclick="addFamily()" class="btn">+ Add</button>
</div>
<div id="family-container">
@foreach($nurse->familyDetails as $i=>$f)
<div data-box class="grid-2 border p-3 mb-3 rounded">
<button type="button" onclick="removeItem(this,'family_details',{{ $f->id }})" class="absolute right-2 top-2 text-red-600">✖</button>
<input type="hidden" name="family_details[{{ $i }}][id]" value="{{ $f->id }}">
<input class="input" name="family_details[{{ $i }}][name]" value="{{ $f->name }}" placeholder="Name">
<input class="input" name="family_details[{{ $i }}][relationship]" value="{{ $f->relationship }}" placeholder="Relationship">
<input type="date" class="input" name="family_details[{{ $i }}][date_of_birth]" value="{{ $f->date_of_birth?\Carbon\Carbon::parse($f->date_of_birth)->format('Y-m-d'):'' }}">
</div>
@endforeach
</div>
</div>

{{-- ================= DOCUMENTS ================= --}}
<div class="section">
<h2 class="text-xl font-bold mb-2">Documents</h2>
<input type="file" name="documents[]" multiple class="mb-2">
@foreach($nurse->documents as $doc)
<div data-doc-id="{{ $doc->id }}" class="flex items-center gap-3 mb-2">
<a target="_blank" href="{{ asset('storage/'.$doc->document_path) }}">{{ $doc->document_type }}</a>
<button type="button" onclick="removeDocument(this,{{ $doc->id }})" class="text-red-600">Delete</button>
</div>
@endforeach
</div>

<button class="btn mt-4">Update Profile</button>
</form>

<script>
let addressIndex={{ $nurse->addresses->count() }};
let professionIndex={{ $nurse->professions->count() }};
let qualificationIndex={{ $nurse->qualifications->count() }};
let familyIndex={{ $nurse->familyDetails->count() }};

const deleted={addresses:[],professions:[],qualifications:[],family_details:[],documents:[]};

function removeItem(btn,type,id){
btn.closest('[data-box]').remove();
if(id){deleted[type].push(id);document.getElementById('deleted_'+type).value=JSON.stringify(deleted[type]);}
}

function addAddress(){
document.getElementById('addresses-container').insertAdjacentHTML('beforeend',`
<div data-box class="grid-3 border p-3 mb-3 rounded">
<button type="button" onclick="removeItem(this,'addresses')" class="absolute right-2 top-2 text-red-600">✖</button>
<input class="input" name="addresses[${addressIndex}][address_type]" placeholder="Type">
<input class="input" name="addresses[${addressIndex}][street]" placeholder="Street">
<input class="input" name="addresses[${addressIndex}][city]" placeholder="City">
<input class="input" name="addresses[${addressIndex}][state]" placeholder="State">
<input class="input" name="addresses[${addressIndex}][country]" placeholder="Country">
<input class="input" name="addresses[${addressIndex}][postal_code]" placeholder="Postal Code">
</div>`);addressIndex++;
}

// function addProfession(){
// document.getElementById('professions-container').insertAdjacentHTML('beforeend',`
// <div data-box class="grid-2 border p-3 mb-3 rounded">
// <button type="button" onclick="removeItem(this,'professions')" class="absolute right-2 top-2 text-red-600">✖</button>
// <input class="input" name="professions[${professionIndex}][title]" placeholder="Title">
// <input class="input" name="professions[${professionIndex}][department_id]" placeholder="Department ID">
// </div>`);professionIndex++;
// }

function addQualification(){
document.getElementById('qualifications-container').insertAdjacentHTML('beforeend',`
<div data-box class="grid-3 border p-3 mb-3 rounded">
<button type="button" onclick="removeItem(this,'qualifications')" class="absolute right-2 top-2 text-red-600">✖</button>
<input class="input" name="qualifications[${qualificationIndex}][degree]" placeholder="Degree">
<input class="input" name="qualifications[${qualificationIndex}][institution]" placeholder="Institution">
<input class="input" name="qualifications[${qualificationIndex}][year_completed]" placeholder="Year">
</div>`);qualificationIndex++;
}

function addFamily(){
document.getElementById('family-container').insertAdjacentHTML('beforeend',`
<div data-box class="grid-2 border p-3 mb-3 rounded">
<button type="button" onclick="removeItem(this,'family_details')" class="absolute right-2 top-2 text-red-600">✖</button>
<input class="input" name="family_details[${familyIndex}][name]" placeholder="Name">
<input class="input" name="family_details[${familyIndex}][relationship]" placeholder="Relationship">
<input type="date" class="input" name="family_details[${familyIndex}][date_of_birth]">
</div>`);familyIndex++;
}

function removeDocument(btn,id){
deleted.documents.push(id);
document.getElementById('deleted_documents').value=JSON.stringify(deleted.documents);
btn.closest('[data-doc-id]').remove();
}
</script>

@endsection
