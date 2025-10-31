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
    protected $table = 'mcq_answers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'answers',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'answers' => 'array', // automatically decode/encode JSON
    ];
}
