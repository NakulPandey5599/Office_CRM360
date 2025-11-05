<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\CandidatesFactory;

class Candidates extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'linkedin_profile',
        'job_summary',
        'job_profile',
        'interview_mode',
        'interview_date',
        'interview_time',
        'status',
        'final_selection',
        'notes',
        'resume',
        'email_sent',
        'company_id',
    ];
    
     protected $hidden = [
        'password',
    ];
}
