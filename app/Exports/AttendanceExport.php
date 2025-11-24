<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $departmentId;
    protected $status;
    protected $employeeId;
    protected $employeeName;

    public function __construct($startDate, $endDate, $departmentId = null, $status = null, $employeeId = null, $employeeName = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->departmentId = $departmentId;
        $this->status = $status;
        $this->employeeId = $employeeId;
        $this->employeeName = $employeeName;
    }

    public function query()
    {
        $query = Attendance::with(['employee.department'])
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->departmentId) {
            $query->whereHas('employee', function ($q) {
                $q->where('department_id', $this->departmentId);
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->employeeId) {
            $query->whereHas('employee', function ($q) {
                $q->where('employee_code', 'like', '%' . $this->employeeId . '%');
            });
        }

        if ($this->employeeName) {
            $query->whereHas('employee', function ($q) {
                $q->where('name', 'like', '%' . $this->employeeName . '%');
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Employee Code',
            'Department',
            'Date',
            'Status',
            'Check In',
            'Check Out',
            'Notes',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->employee->name,
            $attendance->employee->employee_code,
            $attendance->employee->department->name ?? 'N/A',
            $attendance->date,
            ucfirst(str_replace('_', ' ', $attendance->status)),
            $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-',
            $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-',
            $attendance->notes ?: '-',
        ];
    }
}
