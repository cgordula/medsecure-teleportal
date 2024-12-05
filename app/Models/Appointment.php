<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'patient_id',
        'appointment_date',
        'appointment_time',
        'doctor',
        'status',
        'message',
    ];

    // Relationship with Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
