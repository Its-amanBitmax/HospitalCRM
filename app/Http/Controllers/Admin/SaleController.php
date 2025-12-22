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
        $sales = Sale::with('store')->get();
        $stores = Store::all();

        return view('admin.sales.index', compact('sales', 'stores'));
    }

    
    public function create()
    {
        return view('admin.sales.create', [
            'stores' => Store::all(),
            'medicines' => Medicine::where('status', 1)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'payment_method' => 'required',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'items.*.total' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            // ✅ Invoice number WITHOUT migration change
            $invoiceNo = 'INV-' . now()->format('YmdHis');

            $sale = Sale::create([
                'invoice_no'     => $invoiceNo,
                'store_id'       => $request->store_id,
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'sub_total'      => $request->sub_total,
                'discount'       => $request->discount ?? 0,
                'tax'            => $request->tax ?? 0,
                'grand_total'    => $request->grand_total,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($request->items as $item) {

                $medicine = Medicine::lockForUpdate()->find($item['medicine_id']);

                // ❌ Out of stock protection
                if ($medicine->stock < $item['quantity']) {
                    throw new \Exception(
                        $medicine->medicine_name . ' stock not available'
                    );
                }

                // ✅ Save sale item
                SaleItem::create([
                    'sale_id'     => $sale->id,
                    'medicine_id' => $medicine->id,
                    'quantity'    => $item['quantity'],
                    'price'       => $item['price'],
                    'total'       => $item['total'],
                ]);

                // ✅ Deduct stock
                $medicine->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return redirect()
                ->route('admin.sales.create')
                ->with('success', 'Sale completed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
