<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Verification2ndFactorMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Verification2ndFactorJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $user;
  protected $secretKey;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($user, $secretKey)
  {
    $this->user = $user;
    $this->secretKey = $secretKey;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    try {
      if ($this->secretKey && $this->user) {
        Mail::to($this->user->email)->send(new Verification2ndFactorMail($this->user, $this->secretKey));
        if (Mail::failures()) {
          throw new \Exception('Failed to send the email.');
        }
      }
    } catch (\Exception $e) {
      Log::error('[Verification2ndFactorJob->handle: ' . __LINE__ . '] ' . $e->getMessage());
    }
  }
}
