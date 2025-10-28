<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HRMS\Models\Candidates;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\OfferLetter;
use Modules\HRMS\Models\FresherEmployee;
use Modules\HRMS\Models\ExperiencedEmployee;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $registeredCandidates = Candidates::count(); // total registered
    $freshers = FresherEmployee::count();
    $experienced = ExperiencedEmployee::count();
    $pendingPreJoining = $freshers + $experienced;
    $offerLettersSent = OfferLetter::count();
    $latestCandidates = Candidates::latest()->take(5)->get();
    $latestOffers = OfferLetter::latest()->take(5)->get(['candidate_name']);
    
    $trainingLabels = ['Q1','Q2','Q3','Q4'];
    $trainingData = [10, 20, 30, 25]; // Replace with real data
    $onboardingData = [5, 15, 10]; 

    // $activeTrainingModules = TrainingModule::where('status', 'active')->count();

    return view('hrms::dashboard.index', compact(
        'registeredCandidates',
        'pendingPreJoining',
        'offerLettersSent',
        'latestCandidates',
        'latestOffers',
        'trainingLabels',
        'trainingData',
        'onboardingData',
        // 'activeTrainingModules'
    ));
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
    public function store(Request $request) {}

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
}
