<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $fillable = ['bed_id', 'ward_id', 'type', 'status'];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function bedAssignments()
    {
        return $this->hasMany(BedAssignment::class);
    }

    public function activeAssignment()
    {
        return $this->hasOne(BedAssignment::class)->where('status', 'active');
    }
}
