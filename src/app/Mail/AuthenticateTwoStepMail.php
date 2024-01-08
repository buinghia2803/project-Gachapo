<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthenticateTwoStepMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $authenticateCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($authenticateCode)
    {
        $this->authenticateCode = $authenticateCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $authenticateCode = $this->authenticateCode;
        return $this->subject("[Gachapo]")
            ->view('emails.authenticate-two-step', [
                'authenticateCode' => $authenticateCode
            ]);
    }
}
