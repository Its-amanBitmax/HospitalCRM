<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $table = 'expertise';

    protected $fillable = [
        'employee_id',
        'skill',
        'proficiency_level',
        'years_of_experience',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
