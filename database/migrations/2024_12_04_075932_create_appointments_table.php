<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');  // Foreign key to the 'patients' table
            $table->date('appointment_date');  // Date of the appointment
            $table->time('appointment_time');  // Time of the appointment
            $table->unsignedBigInteger('doctor_id');  // Foreign key to the 'doctors' table
            $table->string('status')->default('Scheduled');  // Status, e.g., 'Scheduled', 'Accepted', 'Declined' 'Completed', 'Cancelled'
            $table->text('message')->nullable();  // Optional message or notes from the patient
            $table->timestamps();  // Created and updated timestamps

            // Foreign key constraint to link appointments with patients
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            // Foreign key constraint to link appointments with doctors
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
