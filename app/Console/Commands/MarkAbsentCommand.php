<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Console\Command;
use Carbon\Carbon;

class MarkAbsentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark employees as absent if they have not checked in by the end of the day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();

        // Get all employees
        $employees = Employee::all();

        $markedAbsent = 0;

        foreach ($employees as $employee) {
            // Check if attendance already exists for today
            $existingAttendance = Attendance::where('employee_id', $employee->id)
                ->where('date', $today)
                ->first();

            if (!$existingAttendance) {
                // Mark as absent
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $today,
                    'status' => 'absent',
                ]);

                $markedAbsent++;
            }
        }

        $this->info("Marked {$markedAbsent} employees as absent for {$today->format('Y-m-d')}.");

        return 0;
    }
}
