<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Item;

class StockController extends Controller
{
    public function index()
    {
        return view('admin.stock');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:suppliers,email',
            'address' => 'required|string',
        ]);

        $supplierId = 'SUP' . str_pad(Supplier::count() + 1, 3, '0', STR_PAD_LEFT);

        Supplier::create([
            'supplier_id' => $supplierId,
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return response()->json(['message' => 'Supplier added successfully']);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Out of Stock,Discontinued',
        ]);

        $itemId = 'ITM' . str_pad(Item::count() + 1, 3, '0', STR_PAD_LEFT);

        Item::create([
            'item_id' => $itemId,
            'item_name' => $request->item_name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'price_per_unit' => $request->price_per_unit,
            'supplier_id' => $request->supplier_id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Item added successfully']);
    }

    public function getSuppliers()
    {
        $suppliers = Supplier::withCount('items')->get();
        return response()->json($suppliers);
    }

    public function getItems()
    {
        $items = Item::with('supplier')->get();
        return response()->json($items);
    }

    public function updateSupplier(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:suppliers,email,' . $id,
            'address' => 'required|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return response()->json(['message' => 'Supplier updated successfully']);
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully']);
    }

    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Out of Stock,Discontinued',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'item_name' => $request->item_name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'price_per_unit' => $request->price_per_unit,
            'supplier_id' => $request->supplier_id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Item updated successfully']);
    }

    public function deleteItem($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}
