<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HRMS\Models\JoiningLetter;
use Modules\HRMS\Mail\JoiningLetterMail;
use Modules\HRMS\Models\DataVerification;

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

    /**
     * Search candidate (for joining letter)
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // 🔹 Unified search in prejoining_employees
        $results = DB::table('prejoining_employees')
            ->where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('job_profile', 'like', "%{$query}%")
            ->select('id', 'first_name', 'last_name', 'job_profile', 'email')
            ->limit(10)
            ->get();

        // 🔹 Attach verification status
        foreach ($results as $emp) {
            $emp->status = DataVerification::where('candidate_id', $emp->id)->value('status') ?? '⏳ Pending';
        }

        return response()->json($results);
    }

    /**
     * Send Joining Letter Email
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'candidate_email' => 'required|email',
            'candidate_name'  => 'required|string',
            'designation'     => 'required|string',
            'department'      => 'required|string',
            'joining_date'    => 'required|date',
            'location'        => 'required|string',
        ]);

        $details = $request->all();

        try {
            Mail::to($details['candidate_email'])->send(new JoiningLetterMail($details));
            return response()->json(['message' => 'Joining Letter sent successfully to ' . $details['candidate_email']]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error sending email: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Download Joining Letter as PDF
     */
    public function downloadPDF(Request $request)
    {
        try {
            $data = $request->all();

            // Log data for debugging
            Log::info('PDF Data:', $data);

            $pdf = Pdf::loadView('hrms::joiningLetter.joining_letter_pdf', [
                'name'         => $data['candidate_name'] ?? 'Unknown',
                'designation'  => $data['designation'] ?? 'N/A',
                'department'   => $data['department'] ?? 'N/A',
                'joining_date' => $data['joining_date'] ?? 'N/A',
                'location'     => $data['location'] ?? 'N/A',
            ]);

            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . ($data['candidate_name'] ?? 'Employee') . '_Joining_Letter.pdf"');

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'PDF generation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

