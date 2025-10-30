<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedAssignment extends Model
{
    protected $fillable = [
        'user_id',
        'bed_id',
        'assigned_date',
        'discharge_date',
        'status',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'discharge_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }
}
