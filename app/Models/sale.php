<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_no',
        'store_id',
        'customer_name',
        'customer_phone',
        'sub_total',
        'discount',
        'tax',
        'grand_total',
        'payment_method'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
