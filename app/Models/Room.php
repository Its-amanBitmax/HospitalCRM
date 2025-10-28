<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'room_no',
        'department_id',
        'profession_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function roomAssignments()
    {
        return $this->hasMany(RoomAssignment::class);
    }
}
