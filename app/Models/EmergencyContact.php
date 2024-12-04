<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    // Define the table associated with the model (if it's different from the default 'emergency_contacts')
    protected $table = 'emergency_contacts';

    // Specify the fillable attributes (columns you want to mass assign)
    protected $fillable = [
        'patient_id',
        'name',
        'relationship',
        'phone'
    ];

    // Define the relationship to the Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
