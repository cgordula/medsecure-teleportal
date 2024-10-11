<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    // use HasFactory, Notifiable;
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'specialization',
        'license_number',
        'password',
        'role',
    ];
}
