<?php

namespace Modules\HRMS\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\HRMS\Models\Attendance;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\ExperiencedEmployee;

class AttendanceController extends Controller
{

    public function bulkAttendence()
    {
        $employees = ExperiencedEmployee::all();


        return view('hrms::payroll.bulkAttendance', compact('employees'));
    }


public function filter(Request $request)
{
    $month = $request->input('month') ?: date('m');
    $year  = $request->input('year')  ?: date('Y');
    $day   = $request->input('day')   ?: date('d');

    $employees = ExperiencedEmployee::all();

    $selectedDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
    $weekDays = [$selectedDate];

    $attendance = [];
    $records = Attendance::whereDate('date', $selectedDate)->get();

    foreach ($records as $rec) {
        $attendance[$rec->employee_id][$selectedDate] = $rec->status;
    }

    foreach ($employees as $emp) {
        foreach ($weekDays as $d) {
            $attendance[$emp->id][$d] = $attendance[$emp->id][$d] ?? 'A';
        }
    }

    return view('hrms::payroll.bulkAttendance', compact(
        'employees', 'month', 'year', 'day', 'weekDays', 'attendance'
    ));
}


    //save attendance

    public function save(Request $request)
    {
        //   dd($request->all());
        $attendanceData = $request->attendance;

        if (!$attendanceData) {
            return back()->with('error', 'No attendance data to save.');
        }

        foreach ($attendanceData as $empId => $days) {
            foreach ($days as $date => $status) {
                Attendance::updateOrCreate(
                    ['employee_id' => $empId, 'date' => $date],
                    ['status' => $status]
                );
            }
        }

        return back()->with('success', 'Attendance saved successfully!');
    }

public function searchEmployee(Request $request)
{
    $query = $request->get('query');

    $results = ExperiencedEmployee::query()
        ->where('first_name', 'LIKE', "%{$query}%")
        ->orWhere('last_name', 'LIKE', "%{$query}%")
        ->orWhere('job_profile', 'LIKE', "%{$query}%")
        ->limit(10)
        ->get(['id', 'first_name', 'last_name', 'job_profile']);

    return response()->json($results);
}


    /**
     * 💾 Store Attendance Record
     */


public function storeAttendance(Request $request)
{
    try {
        // Basic validation first
        $validated = $request->validate([
            'employee_id'         => 'required|integer',
            'employee_name'       => 'required|string',
            'employee_department' => 'required|string',
            'date'                => 'required|date',
            'status'              => 'required|string|in:Present,Absent,Leave,Half Day',
            'clock_in'            => 'nullable',
            'clock_out'           => 'nullable',
            'is_late'             => 'nullable|boolean',
            'is_half_day'         => 'nullable|boolean',
            'working_from'        => 'nullable|string',
        ]);

        $overwrite = $request->boolean('overwrite');

        // 🧠 Auto-handle Absent / Leave defaults
        if (in_array($validated['status'], ['Absent', 'Leave'])) {
            $validated['clock_in']     = null;
            $validated['clock_out']    = null;
            $validated['is_late']      = 0;
            $validated['is_half_day']  = 0;
            $validated['working_from'] = 'other';
        } else {
            // Fallback for Present / Half Day
            $validated['clock_in']     = $validated['clock_in'] ?? $request->clock_in;
            $validated['clock_out']    = $validated['clock_out'] ?? $request->clock_out;
            $validated['is_late']      = $validated['is_late'] ?? 0;
            $validated['is_half_day']  = $validated['is_half_day'] ?? 0;
            $validated['working_from'] = $validated['working_from'] ?? $request->working_from;
        }

        // 🗑️ If overwrite is enabled, remove existing entry
        if ($overwrite) {
            Attendance::where('employee_id', $validated['employee_id'])
                ->where('date', $validated['date'])
                ->delete();
        }

        // 💾 Save or update
        Attendance::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'date'        => $validated['date'],
            ],
            [
                'employee_name'  => $validated['employee_name'],
                'department'     => $validated['employee_department'],
                'status'         => $validated['status'],
                'clock_in'       => $validated['clock_in'],
                'clock_out'      => $validated['clock_out'],
                'is_late'        => $validated['is_late'],
                'is_half_day'    => $validated['is_half_day'],
                'working_from'   => $validated['working_from'],
            ]
        );

        return response()->json(['success' => 'Attendance saved successfully!']);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



}