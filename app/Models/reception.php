<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;

    protected $table = 'receptions';

    protected $fillable = [
        'reception_id',
        'password',
        'assigned_employee',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee');
    }

    public function visits()
    {
        return $this->hasMany(PatientVisit::class, 'referred_by');
    }
}
