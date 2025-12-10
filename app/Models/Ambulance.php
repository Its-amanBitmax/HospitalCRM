<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    protected $fillable = [
        'ambulance_number',
        'vehicle_type',
        'driver_id',
        'status',
    ];

    public function driver()
    {
        return $this->belongsTo(Employee::class, 'driver_id');
    }
}
