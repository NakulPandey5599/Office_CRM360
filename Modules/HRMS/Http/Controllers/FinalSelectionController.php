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

        // Only send email if selected
        if($candidate->final_selection != 'Selected') {
            return back()->with('error', 'Candidate not selected!');
        }

        // Send email using Laravel Mail
        Mail::send('emails.prejoining', ['candidate' => $candidate], function($message) use ($candidate) {
            $message->to($candidate->email, $candidate->full_name)
                    ->subject('Pre-Joining Form');
        });

        return back()->with('success', 'Email sent successfully to '.$candidate->full_name);
    }
}
