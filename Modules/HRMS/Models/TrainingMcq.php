<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\TrainingMcqFactory;

class TrainingMcq extends Model
{
    use HasFactory;

    protected $fillable = ['assessment_name', 'questions'];

    protected $casts = [
        'questions' => 'array', // automatically decode JSON to array
    ];
}
