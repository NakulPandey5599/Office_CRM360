<?php

namespace Modules\HRMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
   
   

    public function monthlyPayroll()
    {
        return view('hrms::payroll.monthly');
    }

    public function hourlyPayroll(){
         return view('hrms::payroll.hourly');
    }

    public function finalizedPayroll(){
         return view('hrms::payroll.finalized');
    }
}