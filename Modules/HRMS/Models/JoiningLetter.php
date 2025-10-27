<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\JoiningLetterFactory;

class JoiningLetter extends Model
{
    use HasFactory;

    protected $table = 'joining_letters';

    protected $fillable = [
        'designation',
        'department',
        'joining_date',
        'location',
    ];
}
