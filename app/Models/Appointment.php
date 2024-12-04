<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'appointment_date', 'appointment_time', 'status', 'notes',
    ];

    // Relationship with Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
