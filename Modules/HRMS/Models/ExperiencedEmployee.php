<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\ExperiencedEmployeeFactory;

class ExperiencedEmployee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
        protected $table = 'experienced_employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'gender',
        'job_profile',
        'address',
        'permanent_address',
        'pan_number',
        'aadhaar_number',
        'pan_proof',
        'aadhaar_proof',
        'highest_qualification',
        'highest_university',
        'year_of_passing',
        'highest_specialization',
        'university_percentage',
        'university_document',
        'puc_college',
        'puc_year',
        'puc_percentage',
        'puc_document',
        'tenth_school',
        'tenth_year',
        'tenth_percentage',
        'tenth_document',
        'father_name',
        'mother_name',
        'emergency_contact_name',
        'emergency_contact_number',
        'company_name',
        'designation',
        'duration',
        'reason_for_leaving',
        'experience_certificate',
        'salary_slip',
        // 'employee_id' // uncomment if you have this column
    ];

    // Cast JSON columns to array automatically
    protected $casts = [
        'highest_qualification' => 'array',
        'highest_university' => 'array',
        'year_of_passing' => 'array',
        'highest_specialization' => 'array',
        'university_percentage' => 'array',
        'university_document' => 'array',
        'company_name' => 'array',
        'designation' => 'array',
        'duration' => 'array',
        'reason_for_leaving' => 'array',
        'experience_certificate' => 'array',
        'salary_slip' => 'array',
    
    ];

    // protected static function newFactory(): ExperiencedEmployeeFactory
    // {
    //     // return ExperiencedEmployeeFactory::new();
    // }
}
