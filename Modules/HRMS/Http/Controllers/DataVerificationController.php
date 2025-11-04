<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HRMS\Models\Candidates;
use Modules\HRMS\Models\DataVerification;
use Modules\HRMS\Mail\CandidateVerificationMail;

class DataVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ✅ Use prejoining_employees instead of ExperiencedEmployee
        $dataVerification = DataVerification::all();
        $prejoining = DB::table('prejoining_employees')->get();

        return view('hrms::dataVerification.verification', compact('dataVerification', 'prejoining'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrms::create');
    }

    /**
     * Store verification details and send email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'previous_company_name'  => 'required|string|max:255',
            'hr_contact_name'        => 'required|string|max:255',
            'hr_contact_email'       => 'required|email|max:255',
            'hr_contact_phone'       => 'required|string|max:20',
            'receiving_letter'       => 'nullable|file|mimes:pdf,jpg,png',
            'experience_certificate' => 'nullable|file|mimes:pdf,jpg,png',
            'candidate_name'         => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Handle file uploads
            $receivingLetterPath = $request->hasFile('receiving_letter')
                ? $request->file('receiving_letter')->store('data_verification/receiving_letters', 'public')
                : null;

            $experienceCertPath = $request->hasFile('experience_certificate')
                ? $request->file('experience_certificate')->store('data_verification/experience_certificates', 'public')
                : null;

            // ✅ Save record
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

            // ✅ Candidate info
            $candidate = [
                'id'      => $verification->id,
                'name'    => $request->candidate_name,
                'email'   => $request->hr_contact_email,
                'company' => $request->previous_company_name,
            ];

            // ✅ Prepare attachments
            $attachments = [];

            if (is_string($verification->receiving_letter) && !empty($verification->receiving_letter)) {
                $path = storage_path('app/public/' . $verification->receiving_letter);
                if (file_exists($path)) $attachments[] = $path;
            }

            if (is_string($verification->experience_certificate) && !empty($verification->experience_certificate)) {
                $path = storage_path('app/public/' . $verification->experience_certificate);
                if (file_exists($path)) $attachments[] = $path;
            }

            // ✅ Send email
            Mail::to($request->hr_contact_email)->send(
                new CandidateVerificationMail(
                    [
                        'id'      => $verification->id,
                        'name'    => $request->candidate_name,
                        'email'   => $request->hr_contact_email,
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

    /**
     * Update verification status via HR response link
     */
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

    /**
     * Search candidates (previously experienced_employees)
     */
    public function searchExperiencedEmployee(Request $request)
    {
        $query = $request->get('query');

        // ✅ Unified search in prejoining_employees
        $results = DB::table('prejoining_employees')
            ->where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('job_profile', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'first_name', 'last_name', 'job_profile']);

        return response()->json($results);
    }

    /**
     * Get verification details by candidate ID
     */
    public function getCandidateVerification($id)
    {
        $verification = DataVerification::where('id', $id)->latest()->first();

        if (!$verification) {
            return response()->json(['error' => 'No verification data found'], 404);
        }

        return response()->json([
            'status'           => $verification->status,
            'hr_contact_name'  => $verification->hr_contact_name,
            'hr_contact_email' => $verification->hr_contact_email,
        ]);
    }
}
