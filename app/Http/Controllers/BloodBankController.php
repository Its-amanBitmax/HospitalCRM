<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BloodBank;
use Illuminate\Http\Request;

class BloodBankController extends Controller
{
    public function index()
    {
        $bloods = BloodBank::orderBy('blood_group')->get();
        return view('admin.bloodbanks.index', compact('bloods'));
    }

    public function create()
    {
        return view('admin.bloodbanks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'blood_group'   => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'units'         => 'required|integer|min:1',
            'donor_name'    => 'required|string|max:100',
            'donor_contact' => 'required|string|max:20',
            'donor_address' => 'nullable|string|max:255',
            'status'        => 'required|in:available,low,out_of_stock'
        ]);

        BloodBank::create($data);

        return redirect()->route('admin.bloodbanks.index')
            ->with('success', 'Blood record added successfully');
    }

    public function edit(BloodBank $bloodBank)
    {
        return view('admin.bloodbanks.edit', compact('bloodBank'));
    }

    public function update(Request $request, BloodBank $bloodBank)
    {
        $data = $request->validate([
            'blood_group'   => 'required',
            'units'         => 'required|integer|min:0',
            'donor_name'    => 'required|string|max:100',
            'donor_contact' => 'required|string|max:20',
            'donor_address' => 'nullable|string|max:255',
            'status'        => 'required|in:available,low,out_of_stock',
        ]);

        $bloodBank->update($data);

        return redirect()->route('admin.bloodbanks.index')
            ->with('success', 'Blood record updated');
    }

    public function destroy(BloodBank $bloodBank)
    {
        $bloodBank->delete();

        return back()->with('success', 'Blood record deleted');
    }
}
