<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['ward_id', 'name', 'floor', 'bed_limit', 'status'];

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
}
