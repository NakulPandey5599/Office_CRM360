<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TrainingAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hrms::trainingAssessment.index');
    }

 
    public function mcq()
    {
        return view('hrms::trainingAssessment.mcq');
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
}
