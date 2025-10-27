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
        $table->string('candidate_name')->nullable()->after('id');
        $table->string('candidate_department')->nullable()->after('candidate_name');
        $table->unsignedBigInteger('candidate_id')->nullable()->after('candidate_department');
 
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
