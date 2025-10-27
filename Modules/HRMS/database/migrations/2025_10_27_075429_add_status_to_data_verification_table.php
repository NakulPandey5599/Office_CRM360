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
        Schema::table('data_verification', function (Blueprint $table) {
            $table->enum('status', ['pending', 'verified', 'not_verified'])
                  ->default('pending')
                  ->after('experience_certificate');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_verification', function (Blueprint $table) {
            
        });
    }
};
