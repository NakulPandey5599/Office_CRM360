<?php

namespace Modules\HRMS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HRMS\Models\Attendance;
use Modules\HRMS\Models\SalarySlip;
use App\Http\Controllers\Controller;
use Modules\HRMS\Models\OfferLetter;
use Modules\HRMS\Models\PreJoiningEmployee;

class PayrollController extends Controller
{
// salary slip methods
//  public function salarySlipIndex(Request $request)
//  {
//     return view('hrms::payroll.salarySlipIndex');
//  }

public function salaryslipshow(Request $request, $emp_id)
{    
    $from = $request->get('from');
    $to   = $request->get('to');

    // Fetch latest attendance record
    $payroll = Attendance::where('employee_id', $emp_id)
        ->orderBy('id', 'DESC')
        ->first();

    if (!$payroll) {
        return abort(404, "No attendance records found!");
    }

    // Count Present Days
    $presentDays = Attendance::where('employee_id', $emp_id)
        ->where('status', 'P')
        ->count();

    // Half Days
    $halfDays = Attendance::where('employee_id', $emp_id)
        ->where('status', 'P')
        ->where('is_half_day', true)
        ->count();

    // Paid Leaves
    $paidLeaves = Attendance::where('employee_id', $emp_id)
        ->where('leave_type', 'paid leave')
        ->count();

    // Off Days
    $offDays = Attendance::where('employee_id', $emp_id)
        ->where('status', 'O')
        ->count();

    // Unpaid leaves
    $unpaidLeaves = Attendance::where('employee_id', $emp_id)
        ->where('leave_type', 'unpaid leave')
        ->count();

    // Absent Days
    $absentDays = Attendance::where('employee_id', $emp_id)
        ->where('status', 'A')
        ->count();

    // LOP
    $lop = $absentDays + $unpaidLeaves;

    // Paid Days
    $paidDays = $presentDays + $paidLeaves + $offDays;

    $paymentMonth = date("F Y", strtotime($from));

    // Payment Date
    $paymentDate = date("d-m-Y", strtotime($to));

    return view('hrms::payroll.salarySlipIndex', compact(
        'payroll',
        'presentDays',
        'halfDays',
        'paidLeaves',
        'offDays',
        'paidDays',
        'absentDays',
        'unpaidLeaves',
        'lop',
        'paymentMonth',
        'paymentDate'
    ));
}


    /**
     * Save Salary Slip
     */
public function salaryslipstore(Request $request)
{
    try {

        $validated = $request->validate([
            'employee_name'     => 'required|string|max:255',
            'designation'       => 'nullable|string|max:255',

            // Changed from date → string
            'joining_date'      => 'nullable|string',

            'employee_id'       => 'required|string|max:50',

            'ctc'               => 'nullable|numeric',

            'payment_month'     => 'nullable|string',

            // Changed from date → string
            'payment_date'      => 'nullable|string',

            'days_present'      => 'nullable|numeric',
            'days_paid'         => 'nullable|numeric',
            'lop'               => 'nullable|numeric',

            'basic_salary'      => 'nullable|numeric',
            'hra'               => 'nullable|numeric',
            'travel_allowance'  => 'nullable|numeric',
            'special_allowance' => 'nullable|numeric',
            'performance_bonus' => 'nullable|numeric',

            'pf'                => 'nullable|numeric',
            'gratuity'          => 'nullable|numeric',
            'epf'               => 'nullable|numeric',
            'tds'               => 'nullable|numeric',
            'professional_tax'  => 'nullable|numeric',

            'total_earnings'    => 'nullable|numeric',
            'total_deductions'  => 'nullable|numeric',
            'net_salary'        => 'nullable|numeric',
        ]);

        $salary = SalarySlip::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Salary slip saved successfully',
            'data'   => $salary
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => 'validation_error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


   // monthly payroll methods

    public function monthlyPayroll()
    {
        return view('hrms::payroll.monthly');
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $from = $request->from_date;
        $to = $request->to_date;

        // Fetch all employees who have attendance in the range
        $employees = PreJoiningEmployee::select('id', 'first_name', 'last_name', 'job_profile', 'designation')->get();

        $results = [];

        foreach ($employees as $emp) {
            $attendance = Attendance::where('employee_id', $emp->id)
                ->whereBetween('date', [$from, $to])
                ->get();

            if ($attendance->isEmpty()) {
                continue; // skip if no records
            }

            // Calculate attendance details
            $fullDays = $attendance->where('status', 'P')->where('is_half_day', false)->count();
            $halfDays = $attendance->where('status', 'P')->where('is_half_day', true)->count();
            $offDays = $attendance->where('status', 'O')->count();
            $paidLeaves = $attendance->where('leave_type', 'paid leave')->count();
            $unpaidLeaves = $attendance->where('leave_type', 'unpaid leave')->count();

            // Paid days = full + half + paid leaves + off
            $paidDays = $fullDays + $halfDays + $paidLeaves + $offDays;
            $unpaidDays = $unpaidLeaves;

            // Example: assume daily wage 800 (optional, you can add salary info later)
            $dailyWage = 0;
            $earnedWages = ($fullDays * $dailyWage) + ($halfDays * $dailyWage * 0.5) + ($paidLeaves * $dailyWage);
            $grossWages = ($paidDays + $unpaidDays) * $dailyWage;
            $otherEarnings = 0;

            $results[] = [
                'emp_id' => $emp->id,
                'name' => $emp->first_name . ' ' . $emp->last_name,
                'department' => $attendance->first()->department ?? 'N/A',
                'designation' => $emp->designation ?? $emp->job_profile ?? 'N/A',
                'full_day' => $fullDays,
                'half_day' => $halfDays,
                'off_days' => $offDays,
                'paid_leaves' => $paidLeaves,
                'paid_days' => $paidDays,
                'unpaid_days' => $unpaidDays,
                'daily_wage' => number_format($dailyWage, 2),
                'gross_wages' => number_format($grossWages, 2),
                'earned_wages' => number_format($earnedWages, 2),
                'other_earnings' => number_format($otherEarnings, 2),
            ];
        }

        return response()->json($results);
    }

// hourly payroll methods
public function hourlyPayroll()
{
    return view('hrms::payroll.hourly');
}
public function fetchHourly(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date'
    ]);

    $hourlyWage = 500;        // fixed
    $standardPerDay = 9;      // 9 hours per day

    // Count total days in date range
    $days = (strtotime($request->to_date) - strtotime($request->from_date)) / 86400 + 1;

    // Total standard hours for selected date range
    $standardHoursTotal = $standardPerDay * $days;


    // HELPER — Convert decimal hours →  "Xh Ym"
    $convertHoursToHM = function ($hrs) {
        $h = floor($hrs);
        $m = round(($hrs - $h) * 60);
        return "{$h}h {$m}m";
    };


    $employees = PreJoiningEmployee::select('id','first_name','last_name','designation')->get();
    $results = [];

    foreach ($employees as $emp) {

        // Fetch attendance
        $attendance = Attendance::where('employee_id', $emp->id)
                                ->whereBetween('date', [$request->from_date, $request->to_date])
                                ->get();

        $totalWorkedRaw = 0;

        foreach ($attendance as $row) {
            if ($row->clock_in && $row->clock_out) {

                $in  = strtotime($row->clock_in);
                $out = strtotime($row->clock_out);

                $totalWorkedRaw += ($out - $in) / 3600;
            }
        }


        // ---- RAW DECIMAL HOURS FOR SALARY ----
        $rawTotal   = round($totalWorkedRaw, 2);
        $rawOver    = max(0, $rawTotal - $standardHoursTotal);

        // ---- DISPLAY FORMAT (Hh Mm) ----
        $totalWorkedDisplay = $convertHoursToHM($rawTotal);
        $overtimeDisplay    = $convertHoursToHM($rawOver);
        $standardHoursDisp  = $convertHoursToHM($standardHoursTotal);


        // ✔ Salary calculations use raw decimals
        $grossWages  = number_format($hourlyWage * $rawTotal, 2, '.', '');
        $overtimePay = number_format($hourlyWage * $rawOver, 2, '.', '');


        // ---- FINAL RESULT ----
        $results[] = [
            'emp_id'           => $emp->id,
            'name'             => $emp->first_name . ' ' . $emp->last_name,
            'department'       => $attendance->first()->department ?? 'N/A',
            'designation'      => $emp->designation ?? 'N/A',

            'hourly_wage'      => $hourlyWage,

            // DISPLAY VALUES — Hh Mm
            'standard_hours'   => $standardHoursDisp,
            'total_hours'      => $totalWorkedDisplay,
            'overtime_hours'   => $overtimeDisplay,

            // Decimal values (salary)
            'gross_wages'      => $grossWages,
            'overtime_pay'     => $overtimePay,

            'adjustment'       => 0,
            'penalties'        => 0,
            'loan_adv'         => 0,
        ];
    }

    return response()->json($results);
}
     

public function saveHourlyRow(Request $request)
{
    return response()->json([
        'status' => 'success',
        'employee' => "Employee ID $request->emp_id"
    ]);
}



}