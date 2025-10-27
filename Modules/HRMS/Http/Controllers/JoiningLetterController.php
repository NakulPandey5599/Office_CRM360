<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Validated;
use Modules\HRMS\Models\JoiningLetter;
use Modules\HRMS\Mail\JoiningLetterMail;

class JoiningLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hrms::joiningLetter.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrms::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $joiningForm = $request->validate([
            'department'    => 'required|string|max:255',
            'joining_date'  => 'required|date',
            'location'      => 'required|string|max:255',
            'designation'   => 'required|string|max:255',
        ]);

        $joining = JoiningLetter::create($joiningForm);

        return response()->json([
            'success' => true,
            'joining' => $joining,
        ]);
    }


    
    public function search(Request $request)
    {
        $query = $request->input('query');

        // 🔹 Search in experienced_employees
        $experienced = DB::table('experienced_employees')
            ->where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('job_profile', 'like', "%{$query}%")
            ->select('id', 'first_name', 'last_name', 'job_profile', 'email')
            ->limit(10)
            ->get();

        // 🔹 Search in freshers_employees
        $freshers = DB::table('freshers_employees')
            ->where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('job_profile', 'like', "%{$query}%")
            ->select('id', 'first_name', 'last_name', 'job_profile', 'email')
            ->limit(10)
            ->get();

        // 🔹 Merge both results
        $results = $experienced->merge($freshers);

        return response()->json($results);
    }


    public function sendEmail(Request $request)
    {
        $request->validate([
            'candidate_email' => 'required|email',
            'candidate_name' => 'required|string',
            'designation' => 'required|string',
            'department' => 'required|string',
            'joining_date' => 'required|date',
            'location' => 'required|string',
        ]);

        $details = $request->all();

        try {
            Mail::to($details['candidate_email'])->send(new JoiningLetterMail($details));
            return response()->json(['message' => 'Joining Letter sent successfully to ' . $details['candidate_email']]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error sending email: ' . $e->getMessage()], 500);
        }
    }



}
