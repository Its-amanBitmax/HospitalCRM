<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'relationship',
        'date_of_birth',
        'contact_number',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
