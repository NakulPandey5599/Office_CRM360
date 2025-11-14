<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\SalaryslipFactory;

class SalarySlip extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        // 🔹 Employee Info
        'employee_id',
        'employee_name',
        'designation',
        'joining_date',
        'ctc',

        // 🔹 Payroll Details
        'payment_month',
        'payment_date',
        'days_present',
        'days_paid',
        'lop',

        // 🔹 Earnings
        'basic_salary',
        'hra',
        'travel_allowance',
        'special_allowance',
        'performance_bonus',
        'total_earnings',

        // 🔹 Deductions
        'pf',
        'gratuity',
        'epf',
        'tds',
        'professional_tax',
        'total_deductions',

        // 🔹 Final Pay
        'net_salary',

        
    ];

    // ✅ Casting for numeric fields
    protected $casts = [
    // REMOVE date casting, or change to string
    
    'ctc' => 'decimal:2',
    'basic_salary' => 'decimal:2',
    'hra' => 'decimal:2',
    'travel_allowance' => 'decimal:2',
    'special_allowance' => 'decimal:2',
    'performance_bonus' => 'decimal:2',
    'pf' => 'decimal:2',
    'gratuity' => 'decimal:2',
    'epf' => 'decimal:2',
    'tds' => 'decimal:2',
    'professional_tax' => 'decimal:2',
    'total_earnings' => 'decimal:2',
    'total_deductions' => 'decimal:2',
    'net_salary' => 'decimal:2',
];


}
