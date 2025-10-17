<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freshers_employees', function (Blueprint $table) {
            $table->id();
             
            // // Fresher or Experienced
            // $table->string('experience_type');

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('dob');
            $table->string('gender');
            $table->string('job_profile');
            $table->string('address');
            $table->string('permanent_address');
            $table->string('pan_number')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_proof');
            $table->string('aadhaar_proof');

            // Education Details (multiple stored as JSON)
            $table->string('highest_qualification'); // only BCA, MCA etc.
            $table->json('highest_university');
            $table->json('year_of_passing');
            $table->json('highest_specialization');
            $table->json('university_percentage');
            $table->json('university_document');

            $table->string('puc_college');
            $table->string('puc_year');
            $table->string('puc_percentage');
            $table->string('puc_document');

            $table->string('tenth_school');
            $table->string('tenth_year');
            $table->string('tenth_percentage');
            $table->string('tenth_document');

            // Family / Emergency
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freshers_employees');
    }
};
