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
        Schema::create('data_verification', function (Blueprint $table) {
            $table->id();
            $table->string('previous_company_name');
            $table->string('hr_contact_name');
            $table->string('hr_contact_email');
            $table->string('hr_contact_phone');
            $table->string('receiving_letter'); 
            $table->string('experience_certificate'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_verification');
    }
};
