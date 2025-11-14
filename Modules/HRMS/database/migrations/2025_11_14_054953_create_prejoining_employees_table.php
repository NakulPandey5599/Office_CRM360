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
        Schema::create('prejoining_employees', function (Blueprint $table) {
            $table->id();
              // 👇 Common for both
            $table->enum('experience_type', ['Fresher', 'Experienced'])->default('Fresher');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('dob');
            $table->string('gender');
            $table->string('job_profile');
            $table->text('address');
            $table->text('permanent_address');
            $table->string('pan_number')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_proof');
            $table->string('aadhaar_proof');

            // 🎓 Education Details
            $table->json('highest_qualification')->nullable(); 
            $table->json('highest_university')->nullable();
            $table->json('year_of_passing')->nullable();
            $table->json('highest_specialization')->nullable();
            $table->json('university_percentage')->nullable();
            $table->json('university_document')->nullable();

            $table->string('puc_college')->nullable();
            $table->string('puc_year')->nullable();
            $table->string('puc_percentage')->nullable();
            $table->string('puc_document')->nullable();

            $table->string('tenth_school')->nullable();
            $table->string('tenth_year')->nullable();
            $table->string('tenth_percentage')->nullable();
            $table->string('tenth_document')->nullable();

            // 👨‍👩 Family / Emergency Info
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');

            // 💼 Only for Experienced
            $table->json('company_name')->nullable();
            $table->json('designation')->nullable();
            $table->json('duration')->nullable();
            $table->json('reason_for_leaving')->nullable();
            $table->json('experience_certificate')->nullable();
            $table->json('salary_slip')->nullable();
            $table->json('receiving_letter')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prejoining_employees');
    }
};
