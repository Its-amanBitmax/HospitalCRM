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
        $stores = Store::where('status', 1)->get();
        return view('admin.medicine.create', compact('stores'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'medicine_name' => 'required',
            'sale_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $medicine = new Medicine();
        $medicine->store_id = $request->store_id;
        $medicine->medicine_name = $request->medicine_name;
        $medicine->brand = $request->brand;
        $medicine->category = $request->category;
        $medicine->batch_no = $request->batch_no;
        $medicine->expiry_date = $request->expiry_date;
        $medicine->purchase_price = $request->purchase_price;
        $medicine->sale_price = $request->sale_price;
        $medicine->stock = $request->stock;
        $medicine->status = $request->status ?? 1;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('medicines', $imageName, 'public');
            $medicine->image = $imagePath;

        }

        $medicine->save();

        return redirect()->route('admin.medicine.index')
            ->with('success', 'Medicine added successfully');
    }

    public function edit(Medicine $medicine)
    {
        $stores = Store::where('status', 1)->get();
        return view('admin.medicine.edit', compact('medicine', 'stores'));
    }


    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'store_id' => 'required',
            'medicine_name' => 'required',
            'sale_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload for update
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('medicines', $imageName, 'public');
            $medicine->image = $imagePath;
        } elseif ($request->has('remove_image') && $request->remove_image) {
            // Remove current image
            if ($medicine->image) {
                \Storage::disk('public')->delete($medicine->image);
            }
            $medicine->image = null;
        }

        // Update other fields individually to avoid mass assignment issues with file inputs
        $medicine->store_id = $request->store_id;
        $medicine->medicine_name = $request->medicine_name;
        $medicine->brand = $request->brand;
        $medicine->category = $request->category;
        $medicine->batch_no = $request->batch_no;
        $medicine->expiry_date = $request->expiry_date;
        $medicine->purchase_price = $request->purchase_price;
        $medicine->sale_price = $request->sale_price;
        $medicine->stock = $request->stock;
        $medicine->status = $request->status ?? 1;

        $medicine->save();
        return redirect()->route('admin.medicine.index')
            ->with('success', 'Medicine updated');
    }


    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return back()->with('success', 'Medicine deleted');
    }

    
}
