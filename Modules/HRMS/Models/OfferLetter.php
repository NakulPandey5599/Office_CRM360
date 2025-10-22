<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\OfferLetterFactory;

class OfferLetter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'candidate_id',
        'candidate_name',
        'designation',
        'department',
        'joining_date',
        'location',
        'ctc',
        
    ];

    // protected static function newFactory(): OfferLetterFactory
    // {
    //     // return OfferLetterFactory::new();
    // }
}
