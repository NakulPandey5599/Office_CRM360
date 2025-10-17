<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\Candidates;


class NewCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
{
    // Fetch candidates
    // Return the list view
    return view();
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrms::candidatesRegistration.newCandidate');
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request){
        try {
            
            
            // ✅ Validate incoming request data
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:candidates,email',
                'phone' => 'required|string|max:20',
                'linkedin_profile' => 'required|url',
                'job_summary' => 'required|string',
                'job_profile' => 'required|string|max:255',
                'interview_mode' => 'required|string|max:100',
                'interview_date' => 'required|date',
                'interview_time' => 'nullable',
                'status' => 'required|string|max:100',
                'final_selection' => 'required|string|max:100',
                'notes' => 'nullable|string',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);
    
            // ✅ Handle file upload
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
                $validated['resume'] = $resumePath;
            }
        
            // ✅ Add static company_id here
            $validated['company_id'] = 123; // <-- Replace 123 with your static ID

            // ✅ Create candidate
            $candidate = Candidates::create($validated);
    
            return redirect()->back()->with('success', 'User added successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error: ' . $th->getMessage());

        }
    }


}