<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCheckup extends Model
{
    protected $fillable = [
        'user_id',
        'checkup_date',
        'diagnosis',
        'treatment',
    ];

    protected $casts = [
        'checkup_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
