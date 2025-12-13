<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Store;
use App\Models\Medicine;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
public function index()
{
$sales = Sale::latest()->get();
return view('admin.sales.index', compact('sales'));
}


public function create()
{
$stores = Store::all();
$medicines = Medicine::where('status',1)->get();


return view('admin.sales.create', compact('stores','medicines'));
}


public function store(Request $request)
{
DB::transaction(function () use ($request) {


$sale = Sale::create([
'invoice_no' => 'INV'.time(),
'store_id' => $request->store_id,
'customer_name' => $request->customer_name,
'customer_phone' => $request->customer_phone,
'sub_total' => $request->sub_total,
'discount' => $request->discount,
'tax' => $request->tax,
'grand_total' => $request->grand_total,
'payment_method' => $request->payment_method,
]);


foreach ($request->items as $item) {
$medicine = Medicine::find($item['medicine_id']);


SaleItem::create([
'sale_id' => $sale->id,
'medicine_id' => $medicine->id,
'quantity' => $item['quantity'],
'price' => $item['price'],
'total' => $item['total'],
]);


// 🔴 Inventory OUT
Inventory::create([
'store_id' => $request->store_id,
'medicine_id' => $medicine->id,
'type' => 'OUT',
'quantity' => $item['quantity'],
'stock_before' => $medicine->stock,
'stock_after' => $medicine->stock - $item['quantity'],
'reference' => $sale->invoice_no,
]);


$medicine->decrement('stock', $item['quantity']);
}
});


return redirect()->route('admin.sales.index')
->with('success','Sale completed successfully');
}
}