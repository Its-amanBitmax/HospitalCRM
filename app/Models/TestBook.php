<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestBook extends Model
{

    protected $fillable = [
        'user_id',
        'test_checkup_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
    ];

    public function test()
    {
        return $this->belongsTo(TestCheckup::class, 'test_checkup_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
