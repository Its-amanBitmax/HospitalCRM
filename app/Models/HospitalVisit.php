<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalVisit extends Model
{
    protected $fillable = [
        'visitor_name',
        'visitor_contact',
        'visitor_email',
        'visitor_relation',
        'contact_person_name',
        'contact_person_phone',
        'visit_type',
        'purpose',
        'notes',
        'patient_id',
        'patient_mr_no',
        'doctor_id',
        'invited_at',
        'invite_status',
        'invitation_code',
        'scheduled_visit',
        'check_in',
        'check_out',
        'status',
        'id_proof_type',
        'id_proof_number',
        'badge_number',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'scheduled_visit' => 'datetime',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
