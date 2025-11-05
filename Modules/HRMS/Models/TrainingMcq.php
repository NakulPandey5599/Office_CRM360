<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\TrainingMcqFactory;

class TrainingMcq extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'question', 'option_a', 'option_b',
        'option_c', 'option_d', 'correct_option'
    ];
}
