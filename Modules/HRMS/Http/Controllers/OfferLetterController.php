<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\HRMS\Models\OfferLetter;
use Modules\HRMS\Models\Candidates;
use Modules\HRMS\Mail\OfferLetterMail;


class OfferLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hrms::offerLetter.index');
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


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('hrms::show');
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

public function sendOfferEmail($id)
{
   try {
    $candidate = Candidates::findOrFail($id);
     if ($candidate->final_selection != 'Selected') {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not selected!'
            ]);
        }
    $offer = OfferLetter::where('candidate_id', $id)->first();

    if (!$offer) return response()->json(['success'=>false,'message'=>'Offer not found!']);

    Mail::to($candidate->email)->send(new OfferLetterMail($offer));

    return response()->json(['success'=>true,'message'=>'Email sent to '.$candidate->full_name]);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Exception: '.$e->getMessage()
    ]);
}

}


}
