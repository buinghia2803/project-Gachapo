<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AuthenticateTwoStepMail;
use Mail;

class AuthenticateTwoStep implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $authenticateCode;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($authenticateCode, $email)
    {
        $this->authenticateCode = $authenticateCode;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ($this->authenticateCode && $this->email) {
                Mail::to($this->email)->send(new AuthenticateTwoStepMail($this->authenticateCode));
                if (Mail::failures()) {
                    throw new \Exception('Failed to send the email.');
                }
            }
        } catch (\Exception $e) {
            \Log::error('[SendMailtAuthenticateTwoStep->handle: ' . __LINE__ . '] ' . $e->getMessage());
        }
    }
}
