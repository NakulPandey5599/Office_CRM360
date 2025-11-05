<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HRMS\Models\Candidates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CandidateAuthController extends Controller
{

    public function showLoginForm()
    {
        // ✅ If already logged in, redirect to pre-joining
        // if (Session::has('candidate_id')) {
        //     return redirect()->route('preJoiningProcess.index');
        // }

        return view('hrms::preJoiningProcess.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $candidate = Candidates::where('email', $request->email)->first();

        if ($candidate && Hash::check($request->password, $candidate->password)) {
            // ✅ Save login info to session
            Session::put('candidate_id', $candidate->id);
            Session::put('candidate_name', $candidate->full_name);

            return redirect()->route('preJoiningProcess.index');
        }

        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    public function logout()
    {
        Session::forget(['candidate_id', 'candidate_name']);
        return redirect()->route('candidate.login')->with('success', 'Logged out successfully.');
    }

}