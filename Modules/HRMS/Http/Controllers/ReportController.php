<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HRMS\Models\Candidates;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\DataVerification;
use Modules\HRMS\Models\ExperiencedEmployee;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        // Total Registered → Candidates table
        $totalRegistered = Candidates::count();

        // Verification counts → ExperiencedEmployee table
        $verified = DataVerification::where('status', 'verified')->count();
        $pending = DataVerification::where('status', 'pending')->count();

        // Monthly registrations (from Candidates)
        $monthlyRegistrations = Candidates::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Format data for chart
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $chartData = array_map(fn($m) => $monthlyRegistrations[$m] ?? 0, range(1, 12));

        return view('hrms::reports.index', compact(
            'totalRegistered',
            'verified',
            'pending',
            'months',
            'chartData'
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
