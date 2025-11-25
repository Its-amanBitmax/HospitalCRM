<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'hire_date',
        'status',
        'image',
        'employee_code',
        'password',
        'department_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

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

    public function specialities()
    {
        return $this->belongsToMany(Speciality::class, 'employee_speciality')->withPivot('proficiency_level', 'years_of_experience');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function attendances()
{
    return $this->hasMany(Attendance::class, 'employee_id', 'id');
}

}
