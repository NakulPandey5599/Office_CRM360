<?php

namespace Modules\HRMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $hrName;
    public $attachments;

    public function __construct($candidate, $hrName, $attachments = [])
    {
        $this->candidate = $candidate;
        $this->hrName = $hrName;
        $this->attachments = $attachments;
    }

    public function build()
    {
        $email = $this->subject('Candidate Data Verification')
                      ->view('hrms::emails.candidate_verification');

        foreach ($this->attachments as $file) {
            $email->attach(storage_path('app/public/' . $file));
        }

        return $email;
    }
}
