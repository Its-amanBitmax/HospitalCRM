<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ward;
use App\Models\Bed;

class WardBedController extends Controller
{
    public function index()
    {
        return view('admin.ward-bed');
    }

    public function storeWard(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floor' => 'required|integer',
            'bed_limit' => 'required|integer',
            'status' => 'required|in:Active,Maintenance',
        ]);

        $wardId = 'WD' . str_pad(Ward::count() + 1, 3, '0', STR_PAD_LEFT);

        Ward::create([
            'ward_id' => $wardId,
            'name' => $request->name,
            'floor' => $request->floor,
            'bed_limit' => $request->bed_limit,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Ward added successfully']);
    }

    public function storeBed(Request $request)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_id' => 'required|string|unique:beds,bed_id',
            'type' => 'required|in:General,Critical,Deluxe',
            'status' => 'required|in:Active,Occupied,Maintenance',
        ]);

        Bed::create([
            'bed_id' => $request->bed_id,
            'ward_id' => $request->ward_id,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Bed added successfully']);
    }

    public function getWards()
    {
        $wards = Ward::withCount('beds')->get();
        return response()->json($wards);
    }

    public function getBeds()
    {
        $beds = Bed::with('ward')->get();
        return response()->json($beds);
    }

    public function updateWard(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floor' => 'required|integer',
            'bed_limit' => 'required|integer',
            'status' => 'required|in:Active,Maintenance',
        ]);

        $ward = Ward::findOrFail($id);
        $ward->update([
            'name' => $request->name,
            'floor' => $request->floor,
            'bed_limit' => $request->bed_limit,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Ward updated successfully']);
    }

    public function deleteWard($id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();

        return response()->json(['message' => 'Ward deleted successfully']);
    }

    public function updateBed(Request $request, $id)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'bed_id' => 'required|string|unique:beds,bed_id,' . $id,
            'type' => 'required|in:General,Critical,Deluxe',
            'status' => 'required|in:Active,Occupied,Maintenance',
        ]);

        $bed = Bed::findOrFail($id);
        $bed->update([
            'bed_id' => $request->bed_id,
            'ward_id' => $request->ward_id,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Bed updated successfully']);
    }

    public function deleteBed($id)
    {
        $bed = Bed::findOrFail($id);
        $bed->delete();

        return response()->json(['message' => 'Bed deleted successfully']);
    }
}
