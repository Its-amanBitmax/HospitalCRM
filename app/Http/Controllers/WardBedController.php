<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\BedAssignment;
use Illuminate\Support\Facades\Log;

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

        try {
            Log::info('Store Ward Request', [
                'user_id' => auth()->id(),
                'data' => $request->all()
            ]);

            $lastWard = Ward::orderBy('id', 'desc')->first();
            $nextId = $lastWard ? intval(substr($lastWard->ward_id, 2)) + 1 : 1;
            $wardId = 'WD' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $ward = Ward::create([
                'ward_id' => $wardId,
                'name' => $request->name,
                'floor' => $request->floor,
                'bed_limit' => $request->bed_limit,
                'status' => $request->status,
            ]);

            Log::info('Ward Created Successfully', [
                'ward_id' => $ward->ward_id,
                'created_by' => auth()->id()
            ]);

            return response()->json(['message' => 'Ward added successfully']);
        } catch (\Exception $e) {

            Log::error('Ward Creation Failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json(['message' => 'Something went wrong'], 500);
        }
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

        // Add patient information for occupied beds
        $beds->transform(function ($bed) {
            if ($bed->status === 'Occupied') {
                $activeAssignment = $bed->bedAssignments()->where('status', 'active')->with('user')->first();
                if ($activeAssignment) {
                    $bed->patient = $activeAssignment->user;
                }
            }
            return $bed;
        });

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

    public function assignBed(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bed_id' => 'required|exists:beds,id',
            'assigned_date' => 'required|date',
        ]);

        // Check if bed is already occupied
        $existingAssignment = BedAssignment::where('bed_id', $request->bed_id)
            ->where('status', 'active')
            ->first();

        if ($existingAssignment) {
            return response()->json(['error' => 'Bed is already occupied'], 400);
        }

        // Check if user already has an active bed assignment
        $userAssignment = BedAssignment::where('user_id', $request->user_id)
            ->where('status', 'active')
            ->first();

        if ($userAssignment) {
            return response()->json(['error' => 'User already has an active bed assignment'], 400);
        }

        BedAssignment::create([
            'user_id' => $request->user_id,
            'bed_id' => $request->bed_id,
            'assigned_date' => $request->assigned_date,
            'status' => 'active',
        ]);

        // Update bed status to occupied
        $bed = Bed::find($request->bed_id);
        $bed->update(['status' => 'Occupied']);

        return response()->json(['message' => 'Bed assigned successfully']);
    }

    public function getBedAssignments($userId)
    {
        $assignments = BedAssignment::with(['bed.ward'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($assignments);
    }

    public function updateBedAssignment(Request $request, $id)
    {
        $request->validate([
            'discharge_date' => 'required|date',
        ]);

        $assignment = BedAssignment::findOrFail($id);
        $assignment->update([
            'discharge_date' => $request->discharge_date,
            'status' => 'discharged',
        ]);

        // Update bed status to active
        $bed = $assignment->bed;
        $bed->update(['status' => 'Active']);

        return response()->json(['message' => 'Bed assignment updated successfully']);
    }

    public function removeBedAssignment($id)
    {
        $assignment = BedAssignment::findOrFail($id);

        // Update bed status to active
        $bed = $assignment->bed;
        $bed->update(['status' => 'Active']);

        $assignment->delete();

        return response()->json(['message' => 'Bed assignment removed successfully']);
    }

    public function transferBed(Request $request, $assignmentId)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'assigned_date' => 'required|date',
        ]);

        $currentAssignment = BedAssignment::findOrFail($assignmentId);

        // Check if the new bed is already occupied
        $existingAssignment = BedAssignment::where('bed_id', $request->bed_id)
            ->where('status', 'active')
            ->first();

        if ($existingAssignment) {
            return response()->json(['error' => 'New bed is already occupied'], 400);
        }

        // Update current assignment to discharged
        $currentAssignment->update([
            'discharge_date' => $request->assigned_date,
            'status' => 'discharged',
        ]);

        // Update old bed status to active
        $oldBed = $currentAssignment->bed;
        $oldBed->update(['status' => 'Active']);

        // Create new assignment
        BedAssignment::create([
            'user_id' => $currentAssignment->user_id,
            'bed_id' => $request->bed_id,
            'assigned_date' => $request->assigned_date,
            'status' => 'active',
        ]);

        // Update new bed status to occupied
        $newBed = Bed::find($request->bed_id);
        $newBed->update(['status' => 'Occupied']);

        return response()->json(['message' => 'Patient transferred successfully']);
    }
}
