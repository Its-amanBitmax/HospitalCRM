<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['item_id', 'item_name', 'category', 'quantity', 'unit', 'reorder_level', 'price_per_unit', 'supplier_id', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
