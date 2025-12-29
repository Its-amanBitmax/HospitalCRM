<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'uid',
        'date',
        'reason',
        'department_id',
        'added_by',
        'amount',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
