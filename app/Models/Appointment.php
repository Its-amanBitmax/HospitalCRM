<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'appointment_id';
    protected $fillable = [
        'appointment_code',
        'booked_by_user_id',
        'for_user_type',
        'relative_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'issue',
        'description',
        'status',
        'type',
        'shift_name',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            $appointment->appointment_code = 'APT-' . strtoupper(Str::random(8));
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by_user_id');
    }

    public function relative()
    {
        return $this->belongsTo(Relative::class, 'relative_id');
    }
}
