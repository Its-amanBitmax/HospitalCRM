<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
protected $fillable = [
'store_name','owner_name','license_no','gst_no',
'phone','email','address','status'
];
}
