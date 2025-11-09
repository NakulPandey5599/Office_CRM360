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
    // Fetch the currently active module
    $activeModule = TrainingModule::where('is_active', true)->first();

    // If no active module found, return view with null
    return view('hrms::trainingAssessment.index', [
        'latestModule' => $activeModule
    ]);
}

    public function createModule()
    {
        // Fetch only the most recent module
        $latestModule = TrainingModule::latest()->first();
        $allModules = TrainingModule::orderBy('created_at', 'desc')->get();

        return view('hrms::trainingAssessment.create', compact('latestModule', 'allModules'));
    }

    public function createAssessment()
    {
        $mcqs = TrainingMcq::all(); // one record = one assessment
        $latestModule = TrainingModule::latest()->first();
        $allModules = TrainingModule::all();

        return view('hrms::trainingAssessment.createAssessment', compact('latestModule', 'mcqs', 'allModules'));
    }

public function mcq()
{
    // Fetch the active MCQ module (using status column)
    $active = TrainingMcq::where('status', 'active')->first();

    if (!$active) {
        return view('hrms::trainingAssessment.mcq', [
            'questions' => [],
            'assessment' => null
        ]);
    }

    // Decode questions JSON safely
    $questions = collect($active->questions)->map(function ($q, $index) {
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
        'assessment' => $active,
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
            Log::error('Training Module Upload Error: ' . $th->getMessage());
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
            'status' => 'required|in:active,inactive',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:A,B,C,D',
        ]);

        if ($request->status === 'active') {
            // Deactivate all other active assessments
            TrainingMcq::where('status', 'active')->update(['status' => 'inactive']);
        }

        $assessmentName = $request->assessment_name ?: 'Assessment - ' . now()->format('Y-m-d H:i:s');

        // ✅ Save all questions as one JSON
        TrainingMcq::create([
            'assessment_name' => $assessmentName,
            'questions' => $request->questions,
            'status' => $request->status ?? 'inactive',

        ]);

        return response()->json([
            'success' => true,
            'message' => "Assessment '$assessmentName' saved successfully!"
        ]);
    }

    public function deleteMcq($id)
    {
        TrainingMcq::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }


    public function updateMcq(Request $request, $id)
     {
        $request->validate([
            'assessment_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:A,B,C,D',
        ]);

        if ($request->status === 'active') {
            // Deactivate all other active assessments except the one being updated
            TrainingMcq::where('id', '!=', $id)->update(['status' => 'inactive']);
        }

        $mcq = TrainingMcq::findOrFail($id);

        $mcq->update([
            'assessment_name' => $request->assessment_name,
            'questions' => $request->questions,
            'status' => $request->status ?? 'inactive',

        ]);

        return response()->json(['success' => true, 'message' => 'MCQ updated successfully!']);
    }

    public function getMcq($id)
    {
        $mcq = TrainingMcq::find($id);

        if (!$mcq) {
            return response()->json(['error' => 'MCQ not found'], 404);
        }

        return response()->json($mcq);
    }

    public function getAssessmentMcqs($assessment_name)
    {
        $mcqs = TrainingMcq::where('assessment_name', $assessment_name)->get();

        if ($mcqs->isEmpty()) {
            return response()->json(['error' => 'No MCQs found'], 404);
        }

        return response()->json($mcqs);
    }

    //module listing 
    public function getModule($id)
    {
        return response()->json(TrainingModule::find($id));
    }

    public function updateModule(Request $request, $id)
    {
        $module = TrainingModule::findOrFail($id);
        $module->title = $request->title;
        $module->description = $request->description;
        $module->duration = $request->duration;
        $module->is_active = $request->is_active;
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('training_videos', 'public');
            $module->video_path = '/storage/' . $path;
        }
        $module->save();
        return response()->json(['success' => true]);
    }

    public function deleteModule($id)
    {
        $module = TrainingModule::findOrFail($id);
        $module->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        TrainingMcq::where('status', 'active')->update(['status' => 'inactive']);

        $assessment = TrainingMcq::findOrFail($id);
        $assessment->update(['status' => 'active']);

        return response()->json([
            'success' => true,
            'message' => "{$assessment->assessment_name} activated successfully!"
        ]);
    }

    public function toggleStatusModules(Request $request, $id)
    {
        try {
            $module = TrainingModule::find($id);

            if (!$module) {
                return response()->json(['success' => false, 'message' => 'Module not found']);
            }

            $status = $request->input('status');

            // Ensure only one active at a time
            if ($status === 'active') {
                TrainingModule::query()->update(['is_active' => false]);
                $module->is_active = true;
            } else {
                $module->is_active = false;
            }

            $module->save();

            return response()->json([
                'success' => true,
                'new_status' => $status,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle status failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
