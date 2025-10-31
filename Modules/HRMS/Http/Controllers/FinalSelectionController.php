<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HRMS\Models\Candidates;

class FinalSelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $finalSelection = Candidates::where('final_selection', 'selected')->get();

        return view('hrms::candidatesRegistration.finalSelection', compact('finalSelection'));
    }

public function sendEmail($id)
{
    $candidate = Candidates::findOrFail($id);

    if (strtolower($candidate->final_selection) != 'selected') {
        return response()->json(['status' => 'error', 'message' => 'Candidate not selected!']);
    }

    try {
        Mail::send('hrms::emails.prejoining', ['candidate' => $candidate], function ($message) use ($candidate) {
            $message->to($candidate->email, $candidate->full_name)
                    ->subject('Pre-Joining Form');
        });

        $candidate->update(['email_sent' => true]);

        return response()->json(['status' => 'success', 'message' => 'Email sent successfully to ' . $candidate->full_name]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to send email: ' . $e->getMessage()]);
    }
}
}
