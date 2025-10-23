<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll';

    protected $fillable = [
        'employee_id',
        'salary',
        'bank_account',
        'bank_name',
        'ifsc_code',
        'upi_number',
        'pf_number',
        'payment_frequency',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
