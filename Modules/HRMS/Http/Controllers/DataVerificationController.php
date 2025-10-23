<?php

    namespace Modules\HRMS\Http\Controllers;



    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Mail;
    use Modules\HRMS\Models\Candidates;
    use Modules\HRMS\Models\DataVerification;
    use Modules\HRMS\Models\ExperiencedEmployee;
    use Modules\HRMS\Mail\CandidateVerificationMail;


    class DataVerificationController extends Controller
    {
        /**

        * Display a listing of the resource.
        */
        public function index()
        {
            // fall back to an empty collection if the model class does not exist
            $dataVerification = DataVerification::all();
            $experienced = ExperiencedEmployee::all();
            return view('hrms::dataVerification.verification', compact('dataVerification', 'experienced'));
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
    // Validate request
    $request->validate([
        'previous_company_name' => 'required|string|max:255',
        'hr_contact_name'       => 'required|string|max:255',
        'hr_contact_email'      => 'required|email|max:255',
        'hr_contact_phone'      => 'required|string|max:20',
        'receiving_letter'      => 'nullable|file|mimes:pdf,jpg,png',
        'experience_certificate'=> 'nullable|file|mimes:pdf,jpg,png',
        'candidate_name'        => 'required|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // Handle file uploads
        $receivingLetterPath = $request->hasFile('receiving_letter') 
            ? $request->file('receiving_letter')->store('data_verification/receiving_letters', 'public') 
            : null;

        $experienceCertPath = $request->hasFile('experience_certificate') 
            ? $request->file('experience_certificate')->store('data_verification/experience_certificates', 'public') 
            : null;

        // Save record in DB
        $dataVerification = DataVerification::create([
            'previous_company_name' => $request->previous_company_name,
            'hr_contact_name'       => $request->hr_contact_name,
            'hr_contact_email'      => $request->hr_contact_email,
            'hr_contact_phone'      => $request->hr_contact_phone,
            'receiving_letter'      => $receivingLetterPath,
            'experience_certificate'=> $experienceCertPath,
        ]);

        // Candidate as array
        $candidate = [
            'name' => $request->candidate_name,
        ];

        // Attachments (full paths)
        $attachments = [];
        foreach ([$receivingLetterPath, $experienceCertPath] as $file) {
            if ($file && file_exists(storage_path('app/public/' . $file))) {
                $attachments[] = storage_path('app/public/' . $file);
            }
        }

        // Send email
        Mail::to($request->hr_contact_email)->send(new CandidateVerificationMail(
            $candidate,                  // ✅ array
            $request->hr_contact_name,   // ✅ string
            $attachments                 // ✅ array
        ));

        DB::commit();
        return redirect()->back()->with('success', 'Verification email sent successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('DataVerification store error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to send email. Please try again.');
    }
}



// // Modified sendVerificationEmail for safe attachments
// protected function sendVerificationEmail($candidate, $hrEmail, $hrName, $attachments = [])
// {
//     $validAttachments = [];
//     foreach ($attachments as $file) {
//         if ($file && file_exists(storage_path('app/public/' . $file))) {
//             $validAttachments[] = storage_path('app/public/' . $file);
//         }
//     }

//     Mail::to($hrEmail)->send(new CandidateVerificationMail($candidate, $hrName, $validAttachments));
// }




        /**
         * Show the specified resource.
         */

        public function show($id)
        {
            $dataVerification = DataVerification::findOrFail($id);
            $experienced = ExperiencedEmployee::findOrFail($id);
            return view('hrms::dataVerification.verification', compact('dataVerification', 'experienced'));
        }
        
    
    }