<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'store_id',
        'medicine_name',
        'brand',
        'category',
        'batch_no',
        'expiry_date',
        'image',
        'stock',
        'purchase_price',
        'sale_price',
        'status'
    ];

    // Relationships
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
