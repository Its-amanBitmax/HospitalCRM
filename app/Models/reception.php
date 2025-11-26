<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reception extends Model
{
    use HasFactory;

    protected $table = 'receptions'; 
    
    protected $fillable = [
        'reception_id',
        'password',
        'assigned_employee',
        'status',
    ];

 public function employee()
{
    return $this->belongsTo(\App\Models\Employee::class, 'assigned_employee');
}




}
