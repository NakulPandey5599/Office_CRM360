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

   
public function store(Request $request)
{
    // ✅ Step 1: Validate request
    $request->validate([
        'previous_company_name' => 'required|string|max:255',
        'hr_contact_name'       => 'required|string|max:255',
        'hr_contact_email'      => 'required|email|max:255',
        'hr_contact_phone'      => 'required|string|max:20',
        'receiving_letter'      => 'nullable|file|mimes:pdf,jpg,png',
        'experience_certificate' => 'nullable|file|mimes:pdf,jpg,png',
        'candidate_name'        => 'required|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Step 2: Handle file uploads
        $receivingLetterPath = $request->hasFile('receiving_letter')
            ? $request->file('receiving_letter')->store('data_verification/receiving_letters', 'public')
            : null;

        $experienceCertPath = $request->hasFile('experience_certificate')
            ? $request->file('experience_certificate')->store('data_verification/experience_certificates', 'public')
            : null;

        // ✅ Step 3: Save record in DB
        $verification = DataVerification::create([
            'previous_company_name'  => $request->previous_company_name,
            'hr_contact_name'        => $request->hr_contact_name,
            'hr_contact_email'       => $request->hr_contact_email,
            'hr_contact_phone'       => $request->hr_contact_phone,
            'candidate_name'         => $request->candidate_name,
            'candidate_department'   => $request->candidate_department,
            'candidate_id'           => $request->candidate_id,
            'receiving_letter'       => $receivingLetterPath,
            'experience_certificate' => $experienceCertPath,
            'status'                 => 'pending',
            
        ]);

        // ✅ Step 4: Prepare candidate info
        $candidate = [
            'id'      => $verification->id,
            'name'    => $request->candidate_name,
            'email'   => $request->hr_contact_email,
            'company' => $request->previous_company_name,
        ];

        // ✅ Step 5: Safely prepare attachments
        $attachments = [];

        if (is_string($verification->receiving_letter) && !empty($verification->receiving_letter)) {
            $path = storage_path('app/public/' . $verification->receiving_letter);
            if (file_exists($path)) $attachments[] = $path;
        }

        if (is_string($verification->experience_certificate) && !empty($verification->experience_certificate)) {
            $path = storage_path('app/public/' . $verification->experience_certificate);
            if (file_exists($path)) $attachments[] = $path;
        }

        // Ensure $attachments is always an array
        if (!is_array($attachments)) {
            $attachments = [$attachments];
        }

        Mail::to($request->hr_contact_email)->send(
    new CandidateVerificationMail(
        [
            'id' => $verification->id,
            'name' => $request->candidate_name,
            'email' => $request->hr_contact_email,
            'company' => $request->previous_company_name,
        ],
        $request->hr_contact_name,
        $attachments
    )
);


        DB::commit();

        return redirect()->back()->with('success', 'Verification email sent successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('DataVerification store error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to send email. Please try again.');
    }
}


public function verifyResponse(Request $request)
{
    $id = $request->query('id');
    $status = $request->query('status');

    $verification = DataVerification::find($id);

    if (!$verification) {
        return response()->json(['message' => 'Record not found!'], 404);
    }

    $verification->status = $status;
    $verification->save();

    return view('hrms::emails.thankyou', ['status' => $status]);
}

public function searchExperiencedEmployee(Request $request)
{
    $query = $request->get('query');

    $results = ExperiencedEmployee::query()
        ->where('first_name', 'LIKE', "%{$query}%")
        ->orWhere('last_name', 'LIKE', "%{$query}%")
        ->orWhere('job_profile', 'LIKE', "%{$query}%")
        ->limit(10)
        ->get(['id', 'first_name', 'last_name', 'job_profile']);

    return response()->json($results);
}

 public function getCandidateVerification($id)
{
    // Find the latest verification record for that candidate
    $verification = DataVerification::where('id', $id)->latest()->first();

    if (!$verification) {
        return response()->json(['error' => 'No verification data found'], 404);
    }

    return response()->json([
        'status' => $verification->status,
        'hr_contact_name' => $verification->hr_contact_name,
        'hr_contact_email' => $verification->hr_contact_email,
    ]);
}

}