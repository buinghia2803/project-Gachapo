<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verification2ndFactorMail extends Mailable
{
  use Queueable, SerializesModels;

  protected $user;
  protected $secretKey;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user, $secretKey)
  {
    $this->user = $user;
    $this->secretKey = $secretKey;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject("[Gachapo] アカウント認証")
      ->view('emails.verify-2nd-factor-mail', [
        'secretKey' => $this->secretKey,
        'name' => $this->user->name
      ]);
  }
}
