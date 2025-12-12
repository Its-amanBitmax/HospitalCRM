<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodBank extends Model
{
    protected $fillable = [
        'blood_group',
        'units',
        'donor_name',
        'donor_contact',
        'donor_address',
        'status'
    ];
}
