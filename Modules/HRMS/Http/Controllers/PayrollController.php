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

    public function salarySlipIndex()
    {
        return view('hrms::payroll.salarySlipIndex');
    }

    public function searchEmployeeSalarySlip(Request $request)
    {
        $query = trim($request->get('query'));

        if (empty($query)) {
            return response()->json([]);
        }

        $employees = OfferLetter::where('candidate_name', 'LIKE', "%{$query}%")
            ->orWhere('candidate_id', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get([
                'id',
                'candidate_name',
                'candidate_id',
                'designation',
                'joining_date',
                'ctc',
            ]);

        return response()->json($employees);
    }

    public function salarySlipStore(Request $request)
    {

        $validated = $request->validate([
            'employee_id' => 'required|numeric',
            'employee_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'ctc' => 'nullable|numeric',

            'payment_month' => 'required|string|max:15',
            'payment_date' => 'nullable|date',
            'days_present' => 'nullable|integer',
            'days_paid' => 'nullable|integer',
            'lop' => 'nullable|integer',

            'basic_salary' => 'nullable|numeric',
            'hra' => 'nullable|numeric',
            'travel_allowance' => 'nullable|numeric',
            'special_allowance' => 'nullable|numeric',
            'performance_bonus' => 'nullable|numeric',
            'total_earnings' => 'nullable|numeric',

            'pf' => 'nullable|numeric',
            'gratuity' => 'nullable|numeric',
            'epf' => 'nullable|numeric',
            'tds' => 'nullable|numeric',
            'professional_tax' => 'nullable|numeric',
            'total_deductions' => 'nullable|numeric',
            'net_salary' => 'nullable|numeric',

            'bank_name' => 'nullable|string|max:255',
            'account_no' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:50',
        ]);

        $salarySlip = SalarySlip::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Salary slip saved successfully!',
            'data' => $salarySlip
        ]);
    }


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
    
    public function hourlyPayroll()
    {
        return view('hrms::payroll.hourly');
    }

    public function finalizedPayroll()
    {
        return view('hrms::payroll.finalized');
    }
}
