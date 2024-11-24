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
        'first_name', 'last_name', 'email', 'password', 'phone', 'gender', 'birthdate', 'profile_picture',
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
}
