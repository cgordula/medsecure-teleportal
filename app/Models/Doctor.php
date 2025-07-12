<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialization',
        'license_number',
        'password',
        'role',
        'profile_picture',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        // For auto-generating reference number on creation
        static::creating(function ($doctor) {
            if (empty($patient->reference_number)) {
                $date = now()->format('Ymd');
                $nextNumber = str_pad(Doctor::count() + 1, 4, '0', STR_PAD_LEFT);
                $doctor->reference_number = 'MSD-' . $date . '-' . $nextNumber;
            }
        });
    }

    // Relationship to the Appointment model
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

}
