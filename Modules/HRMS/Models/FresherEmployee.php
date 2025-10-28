<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\FresherEmployeeFactory;

class FresherEmployee extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'freshers_employees';

    // Fillable columns
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
    ];

    // Cast JSON columns to array automatically
    protected $casts = [
        'highest_qualification' => 'array',
        'highest_university' => 'array',
        'year_of_passing' => 'array',
        'highest_specialization' => 'array',
        'university_percentage' => 'array',
        'university_document' => 'array',
    ];
}
