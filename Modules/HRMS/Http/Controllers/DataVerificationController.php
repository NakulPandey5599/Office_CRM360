<?php

    namespace Modules\HRMS\Http\Controllers;



    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Mail;
    use Modules\HRMS\Models\Candidates;
    use Modules\HRMS\Models\DataVerification;
    use Modules\HRMS\Models\ExperiencedEmployee;
    use Modules\HRMS\Mail\CandidateVerificationMail;


    class DataVerificationController extends Controller
    {
        /**

        * Display a listing of the resource.
        */
        public function index()
        {
            // fall back to an empty collection if the model class does not exist
        $dataVerification = DataVerification::all();
            $experienced = ExperiencedEmployee::all();
            return view('hrms::dataVerification.verification', compact('dataVerification', 'experienced'));
        }
        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('hrms::create');
        }

        /**
         * Store a newly created resource in storage.
         */
    
    public function store(Request $request)
    {
        // try {
            // Validate incoming request
            $request->validate([
                'previous_company_name' => 'required|string|max:255',
                'hr_contact_name' => 'required|string|max:255',
                'hr_contact_email' => 'required|email|max:255',
                'hr_contact_phone' => 'required|string|max:20',
                'receiving_letter' => 'nullable|file|mimes:pdf,jpg,png',
                'experience_certificate' => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            DB::beginTransaction(); // Start DB transaction

            // Handle file uploads
            $receivingLetterPath = null;
            if ($request->hasFile('receiving_letter')) {
                $receivingLetterPath = $request->file('receiving_letter')
                    ->store('data_verification/receiving_letters', 'public');
            }

            $experienceCertPath = null;
            if ($request->hasFile('experience_certificate')) {
                $experienceCertPath = $request->file('experience_certificate')
                    ->store('data_verification/experience_certificates', 'public');
            }

            // Save data to database
            DataVerification::create([
                'previous_company_name' => $request->previous_company_name,
                'hr_contact_name' => $request->hr_contact_name,
                'hr_contact_email' => $request->hr_contact_email,
                'hr_contact_phone' => $request->hr_contact_phone,
                'receiving_letter' => $receivingLetterPath,
                'experience_certificate' => $experienceCertPath,
            ]);

            $candidate = [
            'hr_contact_name' => $request->hr_contact_name,
            ];

             //  Trigger email
        //  // Make sure candidate_id is passed
        $attachments = array_filter([$receivingLetterPath, $experienceCertPath]);
        $this->sendVerificationEmail($candidate, $request->hr_contact_email, $request->hr_contact_name, $attachments);

            DB::commit(); // Commit transaction

            return redirect()->back()->with('success', 'Data verification details saved successfully!');

        // } catch (\Exception $e) {
        //     DB::rollBack(); // Rollback DB changes if any error occurs

        //     // Log the error
        //     Log::error('DataVerification store error: ' . $e->getMessage());

        //     return redirect()->back()->with('error', 'Something went wrong while saving data. Please try again.');
        // }
    }


        /**
         * Show the specified resource.
         */

        public function show($id)
        {
            $dataVerification = DataVerification::findOrFail($id);
            $experienced = ExperiencedEmployee::findOrFail($id);
            return view('hrms::dataVerification.verification', compact('dataVerification', 'experienced'));
        }
        /**
         * Show the form for editing the specified resource.
         */
        public function edit($id)
        {
            return view('hrms::edit');
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, $id) {}

        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id) {}

    protected function sendVerificationEmail($candidate, $hrEmail, $hrName, $attachments = [])
     {
        Mail::to($hrEmail)->send(new CandidateVerificationMail($candidate, $hrName, $attachments));
     }

    }
