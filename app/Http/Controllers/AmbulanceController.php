<?php

namespace App\Http\Controllers;

use App\Models\Ambulance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AmbulanceController extends Controller
{
public function index()
{
    // All ambulances with driver relation
    $ambulances = Ambulance::with('driver')->latest()->get();

    // Stats
    $totalAmbulances     = $ambulances->count();
    $availableAmbulances = $ambulances->where('status', 'available')->count();
    $busyAmbulances      = $ambulances->whereIn('status', ['in_use', 'maintenance'])->count();

    return view('admin.ambulances.index', compact(
        'ambulances',
        'totalAmbulances',
        'availableAmbulances',
        'busyAmbulances'
    ));
}

public function create()
{
    $drivers = Employee::with('professions')
        ->whereHas('professions', function ($query) {
            $query->where('title', 'Driver');
        })
        ->get();

    return view('admin.ambulances.create', compact('drivers'));
}



 public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'ambulance_number' => 'required|string|max:50|unique:ambulances,ambulance_number',
        'vehicle_type'     => 'required|string|max:100',
        'status'           => 'required|in:available,in_use,maintenance,out_of_service',
        'driver_id'        => 'nullable|exists:employees,id',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }

    DB::beginTransaction();

    try {

        // ✅ Optional: Ensure selected driver is actually a DRIVER
        if ($request->filled('driver_id')) {
            $isDriver = Employee::where('id', $request->driver_id)
                ->whereHas('professions', function ($q) {
                    $q->where('title', 'Driver');
                })
                ->exists();

            if (! $isDriver) {
                return back()
                    ->withErrors(['driver_id' => 'Selected employee is not a driver'])
                    ->withInput();
            }
        }

        // ✅ Safe mass assignment (NO $request->all())
        $ambulance = Ambulance::create([
            'ambulance_number' => $request->ambulance_number,
            'vehicle_type'     => $request->vehicle_type,
            'status'           => $request->status,
            'driver_id'        => $request->driver_id,
        ]);

        DB::commit();

        return redirect()
            ->route('admin.ambulances.index')
            ->with('success', 'Ambulance created successfully');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()
            ->with('error', 'Something went wrong while saving ambulance')
            ->withInput();
    }
}

public function show($id)
{
    $ambulance = Ambulance::with(['driver.professions'])->findOrFail($id);
    return response()->json($ambulance);
}

/* ================= UPDATE ================= */
public function update(Request $request, $id)
{
    $ambulance = Ambulance::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'ambulance_number' => 'sometimes|required|string|max:50|unique:ambulances,ambulance_number,' . $ambulance->id,
        'vehicle_type'     => 'sometimes|required|string|max:100',
        'status'           => 'sometimes|required|in:available,in_use,maintenance,out_of_service',
        'driver_id'        => 'nullable|exists:employees,id',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();

    try {

        // ✅ If driver selected, validate profession + availability
        if ($request->filled('driver_id')) {

            $isDriver = Employee::where('id', $request->driver_id)
                ->whereHas('professions', fn ($q) => $q->where('title', 'Driver'))
                ->exists();

            if (! $isDriver) {
                return back()
                    ->withErrors(['driver_id' => 'Selected employee is not a Driver'])
                    ->withInput();
            }

            // ✅ Prevent double assignment
            $alreadyAssigned = Ambulance::where('driver_id', $request->driver_id)
                ->where('id', '!=', $ambulance->id)
                ->exists();

            if ($alreadyAssigned) {
                return back()
                    ->withErrors(['driver_id' => 'Driver already assigned to another ambulance'])
                    ->withInput();
            }
        }

        // ✅ Safe update (NO request->all())
        $ambulance->update([
            'ambulance_number' => $request->ambulance_number ?? $ambulance->ambulance_number,
            'vehicle_type'     => $request->vehicle_type ?? $ambulance->vehicle_type,
            'status'           => $request->status ?? $ambulance->status,
            'driver_id'        => $request->driver_id,
        ]);

        DB::commit();

        return redirect()
            ->route('admin.ambulances.index')
            ->with('success', 'Ambulance updated successfully');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()
            ->with('error', 'Failed to update ambulance')
            ->withInput();
    }
}

/* ================= DESTROY ================= */
public function destroy($id)
{
    $ambulance = Ambulance::findOrFail($id);

    DB::beginTransaction();

    try {
        // ✅ Optional: auto unassign driver
        $ambulance->update(['driver_id' => null]);
        $ambulance->delete();

        DB::commit();

        return redirect()
            ->route('admin.ambulances.index')
            ->with('success', 'Ambulance deleted successfully');

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()
            ->route('admin.ambulances.index')
            ->with('error', 'Failed to delete ambulance');
    }
}

/* ================= ASSIGN DRIVER ================= */
public function assignDriver(Request $request, $id)
{
    $ambulance = Ambulance::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'driver_id' => 'required|exists:employees,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // ✅ Ensure employee is Driver
    $isDriver = Employee::where('id', $request->driver_id)
        ->whereHas('professions', fn ($q) => $q->where('title', 'Driver'))
        ->exists();

    if (! $isDriver) {
        return response()->json([
            'error' => 'Selected employee is not a Driver'
        ], 422);
    }

    // ✅ Prevent double assignment
    $alreadyAssigned = Ambulance::where('driver_id', $request->driver_id)
        ->where('id', '!=', $ambulance->id)
        ->exists();

    if ($alreadyAssigned) {
        return response()->json([
            'error' => 'Driver already assigned to another ambulance'
        ], 422);
    }

    $ambulance->update(['driver_id' => $request->driver_id]);

    return response()->json([
        'message' => 'Driver assigned successfully',
        'ambulance' => $ambulance->load('driver')
    ]);
}

/* ================= AVAILABLE DRIVERS ================= */
public function getAvailableDrivers()
{
    $drivers = Employee::where('status', 'active')
        ->whereHas('professions', fn ($q) => $q->where('title', 'Driver'))
        ->whereDoesntHave('ambulance') // relation required
        ->select('id','name','phone')
        ->get();

    return response()->json($drivers);
}
}
