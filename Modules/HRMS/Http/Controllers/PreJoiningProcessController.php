<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\PreJoiningEmployee;

class PreJoiningProcessController extends Controller
{
    public function index()
    {
        return view('hrms::preJoiningProcess.index');
    }

    public function fresher()
    {
        return view('hrms::preJoiningProcess.fresher');
    }

    public function experienced()
    {
        return view('hrms::preJoiningProcess.experience');
    }

    public function store(Request $request)
    {
        $request->validate([
            'experience_type' => 'required|in:Fresher,Experienced',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:prejoining_employees,email',
            'phone'      => 'required|digits:10',
            'dob'        => 'required|date',
            'gender'     => 'required|string',
            'job_profile' => 'required|string',
            'address'    => 'required|string',
            'permanent_address' => 'required|string',
            'pan_number' => 'nullable|string',
            'aadhaar_number' => 'nullable|string',
            'pan_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'aadhaar_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            // Education validation
            'highest_qualification.*' => 'nullable|string',
            'highest_university.*'    => 'nullable|string',
            'year_of_passing.*'       => 'nullable|digits:4',
            'highest_specialization.*' => 'nullable|string',
            'university_percentage.*' => 'nullable|numeric',
            'university_document.*'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'puc_college'  => 'nullable|string',
            'puc_year'     => 'nullable|digits:4',
            'puc_percentage' => 'nullable|numeric',
            'puc_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tenth_school' => 'nullable|string',
            'tenth_year'   => 'nullable|digits:4',
            'tenth_percentage' => 'nullable|numeric',
            'tenth_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            // Family info
            'father_name'  => 'required|string',
            'mother_name'  => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_number' => 'required|digits:10',
            // Experience validation only if experienced
            'company_name.*' => 'required_if:experience_type,Experienced|string',
            'designation.*'  => 'required_if:experience_type,Experienced|string',
            'duration.*'     => 'required_if:experience_type,Experienced|string',
            'reason_for_leaving.*' => 'required_if:experience_type,Experienced|string',
        ]);

        // Upload required files
        $panPath = $request->file('pan_proof')->store('documents/pan', 'public');
        $aadhaarPath = $request->file('aadhaar_proof')->store('documents/aadhaar', 'public');
        $pucDoc = $request->hasFile('puc_document') ? $request->file('puc_document')->store('documents/puc', 'public') : null;
        $tenthDoc = $request->hasFile('tenth_document') ? $request->file('tenth_document')->store('documents/tenth', 'public') : null;

        // University documents (multiple)
        $universityDocs = [];
        if ($request->hasFile('university_document')) {
            foreach ($request->file('university_document') as $file) {
                $universityDocs[] = $file->store('documents/university', 'public');
            }
        }

        // For experienced type – optional file fields
        $expCerts = [];
        if ($request->hasFile('experience_certificate')) {
            foreach ($request->file('experience_certificate') as $file) {
                $expCerts[] = $file->store('documents/experience_certificate', 'public');
            }
        }

        $salarySlips = [];
        if ($request->hasFile('salary_slip')) {
            foreach ($request->file('salary_slip') as $file) {
                $salarySlips[] = $file->store('documents/salary_slip', 'public');
            }
        }

        // Save data
        PreJoiningEmployee::create([
            'experience_type' => $request->experience_type,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'job_profile' => $request->job_profile,
            'address' => $request->address,
            'permanent_address' => $request->permanent_address,
            'pan_number' => $request->pan_number,
            'aadhaar_number' => $request->aadhaar_number,
            'pan_proof' => $panPath,
            'aadhaar_proof' => $aadhaarPath,
            'highest_qualification' => json_encode($request->highest_qualification),
            'highest_university' => json_encode($request->highest_university),
            'year_of_passing' => json_encode($request->year_of_passing),
            'highest_specialization' => json_encode($request->highest_specialization),
            'university_percentage' => json_encode($request->university_percentage),
            'university_document' => json_encode($universityDocs),
            'puc_college' => $request->puc_college,
            'puc_year' => $request->puc_year,
            'puc_percentage' => $request->puc_percentage,
            'puc_document' => $pucDoc,
            'tenth_school' => $request->tenth_school,
            'tenth_year' => $request->tenth_year,
            'tenth_percentage' => $request->tenth_percentage,
            'tenth_document' => $tenthDoc,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'company_name' => json_encode($request->company_name),
            'designation' => json_encode($request->designation),
            'duration' => json_encode($request->duration),
            'reason_for_leaving' => json_encode($request->reason_for_leaving),
            'experience_certificate' => json_encode($expCerts),
            'salary_slip' => json_encode($salarySlips),
        ]);

        return redirect()->back()->with('success', "{$request->experience_type} employee saved successfully!");
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = DB::table('prejoining_employees')
            ->where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->select('id', DB::raw("CONCAT(first_name, ' ', last_name) as name"), 'job_profile', 'experience_type')
            ->limit(10)
            ->get();

        return response()->json($results);
    }
}
