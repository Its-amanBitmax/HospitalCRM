<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
protected $fillable = [
'store_id','medicine_id','type','quantity',
'stock_before','stock_after','reference','note'
];


public function store() { return $this->belongsTo(Store::class); }
public function medicine() { return $this->belongsTo(Medicine::class); }
}