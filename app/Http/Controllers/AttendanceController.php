<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Models\Department;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get();
        $today = Carbon::today();

        // Get today's attendance records
        $todayAttendances = Attendance::where('date', $today)
            ->with('employee.department')
            ->get()
            ->keyBy('employee_id');

        return view('admin.attendance.index', compact('employees', 'todayAttendances', 'today'));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'status' => 'required|in:present,absent,leave,late,half_day,holiday,week_off',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        $date = Carbon::today();

        Attendance::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'date' => $date,
            ],
            [
                'status' => $request->status,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'notes' => $request->notes,
            ]
        );

        return response()->json(['message' => 'Attendance marked successfully']);
    }

    public function show($employeeId)
    {
        $employee = Employee::with('department')->findOrFail($employeeId);

        $attendances = Attendance::where('employee_id', $employeeId)
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('admin.attendance.show', compact('employee', 'attendances'));
    }

    public function bulkMark(Request $request)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.employee_id' => 'required|exists:employees,id',
            'attendances.*.status' => 'required|in:present,absent,leave,late,half_day,holiday,week_off',
        ]);

        $date = Carbon::today();

        DB::beginTransaction();
        try {
            foreach ($request->attendances as $attendanceData) {
                Attendance::updateOrCreate(
                    [
                        'employee_id' => $attendanceData['employee_id'],
                        'date' => $date,
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'check_in' => $attendanceData['check_in'] ?? null,
                        'check_out' => $attendanceData['check_out'] ?? null,
                        'notes' => $attendanceData['notes'] ?? null,
                    ]
                );
            }
            DB::commit();
            return response()->json(['message' => 'Bulk attendance marked successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to mark attendance'], 500);
        }
    }

    public function report(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        $departmentId = $request->get('department_id');
        $status = $request->get('status');
        $employeeId = $request->get('employee_id');
        $employeeName = $request->get('employee_name');

        $query = Attendance::with(['employee.department'])
            ->whereBetween('date', [$startDate, $endDate]);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($employeeId) {
            $query->whereHas('employee', function ($q) use ($employeeId) {
                $q->where('employee_code', 'like', '%' . $employeeId . '%');
            });
        }

        if ($employeeName) {
            $query->whereHas('employee', function ($q) use ($employeeName) {
                $q->where('name', 'like', '%' . $employeeName . '%');
            });
        }

        $attendances = $query->get();

        $summary = [
            'total_days' => $attendances->unique('date')->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'holiday' => $attendances->where('status', 'holiday')->count(),
            'week_off' => $attendances->where('status', 'week_off')->count(),
        ];

        $departments = \App\Models\Department::all();

        // Handle Excel export
        if ($request->has('export') && $request->export === 'excel') {
            return Excel::download(new AttendanceExport($startDate, $endDate, $departmentId, $status, $employeeId, $employeeName), 'attendance_report.xlsx');
        }

        return view('admin.attendance.report', compact('attendances', 'summary', 'startDate', 'endDate', 'departments'));
    }

    // public function monthlyView(Request $request)
    // {
    //     $month = $request->input('month', now()->format('Y-m'));
    //     $departmentId = $request->input('department_id');

    //     $departments = Department::all();

    //     $employeesQuery = Employee::query();
    //     if ($departmentId) {
    //         $employeesQuery->where('department_id', $departmentId);
    //     }
    //     $employees = $employeesQuery->with(['attendances' => function($q) use ($month) {
    //         $q->whereBetween('date', [
    //             \Carbon\Carbon::parse($month . '-01')->startOfMonth()->toDateString(),
    //             \Carbon\Carbon::parse($month . '-01')->endOfMonth()->toDateString()
    //         ]);
    //     }])->get();

    //     $start = \Carbon\Carbon::parse($month . '-01')->startOfMonth();
    //     $end = \Carbon\Carbon::parse($month . '-01')->endOfMonth();
    //     $dates = [];
    //     for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
    //         $dates[] = $date->format('Y-m-d');
    //     }

    //     return view('admin.attendance.389monthly-view', compact('month', 'departments', 'employees', 'dates'));
    // }



     public function monthlyView(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $departmentId = $request->input('department_id');

        $departments = Department::all();

        $employeesQuery = Employee::query();
        if ($departmentId) {
            $employeesQuery->where('department_id', $departmentId);
        }
        $employees = $employeesQuery->with(['attendances' => function($q) use ($month) {
            $q->whereBetween('date', [
                \Carbon\Carbon::parse($month . '-01')->startOfMonth()->toDateString(),
                \Carbon\Carbon::parse($month . '-01')->endOfMonth()->toDateString()
            ]);
        }])->get();

        $start = \Carbon\Carbon::parse($month . '-01')->startOfMonth();
        $end = \Carbon\Carbon::parse($month . '-01')->endOfMonth();
        $dates = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return view('admin.attendance.monthly-view', compact('month', 'departments', 'employees', 'dates'));
    }
}
