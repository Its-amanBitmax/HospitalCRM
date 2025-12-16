<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseTask extends Model
{
    protected $fillable = [
        'department_id',
        'room_id',
        'nurse_id',
        'doctor_id',
        'user_id',
        'notes',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Employee::class, 'nurse_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }


    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
