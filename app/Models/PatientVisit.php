<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    protected $fillable = [
        'user_id',
        'visit_type',
        'date_of_visit',
        'chief_complaint',
        'referred_by',
        'department_consultant',
    ];

    protected $casts = [
    'date_of_visit' => 'date:Y-m-d',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
public function reception()
{
    return $this->belongsTo(Reception::class, 'referred_by');
}

public function consultantAssignment()
{
    return $this->belongsTo(RoomAssignment::class, 'department_consultant');
}




}
