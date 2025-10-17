<?php

namespace Modules\HRMS\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\FresherEmployee;
use Modules\HRMS\Models\ExperiencedEmployee;

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

    public function create()
    {
        return view('hrms::create');
    }

public function store(Request $request)
{
    // Base validation for personal info
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|max:255',
        'phone'      => 'required|digits:10',
        'dob'        => 'required|string',
        'gender'     => 'required|string',
        'job_profile'=> 'required|string',
        'address'    => 'required|string',
        'permanent_address' => 'required|string',
        'pan_number' => 'nullable|string',
        'aadhaar_number' => 'nullable|string',
        'pan_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'aadhaar_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        // Education validation
        'highest_qualification.*' => 'required|string',
        'highest_university.*'    => 'required|string',
        'year_of_passing.*'       => 'required|digits:4',
        'highest_specialization.*'=> 'required|string',
        'university_percentage.*' => 'required|numeric',
        'university_document.*'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'puc_college'  => 'required|string',
        'puc_year'     => 'required|digits:4',
        'puc_percentage'=> 'required|numeric',
        'puc_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'tenth_school' => 'required|string',
        'tenth_year'   => 'required|digits:4',
        'tenth_percentage'=> 'required|numeric',
        'tenth_document'=> 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        // Family info
        'father_name'  => 'required|string',
        'mother_name'  => 'required|string',
        'emergency_contact_name' => 'required|string',
        'emergency_contact_number' => 'required|digits:10',
        // Experience validation
        'company_name.*' => 'required_if:experience_type,Experienced|string',
        'designation.*'  => 'required_if:experience_type,Experienced|string',
        'duration.*'     => 'required_if:experience_type,Experienced|string',
        'reason_for_leaving.*' => 'required_if:experience_type,Experienced|string',
        'experience_certificate.*' => 'required_if:experience_type,Experienced|file|mimes:pdf,jpg,jpeg,png',   
        'salary_slip.*' => 'required_if:experience_type,Experienced|file|mimes:pdf,jpg,jpeg,png',
    ]);

    $experienceType = $request->input('experience_type');

    // Upload main documents
    $panPath = $request->file('pan_proof')->store('documents/pan', 'public');
    $aadhaarPath = $request->file('aadhaar_proof')->store('documents/aadhaar', 'public');

    // Upload PUC & 10th
    $pucDoc = $request->file('puc_document')->store('documents/puc', 'public');
    $tenthDoc = $request->file('tenth_document')->store('documents/tenth', 'public');

    // Upload multiple university documents
    $universityDocs = [];
    if($request->hasFile('university_documents')){
        foreach($request->file('university_documents') as $file){
            $universityDocs[] = $file->store('documents/university', 'public');
        }
    }

    // Data array
    $data = [
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'dob'        => $request->dob,
        'gender'     => $request->gender,
        'job_profile'=> $request->job_profile,
        'address'    => $request->address,
        'permanent_address' => $request->permanent_address,
        'pan_number' => $request->pan_number,
        'aadhaar_number' => $request->aadhaar_number,
        'pan_proof' => $panPath,
        'aadhaar_proof' => $aadhaarPath,
        'highest_qualification' => json_encode($request->highest_qualification),
        'highest_university'    => json_encode($request->highest_university),
        'year_of_passing'       => json_encode($request->year_of_passing),
        'highest_specialization'=> json_encode($request->highest_specialization),
        'university_percentage' => json_encode($request->university_percentage),
        'university_document'   => json_encode($universityDocs),
        'puc_college'  => $request->puc_college,
        'puc_year'     => $request->puc_year,
        'puc_percentage'=> $request->puc_percentage,
        'puc_document' => $pucDoc,
        'tenth_school' => $request->tenth_school,
        'tenth_year'   => $request->tenth_year,
        'tenth_percentage'=> $request->tenth_percentage,
        'tenth_document'=> $tenthDoc,
        'father_name'  => $request->father_name,
        'mother_name'  => $request->mother_name,
        'emergency_contact_name' => $request->emergency_contact_name,
        'emergency_contact_number' => $request->emergency_contact_number,
        'company_name' => json_encode($request->company_name),
        'designation'  => json_encode($request->designation),
        'duration'     => json_encode($request->duration),
        'reason_for_leaving' => json_encode($request->reason_for_leaving),
        // 'employee_id'  => $employeeId,
        'experience_certificate' => json_encode($request->experience_certificate),
        'salary_slip' => json_encode($request->salary_slip),
    ];

    // Save to Fresher or Experienced
    if($experienceType === 'Fresher'){
        FresherEmployee::create($data);
        return redirect()->back()->with('success', 'Fresher employee saved successfully!');
    }else{
        ExperiencedEmployee::create($data);
        return redirect()->back()->with('success', 'Experienced employee saved successfully!');
    }
}





    public function show($id)
    {
        return view('hrms::show');
    }

    public function edit($id)
    {
        return view('hrms::edit');
    }

    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
