<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Modules\HRMS\Models\Candidates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HRMS\Models\OfferLetter;
use Modules\HRMS\Mail\OfferLetterMail;
use Modules\HRMS\Models\FresherEmployee;
use Modules\HRMS\Models\ExperiencedEmployee;


class OfferLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Fetch the latest status from data_verification table
    $status = DB::table('data_verification')->value('status') ?? 'pending';

    // Optionally, you can fetch by candidate if needed:
    // $status = DB::table('data_verification')->where('candidate_id', $candidateId)->value('status') ?? 'pending';

    return view('hrms::offerLetter.index', compact('status'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // 🧩 Validation (good practice)
            $validated = $request->validate([
                'candidate_id' => 'required|string|max:255',
                'candidate_name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'joining_date' => 'required|date',
                'location' => 'required|string|max:255',
                'ctc' => 'required|string|max:255',
            ]);

            // 🧠 Create new offer record
            $offer = OfferLetter::create($validated);

            // 🟢 Return JSON response (for JS fetch)
            return response()->json([
                'success' => true,
                'offer' => $offer,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function sendOfferEmail(Request $request)
    {
        try {
            $email = trim($request->email);

            // Search in fresher employees
            $candidate = DB::table('freshers_employees')->where('email', $email)->first();

            // If not found, search in experienced employees
            if (!$candidate) {
                $candidate = DB::table('experienced_employees')->where('email', $email)->first();
            }

            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found!'
                ]);
            }

            // Check selection status
            // if ($candidate->final_selection != 'Selected') {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Candidate not selected!'
            //     ]);
            // }

            // Get offer letter
            $offer = OfferLetter::where('candidate_id', $candidate->id ?? null)->first();
            if (!$offer) return response()->json(['success' => false, 'message' => 'Offer not found!']);

            Mail::to($candidate->email)->send(new OfferLetterMail($offer));

            return response()->json(['success' => true, 'message' => 'Email sent to ' . $candidate->first_name ?? $candidate->name]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
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



public function downloadPDF(Request $request)
{
    $data = $request->all();

    $pdf = Pdf::loadView('hrms::offerLetter.offer_letter_pdf', [
        'candidate_name' => $data['candidate_name'] ?? 'Unknown',
        'designation'    => $data['designation'] ?? 'N/A',
        'department'     => $data['department'] ?? 'N/A',
        'joining_date'   => $data['joining_date'] ?? 'N/A',
        'location'       => $data['location'] ?? 'N/A',
        'ctc'            => $data['ctc'] ?? 'N/A',
    ]);

    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="' . $data['candidate_name'] . '_Offer_Letter.pdf"');
}






}
