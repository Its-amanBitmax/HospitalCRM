<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
public function index() {
$stores = Store::latest()->get();
return view('admin.store.index', compact('stores'));
}


public function create() {
return view('admin.store.create');
}


public function store(Request $request) {
$request->validate([
'store_name' => 'required'
]);


Store::create($request->all());
return redirect()->route('admin.store.index')->with('success','Store created');
}


public function edit(Store $store) {
return view('admin.store.edit', compact('store'));
}


public function update(Request $request, Store $store) {
$store->update($request->all());
return redirect()->route('admin.store.index')->with('success','Updated');
}

public function destroy($id)
{
    Store::findOrFail($id)->delete();
    return redirect()->route('admin.store.index')
        ->with('success', 'Store deleted successfully');
}

}