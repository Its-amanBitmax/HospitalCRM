<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCheckup extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_name',
        'test_code',
        'category',
        'department_id',
        'sample_required',
        'sample_type',
        'fasting_required',
        'unit',
        'tat',
        'normal_range',
        'instructions',
        'status'
    ];

    protected $casts = [
        'sample_required' => 'boolean',
        'fasting_required' => 'boolean',
    ];

    /**
     * Relationship with Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Scope for active tests
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function book()
    {
        return $this->hasMany(TestBook::class, 'test_id');
    }
}
