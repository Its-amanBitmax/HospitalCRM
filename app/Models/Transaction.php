<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
        protected $fillable = [
        'module',
        'amount',
        'transaction_type',
        'payment_mode',
        'status',
        'transaction_date',
        'remarks',
        'created_by',
        'transaction_id'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
