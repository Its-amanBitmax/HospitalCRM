<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relative extends Model
{
    public $timestamps = false; 
    protected $primaryKey = 'relative_id';
    protected $fillable = [
        'user_id', 'name', 'age', 'gender', 'relation', 'blood_group', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
