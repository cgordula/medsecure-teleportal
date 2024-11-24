<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');  // Storing the first name
            $table->string('last_name');   // Storing the last name
            $table->string('email')->unique();  // Email should be unique
            $table->string('password');    // Storing the hashed password
            $table->string('phone')->nullable();  // Phone number (nullable)
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();  // Gender field (nullable)
            $table->integer('age')->nullable(); 
            $table->date('birthdate')->nullable();  // Birthdate (nullable)
            $table->string('profile_picture')->nullable();  // Profile picture (nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
