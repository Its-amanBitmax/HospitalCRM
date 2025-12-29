<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Store;
use App\Models\Medicine;


class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with(['store', 'medicine'])
            ->latest()->get();


        return view('admin.inventory.index', compact('inventories'));
    }


    public function create()
    {
        $stores = Store::where('status', 1)->get();
        $medicines = Medicine::where('status', 1)->get();


        return view('admin.inventory.create', compact('stores', 'medicines'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'medicine_id' => 'required',
            'type' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);
        $medicine = Medicine::findOrFail($request->medicine_id);
        $before = $medicine->stock;
        if ($request->type == 'IN') {
            $after = $before + $request->quantity;
        } elseif ($request->type == 'OUT') {
            $after = $before - $request->quantity;
        } else {
            $after = $request->quantity;
        }


        Inventory::create([
            'store_id' => $request->store_id,
            'medicine_id' => $medicine->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'stock_before' => $before,
            'stock_after' => $after,
            'reference' => $request->reference,
            'note' => $request->note,
        ]);
        $medicine->update(['stock' => $after]);
        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory updated successfully');
    }



    
}
