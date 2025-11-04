<?php


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Modules\HRMS\app\Models\Candidates;
use Modules\HRMS\Http\Controllers\ReportController;
use Modules\HRMS\Http\Controllers\PayrollController;
use Modules\HRMS\Http\Controllers\DashboardController;
use Modules\HRMS\Http\Controllers\InterviewController;
use Modules\HRMS\Http\Controllers\AttendanceController;
use Modules\HRMS\Http\Controllers\OfferLetterController;
use Modules\HRMS\Http\Controllers\RecruitmentController;
use Modules\HRMS\Http\Controllers\NewCandidateController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Modules\HRMS\Http\Controllers\JoiningLetterController;
use Modules\HRMS\Http\Controllers\CandidatesListController;
use Modules\HRMS\Http\Controllers\FinalSelectionController;
use Modules\HRMS\Http\Controllers\DataVerificationController;
use Modules\HRMS\Http\Controllers\PreJoiningProcessController;
use Modules\HRMS\Http\Controllers\TrainingAssessmentController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Recruitment Routes
    Route::get('hrms/recruitment', [RecruitmentController::class, 'index'])->name('recruitment.index'); 
    //Candidate Registration Routes
    Route::get('hrms/new-candidate', [NewCandidateController::class, 'create'])->name('candidate.create');
    Route::post('hrms/new-candidate-store', [NewCandidateController::class, 'store'])->name('candidate.store');

    //candidate List Routes
    Route::get('hrms/candidate-list', [CandidatesListController::class, 'index'])->name('candidate.index');
    Route::delete('hrms/candidate/{id}', [CandidatesListController::class, 'destroy'])->name('candidate.destroy');
    Route::put('hrms/candidate/update/{id}', [CandidatesListController::class, 'update'])->name('candidate.update');

    //Interview Routes
    Route::get('hrms/interview', [InterviewController::class, 'index'])->name('interviews.index');
    //Final Selection Routes
    Route::get('hrms/final-selections', [FinalSelectionController::class, 'index'])->name('final-selections.index');
});

//pre-processing Routes

  Route::get('hrms/pre-joining-process', [PreJoiningProcessController::class, 'index'])->name('preJoiningProcess.index');
  Route::get('hrms/pre-joining-process/experienced', [PreJoiningProcessController::class, 'experienced'])->name('preJoiningProcess.experienced');
  Route::get('hrms/pre-joining-process/fresher', [PreJoiningProcessController::class, 'fresher'])->name('preJoiningProcess.fresher');
  Route::post('hrms/pre-joining-process/store', [PreJoiningProcessController::class, 'store'])->name('preJoiningProcess.store');

  // Data Verification Routes
  Route::get('hrms/data-verification', [DataVerificationController::class, 'index'])->name('dataVerification.index');
  Route::get('hrms/data-verification/{id}', [DataVerificationController::class, 'show'])->name('dataVerification.show');
  Route::post('hrms/data-verification/store', [DataVerificationController::class, 'store'])->name('dataVerification.store');
  Route::get('/search-experienced-employee', [DataVerificationController::class, 'searchExperiencedEmployee'])->name('experienced_employee.search');
  Route::get('/hrms/verify-response', [DataVerificationController::class, 'verifyResponse']);
  Route::get('/get-candidate-verification/{id}', [DataVerificationController::class, 'getCandidateVerification']);



  // Send Email Route
  Route::post('/hrms/send-email/{id}', [FinalSelectionController::class, 'sendEmail'])->name('candidate.sendEmail');

  //offer letter route
  Route::get('hrms/offer-letter', [OfferLetterController::class, 'index'])->name('offerLetter.index');
  Route::post('hrms/offer-letter/store', [OfferLetterController::class, 'store'])->name('offerLetter.store');
  Route::post('hrms/offer/send-email', [OfferLetterController::class, 'sendOfferEmail'])->name('offer.sendEmail');
  Route::get('/search-candidates', [OfferLetterController::class, 'searchCandidates'])->name('searchCandidates');
  Route::get('/hrms/offerletter/search', [OfferLetterController::class, 'search'])->name('offerLetter.search');
  Route::post('/hrms/offer-letter/download', [OfferLetterController::class, 'downloadPDF'])->name('hrms.offer.download');


  Route::get('/hrms/joining-letter',[JoiningLetterController::class, 'index'])->name('joiningLetter.index');
  Route::post('hrms/joining-letter/store', [JoiningLetterController::class, 'store'])->name('joining-letter.store');
  Route::get('/hrms/joining-letter/search', [JoiningLetterController::class, 'search'])->name('joining-letter.search');
  Route::post('/hrms/joining-letter/send-email', [JoiningLetterController::class, 'sendEmail'])->name('joining-letter.sendEmail');
  Route::post('/hrms/joining-letter/download', [JoiningLetterController::class, 'downloadPDF'])->name('hrms.joining.download');

  Route::get('/hrms/training-assessment', [TrainingAssessmentController::class, 'index'])->name('trainingAssessment.index');
  Route::post('hrms/training/add-module', [TrainingAssessmentController::class, 'store'])->name('training.addModule');

  Route::get('/hrms/training-assessment/mcq', [TrainingAssessmentController::class, 'mcq'])->name('trainingAssessment.mcq');
  Route::post('/training/submit', [TrainingAssessmentController::class, 'storeAnswers'])->name('training.submit');


  Route::get('/hrms/report', [ReportController::class, 'index'])->name('report.index');
  Route::get('/hrms/dashboard',[DashboardController::class, 'index'])->name('dashboard.index');
  
  //Payroll Routes
  Route::get('/hrms/payroll/monthly-payroll', [PayrollController::class, 'monthlyPayroll'])->name('monthlyPayroll.index');
  Route::get('/hrms/payroll/hourly-payroll', [PayrollController::class, 'hourlyPayroll'])->name('hourlyPayroll.index');
  Route::get('/hrms/payroll/finalized-payroll', [PayrollController::class, 'finalizedPayroll'])->name('finalizedPayroll.index');


  Route::get('/hrms/payroll/bulk-attendence', [AttendanceController::class, 'bulkAttendence'])->name('bulkAttendence.index');
Route::get('/bulk-attendance/filter', [AttendanceController::class, 'filter'])->name('bulk.attendance.filter');
Route::post('/bulk-attendance/save', [AttendanceController::class, 'save'])->name('bulk.attendance.save');
Route::post('/attendance/mark', [AttendanceController::class, 'storeAttendance'])->name('attendance.mark.store');
Route::get('/attendance/search', [AttendanceController::class, 'searchEmployee'])->name('attendance.search');


