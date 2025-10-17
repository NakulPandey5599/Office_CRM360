<?php

namespace Modules\HRMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hrms::candidatesRegistration.index');
    }
    public function candidate()
    {
        return view('hrms::candidatesRegistration.newCandidate');
    }
}