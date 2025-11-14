<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\PreJoiningEmployeeFactory;

class PreJoiningEmployee extends Model
{
    use HasFactory;

    protected $table = 'prejoining_employees';

    protected $fillable = [
        'experience_type',
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
        'receiving_letter',
    ];

    // Cast JSON fields automatically to array
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
        'receiving_letter' => 'array',
    ];

}
