<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'age',
        'gender',
        'full_address',
        'username',
        'password',
        'mobile_no',
        'email',
        'registered_through',
        'type',
        'status',
        'image',
        'father_spouse_name',
        'alternate_no',
        'city',
        'state',
        'pin_code',
        'id_proof_type',
        'id_number',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the patient visits for the user.
     */
    public function patientVisits()
    {
        return $this->hasMany(PatientVisit::class);
    }

    /**
     * Get the patient checkups for the user.
     */
    public function patientCheckups()
    {
        return $this->hasMany(PatientCheckup::class);
    }

    /**
     * Get the patient documents for the user.
     */
    public function patientDocuments()
    {
        return $this->hasMany(PatientDocument::class);
    }
}
