<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $table = 'specialities';

    protected $fillable = [
        'skill',
        'image',
    ];


    public function employees()
{
    return $this->belongsToMany(Employee::class, 'employee_speciality')
                ->withPivot('proficiency_level', 'years_of_experience');
}
}
