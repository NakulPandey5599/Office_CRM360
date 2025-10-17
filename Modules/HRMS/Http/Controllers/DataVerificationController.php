<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\DataVerification;
use Modules\HRMS\Models\ExperiencedEmployee;

class DataVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $experienced = ExperiencedEmployee::all();
        return view('hrms::dataVerification.index',compact('experienced'));
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
    // Validate incoming request
    $request->validate([
        'previous_company_name' => 'required|string|max:255',
        'hr_contact_name' => 'required|string|max:255',
        'hr_contact_email' => 'required|email|max:255',
        'hr_contact_phone' => 'required|string|max:20',
        'receiving_letter' => 'nullable|file|mimes:pdf,jpg,png',
        'experience_certificate' => 'nullable|file|mimes:pdf,jpg,png',
    ]);

    // Handle file uploads
    $receivingLetterPath = null;
    if ($request->hasFile('receiving_letter')) {
        $receivingLetterPath = $request->file('receiving_letter')
            ->store('data_verification/receiving_letters', 'public');
    }

    $experienceCertPath = null;
    if ($request->hasFile('experience_certificate')) {
        $experienceCertPath = $request->file('experience_certificate')
            ->store('data_verification/experience_certificates', 'public');
    }

    // Save data to database
    DataVerification::create([
        'previous_company_name' => $request->previous_company_name,
        'hr_contact_name' => $request->hr_contact_name,
        'hr_contact_email' => $request->hr_contact_email,
        'hr_contact_phone' => $request->hr_contact_phone,
        'receiving_letter' => $receivingLetterPath,
        'experience_certificate' => $experienceCertPath,
    ]);

    return redirect()->back()->with('success', 'Data verification details saved successfully!');
}


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $employee = ExperiencedEmployee::findOrFail($id);
         $dataVerification = DataVerification::where('id', $id)->first();
        return view('hrms::dataVerification.verification', compact('employee', 'dataVerification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('hrms::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
