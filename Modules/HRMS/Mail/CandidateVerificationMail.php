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
    public $fileAttachments;

    /**
     * Create a new message instance.
     */
    public function __construct(array $candidate, string $hrName, array $fileAttachments = [])
    {
        $this->candidate = $candidate;
        $this->hrName = $hrName;
        $this->fileAttachments = $fileAttachments;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->subject('Candidate Verification Request')
            ->view('hrms::emails.candidate_verification')
            ->with([
                'candidate' => $this->candidate,
                'hrName' => $this->hrName,
            ]);

        // ✅ Attach all files safely
        foreach ($this->fileAttachments as $file) {
            if (file_exists($file)) {
                $email->attach($file);
            }
        }

        return $email;
    }
}
