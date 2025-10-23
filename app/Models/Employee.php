<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'hire_date',
        'image',
    ];

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payroll()
    {
        return $this->hasOne(Payroll::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function familyDetails()
    {
        return $this->hasMany(FamilyDetail::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }

    public function expertise()
    {
        return $this->hasMany(Expertise::class);
    }
}
