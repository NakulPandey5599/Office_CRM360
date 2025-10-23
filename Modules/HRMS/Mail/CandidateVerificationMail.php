<?php

namespace Modules\HRMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $candidate;
    public string $hrName;

    /**
     * Create a new message instance.
     *
     * @param array $candidate
     * @param string $hrName
     * @param array $attachments
     */
    public function __construct(array $candidate, string $hrName, array $attachments = [])
    {
        $this->candidate = $candidate;
        $this->hrName = $hrName;

        // Attach files using the parent Mailable's attach() method
        foreach ($attachments as $file) {
            if (file_exists($file)) {
                $this->attach($file);
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Candidate Verification')
                    ->view('hrms::emails.candidate_verification')
                    ->with([
                        'candidate' => $this->candidate,
                        'hrName' => $this->hrName,
                    ]);
    }
}
