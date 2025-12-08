<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalSchedule extends Model
{
        protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
