<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalInformation extends Model
{
    use HasFactory;

    // Define the table associated with the model (if it's different from the default 'medical_information')
    protected $table = 'medical_information';

    // Specify the fillable attributes (columns you want to mass assign)
    protected $fillable = [
        'patient_id', 
        'medical_history', 
        'current_medications', 
        'allergies', 
        'primary_complaint', 
        'consultation_notes', 
        'diagnoses', 
        'prescriptions', 
        'body_measures'
    ];

     // Define the relationship to the Patient model
     public function patient()
     {
         return $this->belongsTo(Patient::class);
     }
}