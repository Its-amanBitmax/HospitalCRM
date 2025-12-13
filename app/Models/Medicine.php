<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
protected $fillable = [
'store_id','medicine_name','brand','category','batch_no','image',
'expiry_date','stock','purchase_price','sale_price','status'
];


public function store()
{
return $this->belongsTo(Store::class);
}
}