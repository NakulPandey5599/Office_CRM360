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
        Schema::create('salary_slip', function (Blueprint $table) {
            $table->id();
            // 🔹 Employee Info
            $table->string('employee_id');
            $table->string('employee_name');
            $table->string('designation')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('ctc', 10, 2)->nullable();

            // 🔹 Payroll Details
            $table->string('payment_month', 15);
            $table->date('payment_date')->nullable();
            $table->integer('days_present')->default(0);
            $table->integer('days_paid')->default(0);
            $table->integer('lop')->default(0);

            // 🔹 Earnings
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->decimal('hra', 10, 2)->nullable();
            $table->decimal('travel_allowance', 10, 2)->nullable();
            $table->decimal('special_allowance', 10, 2)->nullable();
            $table->decimal('performance_bonus', 10, 2)->nullable();
            $table->decimal('total_earnings', 10, 2)->nullable();

            // 🔹 Deductions
            $table->decimal('pf', 10, 2)->nullable();
            $table->decimal('gratuity', 10, 2)->nullable();
            $table->decimal('epf', 10, 2)->nullable();
            $table->decimal('tds', 10, 2)->nullable();
            $table->decimal('professional_tax', 10, 2)->nullable();
            $table->decimal('total_deductions', 10, 2)->nullable();

            // 🔹 Final Net Pay
            $table->decimal('net_salary', 10, 2)->nullable();

            // 🔹 Bank Info (Optional - static in your UI but can be dynamic)
            // $table->string('bank_name')->nullable();
            // $table->string('account_no')->nullable();
            // $table->string('ifsc_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slip');
    }
};
