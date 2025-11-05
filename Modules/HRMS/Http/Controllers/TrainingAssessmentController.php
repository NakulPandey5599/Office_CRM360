<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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

 
    public function mcq()
    {
        $mcqs = TrainingMcq::all();
        return view('hrms::trainingAssessment.mcq', compact('mcqs'));
    }

public function storeAnswers(Request $request)
    {
        // Get all answers from frontend
        $data = $request->all();

        // Save into database (as JSON)
        DB::table('mcq_answers')->insert([
            'user_id' => auth()->id() ?? null,
            'answers' => json_encode($data),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => '✅ Answers saved successfully!']);
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


public function storeMcq(Request $request)
{
    $request->validate([
        'module_id' => 'required|exists:training_modules,id',
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string',
        'questions.*.option_a' => 'required|string',
        'questions.*.option_b' => 'required|string',
        'questions.*.option_c' => 'required|string',
        'questions.*.option_d' => 'required|string',
        'questions.*.correct_option' => 'required|in:A,B,C,D',
    ]);

    foreach ($request->questions as $q) {
        TrainingMcq::create([
            'module_id' => $request->module_id,
            'question' => $q['question'],
            'option_a' => $q['option_a'],
            'option_b' => $q['option_b'],
            'option_c' => $q['option_c'],
            'option_d' => $q['option_d'],
            'correct_option' => $q['correct_option'],
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'All MCQs saved successfully!'
    ]);
}

}
