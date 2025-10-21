<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'faq_id',
        'question',
        'answer',
        'category',
        'status',
    ];
}
