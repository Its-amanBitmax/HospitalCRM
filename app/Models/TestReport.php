<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'file_path',
        'file_name',
        'user_status',
        'doctor_status',
    ];

    // Patient (User) relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Doctor (Employee) relationship
    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }
}
