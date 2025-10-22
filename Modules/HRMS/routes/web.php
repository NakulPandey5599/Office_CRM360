<?php


use Illuminate\Support\Facades\Route;
use Modules\HRMS\app\Models\Candidates;
use Modules\HRMS\Http\Controllers\InterviewController;
use Modules\HRMS\Http\Controllers\RecruitmentController;
use Modules\HRMS\Http\Controllers\NewCandidateController;
use Modules\HRMS\Http\Controllers\CandidatesListController;
use Modules\HRMS\Http\Controllers\FinalSelectionController;
use Modules\HRMS\Http\Controllers\DataVerificationController;
use Modules\HRMS\Http\Controllers\PreJoiningProcessController;
use Illuminate\Support\Facades\Mail;
use Modules\HRMS\Http\Controllers\OfferLetterController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Recruitment Routes
    Route::get('hrms/recruitment', [RecruitmentController::class, 'index'])->name('recruitment.index'); 
    //Candidate Registration Routes
    Route::get('hrms/new-candidate', [NewCandidateController::class, 'create'])->name('candidate.create');
    Route::post('hrms/new-candidate-store', [NewCandidateController::class, 'store'])->name('candidate.store');

    //candidate List Routes
    Route::get('hrms/candidate-list', [CandidatesListController::class, 'index'])->name('candidate.index');
    Route::delete('hrms/candidate/{id}', [CandidatesListController::class, 'destroy'])->name('candidate.destroy');
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
  Route::get('/search-experienced-employee', [PreJoiningProcessController::class, 'searchExperiencedEmployee'])->name('experienced_employee.search');

  // Data Verification Routes
  Route::get('hrms/data-verification', [DataVerificationController::class, 'index'])->name('dataVerification.index');
  Route::get('hrms/data-verification/{id}', [DataVerificationController::class, 'show'])->name('dataVerification.show');
  Route::post('hrms/data-verification/store', [DataVerificationController::class, 'store'])->name('dataVerification.store');
  Route::get('/search-candidates', [NewCandidateController::class, 'search'])->name('candidates.search');


  // Send Email Route
  Route::post('/candidate/send-email/{id}', [FinalSelectionController::class, 'sendEmail'])->name('candidate.sendEmail');

  //offer letter route
  Route::get('hrms/offer-letter', [OfferLetterController::class, 'index'])->name('offerLetter.index');
  Route::post('hrms/offer-letter/store', [OfferLetterController::class, 'store'])->name('offerLetter.store');
  Route::post('hrms/offer/send-email/{id}', [OfferLetterController::class, 'sendOfferEmail'])->name('offer.sendEmail');

