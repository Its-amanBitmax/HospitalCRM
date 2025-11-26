<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomAssignment;
use App\Models\Department;
use App\Models\Profession;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        return view('admin.rooms.index');
    }

    public function getRooms()
    {
        try {
            $rooms = Room::leftJoin('departments', 'rooms.department_id', '=', 'departments.id')
                ->leftJoin('professions as room_professions', 'rooms.profession_id', '=', 'room_professions.id')
                ->select(
                    'rooms.*',
                    'departments.department_name',
                    'room_professions.title as room_profession_title'
                )
                ->orderBy('rooms.id')
                ->get()
                ->map(function ($room) {
                    $assignments = RoomAssignment::where('room_id', $room->id)
                        ->leftJoin('employees', 'room_assignments.employee_id', '=', 'employees.id')
                        ->leftJoin('professions', 'employees.id', '=', 'professions.employee_id')
                        ->leftJoin('specialities', 'employees.id', '=', 'specialities.employee_id')
                        ->leftJoin('admins', 'room_assignments.assigned_by', '=', 'admins.id')
                        ->select(
                            'room_assignments.id as assignment_id',
                            'room_assignments.assigned_at',
                            'room_assignments.status as assignment_status',
                            'employees.name as employee_name',
                            'employees.employee_code',
                            'professions.title as employee_profession_title',
                            'specialities.years_of_experience',
                            'admins.name as assigned_by_name'
                        )
                        ->orderBy('room_assignments.assigned_at', 'desc')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->assignment_id,
                                'assigned_at' => $item->assigned_at,
                                'status' => $item->assignment_status,
                                'employee' => $item->employee_name ? [
                                    'name' => $item->employee_name,
                                    'employee_code' => $item->employee_code,
                                    'experience' => $item->years_of_experience,
                                    'profession' => $item->employee_profession_title
                                ] : null,
                                'assignedBy' => $item->assigned_by_name ? [
                                    'name' => $item->assigned_by_name
                                ] : null
                            ];
                        });

                    return [
                        'id' => $room->id,
                        'room_id' => $room->room_id,
                        'room_no' => $room->room_no,
                        'department_id' => $room->department_id,
                        'profession_id' => $room->profession_id,
                        'status' => $room->status,
                        'created_at' => $room->created_at,
                        'updated_at' => $room->updated_at,
                        'department' => $room->department_name ? [
                            'id' => $room->department_id,
                            'department_name' => $room->department_name
                        ] : null,
                        'profession' => $room->room_profession_title ? [
                            'id' => $room->profession_id,
                            'title' => $room->room_profession_title
                        ] : null,
                        'room_assignments' => $assignments
                    ];
                });

            return response()->json($rooms);
        } catch (\Exception $e) {
            \Log::error('Error fetching rooms: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch rooms'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_no' => 'required|string|max:50',
            'department_id' => 'required|exists:departments,id',
            'profession_id' => 'nullable|exists:professions,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $roomId = 'RM' . Date('YmdHis') . rand(100, 999);

        $room = Room::create([
            'room_id' => $roomId,
            'room_no' => $request->room_no,
            'department_id' => $request->department_id,
            'profession_id' => $request->profession_id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Room created successfully.', 'room' => $room]);
    }

    public function show($id)
    {
        $room = Room::with(['department', 'profession', 'roomAssignments.employee', 'roomAssignments.profession', 'roomAssignments.assignedBy'])->findOrFail($id);
        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'room_no' => 'required|string|max:50',
            'department_id' => 'required|exists:departments,id',
            'profession_id' => 'nullable|exists:professions,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $room->update([
            'room_no' => $request->room_no,
            'department_id' => $request->department_id,
            'profession_id' => $request->profession_id,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Room updated successfully.']);
    }

    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);

            // Delete all assignments for this room first to avoid foreign key constraints
            RoomAssignment::where('room_id', $id)->delete();

            $room->delete();
            return response()->json(['message' => 'Room deleted successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting room: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete room'], 500);
        }
    }

    public function assign(Request $request)
    {
        // Check if admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'You are not authenticated.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'department_id' => 'required|exists:departments,id',
            'employee_ids' => 'required|array|min:1',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $assignments = [];
            foreach ($request->employee_ids as $employee_id) {
                $assignment = RoomAssignment::create([
                    'room_id' => $request->room_id,
                    'employee_id' => $employee_id,
                    'profession_id' => null, // No profession needed when assigning by department
                    'assigned_by' => Auth::guard('admin')->id(),
                    'assigned_at' => now(),
                    'status' => 'active',
                ]);
                $assignments[] = $assignment;
            }

            return response()->json(['message' => count($assignments) . ' employees assigned to room successfully.', 'assignments' => $assignments]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to assign employees: ' . $e->getMessage()], 500);
        }
    }

    public function getAssignments($id)
    {
        try {
            $assignments = RoomAssignment::where('room_id', $id)
                ->leftJoin('employees', 'room_assignments.employee_id', '=', 'employees.id')
                ->leftJoin('professions', 'employees.id', '=', 'professions.employee_id')
                ->leftJoin('specialities', 'employees.id', '=', 'specialities.employee_id')
                ->select(
                    'room_assignments.id as assignment_id',
                    'room_assignments.assigned_at',
                    'room_assignments.status as assignment_status',
                    'employees.name as employee_name',
                    'employees.employee_code',
                    'professions.title as employee_profession_title',
                    'specialities.years_of_experience'
                )
                ->orderBy('room_assignments.assigned_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $experience = $item->years_of_experience;
                    $profession = $item->employee_profession_title;

                    return [
                        'id' => $item->assignment_id,
                        'assigned_at' => $item->assigned_at,
                        'status' => $item->assignment_status,
                        'employee' => $item->employee_name ? [
                            'name' => $item->employee_name,
                            'employee_code' => $item->employee_code,
                            'experience' => $experience,
                            'profession' => $profession
                        ] : null
                    ];
                });

            return response()->json($assignments);
        } catch (\Exception $e) {
            \Log::error('Error fetching room assignments: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch room assignments'], 500);
        }
    }

    public function updateAssignmentStatus(Request $request, $id)
    {
        $assignment = RoomAssignment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $assignment->update(['status' => $request->status]);

        return response()->json(['message' => 'Assignment status updated successfully.']);
    }

    public function getProfessions()
    {
        $professions = Profession::all();
        return response()->json($professions);
    }

    public function getEmployees()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

  public function getEmployeesByDepartment($departmentId)
{
    $employees = Employee::join('professions', 'employees.id', '=', 'professions.employee_id')
        ->join('departments', 'professions.department_id', '=', 'departments.id')
        ->where('departments.id', $departmentId)
        ->where('professions.title', 'doctor')
        ->select('employees.id', 'employees.name', 'employees.employee_code')
        ->distinct()
        ->get();

    return response()->json($employees);
}

    public function getAssignedRooms()
    {
        try {
            $assignedCount = RoomAssignment::where('status', 'active')->distinct('room_id')->count('room_id');
            return response()->json(['assigned' => $assignedCount]);
        } catch (\Exception $e) {
            \Log::error('Error fetching assigned rooms: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch assigned rooms'], 500);
        }
    }

    public function removeAssignment($id)
    {
        try {
            $assignment = RoomAssignment::findOrFail($id);
            $assignment->delete();
            return response()->json(['message' => 'Employee removed from room successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error removing assignment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to remove assignment'], 500);
        }
    }
}
