<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'charge',
        'name',
        'type',
        'sub_type',
        'description',
    ];

    // Doctor (Employee) relation
    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
