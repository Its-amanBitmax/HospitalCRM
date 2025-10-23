<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'employee_id',
        'degree',
        'institution',
        'year_completed',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
