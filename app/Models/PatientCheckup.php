<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCheckup extends Model
{
    protected $fillable = [
        'user_id',
        'visit_id',
        'checkup_date',
        'diagnosis',
        'treatment',
    ];

   protected $casts = [
    'checkup_date' => 'date:Y-m-d',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visit()
    {
        return $this->belongsTo(PatientVisit::class, 'visit_id');
    }
}
