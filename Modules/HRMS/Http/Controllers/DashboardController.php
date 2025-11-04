<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HRMS\Models\McqAnswer;
use Modules\HRMS\Models\Candidates;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\OfferLetter;
use Modules\HRMS\Models\PrejoiningEmployee; // ✅ replaced Fresher + Experienced

class DashboardController extends Controller
{
    public function index()
    {
        // 🧮 Core statistics
        $registeredCandidates = Candidates::count();
        $pendingPreJoining = PrejoiningEmployee::count(); // ✅ merged both
        $offerLettersSent = OfferLetter::count();

        $latestCandidates = Candidates::latest()->take(5)->get();
        $latestOffers = OfferLetter::latest()->take(5)->get(['candidate_name']);

        // 📊 Training progress data
        $questionCounts = [];
        $allAnswers = McqAnswer::all(['answers']); // only 'answers' column

        foreach ($allAnswers as $record) {
            $decoded = $record->answers; // already array via model casts

            if (!is_array($decoded)) {
                continue;
            }

            foreach ($decoded as $questionId => $response) {
                if (!isset($questionCounts[$questionId])) {
                    $questionCounts[$questionId] = 0;
                }
                $questionCounts[$questionId]++;
            }
        }

        // ✅ Always ensure exactly 5 questions (Q1–Q5)
        $trainingLabels = ['Q1', 'Q2', 'Q3', 'Q4', 'Q5'];
        $trainingData = [];

        for ($i = 1; $i <= 5; $i++) {
            $trainingData[] = $questionCounts[$i] ?? 0;
        }

        // 🔧 Static onboarding demo data
        $onboardingData = [5, 15, 10];

        return view('hrms::dashboard.index', compact(
            'registeredCandidates',
            'pendingPreJoining',
            'offerLettersSent',
            'latestCandidates',
            'latestOffers',
            'trainingLabels',
            'trainingData',
            'onboardingData'
        ));
    }
}
