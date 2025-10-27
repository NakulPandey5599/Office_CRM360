<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\DataVerificationFactory;

class DataVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
      protected $table = 'data_verification';

    protected $fillable = [
        'candidate_id',
        'candidate_department',
        'candidate_name',
        'previous_company_name',
        'hr_contact_name',
        'hr_contact_email',
        'hr_contact_phone',
        'receiving_letter',
        'experience_certificate',
        'status',

    ];

    // protected static function newFactory(): DataVerificationFactory
    // {
    //     // return DataVerificationFactory::new();
    // }
}
