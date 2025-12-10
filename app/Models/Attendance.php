<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
        'check_in_ip',
        'check_in_location',
        'check_in_latitude',
        'check_in_longitude',
        'check_in_server',
        'check_out_ip',
        'check_out_location',
        'check_out_latitude',
        'check_out_longitude',
        'check_out_server',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
