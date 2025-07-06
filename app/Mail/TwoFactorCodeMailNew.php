<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public function __construct($otp)
    {
         $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Password Reset Code')
            ->view('emails.two-factor-code')
            ->with(['otp' => $this->otp]);
    }
   
}
