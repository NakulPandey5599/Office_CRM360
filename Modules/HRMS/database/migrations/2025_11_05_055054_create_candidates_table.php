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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            
            // Candidate Info
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('linkedin_profile');

            // Job Info
            $table->text('job_summary');
            $table->string('job_profile');

            // Interview Info
            $table->string('interview_mode');
            $table->date('interview_date');
            $table->time('interview_time')->nullable();
            $table->string('status');

            // Final Selection
            $table->string('final_selection')->nullable()->default('on hold');

            // Other Details
            $table->text('notes')->nullable();

            // File Upload
            $table->string('resume');

            // New company_id field
            $table->unsignedBigInteger('company_id')->default(123);
            $table->boolean('email_sent')->default(false);
            $table->string('password')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
