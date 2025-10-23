<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'employee_id',
        'address_type',
        'street',
        'city',
        'state',
        'country',
        'postal_code',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
