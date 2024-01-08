<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Mail\RegisterContactMail;
use Mail;

class SendMailtRegisterContactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $contact)
    {
        $this->email = $email;
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ($this->email && !empty($this->contact)) {
                Mail::to($this->email)->send(new RegisterContactMail($this->contact));
                if (Mail::failures()) {
                    throw new \Exception('Failed to send the email.');
                }
            }
        } catch (\Exception $e) {
            Log::error('[SendMailtRegisterContactJob->handle: ' . __LINE__ . '] ' . $e->getMessage());
        }
    }
}
