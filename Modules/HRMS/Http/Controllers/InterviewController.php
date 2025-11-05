<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\Candidates;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidates::all();
        return view('hrms::candidatesRegistration.interview', compact('candidates'));
    }

   public function updateStatus(Request $request, $id)
{
    $candidate = Candidates::find($id);

    if (!$candidate) {
        return response()->json(['message' => 'Candidate not found.'], 404);
    }

    $candidate->status = $request->status;
    $candidate->save();

    return response()->json(['message' => 'Status updated successfully!']);
}


}