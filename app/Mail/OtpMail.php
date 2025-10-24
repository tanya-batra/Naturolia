<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use SerializesModels;

    public $otp;

    // Constructor to initialize OTP
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        // Send OTP email with subject and body
        return $this->subject('Your OTP for Password Reset')
                    ->view('emails.otpmail');  // Create the email view for OTP
    }
}
