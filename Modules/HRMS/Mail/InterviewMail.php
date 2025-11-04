<?php

namespace Modules\HRMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterviewMail extends Mailable
{
    use Queueable, SerializesModels;

   public $candidate;

    public function __construct($candidate)
    {
        $this->candidate = $candidate;
    }

    public function build()
    {
        return $this->subject('Interview Invitation - ' . $this->candidate->full_name)
                    ->markdown('hrms::emails.interview');
    }
}
