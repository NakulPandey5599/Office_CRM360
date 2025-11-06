<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\HRMS\Models\McqAnswer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HRMS\Models\TrainingMcq;
use Modules\HRMS\Models\TrainingModule;

class TrainingAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Fetch only the most recent module
    $latestModule = TrainingModule::latest()->first();
    

    return view('hrms::trainingAssessment.index', compact('latestModule'));
}

 public function create()
{
    // Fetch only the most recent module
    $latestModule = TrainingModule::latest()->first();

    return view('hrms::trainingAssessment.create', compact('latestModule'));
}

 
    // public function mcq()
    // {
    //     $mcqs = TrainingMcq::all();
    //     return view('hrms::trainingAssessment.mcq', compact('mcqs'));
    // }
    
   public function mcq()
{
    $latest = TrainingMcq::latest()->first();

    if (!$latest) {
        return view('hrms::trainingAssessment.mcq', [
            'questions' => [],
            'assessment' => null
        ]);
    }

    // Decode questions JSON
    $questions = collect($latest->questions)->map(function ($q, $index) {
        return [
            'id' => $index + 1,
            'text' => $q['question'] ?? '',
            'options' => [
                'A' => $q['option_a'] ?? '',
                'B' => $q['option_b'] ?? '',
                'C' => $q['option_c'] ?? '',
                'D' => $q['option_d'] ?? '',
            ],
            'correct' => $q['correct_option'] ?? '',
        ];
    });

    return view('hrms::trainingAssessment.mcq', [
        'assessment' => $latest,
        'questions' => $questions,
    ]);
}



public function storeAnswers(Request $request)
{
    $data = $request->validate([
        'assessment_id' => 'required|integer',
        'score' => 'required|integer',
        'total' => 'required|integer',
        'answers' => 'required|array',
    ]);

    McqAnswer::create([
        'user_id' => Auth::id() ?? null,
        'assessment_id' => $data['assessment_id'],
        'score' => $data['score'],
        'total' => $data['total'],
        'answers' => $data['answers'],
    ]);

    return response()->json(['success' => true, 'message' => 'Result stored successfully!']);
}


public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_file' => 'required|mimes:mp4,webm|max:20480', // 20MB limit
            'duration' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        // Save uploaded file to public storage
        $videoPath = $request->file('video_file')->store('training_videos', 'public');

        // Store in DB
        $module = TrainingModule::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_path' => '/storage/' . $videoPath,
            'duration' => $request->duration ?? 'N/A',
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'module' => $module
        ]);
    } catch (\Throwable $th) {
        Log::error('Training Module Upload Error: '.$th->getMessage());
        return response()->json([
            'success' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}



public function addMcq(Request $request)
{
    $request->validate([
        'assessment_name' => 'nullable|string|max:255',
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string',
        'questions.*.option_a' => 'required|string',
        'questions.*.option_b' => 'required|string',
        'questions.*.option_c' => 'required|string',
        'questions.*.option_d' => 'required|string',
        'questions.*.correct_option' => 'required|in:A,B,C,D',
    ]);

    $assessmentName = $request->assessment_name ?: 'Assessment - ' . now()->format('Y-m-d H:i:s');

    // ✅ Save all questions as one JSON
    TrainingMcq::create([
        'assessment_name' => $assessmentName,
        'questions' => $request->questions,
    ]);

    return response()->json([
        'success' => true,
        'message' => "Assessment '$assessmentName' saved successfully!"
    ]);
}

}
