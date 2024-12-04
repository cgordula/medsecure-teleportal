<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');  // Foreign key referencing the patients table
            $table->string('name');  // Emergency contact name
            $table->string('relationship');  // Relationship to the patient
            $table->string('phone');  // Emergency contact phone number
            $table->timestamps();  // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_contacts');
    }
}
