<?php

namespace Modules\HRMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\HRMS\Database\Factories\AttendanceFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    
    protected $fillable = [
        'employee_id',
        'employee_name',
        'department',
        'date',
        'clock_in',
        'clock_out',
        'is_late',
        'is_half_day',
        'working_from',
        'is_overwritten',
    ];

    protected $casts = [
        'date' => 'date',
        'is_late' => 'boolean',
        'is_half_day' => 'boolean',
    ];
}
