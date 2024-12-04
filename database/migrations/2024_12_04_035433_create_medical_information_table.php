<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_information', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            
            // Medical information fields
            $table->json('medical_history')->nullable(); // JSON field for past medical conditions, surgeries, and family history
            $table->json('allergies')->nullable(); // JSON field for list of allergies
            $table->json('current_medications')->nullable(); // JSON field for current medications
            $table->text('primary_complaint')->nullable(); // Text field for the reason for consultation
            $table->text('consultation_notes')->nullable(); // Doctor's notes
            $table->json('diagnoses')->nullable(); // JSON field for diagnosed conditions
            $table->json('prescriptions')->nullable(); // JSON field for prescriptions
            $table->json('vital_signs')->nullable(); // JSON field for vital signs like BP, heart rate, etc.

            $table->timestamps(); // Created at and Updated at timestamps

            // Foreign key constraint
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_information');
    }
}
