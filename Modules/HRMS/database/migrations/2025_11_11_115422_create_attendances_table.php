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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('employee_name');
            $table->string('department')->nullable();
            $table->date('date');
            $table->string('status', 10)->default('-');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->boolean('is_late')->default(false);
            $table->boolean('is_half_day')->default(false);
            $table->enum('working_from', ['office', 'home', 'other'])->default('other');
            $table->boolean('is_overwritten')->default(false);
            $table->string('leave_type')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
