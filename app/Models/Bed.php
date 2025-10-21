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
}
