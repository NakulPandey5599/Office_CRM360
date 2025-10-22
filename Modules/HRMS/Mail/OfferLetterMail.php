<?php
namespace Modules\HRMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function build()
    {
        return $this->subject('Your Offer Letter')
                    ->markdown('hrms::emails.offer-letter'); // custom view path
    }
}
