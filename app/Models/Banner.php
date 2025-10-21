<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'banner_id',
        'title',
        'image_url',
        'redirect_url',
        'position',
        'status',
    ];

    protected $casts = [
        'position' => 'string',
        'status' => 'string',
    ];
}
