<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\HRMS\Models\Candidates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FinalSelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $status = Candidates::where('status', 'completed')->get();

        return view('hrms::candidatesRegistration.finalSelection', compact('status'));
    }

    public function updateFinalStatus(Request $request, $id)
{
    $candidate = Candidates::find($id);

    if (!$candidate) {
        return response()->json(['message' => 'Candidate not found.'], 404);
    }

    $candidate->final_selection = $request->final_selection;
    $candidate->save();

    return response()->json(['message' => 'Status updated successfully!']);
}




public function sendEmail($id)
{
    $candidate = Candidates::findOrFail($id);

    // ✅ 1. Check if candidate is selected
    if (strtolower($candidate->final_selection) !== 'selected') {
        return response()->json([
            'status' => 'error',
            'message' => 'Candidate not selected!'
        ]);
    }

    // ✅ 2. Prevent duplicate email sending
    if ($candidate->email_sent) {
        return response()->json([
            'status' => 'error',
            'message' => 'Email already sent to this candidate.'
        ]);
    }

    try {
        // ✅ 3. Generate random password and hash it
        $plainPassword = Str::random(8);
        $candidate->password = Hash::make($plainPassword);

        // ✅ 4. Save the hashed password
        $candidate->save();

        // ✅ 5. Send email with login credentials
        Mail::send('hrms::emails.prejoining', [
            'candidate' => $candidate,
            'plainPassword' => $plainPassword
        ], function ($message) use ($candidate) {
            $message->to($candidate->email, $candidate->full_name)
                    ->subject('Pre-Joining Portal Access');
        });

        // ✅ 6. Update status permanently in DB
        $candidate->update([
            'email_sent' => true,
            'email_sent_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Email sent successfully to ' . $candidate->full_name
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to send email: ' . $e->getMessage()
        ]);
    }
}
}

