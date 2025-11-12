<?php

namespace Modules\HRMS\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\HRMS\Models\Attendance;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\PreJoiningEmployee;
use Modules\HRMS\Models\ExperiencedEmployee;

class AttendanceController extends Controller
{
    /**
     * 📋 Show Bulk Attendance Page
     */
    public function bulkAttendence()
    {
        $employees = PreJoiningEmployee::all();
        return view('hrms::payroll.bulkAttendance', compact('employees'));
    }

    /**
     * 🔍 Filter Attendance by Date Range / Month / Year
     */
    public function filter(Request $request)
    {
        $from = $request->input('from_date');
        $to   = $request->input('to_date');
        $branch = $request->input('branch');

        $employees = PreJoiningEmployee::query()
            ->when($branch, fn($q) => $q->where('branch', $branch))
            ->get();

        $attendance = [];
        $weekDays = [];

        // ✅ Generate date range if from/to provided
        if ($from && $to) {
            $period = new \DatePeriod(
                new \DateTime($from),
                new \DateInterval('P1D'),
                (new \DateTime($to))->modify('+1 day')
            );

            foreach ($period as $date) {
                $weekDays[] = $date->format('Y-m-d');
            }

            // ✅ Fetch all attendance records within that range
            $records = Attendance::whereBetween('date', [$from, $to])->get();

            foreach ($records as $rec) {
                $dateKey = Carbon::parse($rec->date)->format('Y-m-d');
                $attendance[$rec->employee_id][$dateKey] = $rec->status;
            }


            // ✅ Ensure every employee has all days accounted for (default A)
            foreach ($employees as $emp) {
                foreach ($weekDays as $d) {
                    $attendance[$emp->id][$d] = $attendance[$emp->id][$d] ?? '-';
                }
            }
        }

        return view('hrms::payroll.bulkAttendance', compact(
            'employees',
            'weekDays',
            'attendance'
        ));
    }


    /**
     * 💾 Save Bulk Attendance Records
     */
    public function save(Request $request)
    {
        $attendanceData = $request->input('attendance');

        if (!$attendanceData) {
            return back()->with('error', 'No attendance data to save.');
        }

        foreach ($attendanceData as $empId => $days) {
            $employee = PreJoiningEmployee::find($empId);
            $employeeName = $employee ? $employee->first_name . ' ' . $employee->last_name : null;

            foreach ($days as $date => $status) {
                Attendance::updateOrCreate(
                    ['employee_id' => $empId, 'date' => $date],
                    [
                        'status'         => $status,
                        'employee_name'  => $employeeName, // ✅ fixed missing field
                        'updated_at'     => now(),
                        'created_at'     => now(),
                    ]
                );
            }
        }

        return back()->with('success', 'Attendance saved successfully!');
    }

    /**
     * 🔎 Search Employee by Name or Department (AJAX)
     */
    public function searchEmployee(Request $request)
    {
        $query = $request->get('query');

        $results = PreJoiningEmployee::query()
            ->where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('job_profile', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'first_name', 'last_name', 'job_profile']);

        return response()->json($results);
    }

    /**
     * 🧾 Store or Update Individual Attendance Record
     */
    public function storeAttendance(Request $request)
    {
        try {
            // ✅ Validation
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
                'overwrite'           => 'nullable|boolean',
            ]);

            $overwrite = $validated['overwrite'] ?? false;

            // 🧠 Auto-handle Absent / Leave defaults
            if (in_array($validated['status'], ['Absent', 'Leave'])) {
                $validated['clock_in']     = null;
                $validated['clock_out']    = null;
                $validated['is_late']      = 0;
                $validated['is_half_day']  = 0;
                $validated['working_from'] = 'Other';
            } else {
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

            // 💾 Save or update record
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
                    'updated_at'     => now(),
                    'created_at'     => now(),
                ]
            );

            return response()->json(['success' => 'Attendance saved successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
public function liveSave(Request $request)
{
    try {
        // ✅ 1. Validation (expanded & consistent)
        $validated = $request->validate([
            'employee_id' => 'required|integer|exists:prejoining_employees,id',
            'date'        => 'required|date',
            'status'      => 'required|string|in:A,P,L',
            'clock_in'     => 'nullable|string',
            'clock_out'    => 'nullable|string',
            'is_late'      => 'nullable|in:0,1',
            'is_half_day'  => 'nullable|in:0,1',
            'working_from' => 'nullable|string|max:100',
            'leave_type'   => 'nullable|string|max:100',
            'reason'       => 'nullable|string|max:255',
            'overwrite'    => 'nullable|boolean',
        ]);

        // ✅ 2. Fetch employee
        $employee = PreJoiningEmployee::find($validated['employee_id']);
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found!',
            ], 404);
        }

        $employeeName = trim(($employee->first_name ?? '') . ' ' . ($employee->last_name ?? ''));

        // ✅ 3. Define default fields
        $defaults = [
            'clock_in'     => $request->input('clock_in'),
            'clock_out'    => $request->input('clock_out'),
            'is_late'      => (int) $request->input('is_late', 0),
            'is_half_day'  => (int) $request->input('is_half_day', 0),
            'working_from' => $request->input('working_from', 'Office'),
            'leave_type'   => null,
            'reason'       => null,
        ];

        // ✅ 4. Adjust logic based on status
        switch ($validated['status']) {
            case 'A': // Absent
                $defaults['clock_in'] = null;
                $defaults['clock_out'] = null;
                $defaults['is_late'] = 0;
                $defaults['is_half_day'] = 0;
                $defaults['working_from'] = 'Other';
                break;

            case 'L': // Leave
                $defaults['working_from'] = 'Other';
                $defaults['leave_type'] = $request->input('leave_type', 'Unpaid Leave');
                $defaults['reason'] = $request->input('reason', 'N/A');
                $defaults['clock_in'] = null;
                $defaults['clock_out'] = null;
                $defaults['is_late'] = 0;
                $defaults['is_half_day'] = 0;
                break;

            case 'P': // Present
                // No reset — keep manual entry (clock_in/out)
                if (empty($defaults['clock_in']) || empty($defaults['clock_out'])) {
                    $defaults['clock_in'] = $defaults['clock_in'] ?? now()->format('H:i');
                    $defaults['clock_out'] = $defaults['clock_out'] ?? now()->addHours(9)->format('H:i');
                }
                break;
        }

        // ✅ 5. Overwrite option
        if ($request->boolean('overwrite')) {
            Attendance::where('employee_id', $validated['employee_id'])
                ->where('date', $validated['date'])
                ->delete();
        }

        // ✅ 6. Save or update record
        Attendance::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'date'        => $validated['date'],
            ],
            array_merge([
                'employee_name' => $employeeName,
                'department'    => $employee->job_profile ?? 'N/A',
                'status'        => $validated['status'],
            ], $defaults)
        );

        // ✅ 7. Custom message per status
        $msg = match ($validated['status']) {
            'P' => 'Present attendance saved successfully!',
            'A' => 'Absent marked successfully!',
            'L' => 'Leave saved successfully!',
            default => 'Attendance updated!',
        };

        return response()->json(['success' => true, 'message' => $msg]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('LiveSave Error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

}