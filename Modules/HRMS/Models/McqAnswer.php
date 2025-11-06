<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\McqAnswerFactory;

class McqAnswer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'assessment_results';

    
    protected $fillable = [
        'user_id',
        'assessment_id',
        'score',
        'total',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}
