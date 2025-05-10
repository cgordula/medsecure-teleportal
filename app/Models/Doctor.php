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

    // Relationship to the Appointment model
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

}
