<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\Candidates;

class CandidatesListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidates::paginate(4);
        return view('hrms::candidatesRegistration.candidatesListings', compact('candidates'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $candidate = Candidates::findOrFail($id);
        $candidate->delete();

        return redirect()->route('candidate.index')->with('success', 'Candidate deleted successfully.');
    }

    public function update(Request $request, $id)
{
    $candidate = Candidates::findOrFail($id);
    $candidate->update([
        'status' => $request->status,
        'final_selection' => $request->final_selection,
    ]);

    return response()->json(['success' => true]);
}

}
