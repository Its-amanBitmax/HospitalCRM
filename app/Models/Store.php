<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name',
        'owner_name',
        'license_no',
        'gst_no',
        'phone',
        'email',
        'address',
        'status'
    ];

    // Relationships
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
