<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;


class Patient extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone', 'gender', 'birthdate', 'profile_picture',  'address_line1', 'address_line2', 'city', 'state', 'postal_code', 'country', 'token',
    ];

    protected $casts = [
        'birthdate' => 'date', // Automatically cast to a Carbon instance
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($patient) {
            if ($patient->birthdate) {
                // Calculate age based on birthdate
                $patient->age = Carbon::parse($patient->birthdate)->age;
            }
        });
    }

    // Hide sensitive information
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function medical_information()
    {
        return $this->hasOne(MedicalInformation::class);
    }

    // Assuming the relationship for emergency contact
    public function emergency_contact()
    {
        return $this->hasOne(EmergencyContact::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
    



}
