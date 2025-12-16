<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Store;

class MedicineController extends Controller
{
public function index()
{
$medicines = Medicine::with('store')->latest()->get();
return view('admin.medicine.index', compact('medicines'));
}


public function create()
{
$stores = Store::where('status',1)->get();
return view('admin.medicine.create', compact('stores'));
}


public function store(Request $request)
{
$request->validate([
'store_id' => 'required',
'medicine_name' => 'required',
'sale_price' => 'required|numeric'
]);


Medicine::create($request->all());
return redirect()->route('admin.medicine.index')
->with('success','Medicine added successfully');
}


public function edit(Medicine $medicine)
{
$stores = Store::where('status',1)->get();
return view('admin.medicine.edit', compact('medicine','stores'));
}


public function update(Request $request, Medicine $medicine)
{
$medicine->update($request->all());
return redirect()->route('admin.medicine.index')
->with('success','Medicine updated');
}


public function destroy(Medicine $medicine)
{
$medicine->delete();
return back()->with('success','Medicine deleted');
}
}