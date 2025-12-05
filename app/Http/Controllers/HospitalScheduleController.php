<?php

namespace App\Http\Controllers;

use App\Models\HospitalSchedule;
use Illuminate\Http\Request;

class HospitalScheduleController extends Controller
{
    public function index()
    {
        $schedules = HospitalSchedule::orderBy('start_date', 'asc')->get();
        return view('admin.HospitalSchedules.index', compact('schedules'));
    }

    // Create Form
    public function create()
    {
        return view('admin.HospitalSchedules.create');
    }

    // Store New
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['start_time'] = date('h:i A', strtotime($request->start_time));
        $data['end_time'] = date('h:i A', strtotime($request->end_time));

        HospitalSchedule::create($data);

        return redirect()->route('hospital.schedule.index')->with('success', 'Schedule Added Successfully');
    }

    // Edit Form Page
    public function edit($id)
    {
        $schedule = HospitalSchedule::findOrFail($id);
        return view('admin.HospitalSchedules.edit', compact('schedule'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $schedule = HospitalSchedule::findOrFail($id);
        $data = $request->all();
        $data['start_time'] = date('h:i A', strtotime($request->start_time));
        $data['end_time'] = date('h:i A', strtotime($request->end_time));
        $schedule->update($data);

        return redirect()->route('hospital.schedule.index')->with('success', 'Schedule Updated Successfully');
    }

    // Delete
    public function destroy($id)
    {
        HospitalSchedule::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Schedule Deleted Successfully');
    }
}
